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
         * 创建后更新专题的统计数据和更新时间
         */
        $subject = $this->Subject;
        if ($subject){
            $subject->updateNewStatus();
        }
    }

    public function afterDelete()
    {
        /**
         * 删除后更新专题的统计数据
         */
        $subject = $this->Subject;
        if ($subject){
            $subject->updateDeleteStatus();
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