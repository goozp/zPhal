<?php

namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class ErrorController extends Controller
{

    public function indexAction()
    {
        $this->view->setRenderLevel(
            View::LEVEL_ACTION_VIEW
        );
    }

    public function route404Action()
    {
        echo 123;
    }
}