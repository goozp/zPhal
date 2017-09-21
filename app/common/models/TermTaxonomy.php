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
            "term_id"
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
