<?php
namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\View;

class MediaController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {

    }

    public function newAction()
    {
        $this->view->setRenderLevel(
            View::LEVEL_ACTION_VIEW
        );

        $this->assets->addCss("backend/library/bootstrap-fileinput/css/fileinput.min.css", true);
        $this->assets->addJs("backend/library/bootstrap-fileinput/js/fileinput.min.js", true);
        $this->assets->addJs("backend/library/bootstrap-fileinput/js/locales/zh.js", true);
        $this->assets->addJs("backend/library/bootstrap-fileinput/themes/fa/theme.min.js", true);
        /*$this->assets->addJs("backend/js/upload.js", true);*/
    }

    public function uploadAction()
    {
        // 检测是否上传文件
        if ($this->request->hasFiles()) {
            $files = $this->request->getUploadedFiles();
            $uploadDir = $this->config->application->uploadDir;

            // 遍历所有文件
            foreach ($files as $file) {
                // Print file details
                echo $file->getName(), " ", $file->getSize(), "\n";

                // 保存文件
                if ($file->moveTo( $uploadDir . $file->getName() )){
                    $output['error'] = 'You are not allowed to upload such a file.';
                    return json_encode($output);
                }
            }
        }
    }
}