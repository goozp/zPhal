<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\TermRelationships;
use ZPhal\Models\Terms;
use ZPhal\Models\TermTaxonomy;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use ZPhal\Modules\Admin\Library\Paginator\Pager;
use ZPhal\Models\Services\Service\PostService;

class TaxonomyController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 分类/标签/链接分类 页面
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
        if ($type == TermTaxonomy::TAXONOMY_CATEGORY) {
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
        elseif ($type == TermTaxonomy::TAXONOMY_TAG) {
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

        } elseif ($type == TermTaxonomy::TAXONOMY_LINK){
            $this->tag->prependTitle("链接分类 - ");
            $topTitle = '链接分类';
            $topSubtitle = '链接分类';

            $postService = container(PostService::class);
            $linkCategory = $postService->getTaxonomyListByType('linkCategory');

            /**
             * 获取分类列表
             */
            $pager = new Pager(
                new PaginatorArray(
                    [
                        "data" => $linkCategory,
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
            return $this->response->redirect("admin/taxonomy/" . $type);
        } else {
            $messages = $this->getErrorMsg($termTaxonomy, "创建失败");
            $this->flash->error($messages);
            return $this->response->redirect("admin/taxonomy/" . $type);
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

            if ($type == TermTaxonomy::TAXONOMY_CATEGORY) {
                $topTitle = '编辑分类';
                $this->tag->prependTitle("编辑分类 - ");
                $parent = $termTaxonomy->parent;

                //分类列表
                /** @var PostService $postsService */
                $postService = container(PostService::class);
                $category = $postService->getTaxonomyListByType('category');
                $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

                $this->view->categoryTree = treeHtml($categoryTree, 'term_taxonomy_id', 'name', '', 0, $parent);

            } elseif ($type == TermTaxonomy::TAXONOMY_TAG) {
                $topTitle = '编辑标签';
                $this->tag->prependTitle("编辑标签 - ");
            } elseif ($type == TermTaxonomy::TAXONOMY_LINK){
                $topTitle = '编辑链接分类目录';
                $this->tag->prependTitle("编辑链接分类目录 - ");
            }else {
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

        if ($type == (TermTaxonomy::TAXONOMY_CATEGORY || TermTaxonomy::TAXONOMY_TAG || TermTaxonomy::TAXONOMY_LINK)) {
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
                        return $this->response->redirect("admin/taxonomy/editTaxonomy/" . $type . '/' . $id);

                    } else {
                        $messages = $this->getErrorMsg($termTaxonomy, "更新失败");
                        $this->flash->error($messages);
                        return $this->response->redirect("admin/taxonomy/editTaxonomy/" . $type . '/' . $id);
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
                return $this->response->redirect("admin/taxonomy/editTaxonomy/" . $type . '/' . $id);

            } else {
                // 清空关联表
                $TermRelationships = TermRelationships::find([
                    "conditions" => "term_taxonomy_id = ?1",
                    "bind" => [
                        1 => $id,
                    ]
                ]);
                foreach ($TermRelationships as $relationship){
                    if ($relationship->delete() === false){
                        $messages = $this->getErrorMsg($relationship, "删除失败");

                        $transaction->rollback($messages); // 回滚

                        $this->flash->error($messages);
                        return $this->response->redirect("admin/taxonomy/editTaxonomy/" . $type . '/' . $id);
                    }
                }

                //删除terms表数据
                if ($term->delete() === false) {
                    $messages = $this->getErrorMsg($term, "删除失败");

                    $transaction->rollback($messages); // 回滚

                    $this->flash->error($messages);
                    return $this->response->redirect("admin/taxonomy/editTaxonomy/" . $type . '/' . $id);

                } else {
                    $transaction->commit(); //提交

                    $this->flash->success("删除成功");
                    return $this->response->redirect("admin/taxonomy/" . $type);
                }
            }

        } else {
            $this->flash->success("错误的操作");
            return $this->response->redirect("admin/taxonomy/" . $type);
        }
    }

    /**
     * ajax快速添加分类或者标签
     */
    public function quickAddTaxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");

        if ($this->request->isPost()) {
            if ($type == TermTaxonomy::TAXONOMY_CATEGORY) {
                $name = $this->request->getPost('newCategory', ['string', 'trim']);
                $parent = $this->request->getPost('categoryParent', 'int', 0);
            } elseif ($type == TermTaxonomy::TAXONOMY_TAG) {
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
                if ($type == TermTaxonomy::TAXONOMY_CATEGORY) {
                    $postService = container(PostService::class);
                    $category = $postService->getTaxonomyListByType('category');
                    $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

                    $data = [
                        "categoryTree" => treeHtml($categoryTree, 'term_taxonomy_id', 'name', ' ', 0, 1, ' '),
                        "categoryTreeNbsp" => treeHtml($categoryTree, 'term_taxonomy_id', 'name'),
                    ];
                } elseif ($type == TermTaxonomy::TAXONOMY_TAG) {
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
}