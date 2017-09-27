<?php

namespace ZPhal\Models\Services\Service;

use ZPhal\Models\Services\AbstractService;

class PostService extends AbstractService
{
    /**
     * 根据类型获取分类列表
     * @param $type
     * @return mixed
     */
    public function getTaxonomyListByType($type)
    {
        /** @var \Phalcon\Mvc\Model\Manager $modelsManager */
        $modelsManager = container('modelsManager');

        return $modelsManager->executeQuery(
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
}