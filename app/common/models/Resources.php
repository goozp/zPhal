<?php

namespace ZPhal\Models;

class Resources extends ModelBase
{

    public $resource_id;

    public $upload_author;

    public $upload_date;

    public $upload_date_gmt;

    public $resource_content;

    public $resource_title;

    public $resource_status;

    public $resource_name;

    public $resource_parent;

    public $guid;

    public $resource_type;

    public $resource_mime_type;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_resources");

        $this->hasMany(
            "resource_id",
            "ZPhal\\Models\\Resourcemeta",
            "resource_id"
        );

    }

    /**
     * 插入新数据前
     */
    public function beforeCreate()
    {
        if (!$this->upload_author){
            $auth = $this->di->get('session')->get('userAuth');
            $this->upload_author = $auth['userId'];
        }

        if (!$this->upload_date){
            $this->upload_date       = date('Y-m-d H:i:s', time());
        }

        if (!$this->upload_date_gmt){
            $this->upload_date_gmt   = gmdate('Y-m-d H:i:s', time());
        }

        $this->resource_status   = 'normal';
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_resources';
    }
}
