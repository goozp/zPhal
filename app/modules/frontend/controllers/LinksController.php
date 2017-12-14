<?php
namespace ZPhal\Modules\Frontend\Controllers;

class LinksController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("link");
    }

    public function indexAction()
    {
        $this->tag->prependTitle('链接' . " - ");

    }

}