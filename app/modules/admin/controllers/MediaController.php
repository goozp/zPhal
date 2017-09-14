<?php
namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Mvc\View;
use ZPhal\Modules\Admin\Components\Media;

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

            //$media = new Media();

            $media = $this->di->get('mediaUpload');
            return $media->uploadMedia($files);
        }
    }
}