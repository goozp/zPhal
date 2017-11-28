<?php

namespace ZPhal\Models;

class Options extends ModelBase
{

    public $option_id;

    public $option_name;

    public $option_value;

    public $autoload;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_options");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_options';
    }
}
