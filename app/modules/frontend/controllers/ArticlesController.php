<?php

namespace ZPhal\Modules\Frontend\Controllers;

use ZPhal\Models\Posts;

class ArticlesController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("article");
    }

    public function indexAction($id)
    {
        $this->tag->prependTitle('文章标题'.$id . " - ");

        $post = Posts::findFirst($id);

        /* 静态资源 */
        $this->assets->addCss("backend/library/github-markdown-css/github-markdown.css", true); // markdown样式
        $this->assets->addCss("backend/library/highlight/styles/Github.css", true); // 代码高亮highlight主题; TODO 可配置
        $this->assets->addCss("backend/library/katex/katex.min.css", true); // 科学公式KaTeX

        $this->assets->addJs("backend/library/highlight/highlight.pack.js", true); // 代码高亮highlight
        $this->assets->addJs("backend/library/katex/katex.min.js", true); // 科学公式KaTeX
        $this->assets->addJs("themes/default/public/js/article.js", true); // 文章页面js

        $markupFixer  = new \TOC\MarkupFixer();// 标签加id
        $tocGenerator = new \TOC\TocGenerator();

        $this->view->setVars([
            'content' => $markupFixer->fix($post->post_html_content),
            'toc' => $tocGenerator->getHtmlMenu($post->post_html_content)
        ]);
    }



}

