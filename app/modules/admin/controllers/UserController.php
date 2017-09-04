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
        // 使用直接闪存
        /*$this->flash->success("Your information was stored correctly!");
        $this->flash->message('error',"Your information was stored correctly!");*/

        // 转发到index动作
        /*return $this->dispatcher->forward(["action" => "index"]);*/

        // 使用会话闪存
        $this->newFlash->success("Your information was stored correctly!");

        // 返回一个完整的HTTP重定向
        return $this->response->redirect("admin/user");
    }

    public function selfAction()
    {

    }
}

