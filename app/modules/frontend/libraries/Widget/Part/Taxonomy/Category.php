<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget\Part\Taxonomy;

use ZPhal\Modules\Frontend\Libraries\Widget\Part\Taxonomy;

class Category extends Taxonomy
{
    protected static $type = 'category';

    public function getList()
    {
        $categoryList = $this->query(self::$type);
        print_r($categoryList);exit;
    }
}