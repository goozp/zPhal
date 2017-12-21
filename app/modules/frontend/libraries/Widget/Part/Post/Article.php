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
     * @return bool|string
     */
    public function getNewList($extra, $num)
    {
        $post = parent::$modelsManager->createBuilder()
            ->columns("ID, post_title, post_date, guid")
            ->from('ZPhal\Models\Posts')
            ->where("post_status = 'publish' AND post_type = 'post' ")
            ->orderBy("post_date DESC")
            ->limit($num)
            ->getQuery()
            ->execute();

        if ($post){
            return $this->getLayout($post->toArray(), $extra);
        }else{
            return false;
        }
    }
}

