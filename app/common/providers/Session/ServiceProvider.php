<?php

namespace ZPhal\Providers\Session;

use ZPhal\Providers\AbstractServiceProvider;
use Phalcon\Session\Adapter\Redis as SessionAdapter;

/**
 * Class ServiceProvider
 * @package ZPhal\Providers\Session
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'session';

    /**
     * {@inheritdoc}
     *
     * 注册session服务
     *
     * @return void
     */
    public function register()
    {
        /**
         * Starts the session the first time some components requests the session service
         */
        $this->di->setShared(
            $this->serviceName,
            function () {
                $session = new SessionAdapter([
                    "uniqueId"   => "zphal",
                    "host"       => "localhost",
                    "port"       => 6379,
                    // "auth"       => "foobared", redis密码
                    "persistent" => false,
                    "lifetime"   => 3600,
                    "prefix"     => "zPhalSession",
                    "index"      => 1,
                ]);
                $session->start();

                return $session;
            }
        );
    }
}