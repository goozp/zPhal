<?php

namespace ZPhal\Models;

class Links extends \Phalcon\Mvc\Model
{

    public $Link_id;

    public $Link_url;

    public $Link_name;

    public $Link_image;

    public $Link_target;

    public $Link_description;

    public $Link_visible;

    public $Link_owner;

    public $Link_rating;

    public $Link_updated;

    public $Link_rel;

    public $Link_notes;

    public $Link_rss;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_links");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_links';
    }

    /**
     * 插入新数据前
     */
    public function beforeCreate()
    {
        $this->link_updated = date('Y-m-d H:i:s', time());
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpLinks[]|ZpLinks|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpLinks|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
