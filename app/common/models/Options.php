<?php

namespace ZPhal\Models;

class Options extends \Phalcon\Mvc\Model
{

    public $Option_id;

    public $Option_name;

    public $Option_value;

    public $Autoload;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_options");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_options';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpOptions[]|ZpOptions|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpOptions|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
