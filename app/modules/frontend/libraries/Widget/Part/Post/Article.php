<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget\Part\Post;

use ZPhal\Modules\Frontend\Libraries\Widget\Part\Post;

class Article extends Post
{
    protected static $type = 'article';

    /**
     * get news article list
     *
     * @param $extra
     * @param $num
     * @return bool|mixed|string
     */
    public function getNewList($extra, $num)
    {
        $cache_key = 'widget-articles-new-list';
        $modelsCache = container('modelsCache');

        if ($modelsCache && $modelsCache->exists($cache_key)){

            $output = $modelsCache->get($cache_key);
            return $output;

        }else{
            $post = parent::$modelsManager->createBuilder()
                ->columns("ID, post_title, post_date, guid")
                ->from('ZPhal\Models\Posts')
                ->where("post_status = 'publish' AND post_type = 'post' ")
                ->orderBy("post_date DESC")
                ->limit($num)
                ->getQuery()
                ->execute();

            if ($post){
                $output = $this->getLayout($post->toArray(), $extra);

                $modelsCache->save($cache_key, $output); // save the cache

                return $output;
            }else{
                return false;
            }
        }
    }
}

