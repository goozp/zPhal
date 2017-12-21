<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget\Part;

class Post
{
    protected static $modelsManager = null;

    protected static $urlGenerator = null;

    /**
     * Taxonomy constructor. Initial services.
     *
     * @param $modelsManager
     * @param $urlGenerator
     */
    public function __construct($modelsManager, $urlGenerator)
    {
        if (self::$modelsManager === null){
            self::$modelsManager = $modelsManager ?: container('modelsManager');
        }

        if (self::$urlGenerator === null){
            self::$urlGenerator = $urlGenerator ?: container('url');
        }
    }

    /**
     * get output html for post
     *
     * @param $data
     * @param array $extra
     * @return string
     */
    public function getLayout($data, $extra=[])
    {
        if (isset($extra['ulClass']) && !empty($extra['ulClass'])){
            $html = '<ul class="news-list ' .$extra['ulClass']. ' ">';
        }else{
            $html = '<ul class="news-list">';
        }

        foreach ($data as $value){
            $html.= '<li class="news-item news-item-' .$value['ID']. '">';

            if (isset($extra['before']) && !empty($extra['before'])){
                $html.= $extra['before'];
            }

            $html.= '<p><a href="' .$value['guid']. '" title="' .$value['post_title']. '">' .$value['post_title']. '</a></p>';

            if (isset($extra['after']) && !empty($extra['before'])){
                $html.= $extra['after'];
            }

            $html.= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}



