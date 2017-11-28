<?php

namespace ZPhal\Models;

class Termmeta extends ModelBase
{

    public $meta_id;

    public $term_id;

    public $meta_key;

    public $meta_value;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_termmeta");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_termmeta';
    }
}
