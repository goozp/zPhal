<?php

namespace ZPhal\Modules\Frontend\Controllers;

class PagesController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("Page");
    }

    public function indexAction($id)
    {
        $this->tag->prependTitle('文章标题'.$id . " - ");

        /* 静态资源 */
        $this->assets->addCss("backend/library/github-markdown-css/github-markdown.css", true); // markdown样式
    }

}
