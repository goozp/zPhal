<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Users;

class UserController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $users = Users::find(
            [
                "order" => "ID",
                "limit" => 10,
            ]
        );

        $this->view->setVars(
            [
                "users" => $users,
            ]
        );
    }

    public function newAction()
    {

    }

    public function selfAction()
    {

    }
}

