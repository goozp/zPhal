<?php

namespace ZPhal\Models;

class Comments extends \Phalcon\Mvc\Model
{

    public $Comment_id;

    public $Comment_post_id;

    public $Comment_author;

    public $Comment_author_email;

    public $Comment_author_url;

    public $Comment_author_ip;

    public $Comment_date;

    public $Comment_date_gmt;

    public $Comment_content;

    public $Comment_approved;

    public $Comment_agent;

    public $Comment_parent;

    public $User_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_comments");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_comments';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpComments[]|ZpComments|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpComments|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
