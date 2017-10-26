<?php

namespace ZPhal\Providers\Router;

use ZPhal\Providers\AbstractServiceProvider;
use Phalcon\Mvc\Router;

/**
 * 路由 ServiceProvider
 * @package ZPhal\Providers\Router
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'router';

    /**
     * {@inheritdoc}
     *
     * 注册路由服务
     *
     * @return void
     */
    public function register()
    {
        /**
         * Registering a router
         */
        $this->di->setShared(
            $this->serviceName,
            function () {
                $router = new Router(false);
                $router->removeExtraSlashes(true);
                $router->setDefaultModule("frontend");
                $router->setDefaultController("index");
                $router->setDefaultAction("index");

                return $router;
            }
        );
    }
}