<?php

namespace ZPhal\Models;

class Terms extends ModelBase
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
        parent::initialize();
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
}
