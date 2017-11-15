<?php

namespace ZPhal\Modules\Admin\Controllers;

/**
 * 页面
 * Class PageController
 * @package ZPhal\Modules\Admin\Controllers
 */
class PageController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $this->tag->prependTitle("页面 - ");

    }

    public function newAction()
    {
        $this->tag->prependTitle("创建页面 - ");

        /* 静态资源 */
        $this->assets->addCss("backend/plugins/editor.md/css/editormd.css", true);
        $this->assets->addCss("backend/library/select2/css/select2.min.css", true);
        $this->assets->addCss("backend/library/AdminLTE/css/AdminLTE-select2.min.css", true);
        $this->assets->addJs("backend/plugins/editor.md/editormd.min.js", true);
        $this->assets->addJs("backend/library/select2/js/select2.full.min.js", true);
        $this->assets->addJs("backend/js/page.js", true);


    }
}