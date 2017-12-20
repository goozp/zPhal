<?php

namespace ZPhal\Modules\Frontend\Providers\Dispatcher;

use ZPhal\Modules\Frontend\Providers\AbstractServiceProvider;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;
use ZPhal\Plugins\NotFoundPlugin;


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
                // dispatcher
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace('ZPhal\Modules\Frontend\Controllers\\');

                // eventsManager
                $debug = container('config')->debug;
                $environment = container('config')->environment;
                if ($environment == 'production' && $debug === false){
                    // 创建一个事件管理器
                    $eventsManager = new EventsManager();

                    // 监听分发器中使用安全插件产生的事件
                    /*$eventsManager->attach(
                        "dispatch:beforeExecuteRoute",
                        new SecurityPlugin()
                    );*/

                    // 处理异常和使用 NotFoundPlugin 未找到异常
                    $eventsManager->attach(
                        "dispatch:beforeException",
                        new NotFoundPlugin()
                    );

                    $dispatcher->setEventsManager($eventsManager); // 分配事件管理器到分发器
                }

                return $dispatcher;
            }
        );
    }
}