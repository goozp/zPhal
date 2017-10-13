<?php

namespace ZPhal\Models;

class Comments extends \Phalcon\Mvc\Model
{

    public $comment_id;

    public $comment_post_id;

    public $comment_author;

    public $comment_author_email;

    public $comment_author_url;

    public $comment_author_ip;

    public $comment_date;

    public $comment_date_gmt;

    public $comment_content;

    public $comment_approved;

    public $comment_agent;

    public $comment_parent;

    public $user_id;

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
     * 插入新数据前
     */
    public function beforeCreate()
    {
        $this->comment_date = date('Y-m-d H:i:s', time());
        $this->comment_date_gmt = gmdate('Y-m-d H:i:s', time());
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
