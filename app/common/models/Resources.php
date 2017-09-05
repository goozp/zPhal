<?php

namespace ZPhal\Models;

class Resources extends \Phalcon\Mvc\Model
{

    public $Resource_id;

    public $Upload_author;

    public $Upload_date;

    public $Upload_date_gmt;

    public $Resource_content;

    public $Resource_title;

    public $Resource_status;

    public $Resource_name;

    public $Resource_parent;

    public $Guid;

    public $Resource_type;

    public $Resource_mime_type;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_resources");
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

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpResources[]|ZpResources|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpResources|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
