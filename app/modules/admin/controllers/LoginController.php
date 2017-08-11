<?php

namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{

    public function indexAction()
    {
        $array = $this -> dispatcher -> getParams('id');
        print_r($array);exit;
    }

}

