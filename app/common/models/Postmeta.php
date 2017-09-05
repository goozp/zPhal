<?php

namespace ZPhal\Models;

class Postmeta extends \Phalcon\Mvc\Model
{

    public $Meta_id;

    public $Post_id;

    public $Meta_key;

    public $Meta_value;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_postmeta");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_postmeta';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpPostmeta[]|ZpPostmeta|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpPostmeta|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
