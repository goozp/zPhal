<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget;

use Phalcon\DiInterface;
use Phalcon\Mvc\User\Plugin;
use ZPhal\Modules\Frontend\Libraries\Widget\Part\Post\Article;
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

    /**
     * 获取分类列表
     *
     * @return mixed
     */
    public function getCategoryList()
    {
        $category = $this->getInstance(Category::class);
        return $category->getList();
    }

    public function getTagList()
    {

    }

    /**
     * 获取最近文章列表
     *
     * @param array $extra ulClass|before|after
     * @param int $num
     * @return mixed
     */
    public function getNewArticles($extra, $num=6)
    {
        $post = $this->getInstance(Article::class);
        return $post->getNewList($extra, $num);
    }

    public function getSiteStatistics()
    {

    }

    public function getCommentList()
    {

    }
}