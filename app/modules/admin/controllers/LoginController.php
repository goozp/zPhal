<?php

namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function initialize()
    {
        // TODO 读取配置获取网站名称
        $this->tag->setTitle("ZPhal后台管理");
    }

    /**
     * 登录页面
     */
    public function indexAction()
    {
        $this->tag->prependTitle("登录 - ");

        $this->view->setRenderLevel(
            View::LEVEL_ACTION_VIEW
        );
    }

    public function loginAction()
    {
        /*$this->view->setRenderLevel(
            View::LEVEL_ACTION_VIEW
        );*/
        echo 123;
    }

    public function registerAction()
    {

    }

}

