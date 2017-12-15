<?php

namespace ZPhal\Modules\Frontend\Controllers;

use ZPhal\Models\Posts;
use ZPhal\Models\Services\Service\TaxonomyService;
use ZPhal\Models\TermRelationships;
use ZPhal\Modules\Frontend\Libraries\Paginator\Pager;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("common");
    }

    public function indexAction()
    {
        $this->tag->prependTitle($this->option->get('blogname') . " - ");
        $this->tag->setTitle($this->option->get('blogdescription'));

        $stime=microtime(true); //获取程序开始执行的时间



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


        // 分页查询
        $pager = new Pager(
            new PaginatorQueryBuilder(
                [
                    'builder' => $builder,
                    'limit'   => 10,
                    'page'    => $this->request->getQuery('page', 'int', 1),
                ]
            ),
            [
                'layoutClass' => 'ZPhal\Modules\Frontend\Libraries\Paginator\Pager\Layout\Bootstrap', // 样式类
                'rangeLength' => 5, // 分页长度
                'urlMask'     => '?page={%page_number}', // 额外url传参
            ]
        );

        $postList = $pager->getIterator();


        $taxonomyService = container(TaxonomyService::class);
        $taxonomy = [];
        foreach ($postList as $value){
            $taxonomyArray = $taxonomyService->separateTaxonomyById($value->terms_id);
            foreach ($taxonomyArray as $item){
                $itemInfo = [
                    'term_taxonomy_id' => $item['term_taxonomy_id'],
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                ];

                $taxonomy[$value['post_id']][$item['taxonomy']][] = $itemInfo;
            }
        }

        $etime=microtime(true);//获取程序执行结束的时间
        $total=$etime-$stime;   //计算差值
        echo "<br />[执行时间：{$total} ]秒";


/*========================*/
        $stime=microtime(true); //获取程序开始执行的时间



        $builder = $this
            ->modelsManager
            ->createBuilder()
            ->from(['p' => 'ZPhal\Models\Posts'])
            ->columns([
                'p.ID as post_id',
                'p.post_date as post_date',
                'p.post_html_content as post_content',
                'p.post_title as post_title',
                'p.guid as post_url',
                'p.cover_picture as cover_picture',
                'p.comment_count',
                'p.view_count',
            ])
            ->where("post_status = 'publish' AND post_type = 'post' ")
            ->orderBy('post_date DESC');

        // 分页查询
        $pager = new Pager(
            new PaginatorQueryBuilder(
                [
                    'builder' => $builder,
                    'limit'   => 10,
                    'page'    => $this->request->getQuery('page', 'int', 1),
                ]
            ),
            [
                'layoutClass' => 'ZPhal\Modules\Frontend\Libraries\Paginator\Pager\Layout\Bootstrap', // 样式类
                'rangeLength' => 5, // 分页长度
                'urlMask'     => '?page={%page_number}', // 额外url传参
            ]
        );

        $postList = $pager->getIterator();

        foreach ($postList as $list){
            $a = TermRelationships::find('object_id='.$list->post_id);

        }

        $etime=microtime(true);//获取程序执行结束的时间
        $total=$etime-$stime;   //计算差值
        echo "<br />[执行时间：{$total} ]秒";

        if ($pager->haveToPaginate()) {
            $page = $pager->getLayout();
        }
        exit;
    }

}

