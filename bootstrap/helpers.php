<?php
/*
  +------------------------------------------------------------------------+
  | ZPhal 辅助函数                                                          |
  +------------------------------------------------------------------------+
  | Copyright (c) 2017 ZPhal                                               |
  +------------------------------------------------------------------------+
*/

use Phalcon\Di;

if (!function_exists('container')) {
    /**
     * 唤醒默认依赖注入容器
     *
     * @param  mixed
     * @return mixed|\Phalcon\DiInterface
     */
    function container()
    {
        $default = Di::getDefault();

        $args = func_get_args();

        if (empty($args)) {
            return $default;
        }

        if (!$default) {
            trigger_error('Unable to resolve Dependency Injection container.', E_USER_ERROR);
        }

        return call_user_func_array([$default, 'getShared'], $args);
    }
}

if (!function_exists('makeTree')) {
    /**
     * 返回树结构
     *
     * @param array $list 要排列的数组
     * @param string $pk 唯一标志,id
     * @param string $pid 父id
     * @param string $child 子集合key
     * @param int $root 层级
     * @return array
     */
    function makeTree($list, $pk = '', $pid = 'parent', $child = 'sun', $root = 0)
    {
        $tree = [];
        foreach ($list as $key => $val) {
            if ($val[$pid] == $root) {
                unset($list[$key]);
                if (!empty($list)) {
                    $child = makeTree($list, $pk, $pid, $child, $val[$pk]);
                    if (!empty($child)) {
                        $val['sun'] = $child;
                    }
                }
                $tree[] = $val;
            }
        }
        return $tree;
    }
}

if (!function_exists('treeHtml')){
    /**
     * 返回要输出的html option结构
     *
     * @param $categoryTree
     * @param $pk
     * @param $name
     * @param string $html
     * @param int $deep
     * @param int $active
     * @return string
     */
    function treeHtml($categoryTree, $pk, $name, $html = '', $deep = 0, $active = 0)
    {
        if ($html == '') {
            $html = '<option value="0">无</option>';
        }

        $nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;';
        $tags = '';
        if ($deep) {
            for ($i = 1; $i <= $deep; $i++) {
                $tags .= $nbsp;
            }
        }

        foreach ($categoryTree as $category) {
            if ($active != 0 && $category[$pk] == $active) {
                $actived = 'selected';
            } else {
                $actived = '';
            }

            $html .= '<option value="' . $category[$pk] . '" ' . $actived . '>' . $tags . $category[$name] . '</option>';

            if (!empty($category['sun'])) {
                $html = treeHtml($category['sun'], $pk, $name, $html, $deep + 1);
            }
        }
        return $html;
    }
}