<?php

namespace ZPhal\Models;

class Posts extends \Phalcon\Mvc\Model
{

    public $Id;

    public $Post_author;

    public $Post_date;

    public $Post_date_gmt;

    public $Post_content;

    public $Post_title;

    public $Post_status;

    public $Comment_status;

    public $Post_name;

    public $Post_modified;

    public $Post_modified_gmt;

    public $Post_parent;

    public $Guid;

    public $Post_type;

    public $Post_mime_type;

    public $Comment_count;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_posts");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_posts';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpPosts[]|ZpPosts|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpPosts|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
