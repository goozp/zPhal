<?php

namespace ZPhal\Modules\Frontend\Controllers;

class ArticlesController extends ControllerBase
{

    public function indexAction()
    {
        $array = $this -> dispatcher -> getParams('aid');
        print_r($array);exit;
    }

}

