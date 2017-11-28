<?php

namespace ZPhal\Models;

class Postmeta extends ModelBase
{

    public $meta_id;

    public $post_id;

    public $meta_key;

    public $meta_value;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_postmeta");

        $this->belongsTo(
            "post_id",
            "ZPhal\\Models\\Posts",
            "ID"
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_postmeta';
    }
}
