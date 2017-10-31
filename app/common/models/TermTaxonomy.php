<?php

namespace ZPhal\Models;

class TermTaxonomy extends \Phalcon\Mvc\Model
{

    public $term_taxonomy_id;

    public $term_id;

    public $taxonomy;

    public $description;

    public $parent;

    public $count;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_term_taxonomy");

        $this->belongsTo(
            "term_id",
            "ZPhal\\Models\\Terms",
            "term_id",
            [
                "alias" => "Terms",
            ]
        );

        $this->hasManyToMany(
            "term_taxonomy_id",
            "ZPhal\\Models\\TermTaxonomy",
            "term_taxonomy_id",
            "object_id",
            "ZPhal\\Models\\TermRelationships",
            "ID",
            [
                'alias' => 'Post'
            ]
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_term_taxonomy';
    }

    /**
     * 获取父id
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * 递归父ID
     * @param array $allId
     * @param $id
     * @return array
     */
    public function getAllParent($allId = [], $id)
    {
        $parent = $id ? $id : $this->parent;
        if ($parent){
            $allId[] = $parent;
            $parentInfo = self::findFirst($parent);
            if ($parentInfo->parent){
                return $this->getAllParent($allId, $parentInfo->parent);
            }
        }
        return $allId;
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermTaxonomy[]|ZpTermTaxonomy|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermTaxonomy|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
