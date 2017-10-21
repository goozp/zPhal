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

    
    public function staticPost($postType)
    {
        $modelsManager = $this->di->get('modelsManager') ?: container('modelsManager');
        
        $count = $modelsManager->executeQuery(
            "SELECT post_type, sum(case post_status when 'publish' then 1 else 0 end) AS publish_num,
            sum(case post_status when 'draft' then 1 else 0 end) AS draft_num,
            sum(case post_status when 'auto-draft' then 1 else 0 end) AS autodraft_num,
            sum(case post_status when 'trash' then 1 else 0 end) AS trash_num
            FROM ZPhal\Models\Posts 
            WHERE post_type = :posttype:",
            [
                'posttype' => $postType
            ]
        )->toArray();

        return $count[0];
    }

    /**
     * 获取结果的时间区间(格式年-月 '%Y-%m')
     * @param $type
     * @return mixed
     */
    public function getDateSection($postType){
        $modelsManager = $this->di->get('modelsManager') ?: container('modelsManager');
        
        return $modelsManager->executeQuery(
            "SELECT DATE_FORMAT(post_date,'%Y-%m') AS year_month
            FROM ZPhal\Models\Posts
            WHERE post_type = :posttype: 
            GROUP BY year_month",
            [
                'posttype' => $postType
            ]
        )->toArray();
    }
}