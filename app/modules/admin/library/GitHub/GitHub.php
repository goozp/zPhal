<?php

namespace ZPhal\Modules\Admin\Library\GitHub;

class GitHub{

    protected $baseUrl = 'https://api.github.com';

    protected static $url;

    public function __construct($username)
    {
        self::$url = $this->baseUrl . '/' . $username;
    }

    public function get()
    {
        $content = $this->cUrl(self::$url);
        print_r($content);
    }

    public function cUrl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);

        //释放curl句柄
        curl_close($ch);

        return $output;
    }
}