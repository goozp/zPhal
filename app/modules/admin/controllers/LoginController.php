<?php

namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{

    public function indexAction()
    {
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

