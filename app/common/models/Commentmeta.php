<?php

namespace ZPhal\Models;

class Commentmeta extends ModelBase
{

    public $meta_id;

    public $comment_id;

    public $meta_key;

    public $meta_value;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_commentmeta");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_commentmeta';
    }
}
