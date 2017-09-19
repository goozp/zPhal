<?php
namespace ZPhal\Modules\Admin\Controllers;


/**
 * 文章类
 * Class PostController
 * @package ZPhal\Modules\Admin\Controllers
 */
class PostController extends ControllerBase
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

    }

    public function taxonomyAction()
    {
        $type = $this->dispatcher->getParam("type");

        if ($type == 'category'){
            $topTitle = '分类';
            $topSubtitle = '文章的分类';
        } elseif ($type == 'tag'){
            $topTitle = '标签';
            $topSubtitle = '文章贴标签';
        }

        $this->view->setVars(
            [
                "topTitle" => $topTitle,
                "topSubtitle" => $topSubtitle
            ]
        );
    }
}