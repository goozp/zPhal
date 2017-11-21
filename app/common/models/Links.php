<?php

namespace ZPhal\Models;

class Links extends \Phalcon\Mvc\Model
{

    public $link_id;

    public $link_url;

    public $link_name;

    public $link_image;

    public $link_target;

    public $link_description;

    public $link_visible;

    public $link_owner;

    public $link_rating;

    public $link_updated;

    public $link_rel;

    public $link_notes;

    public $link_rss;

    const VISIBLE_SHOW = 'Y';

    const VISIBLE_HIDE = 'N';

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
