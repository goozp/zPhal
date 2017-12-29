<?php
namespace ZPhal\Modules\Frontend\Controllers;

class LinksController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("link");

        /**
         * widget for the template
         */
        $this->view->setVars([
            'widgetCategory' => $this->widget->getCategoryList(),
            'widgetNewArticle' => $this->widget->getNewArticles([
                'ulClass' => 'fa-ul ml-4 mb-0',
                'before' => '<i class="fa-li fa fa-angle-double-right"></i>'
            ])
        ]);
    }

    public function indexAction()
    {
        $this->tag->prependTitle('链接' . " - ");

    }

}