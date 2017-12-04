<?php

namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function initialize()
    {
        $this->tag->setTitle($this->option->get('blogname') . " | ZPhal");
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

