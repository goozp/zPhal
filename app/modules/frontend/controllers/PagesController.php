<?php

namespace ZPhal\Modules\Frontend\Controllers;

use ZPhal\Models\Posts;

class PagesController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("Page");
    }

    public function indexAction($param='')
    {
        $this->tag->prependTitle('页面标题' . " - ");

        $post = Posts::findFirst([
            "post_name='{$param}'"
        ]);

        /* 静态资源 */
        $this->assets->addCss("backend/library/github-markdown-css/github-markdown.css", true); // markdown样式

        $this->view->setVars([
            'content' => $post->post_html_content,
        ]);
    }

}
