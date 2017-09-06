<?php
namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $this->checkLogin();
        $this->initValues();
    }

    /**
     * 检测登录
     * @return bool|\Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function checkLogin()
    {
        if (!$this->session->has("userAuth")) {
            return $this->response->redirect("login");
        }
        return true;
    }

    /**
     * 初始化
     */
    public function initValues()
    {
        // 菜单栏固定
        $this->view->setVars(
            [
                "controllerName" => $this->dispatcher->getControllerName(),
                "actionName" => $this->dispatcher->getActionName()
            ]
        );
    }

    public function indexAction()
    {

    }
}
