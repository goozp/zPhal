<?php
namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Services\Service\PostService;
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

    public function indexAction()
    {
        $this->tag->prependTitle("文章列表 - ");
    }

    public function newAction()
    {
        $this->tag->prependTitle("新文章 - ");

        /* 编辑器静态资源 */
        $this->assets->addCss("backend/plugins/editor.md/css/editormd.css", true);
        $this->assets->addJs("backend/plugins/editor.md/editormd.min.js", true);
        $this->assets->addJs("backend/js/md.js", true);
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
        $parent = $this->request->getPost('parent', 'int');
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