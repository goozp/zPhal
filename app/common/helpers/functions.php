<?php

/*
 +------------------------------------------------------------------------+
 | ZPhal                                                                  |
 +------------------------------------------------------------------------+
 | Copyright (c) 2017 ZPhal Team and contributors                         |
 +------------------------------------------------------------------------+
 | This source file is subject to the New BSD License that is bundled     |
 | with this package in the file docs/LICENSE.txt.                        |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to gzp@goozp.com so we can send you a copy immediately.                |
 +------------------------------------------------------------------------+
*/

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
    function treeHtml($categoryTree, $pk, $name, $html = '', $deep = 0, $active = 0, $nbsp="&nbsp;&nbsp;&nbsp;&nbsp;")
    {
        if ($html == '') {
            $html = '<option value="0">无</option>';
        }

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
                $html = treeHtml($category['sun'], $pk, $name, $html, $deep + 1, $active, $nbsp);
            }
        }
        return $html;
    }
}


if (!function_exists('treeHtmlMultiSelect')){
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
    function treeHtmlMultiSelect($categoryTree, $pk, $name, $html = '', $deep = 0, $active = [], $nbsp="&nbsp;&nbsp;&nbsp;&nbsp;")
    {
        if ($html == '') {
            $html = '<option value="0">无</option>';
        }

        $tags = '';
        if ($deep) {
            for ($i = 1; $i <= $deep; $i++) {
                $tags .= $nbsp;
            }
        }

        foreach ($categoryTree as $category) {
            if (in_array($category[$pk], $active)){
                $actived = 'selected';
            } else {
                $actived = '';
            }

            $html .= '<option value="' . $category[$pk] . '" ' . $actived . '>' . $tags . $category[$name] . '</option>';

            if (!empty($category['sun'])) {
                $html = treeHtmlMultiSelect($category['sun'], $pk, $name, $html, $deep + 1, $active, $nbsp);
            }
        }

        return $html;
    }
}

if(!function_exists('subjectTreeHtml')){
    /**
     * 返回专题列表树形数据
     *
     * @param $tree
     * @param array $output
     * @param int $deep
     * @return array
     */
    function subjectTreeHtml($tree, $output = [] , $deep = 0){

        $nbsp = '— ';
        $tags = '';
        if ($deep) {
            for ($i = 1; $i <= $deep; $i++) {
                $tags .= $nbsp;
            }
        }

        $url = container('url');

        foreach ($tree as $treeItem){
            $link = $url->get(["for"=>"edit-subject", 'id'=>$treeItem['subject_id']]);
            $lastUpdated = $treeItem["last_updated"] == '1000-01-01 00:00:00' ? '暂无更新' : $treeItem["last_updated"];

            $output[] = [
                'id'    => $treeItem["subject_id"],
                'html'  => '<tr>
                                <td><a href="'.$link.'">' . $tags . $treeItem["subject_name"] . '</a></td>
                                <td>'.$treeItem["subject_description"].'</td>
                                <td>'.$treeItem["subject_slug"].'</td>
                                <td>'. $lastUpdated .'</td>
                                <td>'.$treeItem["count"].'</td>
                            </tr>'
            ];

            if (!empty($treeItem['sun'])) {
                $output = subjectTreeHtml($treeItem['sun'], $output, $deep + 1);
            }
        }

        return $output;
    }
}

if(!function_exists('articleExcerpt')){
    /**
     * 文章截取
     *
     * @param string $content
     * @param int    $limit
     * @return string
     */
    function articleExcerpt( $content, $limit = 330 ) {
        if ( $content ) {
            $content = preg_replace( "/\[.*?\].*?\[\/.*?\]/is", "", $content );
            $content = mb_strimwidth( strip_tags( $content ), 0, $limit, "..." );
        }

        return strip_tags( $content );
    }
}

if(!function_exists('getClientIp')){
    /**
     * 获取客户端IP
     *
     * @return string
     */
    function getClientIp(){
        if(isset($_SERVER["HTTP_CLIENT_IP"]) and strcasecmp($_SERVER["HTTP_CLIENT_IP"], "unknown")){
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]) and strcasecmp($_SERVER["HTTP_X_FORWARDED_FOR"], "unknown")){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        if(isset($_SERVER["REMOTE_ADDR"])){
            return $_SERVER["REMOTE_ADDR"];
        }
        return "";
    }
}

if (!function_exists('calculateDateDiff')){
    /**
     * 计算时间差
     *
     * @param $before
     * @return string
     */
    function calculateDateDiff($before)
    {
        if (!$before){
            return "未知";
        }

        if($before = '1000-01-01 00:00:00'){
            return '暂无';
        }

        $startDate = strtotime($before);
        $endDate = time();

        $day = floor(($endDate-$startDate)/86400);
        $hour= floor(($endDate-$startDate)%86400/3600);
        $minute=floor(($endDate-$startDate)%86400/60);
        $second=floor(($endDate-$startDate)%86400%60);

        if ($day>=1){
            return $day . " 天前";
        }elseif($day<1 && $hour>=1){
            return $hour . " 小时前";
        }elseif($day<1 && $hour<1 && $minute>=1 ){
            return $minute . " 分钟前";
        }else{
            return $second . " 秒前";
        }
    }
}