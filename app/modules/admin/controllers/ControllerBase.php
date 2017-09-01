<?php
namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $controllerName = $this->dispatcher->getControllerName();
        $actionName = $this->dispatcher->getActionName();
        $this->view->setVars(
            [
                "controllerName" => $controllerName,
                "actionName" => $actionName
            ]
        );
    }

    public function indexAction()
    {

    }
}
