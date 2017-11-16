<?php

namespace ZPhal\Modules\Frontend\Controllers;

class PagesController extends ControllerBase
{

    public function indexAction()
    {
        $array = $this -> dispatcher -> getParams('param');
        print_r($array);exit;
    }

}
