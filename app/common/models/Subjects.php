<?php

namespace ZPhal\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;;

class Subjects extends ModelBase
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
        parent::initialize();
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
     * 保存之后
     */
    public function afterSave()
    {
        $this->clearCache();
    }

    /**
     * 删除之后
     */
    public function afterDelete()
    {
        $this->clearCache();
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
     * 刷新更新时间
     */
    public function refreshUpdateTime()
    {
        $this->last_updated = date("Y-m-d H:i:s" ,time());
    }

    /**
     * count自增
     */
    public function incCount()
    {
        $this->count++;
    }

    /**
     * count自减
     */
    public function decCount()
    {
        $this->count--;
    }

    /**
     * 自增更新拥有数目和更新时间(包括parent)
     * @param int $parent
     */
    public function updateNewStatus($parent=0)
    {
        $update = $parent ? self::findFirst($parent) : $this;
        $update->refreshUpdateTime();
        $update->incCount();
        $update->save();
        if ($update->parent>0){
            $this->updateNewStatus($update->parent);
        }
    }

    /**
     * 自减更新拥有数目(包括parent)
     * @param int $parent
     */
    public function updateDeleteStatus($parent=0)
    {
        $update = $parent ? self::findFirst($parent) : $this;
        $update->decCount();
        $update->save();
        if ($update->parent>0){
            $this->updateDeleteStatus($update->parent);
        }
    }

    /**
     * 清除缓存
     */
    public function clearCache()
    {
        $viewCache = $this->getDI()->getShared('viewCache');
        $viewCache->delete('subject-'. $this->parent);
    }
}