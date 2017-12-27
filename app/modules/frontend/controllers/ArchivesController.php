<?php
namespace ZPhal\Modules\Frontend\Controllers;

class ArchivesController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("archive");

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
        $this->tag->prependTitle('归档' . " - ");


    }

}