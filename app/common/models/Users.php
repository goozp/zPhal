<?php

namespace ZPhal\Models;

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;;
use Phalcon\Validation\Validator\InclusionIn as InclusionValidator;
use Phalcon\Validation\Validator\Email as EmailValidator;


class Users extends ModelBase
{
    const DELETED = 1;

    const NOT_DELETED = 0;

    public $ID;

    public $user_login;

    public $user_pass;

    public $user_nickname;

    public $user_email;

    public $user_url;

    public $user_registered;

    public $user_activation_key;

    public $user_status; // 0 正常 1删除 9 出错

    public $display_name;

    public $user_role;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_users");

        $this->hasMany(
            "ID",
            "ZPhal\\Models\\Usermeta",
            "user_id"
        );

        // 软删除
        $this->addBehavior(
            new SoftDelete(
                [
                    "field" => "user_status",
                    "value" => Users::DELETED,
                ]
            )
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_users';
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'user_email',
            new EmailValidator([
                'message' => '错误的邮箱格式。'
            ])
        );

        $validator->add(
            'user_email',
            new UniquenessValidator([
                'message' => '邮箱已存在！'
            ])
        );

        $validator->add(
            'user_login',
            new UniquenessValidator([
                'message' => '用户名已存在！'
            ])
        );

        $validator->add(
            "user_role",
            new InclusionValidator(
                [
                    "message" => "角色只能为subscriber，writer，editor或者administrator。",
                    "domain" => [
                        "subscriber",
                        "writer",
                        "editor",
                        "administrator",
                        ]
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * 插入新数据前
     */
    public function beforeCreate()
    {
        if (!$this->user_nickname){
            $this->user_nickname = $this->user_login;
        }

        if (!$this->display_name){
            $this->display_name  = $this->user_login;
        }

        $this->user_status   = 0;

        if (!$this->user_registered){
            $this->user_registered = date('Y-m-d H:i:s', time());
        }
    }
}
