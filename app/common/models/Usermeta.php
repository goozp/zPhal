<?php

namespace ZPhal\Models;

class Usermeta extends ModelBase
{

    public $umeta_id;

    public $user_id;

    public $meta_key;

    public $meta_value;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_usermeta");

        $this->belongsTo(
            "user_id",
            "ZPhal\\Models\\Users",
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
        return 'zp_usermeta';
    }
}
