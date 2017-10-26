<?php

namespace ZPhal\Modules\Frontend\Providers\Dispatcher;

use ZPhal\Modules\Frontend\Providers\AbstractServiceProvider;
use Phalcon\Mvc\Dispatcher;

/**
 * Class ServiceProvider
 * @package ZPhal\Modules\Frontend\Providers\Dispatcher
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'dispatcher';

    /**
     * {@inheritdoc}
     *
     * 注册错误信息获取服务
     *
     * @return void
     */
    public function register()
    {
        /**
         * Registering a dispatcher
         */
        $this->di->setShared(
            $this->serviceName,
            function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace('ZPhal\Modules\Frontend\Controllers\\');
                return $dispatcher;
            }
        );
    }
}