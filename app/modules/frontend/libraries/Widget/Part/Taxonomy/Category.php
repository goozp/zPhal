<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget\Part\Taxonomy;

use ZPhal\Modules\Frontend\Libraries\Widget\Part\Taxonomy;

class Category extends Taxonomy
{
    protected static $type = 'category';

    /**
     * Get category list
     *
     * @return mixed
     */
    public function getList()
    {
        $cache_key = 'widget-taxonomy-category-list';
        $modelsCache = container('modelsCache');

        if ($modelsCache && $modelsCache->exists($cache_key)){

            $output = $modelsCache->get($cache_key);
            return $output;

        }else{

            // get data without uncategory(1)
            $categoryList = $this->query(self::$type, [1]);

            $output = $this->layout($categoryList)['html'];

            $modelsCache->save($cache_key, $output); // save the cache

            return $output;
        }
    }

    /**
     * Output category list in html layout by recurrence
     *
     * @param $list
     * @param int $pid
     * @return mixed
     */
    public function layout($list, $pid = 0)
    {
        if ($pid == 0){
            $html = '<ul id="category-list" class="category-list list-unstyled">';
        }else{
            $html = '<ul class="category-sub-list list-unstyled">';
        }

        foreach ($list as $key => $value){
            if ($value['parent'] == $pid){

                $html .= '<li id="category-item-' .$value['term_taxonomy_id']. '" class="category-item"><a href="'. parent::$urlGenerator->get(['for' => 'index-category', 'params' => $value['slug'] ]) .'">'.$value['name'].'</a>';

                /**
                 * 如果有子元素则在li之间插入ul>li，以此递归
                 */
                $children = $this->layout($list, $value['term_taxonomy_id']);

                if (isset($children['hasChild']) && $children['hasChild'] == true){
                    $html .= $children['html'];
                }

                $html .= '</li>';

                $hasChild = true;
            }
        }

        $html .= '</ul>';

        $output['html'] =$html;
        if (isset($hasChild) && $hasChild == true){
            $output['hasChild'] = $hasChild;
        }

        return $output;
    }
}