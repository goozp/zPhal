<?php

namespace ZPhal\Models;

use Phalcon\Mvc\Model;

/**
 * model基类
 * Class ModelBase
 *
 * @package ZPhal\Models
 */
class ModelBase extends Model
{
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Model\ResultsetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Model
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}