<?php

namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\Controller;


class LoginController extends Controller
{

    public function indexAction()
    {
        print_r($this->request->get());exit;
    }

}

