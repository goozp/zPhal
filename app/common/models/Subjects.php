<?php

namespace ZPhal\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;;

class Subjects extends \Phalcon\Mvc\Model
{
    public $subject_id;

    public $subject_name;

    public $subject_slug;

    public $subject_image;

    public $subject_description;

    public $count;

    public $last_updated; // 默认1000-01-01 00:00:00为没有更新

    public $parent;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_subjects");

        $this->hasMany(
            "subject_id",
            "ZPhal\\Models\\SubjectRelationships",
            "subject_id",
            [
                "alias" => "SubjectRelation",
            ]
        );
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'subject_name',
            new UniquenessValidator([
                'message' => '专题名已存在！'
            ])
        );

        $validator->add(
            'subject_slug',
            new UniquenessValidator([
                'message' => '别名已存在！'
            ])
        );

        return $this->validate($validator);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_subjects';
    }

    /**
     * 获取上次更新时间
     * @return string
     */
    public function getLastUpdated()
    {
        if ($this->last_updated == '1000-01-01 00:00:00'){
            return '暂无更新';
        }else{
            return $this->last_updated;
        }
    }

    /**
     * 递归更新父级的数目和更新时间
     * @param $parent
     */
    public function updateParentStatus($parent)
    {
        $parentSubject = self::findFirst($parent);
        $parentSubject->last_updated = date("Y-m-d H:i:s" ,time());
        $parentSubject->count++;
        $parentSubject->save();
        if ($parentSubject->parent >0){
            return $this->updateParentStatus($parentSubject->parent);
        }
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