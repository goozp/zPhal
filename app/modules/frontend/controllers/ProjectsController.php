<?php
namespace ZPhal\Modules\Frontend\Controllers;

class ProjectsController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("product");
    }

    public function indexAction()
    {
        $this->tag->prependTitle('作品' . " - ");

    }

}