<?php
namespace ZPhal\Modules\Frontend\Controllers;

class ProjectsController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("project");

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
        if (!$this->view->getCache()->exists('projects')) {

            $this->tag->prependTitle('作品' . " - ");

            if ($this->option->get('show_project')){
                $ifShow = true;

                $showRepos = $this->option->get('github_show_repo', false, true);
                if ($showRepos){
                    $showRepos = json_decode($showRepos, true);
                }


            }else{
                $ifShow = false;
            }

            $this->view->setVars([
                'ifShow' => $ifShow,
                'showRepos' => $showRepos,
            ]);
        }

        $this->view->cache(
            [
                'key' => 'projects',
            ]
        );
    }

}