<?php

namespace ZPhal\Models;

use Phalcon\Mvc\Model;

class Users extends Model
{
    public function initialize()
    {
        $this->setSource("zp_users");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Member[]|Member
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }
    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Member
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}