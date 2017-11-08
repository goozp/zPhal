<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Postmeta;
use ZPhal\Models\Posts;
use ZPhal\Models\Services\Service\PostService;
use ZPhal\Models\SubjectRelationships;
use ZPhal\Models\Subjects;
use ZPhal\Models\TermRelationships;
use ZPhal\Models\Terms;
use ZPhal\Models\TermTaxonomy;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use ZPhal\Modules\Admin\Library\Paginator\Pager;


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
        $category = $postService->getTaxonomyListByType('category');
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
        $postService = container(PostService::class);
        $category = $postService->getTaxonomyListByType('category');
        $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

        // 标签列表
        $postService = container(PostService::class);
        $tags = $postService->getTaxonomyListByType('tag');

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

                // 分类,标签
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
                $this->flash->success("操作成功!");
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
     * // TODO 编辑
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

        // post 信息
        $postService = container(PostService::class);
        $info = $postService->getPostInfo($id, 'post', 'publish');

        // 发布时间
        $publishDatetime = [];
        if ($info['post_date'] != '1000-01-01 00:00:00'){
            $postTimestamp = strtotime($info['post_date']);
        }
        $publishDatetime['year'] = NULL != $postTimestamp ? date('Y', $postTimestamp) : '';
        $publishDatetime['month'] = NULL != $postTimestamp ? date('m', $postTimestamp) : '';
        $publishDatetime['day'] = NULL != $postTimestamp ? date('d', $postTimestamp) : '';
        $publishDatetime['hour'] = NULL != $postTimestamp ? date('H', $postTimestamp) : '';
        $publishDatetime['minute'] = NULL != $postTimestamp ? date('i', $postTimestamp) : '';
        $publishDatetime['second'] = NULL != $postTimestamp ? date('s', $postTimestamp) : '';


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

        // 查询分类标签


        $this->view->setVars(
            [
                'info' => $info,
                'description' => $postMeta->meta_value,
                "ajaxUri" => $this->url->getBaseUri(),
                "publishDatetime" => $publishDatetime,
            ]
        );
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

    /**
     * ajax快速添加分类或者标签
     */
    public function quickAddTaxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");

        if ($this->request->isPost()) {
            if ($type == 'category') {
                $name = $this->request->getPost('newCategory', ['string', 'trim']);
                $parent = $this->request->getPost('categoryParent', 'int', 0);
            } elseif ($type == 'tag') {
                $name = $this->request->getPost('newTag', ['string', 'trim']);
                $parent = 0;
            } else {
                die(json_encode(['status' => 'error', 'message' => '类型错误'], JSON_UNESCAPED_UNICODE));
            }

            $terms = new Terms();
            $terms->name = $name;
            $terms->slug = $name;

            $termTaxonomy = new TermTaxonomy();
            $termTaxonomy->Terms = $terms;
            $termTaxonomy->taxonomy = $type;
            $termTaxonomy->description = ' ';
            $termTaxonomy->parent = $parent;

            if ($termTaxonomy->save()) {

                // 新的列表
                $data = [];
                if ($type == 'category') {
                    $postService = container(PostService::class);
                    $category = $postService->getTaxonomyListByType('category');
                    $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

                    $data = [
                        "categoryTree" => treeHtml($categoryTree, 'term_taxonomy_id', 'name', ' ', 0, 1, ' '),
                        "categoryTreeNbsp" => treeHtml($categoryTree, 'term_taxonomy_id', 'name'),
                    ];
                } elseif ($type == 'tag') {
                    $postService = container(PostService::class);
                    $tags = $postService->getTaxonomyListByType('tag');

                    $data = [
                        "tags" => $tags,
                    ];
                }

                return json_encode(['status' => 'success', 'message' => '创建成功', 'data' => $data], JSON_UNESCAPED_UNICODE);
            } else {
                $messages = $this->getErrorMsg($termTaxonomy, "创建失败");
                return json_encode(['status' => 'failed', 'message' => $messages], JSON_UNESCAPED_UNICODE);
            }

        } else {
            die(json_encode(['status' => 'error', 'message' => '请求错误'], JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * 添加分类或者标签
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function addTaxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");
        $name = $this->request->getPost('name', ['string', 'trim']);
        $slug = $this->request->getPost('slug', ['string', 'trim', 'lower']);
        $parent = $this->request->getPost('parent', 'int', 0);
        $description = $this->request->getPost('description', ['string', 'trim']);

        $terms = new Terms();
        $terms->name = $name;
        $terms->slug = $slug;

        $termTaxonomy = new TermTaxonomy();
        $termTaxonomy->Terms = $terms;
        $termTaxonomy->taxonomy = $type;
        $termTaxonomy->description = $description;
        $termTaxonomy->parent = $parent;

        if ($termTaxonomy->save()) {
            $this->flash->success("创建成功");
            return $this->response->redirect("admin/post/taxonomy/" . $type);
        } else {
            $messages = $this->getErrorMsg($termTaxonomy, "创建失败");
            $this->flash->error($messages);
            return $this->response->redirect("admin/post/taxonomy/" . $type);
        }
    }

    /**
     * 编辑分类或者标签
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function editTaxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");
        $id = $this->dispatcher->getParam("id");

        $termTaxonomy = TermTaxonomy::findFirst($id);
        if ($termTaxonomy) {
            $description = $termTaxonomy->description;
            $term = $termTaxonomy->Terms;
            $name = $term->name;
            $slug = $term->slug;

            if ($type == 'category') {
                $topTitle = '编辑分类';
                $this->tag->prependTitle("编辑分类 - ");
                $parent = $termTaxonomy->parent;

                //分类列表
                /** @var PostService $postsService */
                $postService = container(PostService::class);
                $category = $postService->getTaxonomyListByType('category');
                $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

                $this->view->categoryTree = treeHtml($categoryTree, 'term_taxonomy_id', 'name', '', 0, $parent);

            } elseif ($type == 'tag') {
                $topTitle = '编辑标签';
                $this->tag->prependTitle("编辑标签 - ");
            } else {
                $this->flash->error("错误操作!");
                return $this->response->redirect("admin/");
            }

            $this->view->setVars(
                [
                    "type" => $type,
                    "topTitle" => $topTitle,
                    "id" => $id,
                    "name" => $name,
                    "slug" => $slug,
                    "description" => $description,
                ]
            );

        } else {
            $this->flash->error("错误操作!");
            return $this->response->redirect("admin/");
        }
    }

    /**
     * 更新分类或标签
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function updateTaxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");
        $id = $this->dispatcher->getParam("id");

        if ($type == 'category' || 'tag') {

            if ($this->request->isPost()) {
                // 获取POST数据
                $name = $this->request->getPost('name', ['string', 'trim']);
                $slug = $this->request->getPost('slug', ['string', 'trim', 'lower']);
                $parent = $this->request->getPost('parent', 'int', 0);
                $description = $this->request->getPost('description', ['string', 'trim']);

                $termTaxonomy = TermTaxonomy::findFirst($id);
                if ($termTaxonomy) {
                    $termTaxonomy->description = $description;
                    $termTaxonomy->parent = $parent;

                    $term = $termTaxonomy->Terms;
                    $term->name = $name;
                    $term->slug = $slug;

                    if ($termTaxonomy->save()) {
                        $this->flash->success("更新成功");
                        return $this->response->redirect("admin/post/editTaxonomy/" . $type . '/' . $id);

                    } else {
                        $messages = $this->getErrorMsg($termTaxonomy, "更新失败");
                        $this->flash->error($messages);
                        return $this->response->redirect("admin/post/editTaxonomy/" . $type . '/' . $id);
                    }
                }
            }
        }

        $this->flash->error("请求错误!");
        return $this->response->redirect("admin/");
    }

    /**
     * 删除分类或标签
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function deleteTaxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");
        $id = $this->dispatcher->getParam("id");

        // accept a transaction manager
        $manager = $this->transactions;

        // Request a transaction
        $transaction = $manager->get();

        $termTaxonomy = TermTaxonomy::findFirst($id);
        if ($termTaxonomy) {
            $termTaxonomy->setTransaction($transaction); // 设置事务
            $term = $termTaxonomy->Terms;

            if ($termTaxonomy->delete() === false) {

                $messages = $this->getErrorMsg($termTaxonomy, "删除失败");

                $transaction->rollback($messages); // 回滚

                $this->flash->error($messages);
                return $this->response->redirect("admin/post/editTaxonomy/" . $type . '/' . $id);

            } else {

                if ($term->delete() === false) {
                    $messages = $this->getErrorMsg($term, "删除失败");

                    $transaction->rollback($messages); // 回滚

                    $this->flash->error($messages);
                    return $this->response->redirect("admin/post/editTaxonomy/" . $type . '/' . $id);

                } else {
                    $transaction->commit(); //提交

                    $this->flash->success("删除成功");
                    return $this->response->redirect("admin/post/taxonomy/" . $type);
                }
            }

        } else {
            $this->flash->success("错误的操作");
            return $this->response->redirect("admin/post/taxonomy/" . $type);
        }
    }

    /**
     * 分类/标签 页面
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function taxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");
        // 当前页数
        $currentPage = abs($this->request->getQuery('page', 'int', 1));
        if ($currentPage == 0) {
            $currentPage = 1;
        }

        /**
         * 分类目录
         */
        if ($type == 'category') {
            $this->tag->prependTitle("分类 - ");
            $topTitle = '分类';
            $topSubtitle = '文章的分类';

            /** @var PostService $postsService */
            $postService = container(PostService::class);
            $category = $postService->getTaxonomyListByType('category');
            $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

            // 获取分类列表
            $pager = new Pager(
                new PaginatorArray(
                    [
                        "data" => $category,
                        "limit" => 20,
                        "page" => $currentPage,
                    ]
                ),
                [
                    'layoutClass' => 'ZPhal\Modules\Admin\Library\Paginator\Pager\Layout\Bootstrap', // 样式类
                    'rangeLength' => 5, // 分页长度
                    'urlMask' => '?page={%page_number}', // 额外url传参
                ]
            );

            $this->view->setVars(
                [
                    "type" => $type,
                    "topTitle" => $topTitle,
                    "topSubtitle" => $topSubtitle,
                    "categoryTree" => treeHtml($categoryTree, 'term_taxonomy_id', 'name'),
                    "pager" => $pager
                ]
            );

        } /**
         * 标签
         */
        elseif ($type == 'tag') {
            $this->tag->prependTitle("标签 - ");
            $topTitle = '标签';
            $topSubtitle = '文章贴标签';

            $postService = container(PostService::class);
            $tags = $postService->getTaxonomyListByType('tag');

            /**
             * 获取分类列表
             */
            $pager = new Pager(
                new PaginatorArray(
                    [
                        "data" => $tags,
                        "limit" => 20,
                        "page" => $currentPage,
                    ]
                ),
                [
                    // We will use Bootstrap framework styles
                    'layoutClass' => 'ZPhal\Modules\Admin\Library\Paginator\Pager\Layout\Bootstrap',
                    // Range window will be 5 pages
                    'rangeLength' => 5,
                    // Just a string with URL mask
                    'urlMask' => '?page={%page_number}',
                ]
            );

            $this->view->setVars(
                [
                    "type" => $type,
                    "topTitle" => $topTitle,
                    "topSubtitle" => $topSubtitle,
                    "pager" => $pager
                ]
            );

        } else {

            $this->flash->error("错误操作!");
            return $this->response->redirect("admin/");
        }
    }
}