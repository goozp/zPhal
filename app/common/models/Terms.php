<?php

namespace ZPhal\Models;

class Terms extends \Phalcon\Mvc\Model
{

    public $term_id;

    public $name;

    public $slug;

    public $term_group;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_terms");

        $this->hasOne(
            "term_id",
            "ZPhal\\Models\\TermTaxonomy",
            "term_id"
        );
    }

    /**
     * 返回关联的TermTaxonomy表
     * @param null $parameters
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getTermTaxonomy($parameters = null)
    {
        return $this->getRelated("ZPhal\\Models\\TermTaxonomy", $parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_terms';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTerms[]|ZpTerms|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTerms|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
