<?php

namespace ZPhal\Modules\Frontend\Controllers;

use ZPhal\Models\Services\Service\TaxonomyService;
use ZPhal\Modules\Frontend\Libraries\Paginator\Pager;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("common");

        /**
         * widget for the template
         */
        $this->view->setVars([
            'widgetCategory' => $this->widget->getCategoryList(),
            'widgetNewArticle' => $this->widget->getNewArticles([
                'ulClass' => 'fa-ul ml-4 mb-0',
                'before' => '<i class="fa-li fa fa-angle-double-right"></i>'
            ])
        ]);
    }

    /**
     * dispatch index
     */
    public function indexAction()
    {
        $this->tag->prependTitle($this->option->get('blogname') . " - ");
        $this->tag->setTitle($this->option->get('blogdescription'));

        $show = $this->option->get('show_on_front');
        if ($show == 'posts'){

            $this->dispatcher->forward(
                [
                    "action"    => "article",
                ]
            );
        }elseif($show == 'page'){

            $this->dispatcher->forward(
                [
                    "action"    => "page",
                    "params" => [$this->option->get('show_on_front_page')]
                ]
            );
        }
    }

    /**
     * list for articles
     * 文章列表
     */
    public function articleAction()
    {
        $nowPage = $this->request->getQuery('page', 'int', 1);

        if (!$this->view->getCache()->exists('index-article-list-page-'.$nowPage)) {
            /**
             * sql for post list
             */
            $builder = $this
                ->modelsManager
                ->createBuilder()
                ->from(['p' => 'ZPhal\Models\Posts'])
                ->groupBy("p.ID")
                ->join('ZPhal\Models\TermRelationships', 'tr.object_id = p.ID', 'tr')
                ->join('ZPhal\Models\TermTaxonomy', "tt.term_taxonomy_id = tr.term_taxonomy_id AND tt.taxonomy = ('category' or 'tag')", "tt")
                ->columns([
                    'p.ID as post_id',
                    'p.post_date as post_date',
                    'p.post_html_content as post_content',
                    'p.post_title as post_title',
                    'p.guid as post_url',
                    'p.cover_picture as cover_picture',
                    'p.comment_count',
                    'p.view_count',
                    'GROUP_CONCAT( tr.term_taxonomy_id ) terms_id',
                ])
                ->where("post_status = 'publish' AND post_type = 'post' ")
                ->orderBy('post_date DESC');

            /**
             * get data page
             * 数据做分页
             */
            $pager = new Pager(
                new PaginatorQueryBuilder(
                    [
                        'builder' => $builder,
                        'limit'   => $this->option->get('posts_per_page'),
                        'page'    => $nowPage,
                    ]
                ),
                [
                    'layoutClass' => 'ZPhal\Modules\Frontend\Libraries\Paginator\Pager\Layout\Bootstrap', // 样式类
                    'rangeLength' => 6, // 分页长度
                    'urlMask'     => 'article?page={%page_number}', // 额外url传参
                ]
            );

            // if current page over total page
            $totalPages = $pager->getTotalPage();
            if ($nowPage > $totalPages){
                $this->dispatcher->forward(
                    [
                        "controller" => "error",
                        "action"    => "route404"
                    ]
                );
            }

            // the post list
            $postList = $pager->getIterator()->toArray();

            /**
             * get categories and tags
             */
            $taxonomyService = container(TaxonomyService::class);
            $taxonomy = [];
            foreach ($postList as $value){
                $taxonomyArray = $taxonomyService->getTaxonomyByIdStr($value['terms_id']);
                foreach ($taxonomyArray as $item){
                    $itemInfo = [
                        'term_taxonomy_id' => $item['term_taxonomy_id'],
                        'name' => $item['name'],
                        'slug' => $item['slug'],
                    ];

                    $taxonomy[$value['post_id']][$item['taxonomy']][] = $itemInfo;
                }
            }

            /**
             * get page output
             */
            if ($pager->haveToPaginate()) {
                $page = $pager->getLayout();
                $this->view->setVar('page', $page);
            }

            /**
             * set values
             */
            $this->view->setVars([
                'posts' => $postList,
                'taxonomy' => $taxonomy,
            ]);

        }

        $this->view->cache(
            [
                'key' => 'index-article-list-page-'.$nowPage,
            ]
        );
    }

    /**
     * list for page
     * 展示页面
     */
    public function pageAction($id)
    {
        echo "page id = ".$id;
    }
}

