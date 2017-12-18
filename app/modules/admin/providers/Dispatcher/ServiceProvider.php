<?php

namespace ZPhal\Modules\Admin\Providers\Dispatcher;

use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;
use ZPhal\Modules\Admin\Providers\AbstractServiceProvider;
use ZPhal\Plugins\NotFoundPlugin;

/**
 * Class ServiceProvider
 * @package ZPhal\Modules\Admin\Providers\Dispatcher
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
        $this->di->setShared(
            $this->serviceName,
            function () {
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

                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace('ZPhal\Modules\Admin\Controllers\\');
                $dispatcher->setEventsManager($eventsManager); // 分配事件管理器到分发器

                return $dispatcher;
            }
        );
    }
}