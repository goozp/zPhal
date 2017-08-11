<?php

namespace ZPhal\Modules\Frontend\Controllers;

class ArticlesController extends ControllerBase
{

    public function indexAction()
    {
        echo $this->request->get('id');
        print_r($_GET);
        //echo 1;
    }

}

