<?php

namespace ZPhal\Models;

class TermRelationships extends ModelBase
{

    public $object_id;

    public $term_taxonomy_id;

    public $term_order;

    /**
     * 初始化
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_term_relationships");

        $this->belongsTo(
            "term_taxonomy_id",
            "ZPhal\\Models\\TermTaxonomy",
            "term_taxonomy_id",
            [
                'alias' => 'TermTaxonomy'
            ]
        );

        $this->belongsTo(
            "object_id",
            "ZPhal\\Models\\Posts",
            "ID",
            [
                'alias' => 'Post'
            ]
        );
    }

    /**
     * 创建之后
     */
    public function afterCreate()
    {
        /**
         * 更新所属分类和标签的数目
         */
        $termTaxonomy = $this->TermTaxonomy;
        if ($termTaxonomy){
            $termTaxonomy->count++;
            $termTaxonomy->save();
        }

    }

    /**
     * 删除之后
     */
    public function afterDelete()
    {
        /**
         * 更新所属分类和标签的数目
         */
        $termTaxonomy = $this->TermTaxonomy;
        if ($termTaxonomy){
            $termTaxonomy->count--;
            $termTaxonomy->save();
        }
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_term_relationships';
    }
}
