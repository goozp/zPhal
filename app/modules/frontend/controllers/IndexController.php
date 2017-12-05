<?php

namespace ZPhal\Modules\Frontend\Controllers;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("common");
    }

    public function indexAction()
    {
        $this->tag->prependTitle($this->option->get('blogname') . " - ");
        $this->tag->setTitle($this->option->get('blogdescription'));
    }

}

