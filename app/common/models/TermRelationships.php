<?php

namespace ZPhal\Models;

class TermRelationships extends \Phalcon\Mvc\Model
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
        $this->setSchema("zphaldb");
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
        $this->TermTaxonomy->count++;
        $this->TermTaxonomy->save();
        if ($this->TermTaxonomy->parent > 0){
            $this->incTermTaxonomyCount($this->TermTaxonomy->parent);
        }

    }

    /**
     * 递归更新父级分类的post数目 ++
     * @param $parent
     */
    public function incTermTaxonomyCount($parent)
    {
        $TermTaxonomy = TermTaxonomy::findFirst($parent);
        $TermTaxonomy ->count++;
        $TermTaxonomy ->save();
        if ($TermTaxonomy->parent > 0){
            $this->incTermTaxonomyCount($parent);
        }
    }

    public function afterUpdate()
    {

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

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermRelationships[]|ZpTermRelationships|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermRelationships|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
