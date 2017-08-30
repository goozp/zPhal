<?php
namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $this->view->setTemplateBefore("common");
    }

    public function indexAction()
    {

    }
}
