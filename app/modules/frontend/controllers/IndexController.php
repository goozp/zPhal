<?php

namespace ZPhal\Modules\Frontend\Controllers;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateAfter("common");
    }

    public function indexAction()
    {

    }

}

