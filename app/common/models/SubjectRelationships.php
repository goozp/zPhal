<?php

namespace ZPhal\Models;

class SubjectRelationships extends ModelBase
{
    public $object_id;

    public $subject_id;

    public $order;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_subject_relationships");

        $this->belongsTo(
            "subject_id",
            "ZPhal\\Models\\Subjects",
            "subject_id",
            [
                "alias" => "Subject",
            ]
        );

        $this->belongsTo(
            "object_id",
            "ZPhal\\Models\\Posts",
            "ID",
            [
                "alias" => "Post",
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
}