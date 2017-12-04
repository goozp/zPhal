<?php

namespace ZPhal\Modules\Admin\Controllers;

class IndexController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $this->tag->prependTitle("仪表盘 - ");

        $this->view->setTemplateBefore("common");
    }
}

