<?php

namespace ZPhal\Modules\Frontend\Libraries\Visit;

use Phalcon\Mvc\User\Plugin;

class Counter extends Plugin
{
    protected static $obj;

    protected $lifetime;

    protected $cookieName = "post-view";

    public function __construct()
    {
        $this->lifetime = time() + 86400;
    }

    /**
     * 计算文章的浏览量
     *
     * @param $article
     */
    public function calculate($article)
    {
        $aid = $article->ID;

        $cookie = $this->getCookie();
        if ($cookie){
            $cookieArr = explode(',', $cookie);

            if(!in_array($aid, $cookieArr)){
                // 时间段内第一次阅读，需计数
                $this->updateCount($article);

                $this->setCookie($aid, $cookieArr);
            }
        }else{
            // 没有设置过cookie,即第一次，需计数
            $this->updateCount($article);

            $this->setCookie($aid);
        }
    }

    /**
     * 更新浏览器记录
     * 通过redis进行中转，每十分钟更新一次
     *
     * TODO 需要一个定时任务去清理十分钟后未被触发更新数据库的残留redis数据
     *
     * @param $article
     * @throws \Exception
     */
    public function updateCount($article)
    {
        if (is_object($article) && isset($article->ID) && !empty($article->ID)){
            $postNumKey = 'post_views_'. $article->ID;
            $lastUpdateKey = 'post_views_last_update_time_'. $article->ID;
        }else{
            throw new \Exception('error object');
        }

        if ($this->redis->get($lastUpdateKey) < (time()-600)){

            // 设置锁参数
            $lockKey = 'lockViews';
            $random = md5( uniqid(getmypid().'_'.mt_rand().'_', true) ); //随机值
            $ttl = 10;
            if (!$this->redis->exists($lockKey)){
                $this->redis->save($lockKey, $random, $ttl); // 设置锁

                /**
                 * 进行更新操作
                 */
                $num = $this->redis->get($postNumKey);
                if ($article->updateView($num)){
                    $this->redis->save($lastUpdateKey, time()); // 设置上次更新时间
                    $this->redis->delete($postNumKey); // 清空堆积的数据
                }

                // 去掉锁; 加入随机值判断避免删除到其他操作的锁
                if($this->redis->get($lockKey) == $random) {
                    $this->redis->delete($lockKey);
                }
            }

        }else{
            if ($this->redis->exists($postNumKey)){
                $this->redis->increment($postNumKey, 1);
            }else{
                $this->redis->save($postNumKey, 1);
            }
        }
    }

    /**
     * 获取浏览记录cookie
     *
     * @return bool|mixed
     */
    public function getCookie()
    {
        // 检测cookie之前有没被设置过
        if ($this->cookies->has($this->cookieName)) {
            // 获取cookie
            $cookie = $this->cookies->get($this->cookieName);

            // 获取cookie的值
            return $value = $cookie->getValue();
        }else{
            return false;
        }
    }

    /**
     * 设置浏览记录cookie
     *
     * @param $articleId
     * @param null $cookieArr
     */
    public function setCookie($articleId, $cookieArr=null)
    {
        if ($cookieArr){
            $cookieArr[] = $articleId;
            $value = implode(',', $cookieArr);
        }else{
            $value = $articleId;
        }

        $this->cookies->set(
            $this->cookieName,
            $value,
            $this->lifetime
        );
    }

    /**
     * 删除浏览记录cookie
     */
    public function deleteCookie()
    {
        $rememberMeCookie = $this->cookies->get($this->cookieName);
        $rememberMeCookie->delete();
    }
}