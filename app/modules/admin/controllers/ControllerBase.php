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
     * 初始化数据
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

    /**
     * 获取错误信息
     * @param $object
     * @param $message
     * @return mixed
     */
    public function getErrorMsg($object, $message)
    {
        $output = $message."：\n";

        $msgs = $object->getMessages();
        foreach ($msgs as $msg) {
            $output .= $msg->getMessage()."\n";
        }

        return $output;
    }
}
