<?php
namespace ZPhal\Modules\Frontend\Controllers;

use ZPhal\Models\Terms;
use ZPhal\Models\Services\Service\TaxonomyService;
use ZPhal\Modules\Frontend\Libraries\Paginator\Pager;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

class TaxonomyController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("common");
    }

    public function categoryAction($param='')
    {
        $this->tag->prependTitle('' . " - ");

        if ($param){
            $termId = $this->getTermIdBySlug($param);

            if ($termId){
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
                    ->where("p.post_status = 'publish' AND p.post_type = 'post' AND tt.term_id = :termId: AND tt.taxonomy = 'category' ",['termId' => $termId])
                    ->orderBy('p.post_date DESC');

                /**
                 * get data page
                 * 数据做分页
                 */
                $pager = new Pager(
                    new PaginatorQueryBuilder(
                        [
                            'builder' => $builder,
                            'limit'   => $this->option->get('posts_per_page'),
                            'page'    => $this->request->getQuery('page', 'int', 1),
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
                if ($this->request->getQuery('page', 'int', 1) > $totalPages){
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
            }else{
                $this->dispatcher->forward(
                    [
                        'controller' => 'error',
                        'action'     => 'route404'
                    ]
                );
            }

        }else{
            $this->dispatcher->forward(
                [
                    'controller' => 'error',
                    'action'     => 'route404'
                ]
            );
        }
    }

    public function tagAction($param='')
    {
        $this->tag->prependTitle('' . " - ");

    }

    /**
     * 通过别名获取termId
     *
     * @param $slug
     * @return bool|\Phalcon\Mvc\Model\Resultset|\Phalcon\Mvc\Phalcon\Mvc\Model
     */
    protected function getTermIdBySlug($slug)
    {
        $term = Terms::findFirst(
            [
                "slug = :slug:",
                'bind' => [
                    'slug' => $slug,
                ]
            ]
        );

        if ($term){
            return $term->term_id;
        }else{
            return false;
        }
    }
}