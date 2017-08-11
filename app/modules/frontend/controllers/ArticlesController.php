<?php

namespace ZPhal\Modules\Frontend\Controllers;

class ArticlesController extends ControllerBase
{

    public function indexAction()
    {
        $array = $this -> dispatcher -> getParams('id');
        print_r($array);exit;
    }

}

