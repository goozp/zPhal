<?php
namespace ZPhal\Modules\Frontend\Controllers;

class ArchivesController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("archive");
    }

    public function indexAction()
    {
        $this->tag->prependTitle('归档' . " - ");

    }

}