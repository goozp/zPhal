<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Posts;
use ZPhal\Models\Postmeta;
use ZPhal\Models\Subjects;
use ZPhal\Models\SubjectRelationships;
use ZPhal\Models\Services\Service\PostService;
use ZPhal\Models\Services\Service\PostmetaService;

/**
 * 页面
 * Class PageController
 * @package ZPhal\Modules\Admin\Controllers
 */
class PageController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 页面列表
     */
    public function indexAction($show = 'all')
    {
        $this->tag->prependTitle("页面 - ");

        $currentPage = $this->request->getQuery('page', 'int'); // GET
        $categorySelected = $this->request->get('categorySelected', 'int'); // POST
        $dateSelected = $this->request->get('dateSelected'); // POST
        $search = $this->request->get('search', ['string', 'trim']); // POST

        // 数目统计
        $postService = container(PostService::class);
        $static = $postService->staticPost('page');

        // 结果集时间区间
        $dateSection = $postService->getDateSection('page');

        // 数据列表
        $condition = [
            'dateSelected' => $dateSelected,
            'search' => $search
        ];
        $pager = $postService->getPostListByType('page', $show, $currentPage, $condition);

        $this->view->setVars(
            [
                "activeShow" => $show,
                "static" => $static,
                "dateSection" => $dateSection,
                'dateSelected' => $dateSelected,
                'search' => $search,
                'pager' => $pager,
                'str' => $str
            ]
        );
    }

    /**
     * 创建新页面
     */
    public function newAction()
    {
        $this->tag->prependTitle("创建页面 - ");

        /* 静态资源 */
        $this->assets->addCss("backend/plugins/editor.md/css/editormd.css", true);
        $this->assets->addCss("backend/library/select2/css/select2.min.css", true);
        $this->assets->addCss("backend/library/AdminLTE/css/AdminLTE-select2.min.css", true);
        $this->assets->addJs("backend/plugins/editor.md/editormd.min.js", true);
        $this->assets->addJs("backend/library/select2/js/select2.full.min.js", true);
        $this->assets->addJs("backend/js/page.js", true);

        /**
         * 父级页面选择
         */
        $parentPages = Posts::find([
            "post_type = 'page' AND post_status = 'publish' ",
            "columns" => "ID, post_title"
        ])->toArray();

        /**
         * TODO
         * 模板
         */


        $this->view->setVars(
            [
                'parentPages' => $parentPages,
                "ajaxUri" => $this->url->getBaseUri(),
            ]
        );
    }


    /**
     * 保存页面
     */
    public function saveAction()
    {
        if($this->request->isPost()){
            $submitWay = $this->request->getPost('submitWay', 'string');

            // 获取表单数据
            $postId = $this->request->getPost('post_id');
            $title = $this->request->getPost('title', 'trim');
            $mr_content = $this->request->getPost('mr_content');
            $description = $this->request->getPost('description', ['string', 'trim']);
            $publishDate = $this->request->getPost('publishDate');
            $ifPublic = $this->request->getPost('ifPublic'); // TODO
            $ifComment = $this->request->getPost('ifComment');
            // 页面属性
            $slugName = $this->request->getPost('slugName', 'trim', '');
            $parent = $this->request->getPost('parent', 'int', 0);
            $template = $this->request->getPost('template');
            
            if ($postId == 0) {
                $post = new Posts();
            } else {
                $post = Posts::findFirst($postId);
            }

            $post->post_author = $this->getUserId();
            $post->post_content = $mr_content;
            $post->post_title = $title ? $title : '无题';
            $post->comment_status = $ifComment == 'yes' ? $post::COMMENT_OPEN : $post::COMMENT_CLOSE;
            $post->post_parent = $parent;
            $post->post_type = $post::TYPE_PAGE;
            if ($slugName != '') {
                $post->post_name = $slugName;
            }else{
                $post->post_name = $title ? $title : '';
            }
            $post->guid = $this->url->get(['for' => 'page', 'params' => $post->post_name]);
            
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
                // 页面模板
                $template = $template ? $template : 'default';
                $postmeta = new Postmeta();
                $postmeta->post_id = $post->ID;
                $postmeta->meta_key = '_zp_page_template';
                $postmeta->meta_value = $template;
                $postmeta->create();

                // 如果输入description,保存
                if ($description != '') {
                    $postmeta = new Postmeta();
                    $postmeta->post_id = $post->ID;
                    $postmeta->meta_key = 'description';
                    $postmeta->meta_value = $description;
                    $postmeta->create();
                }

                // 成功,跳转到文章编辑页
                $this->flash->success("保存成功!");
                return $this->response->redirect("admin/page/edit/" . $post->ID);    
            }
        }

        $this->flash->error("错误操作!");
        return $this->response->redirect("admin/");
    }

    /**
     * 自动保存草稿
     */
    public function autoSaveDraftAction()
    {
        if ($this->request->isPost()) {
            $markdownWord = $this->request->getPost('markdownWord');
            $title = $this->request->getPost('title', 'trim');
            $postId = $this->request->getPost('postId', 'int', 0);
            $slugName = $this->request->getPost('slugName', 'trim', '');

            // 没有记录
            if ($postId == 0) {
                $post = new Posts();
                $post->post_author = $this->getUserId();
                $post->post_content = $markdownWord;
                $post->post_title = $title ? $title : '无题';
                $post->comment_status = $post::COMMENT_OPEN;
                $post->post_parent = 0;
                $post->post_type = $post::TYPE_PAGE;
                $post->post_modified = date('Y-m-d H:i:s', time());
                $post->post_modified_gmt = gmdate('Y-m-d H:i:s', time());
                $post->post_status = 'draft';
                if ($slugName != '') {
                    $post->post_name = $slugName;
                }else{
                    $post->post_name = $title ? $title : '';
                }
                $post->guid = $this->url->get(['for' => 'page', 'params' => $post->post_name]);
                if ($post->create()) {
                    $postId = $post->ID;
                    $data = [
                        'post_id' => $postId,
                        'post_date' => $post->post_modified,
                        'post_url' => $post->guid
                    ];
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
                    if ($slugName != '') {
                        $post->post_name = $slugName;
                    }else{
                        $post->post_name = $title ? $title : '';
                    }
                    $post->guid = $this->url->get(['for' => 'page', 'params' => $post->post_name]);
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

    /**
     * 编辑页面
     */
    public function editAction()
    {
        $this->tag->prependTitle("编辑页面 - ");
        
        /* 静态资源 */
        $this->assets->addCss("backend/plugins/editor.md/css/editormd.css", true);
        $this->assets->addCss("backend/library/select2/css/select2.min.css", true);
        $this->assets->addCss("backend/library/AdminLTE/css/AdminLTE-select2.min.css", true);
        $this->assets->addJs("backend/plugins/editor.md/editormd.min.js", true);
        $this->assets->addJs("backend/library/select2/js/select2.full.min.js", true);
        $this->assets->addJs("backend/js/page-edit.js", true);

        $id = $this->dispatcher->getParam("id");

        /**
         * post信息
         */
        $postService = container(PostService::class);
        $info = $postService->getPostInfo($id, 'page', 'publish');

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

        // 查看postmeta
        $postMeta = Postmeta::find(
            [
                "conditions" => "post_id = ?1 AND (meta_key = ?2 OR meta_key = ?3) ",
                "bind" => [
                    1 => $id,
                    2 => 'description',
                    3 => '_zp_page_template'
                ]
            ]
        )->toArray();
        if($postMeta){
            foreach($postMeta as $meta){
                switch($meta['meta_key']){
                    case 'description':
                        $description = $meta['meta_value'] ? $meta['meta_value'] : '';
                        break;
                    case '_zp_page_template':
                        $template = $meta['meta_value'];
                        break;
                    default:
                        break;
                }
            }
        }

        /**
         * 父级页面选择
         */
        $parentPages = Posts::find([
            "post_type = 'page' AND post_status = 'publish' AND ID <> ?1 ",
            "columns" => "ID, post_title",
            "bind" => [
                1 => $id
            ]
        ])->toArray();

        $this->view->setVars(
            [
                'info' => $info,
                'description' => $description,
                'template' => $template,
                "publishDatetime" => $publishDatetime,
                "ajaxUri" => $this->url->getBaseUri(),
                'parentPages' => $parentPages,
            ]
        );
    }

    /**
     * 更新页面
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
            $description = $this->request->getPost('description', ['string', 'trim']);
            $publishDate = $this->request->getPost('publishDate');
            $ifPublic = $this->request->getPost('ifPublic'); // TODO
            $ifComment = $this->request->getPost('ifComment');
            // 页面属性
            $slugName = $this->request->getPost('slugName', 'trim', '');
            $parent = $this->request->getPost('parent', 'int', 0);
            $template = $this->request->getPost('template');

            $nowStatus = $this->request->getPost('now_status'); // 当前状态

            $post = Posts::findFirst($postId);
            $post->post_content = $mr_content;
            $post->post_title = $title ? $title : '无题';
            $post->comment_status = $ifComment == 'yes' ? $post::COMMENT_OPEN : $post::COMMENT_CLOSE;
            $post->post_parent = $parent;
            if ($slugName != '') {
                $post->post_name = $slugName;
            }else{
                $post->post_name = $title ? $title : '';
            }
            $post->guid = $this->url->get(['for' => 'page', 'params' => $post->post_name]);
            
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
                $postMeta = Postmeta::findFirst(
                    [
                        "conditions" => "post_id = ?1 AND meta_key = ?2 ",
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

                /**
                 * template
                 */
                $postMeta = Postmeta::findFirst(
                    [
                        "conditions" => "post_id = ?1 AND meta_key = ?2 ",
                        "bind" => [
                            1 => $postId,
                            2 => '_zp_page_template'
                        ]
                    ]
                );

                if($postMeta->meta_value != $template){
                    $postMeta->meta_value = $template;
                    $postMeta->save();
                }
                   
                
                // 成功,跳转到文章编辑页
                $this->flash->success("保存成功!");
                return $this->response->redirect("admin/page/edit/" . $postId);
            } else {
                $this->flash->error("保存失败!");
                return $this->response->redirect("admin/page/edit/".$postId);
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

                return $this->response->redirect("admin/page");
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

                return $this->response->redirect("admin/page");
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

                return $this->response->redirect("admin/page");
            }

            // Commit the transaction
            $this->db->commit();

            $this->flash->success("已移至回收站！");
            return $this->response->redirect("admin/page");
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

                    return $this->response->redirect("admin/page/trash");
                }
            }


            if ($post->delete() === false) {
                $this->db->rollback();

                $messages = $this->getErrorMsg($post, "删除失败");
                $this->flash->error($messages);

                return $this->response->redirect("admin/page/trash");
            } else {
                // Commit the transaction
                $this->db->commit();

                $this->flash->success("删除成功！");
                return $this->response->redirect("admin/page/trash");
            }
        }

        $this->flash->error("错误操作!");
        return $this->response->redirect("admin/");
    }

    /**
     * 从回收站还原页面
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

                    return $this->response->redirect("admin/page/trash");
                }

                $postmetaService = container(PostmetaService::class);
                $deleteTrashMeta = $postmetaService->deleteTrashMeta($id);

                if ($deleteTrashMeta->success() === false) {
                    $this->db->rollback();

                    $messages = $this->getErrorMsg($deleteTrashMeta, "还原失败");
                    $this->flash->error($messages);

                    return $this->response->redirect("admin/page/trash");
                }

                // Commit the transaction
                $this->db->commit();

                $this->flash->success("还原成功！");
                return $this->response->redirect("admin/page");
            }
        }

        $this->flash->error("错误操作!");
        return $this->response->redirect("admin/");
    }
}