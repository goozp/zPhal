<?php
namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $this->checkLogin();
        $this->initValues();
        $this->staticResource();

        // TODO 读取配置获取网站名称
        $this->tag->setTitle("ZPhal后台管理");
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
     * 获取用户id
     * @return mixed
     */
    public function getUserId()
    {
        $auth = $this->session->get("userAuth");
        return $auth['userId'];
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
     * 静态资源
     */
    public function staticResource()
    {
        // HTML 头部的js资源
        $this->assets->addCss("backend/library/bootstrap/css/bootstrap.min.css", true);
        $this->assets->addCss("backend/library/font-awesome/css/font-awesome.min.css", true);
        $this->assets->addCss("backend/library/Ionicons/css/ionicons.min.css", true);
        $this->assets->addCss("backend/library/AdminLTE/css/AdminLTE-without-plugins.min.css", true);
        $this->assets->addCss("backend/library/AdminLTE/css/skin-black.min.css", true);

        // HTML尾部的js资源
        $this->assets->addJs("backend/js/jquery.min.js", true);
        $this->assets->addJs("backend/js/jquery.slimscroll.min.js", true);
        $this->assets->addJs("backend/library/bootstrap/js/bootstrap.min.js", true);
        $this->assets->addJs("backend/library/fastclick/lib/fastclick.js", true);
        $this->assets->addJs("backend/library/AdminLTE/js/adminlte.min.js", true);
    }

    /**
     * 获取错误信息
     * @param $object
     * @param $message
     * @return mixed
     */
    public function getErrorMsg($object, $message)
    {
        $control = $this->di->get("messageControl"); // 单例

        $output = $control->getErrorMsg($object, $message);

        return $output;
    }
}
