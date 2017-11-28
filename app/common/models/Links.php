<?php

namespace ZPhal\Models;

class Links extends ModelBase
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
        parent::initialize();
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
}
