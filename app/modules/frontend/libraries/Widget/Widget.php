<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget;

use Phalcon\DiInterface;
use Phalcon\Mvc\User\Plugin;
use ZPhal\Modules\Frontend\Libraries\Widget\Part\Taxonomy\Category;

class Widget extends Plugin
{
    protected static $modelsManager = null;

    protected static $urlGenerator = null;

    public function __construct(DiInterface $di = null)
    {
        if (self::$modelsManager === null){
            self::$modelsManager = $this->di->get('modelsManager') ?: container('modelsManager');
        }

        if (self::$urlGenerator === null){
            self::$urlGenerator = $this->di->get('url') ?: container('url');
        }
    }

    protected function getInstance($className)
    {
        return new $className(self::$modelsManager, self::$urlGenerator);
    }

    public function getCategoryList()
    {
        $category = $this->getInstance(Category::class);
        return $category->getList();
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