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

        } elseif ($type == 'tag'){

        }
    }
}