<?php

namespace ZPhal\Models;

class Resourcemeta extends ModelBase
{

    public $meta_id;

    public $resource_id;

    public $meta_key;

    public $meta_value;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_resourcemeta");

        $this->belongsTo(
            "resource_id",
            "ZPhal\\Models\\Resources",
            "resource_id"
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_resourcemeta';
    }
}
