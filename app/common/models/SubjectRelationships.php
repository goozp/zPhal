<?php

namespace ZPhal\Models;

class SubjectRelationships extends \Phalcon\Mvc\Model
{
    public $object_id;

    public $subject_id;

    public $order;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_subject_relationships");

        $this->belongsTo(
            "subject_id",
            "ZPhal\\Models\\Subjects",
            "subject_id",
            [
                "alias" => "Subject",
            ]
        );
    }

    public function afterCreate()
    {
        /**
         * 更新专题的统计数据和更新时间
         */
        $subject = $this->Subject;
        $subject->last_updated = date("Y-m-d H:i:s" ,time());
        $subject->count++;
        $subject->save();
        if ($subject->parent>0){
            $subject->updateParentStatus($subject->parent);
        }
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_subject_relationships';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermmeta[]|ZpTermmeta|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermmeta|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}