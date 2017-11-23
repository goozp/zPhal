<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Postmeta;
use ZPhal\Models\Posts;
use ZPhal\Models\Services\Service\PostmetaService;
use ZPhal\Models\Services\Service\PostService;
use ZPhal\Models\Services\Service\TaxonomyService;
use ZPhal\Models\SubjectRelationships;
use ZPhal\Models\Subjects;
use ZPhal\Models\TermRelationships;

/**
 * 文章相关
 * Class PostController
 * @package ZPhal\Modules\Admin\Controllers
 */
class PostController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 文章列表
     * TODO 输出优化;展示优化;前端优化
     * @param string $show
     */
    public function indexAction($show = 'all')
    {
        $this->tag->prependTitle("文章列表 - ");

        $currentPage = $this->request->getQuery('page', 'int'); // GET
        $categorySelected = $this->request->get('categorySelected', 'int'); // POST
        $dateSelected = $this->request->get('dateSelected'); // POST
        $search = $this->request->get('search', ['string', 'trim']); // POST

        // 数目统计
        $postService = container(PostService::class);
        $static = $postService->staticPost('post');

        // 分类列表
        $taxonomyService = container(TaxonomyService::class);
        $category = $taxonomyService->getTaxonomyListByType('category');
        $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

        // 结果集时间区间
        $dateSection = $postService->getDateSection('post');

        // 数据列表
        $condition = [
            'categorySelected' => $categorySelected,
            'dateSelected' => $dateSelected,
            'search' => $search
        ];
        $pager = $postService->getPostListByType('post', $show, $currentPage, $condition);

        // 获取分类,标签
        $items = $pager->getIterator();
        if ($items) {
            $str = [];
            foreach ($items as $k => $v) {
                $cateStr = '';
                $tagStr = '';

                $termsArr = explode(',', $v['terms']);
                foreach ($termsArr as $v2) {
                    if ($cate = strstr($v2, 'category', true)) {
                        $cateStr .= $cate . ',';
                    } elseif ($tag = strstr($v2, 'tag', true)) {
                        $tagStr .= $tag . ',';
                    }
                }

                $str[$k]['cateStr'] = substr($cateStr, 0, -1);
                $str[$k]['tagStr'] = substr($tagStr, 0, -1);
            }
        }

        $this->view->setVars(
            [
                "activeShow" => $show,
                "static" => $static,
                "categoryTree" => treeHtml($categoryTree, 'term_taxonomy_id', 'name', '<option value="0">所有分类</option>', 0, $categorySelected),
                "dateSection" => $dateSection,
                'dateSelected' => $dateSelected,
                'search' => $search,
                'pager' => $pager,
                'str' => $str
            ]
        );
    }

    /**
     * 新文章
     * TODO 列表输出优化
     */
    public function newAction()
    {
        $this->tag->prependTitle("新文章 - ");

        /* 静态资源 */
        $this->assets->addCss("backend/plugins/editor.md/css/editormd.css", true);
        $this->assets->addCss("backend/library/select2/css/select2.min.css", true);
        $this->assets->addCss("backend/library/AdminLTE/css/AdminLTE-select2.min.css", true);
        $this->assets->addJs("backend/plugins/editor.md/editormd.min.js", true);
        $this->assets->addJs("backend/library/select2/js/select2.full.min.js", true);
        $this->assets->addJs("backend/js/post.js", true);

        // 分类列表
        $taxonomyService = container(TaxonomyService::class);
        $category = $taxonomyService->getTaxonomyListByType('category');
        $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

        // 标签列表
        $taxonomyService = container(TaxonomyService::class);
        $tags = $taxonomyService->getTaxonomyListByType('tag');

        // 专题列表
        $subjects = Subjects::find()->toArray();
        $subjectsTree = makeTree($subjects, 'subject_id', 'parent');

        $this->view->setVars(
            [
                "categoryTree" => treeHtml($categoryTree, 'term_taxonomy_id', 'name', ' ', 0, 1, ' '),
                "categoryTreeNbsp" => treeHtml($categoryTree, 'term_taxonomy_id', 'name'),
                "tags" => $tags,
                "subjectTree" => treeHtml($subjectsTree, 'subject_id', 'subject_name'),
                "ajaxUri" => $this->url->getBaseUri(),
            ]
        );
    }

    /**
     * 保存文章
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveAction()
    {

        if ($this->request->isPost()) {
            $submitWay = $this->request->getPost('submitWay', 'string');

            // 获取表单数据
            $postId = $this->request->getPost('post_id');
            $title = $this->request->getPost('title', 'trim');
            $mr_content = $this->request->getPost('mr_content');
            $cover_image = $this->request->getPost('cover_image');
            // 以下需要判断
            $description = $this->request->getPost('description', ['string', 'trim']);
            $publishDate = $this->request->getPost('publishDate');
            $categories = $this->request->getPost('categories');
            $tags = $this->request->getPost('tags');
            $subject = $this->request->getPost('subject');

            $ifPublic = $this->request->getPost('ifPublic'); // TODO
            $ifComment = $this->request->getPost('ifComment');
            $ifTop = $this->request->getPost('ifTop'); // TODO

            if ($postId == 0) {
                $post = new Posts();
            } else {
                $post = Posts::findFirst($postId);
            }

            $post->post_author = $this->getUserId();
            $post->post_content = $mr_content;
            $post->post_title = $title ? $title : '无题';
            $post->comment_status = $ifComment == 'yes' ? $post::COMMENT_OPEN : $post::COMMENT_CLOSE;
            $post->post_parent = 0;
            $post->cover_picture = $cover_image;
            $post->post_type = $post::TYPE_ARTICLE;

            // 编辑时间
            $now = time();
            $post->post_modified = date('Y-m-d H:i:s', $now);
            $post->post_modified_gmt = gmdate('Y-m-d H:i:s', $now);

            if ($submitWay == 'publish') {
                // 发布时间
                if (!$post->post_date || $post->post_date == $post::PUBLISH_DEFAULT_TIME) {
                    // 立即发布 or 编辑发布时间
                    if ($publishDate == 'now') {
                        $post->post_date = $post->post_modified;
                        $post->post_date_gmt = $post->post_modified_gmt;

                    } elseif ($publishDate == 'edit') {
                        $year = $this->request->getPost('year');
                        $month = $this->request->getPost('month');
                        $day = $this->request->getPost('day');
                        $hour = $this->request->getPost('hour');
                        $minute = $this->request->getPost('minute');
                        $second = $this->request->getPost('second');
                        $actionTime = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minute . ':' . $second;

                        $post->post_date = $actionTime;
                        $post->post_date_gmt = gmdate("Y-m-d H:i:s", strtotime($actionTime));
                    }
                }

                $post->post_status = 'publish';

            } elseif ($submitWay == 'draft'){

                $post->post_status = 'draft';
            }

            if ($post->save()) {
                $updateURL = Posts::findFirst($post->ID);
                $updateURL->generateUrl();

                // 如果输入description,保存
                if ($description != '') {
                    $postmeta = new Postmeta();
                    $postmeta->post_id = $post->ID;
                    $postmeta->meta_key = 'description';
                    $postmeta->meta_value = $description;
                    $postmeta->create();
                }

                // 分类和标签
                // categories一定有,如未设置则是未分类; tags可能没有设置
                if (!empty($tags)) {
                    $categories = array_merge($categories, $tags); // 合并标签
                }
                foreach ($categories as $item) {
                    $termRelationShip = new TermRelationships();
                    $termRelationShip->object_id = $post->ID;
                    $termRelationShip->term_taxonomy_id = $item;
                    $termRelationShip->create();
                }

                // subject专题, 可能没设置
                if (!empty($subject)) {
                    $subjectRelationShip = new SubjectRelationships();
                    $subjectRelationShip->object_id = $post->ID;
                    $subjectRelationShip->subject_id = $subject;
                    $subjectRelationShip->create();
                }

                // 成功,跳转到文章编辑页
                $this->flash->success("保存成功!");
                return $this->response->redirect("admin/post/edit/" . $post->ID);
            } else {
                $this->flash->error("保存失败!");
                return $this->response->redirect("admin/post/new");
            }

        }
        $this->flash->error("错误操作!");
        return $this->response->redirect("admin/");
    }

    /**
     * 编辑文章
     * TODO 列表输出优化
     */
    public function editAction()
    {
        $this->tag->prependTitle("编辑文章 - ");

        /* 静态资源 */
        $this->assets->addCss("backend/plugins/editor.md/css/editormd.css", true);
        $this->assets->addCss("backend/library/select2/css/select2.min.css", true);
        $this->assets->addCss("backend/library/AdminLTE/css/AdminLTE-select2.min.css", true);
        $this->assets->addJs("backend/plugins/editor.md/editormd.min.js", true);
        $this->assets->addJs("backend/library/select2/js/select2.full.min.js", true);
        $this->assets->addJs("backend/js/post-edit.js", true);

        $id = $this->dispatcher->getParam("id");

        /**
         * post信息
         */
        $postService = container(PostService::class);
        $info = $postService->getPostInfo($id, 'post', 'publish');

        // 发布时间
        $publishDatetime = [];
        if ($info['post_date'] != '1000-01-01 00:00:00'){
            $postTimestamp = strtotime($info['post_date']);
        }else{
            $postTimestamp = 0;
        }
        $publishDatetime['year'] = $postTimestamp ? date('Y', $postTimestamp) : '';
        $publishDatetime['month'] = $postTimestamp ? date('m', $postTimestamp) : '';
        $publishDatetime['day'] = $postTimestamp ? date('d', $postTimestamp) : '';
        $publishDatetime['hour'] = $postTimestamp ? date('H', $postTimestamp) : '';
        $publishDatetime['minute'] = $postTimestamp ? date('i', $postTimestamp) : '';
        $publishDatetime['second'] = $postTimestamp ? date('s', $postTimestamp) : '';

        // 查看postmeta (description)
        $postMeta = Postmeta::findFirst(
            [
                "conditions" => "post_id = ?1 AND meta_key = ?2",
                "bind" => [
                    1 => $id,
                    2 => 'description'
                ]
            ]
        );
        $description = $postMeta ? $postMeta->meta_value : '';


        /**
         * 分类,标签
         */
        // 当前分类标签
        $taxonomyService = container(TaxonomyService::class);
        $taxonomy = $taxonomyService->getPostTaxonomy($id);

        // 分类列表
        $taxonomyService = container(TaxonomyService::class);
        $category = $taxonomyService->getTaxonomyListByType('category');
        $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

        // 标签列表
        $taxonomyService = container(TaxonomyService::class);
        $tags = $taxonomyService->getTaxonomyListByType('tag');
        $tagsTree = makeTree($tags, 'term_taxonomy_id', 'parent', 'sun', 0);


        /**
         * 专题
         */
        // 专题列表
        $subjects = Subjects::find()->toArray();
        $subjectsTree = makeTree($subjects, 'subject_id', 'parent');

        // 当前专题
        $nowSubject = SubjectRelationships::findFirst([
            'object_id = :id: ',
            'bind' => [
                'id' => $id
            ]
        ]);
        $nowSubject = $nowSubject ? $nowSubject->subject_id : 0;

        $this->view->setVars(
            [
                'info' => $info,
                'description' => $description,
                "publishDatetime" => $publishDatetime,
                "ajaxUri" => $this->url->getBaseUri(),
                "categoryTree" => treeHtmlMultiSelect($categoryTree, 'term_taxonomy_id', 'name', ' ', 0, $taxonomy['category'], ' '),
                "categoryTreeNbsp" => treeHtml($categoryTree, 'term_taxonomy_id', 'name'),
                "tagsTree" => treeHtmlMultiSelect($tagsTree, 'term_taxonomy_id', 'name', ' ', 0, $taxonomy['tag'], ' '),
                "subjectTree" => treeHtml($subjectsTree, 'subject_id', 'subject_name', '', 0, $nowSubject),
            ]
        );
    }

    /**
     * 更新文章
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function updateAction()
    {
        if ($this->request->isPost()) {
            $submitWay = $this->request->getPost('submitWay', 'string');

            // 获取表单数据
            $postId = $this->request->getPost('post_id');
            $title = $this->request->getPost('title', 'trim');
            $mr_content = $this->request->getPost('mr_content');
            $cover_image = $this->request->getPost('cover_image');
            // 以下需要判断
            $description = $this->request->getPost('description', ['string', 'trim']);
            $publishDate = $this->request->getPost('publishDate');
            $categories = $this->request->getPost('categories');
            $tags = $this->request->getPost('tags');
            $subject = $this->request->getPost('subject');
            $nowStatus = $this->request->getPost('now_status'); // 当前状态


            $ifPublic = $this->request->getPost('ifPublic'); // TODO
            $ifComment = $this->request->getPost('ifComment');
            $ifTop = $this->request->getPost('ifTop'); // TODO

            $post = Posts::findFirst($postId);
            $post->post_content = $mr_content;
            $post->post_title = $title ? $title : '无题';
            $post->comment_status = $ifComment == 'yes' ? $post::COMMENT_OPEN : $post::COMMENT_CLOSE;
            $post->cover_picture = $cover_image;

            // 编辑时间
            $now = time();
            $post->post_modified = date('Y-m-d H:i:s', $now);
            $post->post_modified_gmt = gmdate('Y-m-d H:i:s', $now);

            // 发布时间
            if ($publishDate == 'now') {
                $post->post_date = $post->post_modified;
                $post->post_date_gmt = $post->post_modified_gmt;

            } elseif ($publishDate == 'edit') {
                $year = $this->request->getPost('year');
                $month = $this->request->getPost('month');
                $day = $this->request->getPost('day');
                $hour = $this->request->getPost('hour');
                $minute = $this->request->getPost('minute');
                $second = $this->request->getPost('second');
                $actionTime = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minute . ':' . $second;

                $post->post_date = $actionTime;
                $post->post_date_gmt = gmdate("Y-m-d H:i:s", strtotime($actionTime));
            }

            // 发布状态
            if($nowStatus == 'publish'){
                $changeStatus = $this->request->getPost('change_status'); // 改变状态
                $post->post_status = $changeStatus;
            } elseif($nowStatus == 'draft'){
                $post->post_status = $submitWay;
            }

            if ($post->save()) {
                /**
                 * description
                 */
                if($description != ''){
                    $postMeta = Postmeta::findFirst(
                        [
                            "conditions" => "post_id = ?1 AND meta_key = ?2",
                            "bind" => [
                                1 => $postId,
                                2 => 'description'
                            ]
                        ]
                    );
                    if($postMeta){
                        $postMeta->meta_value = $description;
                        $postMeta->update();
                    }else{
                        $postmeta = new Postmeta();
                        $postmeta->post_id = $postId;
                        $postmeta->meta_key = 'description';
                        $postmeta->meta_value = $description;
                        $postmeta->create();
                    }
                }

                /**
                 * 分类和标签
                 */
                if (empty($categories)){
                    $categories[] = 1;
                }
                if (!empty($tags)) {
                    $categories = array_merge($categories, $tags); // 合并标签
                }

                // 查询已有的数据
                $TermRelationships = TermRelationships::find(
                    [
                        "conditions" => "object_id = ?1",
                        "bind" => [
                            1 => $postId,
                        ]
                    ]
                );
                $beforeCategories = [];
                foreach($TermRelationships as $term){
                    // 确保不是link的记录
                    $termTaxonomy = $term->TermTaxonomy;
                    if ($termTaxonomy->taxonomy == ($termTaxonomy::TAXONOMY_CATEGORY || $termTaxonomy::TAXONOMY_TAG)){
                        $beforeCategories[] = $term->term_taxonomy_id;
                    }
                }

                // 进行比对,选择性增删改
                $delete = array_diff($beforeCategories, $categories); // 要删除的
                $add = array_diff($categories, $beforeCategories); // 要添加的

                // 删
                foreach($TermRelationships as $term){
                    if(in_array($term->term_taxonomy_id, $delete)){
                        $term->delete();
                    }
                }

                //增
                foreach($add as $id){
                    $termRelationShip = new TermRelationships();
                    $termRelationShip->object_id = $postId;
                    $termRelationShip->term_taxonomy_id = $id;
                    $termRelationShip->create();
                }

                /**
                 * subject专题
                 */
                if (isset($subject)){
                    $subjectRelationShip = SubjectRelationships::findFirst([
                        'object_id = :id: ',
                        'bind' => [
                            'id' => $postId
                        ]
                    ]);
                    if ($subjectRelationShip){
                        if($subject != $subjectRelationShip->subject_id){
                            $subjectRelationShip->delete();
                            if ($subject != 0){
                                $subjectRelationShip = new SubjectRelationships();
                                $subjectRelationShip->object_id = $postId;
                                $subjectRelationShip->subject_id = $subject;
                                $subjectRelationShip->create();
                            }
                        }
                    }else{
                        $subjectRelationShip = new SubjectRelationships();
                        $subjectRelationShip->object_id = $postId;
                        $subjectRelationShip->subject_id = $subject;
                        $subjectRelationShip->create();
                    }
                }

                // 成功,跳转到文章编辑页
                $this->flash->success("保存成功!");
                return $this->response->redirect("admin/post/edit/" . $postId);
            } else {
                $this->flash->error("保存失败!");
                return $this->response->redirect("admin/post/edit/".$postId);
            }
        }

        $this->flash->error("错误操作!");
        return $this->response->redirect("admin/");
    }

    /**
     * 移至回收站
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function trashAction()
    {
        $id = $this->dispatcher->getParam("id");

        // Start a transaction
        $this->db->begin();

        $post = Posts::findFirst($id);

        if ($post){
            $beforeStatus = $post->post_status;
            $post->post_status = $post::STATUS_TRASH;

            if ($post->save() === false) {
                $this->db->rollback();

                $messages = $this->getErrorMsg($post, "移至回收站出错");
                $this->flash->error($messages);

                return $this->response->redirect("admin/post");
            }

            // change time
            $postMeta = new Postmeta();
            $postMeta->post_id = $id;
            $postMeta->meta_key = '_zp_trash_meta_time';
            $postMeta->meta_value = time();
            if ($postMeta->save() === false) {
                $this->db->rollback();

                $messages = $this->getErrorMsg($postMeta, "移至回收站出错");
                $this->flash->error($messages);

                return $this->response->redirect("admin/post");
            }

            // before status
            $postMeta = new Postmeta();
            $postMeta->post_id = $id;
            $postMeta->meta_key = '_zp_trash_meta_status';
            $postMeta->meta_value = $beforeStatus;
            $postMeta->save();
            if ($postMeta->save() === false) {
                $this->db->rollback();

                $messages = $this->getErrorMsg($postMeta, "移至回收站出错");
                $this->flash->error($messages);

                return $this->response->redirect("admin/post");
            }

            // Commit the transaction
            $this->db->commit();

            $this->flash->success("已移至回收站！");
            return $this->response->redirect("admin/post");
        }

        $this->flash->error("错误操作!");
        return $this->response->redirect("admin/");
    }

    /**
     * 从回收站还原文章
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function restoreAction()
    {
        $id = $this->dispatcher->getParam("id");

        // Start a transaction
        $this->db->begin();

        $post = Posts::findFirst($id);

        if ($post){
            $status = Postmeta::findFirst([
                "conditions" => "post_id = ?1 AND meta_key = ?2",
                "bind" => [
                    1 => $id,
                    2 => '_zp_trash_meta_status'
                ]
            ]);

            if ($status){
                $post->post_status = $status->meta_value;
                if ($post->save() === false){
                    $this->db->rollback();

                    $messages = $this->getErrorMsg($post, "还原失败");
                    $this->flash->error($messages);

                    return $this->response->redirect("admin/post/trash");
                }

                $postmetaService = container(PostmetaService::class);
                $deleteTrashMeta = $postmetaService->deleteTrashMeta($id);

                if ($deleteTrashMeta->success() === false) {
                    $this->db->rollback();

                    $messages = $this->getErrorMsg($deleteTrashMeta, "还原失败");
                    $this->flash->error($messages);

                    return $this->response->redirect("admin/post/trash");
                }

                // Commit the transaction
                $this->db->commit();

                $this->flash->success("还原成功！");
                return $this->response->redirect("admin/post");
            }
        }

        $this->flash->error("错误操作!");
        return $this->response->redirect("admin/");
    }

    /**
     * 永久删除
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function deleteAction()
    {
        $id = $this->dispatcher->getParam("id");

        // Start a transaction
        $this->db->begin();

        $post = Posts::findFirst($id);

        if ($post) {
            // 删除postmeta
            $postMeta = Postmeta::find([
                "conditions" => "post_id = ?1",
                "bind" => [
                    1 => $id,
                ]
            ]);

            foreach ($postMeta as $meta){
                if ($meta->delete() === false){
                    $this->db->rollback();

                    $messages = $this->getErrorMsg($meta, "删除失败");
                    $this->flash->error($messages);

                    return $this->response->redirect("admin/post/trash");
                }
            }

            // 删除关联表的记录
            $subject = SubjectRelationships::findFirst([
                "conditions" => "object_id = ?1",
                "bind" => [
                    1 => $id,
                ]
            ]);
            if ($subject){
                if ($subject->delete() === false){
                    $this->db->rollback();

                    $messages = $this->getErrorMsg($subject, "删除失败");
                    $this->flash->error($messages);

                    return $this->response->redirect("admin/post/trash");
                }
            }

            $terms = TermRelationships::find([
                "conditions" => "object_id = ?1",
                "bind" => [
                    1 => $id,
                ]
            ]);
            if ($terms){
                foreach ($terms as $term){
                    // 确保不是link的记录
                    $termTaxonomy = $term->TermTaxonomy;
                    if ($termTaxonomy->taxonomy != ($termTaxonomy::TAXONOMY_CATEGORY || $termTaxonomy::TAXONOMY_TAG)){
                        continue;
                    }

                    if ($term->delete() === false){
                        $this->db->rollback();

                        $messages = $this->getErrorMsg($term, "删除失败");
                        $this->flash->error($messages);

                        return $this->response->redirect("admin/post/trash");
                    }
                }
            }


            if ($post->delete() === false) {
                $this->db->rollback();

                $messages = $this->getErrorMsg($post, "删除失败");
                $this->flash->error($messages);

                return $this->response->redirect("admin/post/trash");
            } else {
                // Commit the transaction
                $this->db->commit();

                $this->flash->success("删除成功！");
                return $this->response->redirect("admin/post/trash");
            }
        }

        $this->flash->error("错误操作!");
        return $this->response->redirect("admin/");
    }

    /**
     * 自动保存草稿
     * @return string
     */
    public function autoSaveDraftAction()
    {
        if ($this->request->isPost()) {
            $markdownWord = $this->request->getPost('markdownWord');
            $title = $this->request->getPost('title', 'trim');
            $postId = $this->request->getPost('postId', 'int', 0);

            // 没有记录
            if ($postId == 0) {
                $post = new Posts();
                $post->post_author = $this->getUserId();
                $post->post_content = $markdownWord;
                $post->post_title = $title ? $title : '无题';
                $post->comment_status = $post::COMMENT_OPEN;
                $post->post_parent = 0;
                $post->post_type = $post::TYPE_ARTICLE;
                $post->post_modified = date('Y-m-d H:i:s', time());
                $post->post_modified_gmt = gmdate('Y-m-d H:i:s', time());
                $post->post_status = 'draft';
                if ($post->create()) {
                    $postId = $post->ID;
                    $post = Posts::findFirst($postId);
                    $post->guid = $this->url->get(['for' => 'article', 'id' => $postId]);
                    if ($post->save()) {
                        $data = [
                            'post_id' => $postId,
                            'post_date' => $post->post_modified,
                            'post_url' => $post->guid
                        ];
                    }
                }
            }
            // 已有记录
            else {
                // 查询已有的记录
                $post = Posts::findFirst(
                    [
                        "conditions" => "ID = ?1 AND post_status = 'draft'",
                        "bind" => [
                            1 => $postId,
                        ]
                    ]
                );

                if ($post) {
                    $post->post_content = $markdownWord;
                    $post->post_title = $title ? $title : '无题';
                    $post->post_modified = date('Y-m-d H:i:s', time());
                    $post->post_modified_gmt = gmdate('Y-m-d H:i:s', time());
                    if ($post->update()) {
                        $data = [
                            'post_id' => $postId,
                            'post_date' => $post->post_modified,
                            'post_url' => $post->guid
                        ];
                    }
                }
            }

            return json_encode(['status' => 'success', 'message' => '保存成功', 'data' => $data], JSON_UNESCAPED_UNICODE);
        }
    }
}