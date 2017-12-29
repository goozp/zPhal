<?php

namespace ZPhal\Modules\Admin\Library\GitHub;

/**
 * Class GitHub
 * TODO 加入获取OAUTH验证，增加可调用次数；深度封装
 *
 * @package ZPhal\Modules\Admin\Library\GitHub
 */
class GitHub{

    protected $baseUrl = 'https://api.github.com';

    /**
     * 获取用户的所有repo列表
     *
     * @param $userName
     * @return bool|mixed
     */
    public function getRepoList($userName)
    {
        $userUrl = $this->baseUrl . '/users/' . $userName;

        $user = json_decode($this->cUrl($userUrl), true);
        if (isset($user['message'])){
            return false;
        }

        $repos = json_decode($this->cUrl($user['repos_url']), true);
        if (isset($repos['message'])){
            return false;
        }
        return $repos;
    }

    /**
     * 获取repo的详细信息
     *
     * @param $repoName
     * @return bool|mixed
     */
    public function getRepo($repoName)
    {
        $repoUrl = $this->baseUrl . '/repos/' . $repoName;

        $repo = json_decode($this->cUrl($repoUrl), true);
        if (isset($repo['message'])){
            return false;
        }
        return $repo;
    }

    /**
     * 调用接口获取数据
     *
     * @param $url
     * @return mixed
     */
    public function cUrl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.27 Safari/525.13');

        //执行并获取HTML文档内容
        $output = curl_exec($ch);

        //释放curl句柄
        curl_close($ch);

        return $output;
    }
}