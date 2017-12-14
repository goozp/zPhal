<?php
namespace ZPhal\Modules\Frontend\Controllers;

class SubjectsController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("subject");
    }

    public function subjectAction($param='')
    {
        $this->tag->prependTitle('专题' . " - ");

    }

    public function detailAction($param='')
    {
        $this->tag->prependTitle('专题' . " - ");

    }

}