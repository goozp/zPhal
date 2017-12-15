<?php

namespace ZPhal\Models\Services\Service;

use ZPhal\Models\Services\AbstractService;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use ZPhal\Modules\Admin\Library\Paginator\Pager;

/**
 * 链接服务类
 * Class LinkService
 * @package ZPhal\Models\Services\Service
 */
class LinkService extends AbstractService
{
    /**
     * @var mixed|\Phalcon\DiInterface
     */
    private static $modelsManager;

    /**
     * PostService constructor.
     * @param null $di
     */
    public function __construct($di = null)
    {
        parent::__construct($di);
        self::$modelsManager = $this->di->get('modelsManager') ?: container('modelsManager');
    }

    /**
     * 获取链接列表
     * TODO 多用户根据权限获取
     */
    public function getLinkList($currentPage, $condition)
    {
        $builder = self::$modelsManager->createBuilder()
            ->columns("l.link_id, l.link_name, l.link_url, l.link_visible, GROUP_CONCAT( t.name ) taxonomy")
            ->from(['l' => 'ZPhal\Models\Links'])
            ->leftJoin('ZPhal\Models\TermRelationships', 'ts.object_id = l.link_id', 'ts')
            ->leftJoin('ZPhal\Models\TermTaxonomy', 'tt.term_taxonomy_id = ts.term_taxonomy_id', 'tt')
            ->leftJoin('ZPhal\Models\Terms', "t.term_id = tt.term_id and tt.taxonomy = 'linkCategory'", 't');

        if ($condition['categorySelected']){
            $builder->andWhere("tt.term_taxonomy_id = :categorySelected:", [ "categorySelected" => $condition['categorySelected']]);
        }

        if (!empty($condition['search'])){
            $builder->andWhere("l.link_name LIKE :name:", ["name" => "%" . $condition['search'] . "%"]);
        }

        $builder->groupBy("l.link_id");
        $builder->orderBy('l.link_id desc');

        // 分页额外url传参
        $urlMask = '?page={%page_number}';
        foreach ($condition as $key => $value){
            $urlMask .= '&'.$key.'='.$value;
        }

        // 分页查询
        return $pager = new Pager(
            new PaginatorQueryBuilder(
                [
                    'builder' => $builder,
                    'limit'   => 20,
                    'page'    => $currentPage,
                ]
            ),
            [
                'layoutClass' => 'ZPhal\Modules\Admin\Library\Paginator\Pager\Layout\Bootstrap', // 样式类
                'rangeLength' => 5, // 分页长度
                'urlMask'     => $urlMask, // 额外url传参
            ]
        );
    }
}