<?php

namespace ZPhal\Models;

class Users extends \Phalcon\Mvc\Model
{

    public $Id;

    public $User_login;

    public $User_pass;

    public $User_nicename;

    public $User_email;

    public $User_url;

    public $User_registered;

    public $User_activation_key;

    public $User_status;

    public $Display_name;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_users");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_users';
    }

    /**
     * TODO 没有生效
     */
    public function beforeCreate()
    {
        if (!$this->User_nicename){
            $this->User_nicename = $this->User_login;
        }

        if (!$this->Display_name){
            $this->Display_name  = $this->user_login;
        }

        $this->User_status   = 0;
        $this->User_registered = date('Y-m-d H:i:s', time());
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpUsers[]|ZpUsers|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpUsers|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
