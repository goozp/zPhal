<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget;

use Phalcon\DiInterface;
use Phalcon\Mvc\User\Plugin;
use ZPhal\Modules\Frontend\Libraries\Widget\Part\Taxonomy\Category;

class Widget extends Plugin
{
    protected static $modelsManager = null;

    public function __construct(DiInterface $di = null)
    {
        if (self::$modelsManager === null){
            self::$modelsManager = $this->di->get('modelsManager') ?: container('modelsManager');
        }
    }

    protected function getInstance($className)
    {
        return new $className(self::$modelsManager);
    }

    public function getCategoryList()
    {
        $category = $this->getInstance(Category::class);
        $category->getList();
    }

    public function getTagList()
    {

    }

    public function getRandomArticles()
    {

    }

    public function getSiteStatistics()
    {

    }

    public function getCommentList()
    {

    }
}