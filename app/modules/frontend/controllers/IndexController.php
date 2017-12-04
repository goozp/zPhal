<?php

namespace ZPhal\Modules\Frontend\Controllers;

use ZPhal\Library\Options\Redis;

class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("common");
    }

    public function indexAction()
    {
        $options = Redis::getInstance();

        $this->tag->setTitle($options->get('blogdescription'));
        $this->tag->prependTitle($options->get('blogname') . " - ");
    }

}

