<?php

namespace ZPhal\Models\Services\Service;

use ZPhal\Models\Services\AbstractService;

/**
 * Taxonomy服务类
 * Class TaxonomyService
 * @package ZPhal\Models\Services\Service
 */
class TaxonomyService extends AbstractService
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
     * 根据类型获取分类列表
     * @param $type
     * @return mixed
     */
    public function getTaxonomyListByType($type)
    {
        return self::$modelsManager->executeQuery(
            "SELECT tt.term_taxonomy_id, tt.term_id, tt.description, tt.parent, tt.count, t.name, t.slug
                  FROM ZPhal\Models\TermTaxonomy AS tt
                  LEFT JOIN ZPhal\Models\Terms AS t ON t.term_id=tt.term_id
                  WHERE tt.taxonomy = :taxonomy:
                  ORDER BY t.term_id ASC",
            [
                "taxonomy" => $type,
            ]
        )->toArray();
    }

    /**
     * 获取post的分类或标签
     * @param $objectId
     * @param string $type category|tag 默认全部
     * @return array
     */
    public function getPostTaxonomy($objectId, $type='')
    {
        $builder = self::$modelsManager->createBuilder()
            ->columns("tr.term_taxonomy_id, tt.taxonomy")
            ->from(['tr' => 'ZPhal\Models\TermRelationships'])
            ->leftJoin('ZPhal\Models\TermTaxonomy', 'tt.term_taxonomy_id = tr.term_taxonomy_id', "tt")
            ->where("tr.object_id = :id:", ["id" => $objectId]);

        if ($type != ''){
            $builder->andWhere("tt.taxonomy = :taxonomy:", ["taxonomy" => $type]);
        }

        $taxonomy = $builder
            ->getQuery()
            ->execute()
            ->toArray();

        $output = [];
        foreach ($taxonomy as $item){
            $output[$item['taxonomy']][] = $item['term_taxonomy_id'];
        }

        return $output;
    }

    /**
     * 获取链接的链接分类
     * @param $objectId int 链接id
     * @return mixed
     */
    public function getLinkTaxonomy($objectId)
    {
        $taxonomy = self::$modelsManager->createBuilder()
            ->columns("tr.term_taxonomy_id")
            ->from(['tr' => 'ZPhal\Models\TermRelationships'])
            ->leftJoin('ZPhal\Models\TermTaxonomy', 'tt.term_taxonomy_id = tr.term_taxonomy_id', "tt")
            ->where("tr.object_id = :id:", ["id" => $objectId])
            ->andWhere("tt.taxonomy = 'linkCategory'")
            ->getQuery()
            ->execute()
            ->toArray();
        return $taxonomy;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function separateTaxonomyById($id)
    {
        $idArray = explode(',', $id);

        $taxonomy = self::$modelsManager->createBuilder()
            ->columns("tt.term_taxonomy_id, tt.taxonomy, t.name, t.slug")
            ->from(['tt' => 'ZPhal\Models\TermTaxonomy'])
            ->join('ZPhal\Models\Terms', 'tt.term_id = t.term_id', "t")
            ->inWhere("tt.term_taxonomy_id", $idArray)
            ->getQuery()
            ->execute()
            ->toArray();

        return $taxonomy;
    }
}