<?php

namespace ZPhal\Models;

class Terms extends \Phalcon\Mvc\Model
{

    public $Term_id;

    public $Name;

    public $Slug;

    public $Term_group;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_terms");
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
