<?php

namespace ZPhal\Modules\Frontend\Controllers;

class ArticlesController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("Article");
    }

    public function indexAction($id)
    {
        $this->tag->prependTitle('文章标题'.$id . " - ");

        /* 静态资源 */
        $this->assets->addCss("backend/plugins/editor.md/css/editormd.preview.css", true);

        $this->assets->addJs("backend/plugins/editor.md/lib/marked.min.js", true);
        $this->assets->addJs("backend/plugins/editor.md/lib/prettify.min.js", true);
        $this->assets->addJs("backend/plugins/editor.md/lib/raphael.min.js", true);
        $this->assets->addJs("backend/plugins/editor.md/lib/underscore.min.js", true);
        $this->assets->addJs("backend/plugins/editor.md/lib/sequence-diagram.min.js", true);
        $this->assets->addJs("backend/plugins/editor.md/lib/flowchart.min.js", true);
        $this->assets->addJs("backend/plugins/editor.md/lib/jquery.flowchart.min.js", true);
        $this->assets->addJs("backend/plugins/editor.md/editormd.min.js", true);
        $this->assets->addJs("themes/default/public/js/article.js", true);
    }

}

