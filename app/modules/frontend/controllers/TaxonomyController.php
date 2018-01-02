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
     * 根据taxonomy获取post列表
     *
     * @param string $param
     */
    public function listAction($param='')
    {
        $type = $this->dispatcher->getParam("type");
        $nowPage = $this->request->getQuery('page', 'int', 1);

        if ($param!= '' && !$this->view->getCache()->exists('taxonomy-'.$type.'-'.$param.'-page-'.$nowPage)) {

            if ($param){

                /**
                 * sql for post list
                 */
                $builder = $this
                    ->modelsManager
                    ->createBuilder()
                    ->from(['p' => 'ZPhal\Models\Posts'])
                    ->groupBy("p.ID")
                    ->join('ZPhal\Models\TermRelationships', 'tr.object_id = p.ID', 'tr')
                    ->join('ZPhal\Models\TermTaxonomy', "tt.term_taxonomy_id = tr.term_taxonomy_id AND tt.taxonomy = :type:", "tt")
                    ->join('ZPhal\Models\Terms', 't.term_id = tt.term_id', "t")
                    ->columns([
                        'p.ID as post_id',
                        'p.post_date as post_date',
                        'p.post_html_content as post_content',
                        'p.post_title as post_title',
                        'p.guid as post_url',
                        'p.cover_picture as cover_picture',
                        'p.comment_count',
                        'p.view_count',
                        't.name as taxonomy_name',
                    ])
                    ->where("p.post_status = 'publish' AND p.post_type = 'post' AND t.slug = :slug: AND tt.taxonomy = :type: ",
                        ['slug' => $param, 'type' => $type])
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
                            'page'    => $nowPage,
                        ]
                    ),
                    [
                        'layoutClass' => 'ZPhal\Modules\Frontend\Libraries\Paginator\Pager\Layout\Bootstrap', // 样式类
                        'rangeLength' => 6, // 分页长度
                        'urlMask'     => '?page={%page_number}', // 额外url传参
                    ]
                );

                // if current page over total page when total item is more than 0
                $totalPages = $pager->getTotalPage();
                $totalItems = $pager->count();
                if ($totalItems != 0){
                    if ($nowPage > $totalPages){
                        $this->dispatcher->forward(
                            [
                                "controller" => "error",
                                "action"    => "route404"
                            ]
                        );
                        return;
                    }
                }


                // the post list
                $postList = $pager->getIterator()->toArray();

                /**
                 * get categories and tags
                 */
                $taxonomy = [];
                if (!empty($postList)){
                    foreach ($postList as $post){
                        $taxonomy[$post['post_id']] = $this->getTaxonomy($post['post_id']);
                    }
                }

                //set title
                if($type == 'category'){
                    $this->tag->prependTitle($postList[0]['taxonomy_name'].' - 分类' . " - ");
                }elseif($type == 'tag'){
                    $this->tag->prependTitle($postList[0]['taxonomy_name'].' - 标签' . " - ");
                }else{
                    $this->tag->prependTitle($postList[0]['taxonomy_name']. " - ");
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
        }

        $this->view->cache(
            [
                'key' => 'taxonomy-'.$type.'-'.$param.'-page-'.$nowPage,
            ]
        );
    }

    /**
     * 根据postId获取taxonomy
     *
     * @param $id
     * @return array
     */
    protected function getTaxonomy($id)
    {
        $taxonomy = $this->modelsManager->createBuilder()
            ->columns("tr.term_taxonomy_id, tt.taxonomy, t.name, t.slug")
            ->from(['tr' => 'ZPhal\Models\TermRelationships'])
            ->leftJoin('ZPhal\Models\TermTaxonomy', 'tt.term_taxonomy_id = tr.term_taxonomy_id', "tt")
            ->leftJoin('ZPhal\Models\Terms', 't.term_id = tt.term_id', "t")
            ->where("tr.object_id = :id:", ["id" => $id])
            ->getQuery()
            ->execute();
        $taxonomy = empty($taxonomy) ?: $taxonomy->toArray();

        $output = [];
        foreach ($taxonomy as $item){
            if ($item['taxonomy'] == 'category' || $item['taxonomy'] == 'tag'){
                $output[$item['taxonomy']][] = $item;
            }
        }

        return $output;
    }
}