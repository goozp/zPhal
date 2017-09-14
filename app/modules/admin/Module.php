<?php
namespace ZPhal\Modules\Admin;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;
use ZPhal\Modules\Admin\Components\Media;
use ZPhal\Modules\Admin\Library\Message\MessageControl;
use ZPhal\Modules\Admin\Listeners\AliYunOss;
use ZPhal\Modules\Admin\Providers\NewFlash;


class Module implements ModuleDefinitionInterface
{
    /**
     * 注册该模块自动加载的命名空间
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'ZPhal\Modules\Admin\Controllers'   => __DIR__ . '/controllers/',
            'ZPhal\Modules\Admin\Models'        => __DIR__ . '/models/',
            'ZPhal\Modules\Admin\Components'    => __DIR__ . '/components/',
            'ZPhal\Modules\Admin\Library'       => __DIR__ . '/library/',
            'ZPhal\Modules\Admin\Providers'     => __DIR__ . '/providers/',
            'ZPhal\Modules\Admin\Listeners'     => __DIR__ . '/listeners/',
            'ZPhal\Modules\Admin\Plugins'       => __DIR__ . '/plugins/',
        ]);

        $loader->register();
    }

    /**
     * 注册该模块的服务
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * 注册view引擎
         */
        $di->set('view', function () {
            $view = new View();
            $view->setDI($this);
            $view->setViewsDir(__DIR__ . '/views/');

            $view->registerEngines([
                '.volt'  => 'voltShared',
                '.phtml' => PhpEngine::class
            ]);

            return $view;
        });

        /**
         * 注册dispatcher
         */
        $di->set('dispatcher', function () {
            // 创建一个事件管理器
            //$eventsManager = new EventsManager();

            // 监听分发器中使用安全插件产生的事件
            /*$eventsManager->attach(
                "dispatch:beforeExecuteRoute",
                new SecurityPlugin()
            );*/

            // 处理异常和使用 NotFoundPlugin 未找到异常
            /*$eventsManager->attach(
                "dispatch:beforeException",
                new NotFoundPlugin()
            );*/

            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('ZPhal\Modules\Admin\Controllers\\');
            //$dispatcher->setEventsManager($eventsManager); // 分配事件管理器到分发器

            return $dispatcher;
        });

        /**
         * 注册一个文件上传服务
         */
        $di->set('mediaUpload',function (){
            $media = new Media();

            // TODO 判断是否开启阿里云Oss
            // 创建一个事件管理器
            $eventsManager = new EventsManager();
            $eventsManager->attach(
                "media",
                new AliYunOss()
            );
            $media->setEventsManager($eventsManager);

            return $media;
        });

        /**
         * 注册闪存提示class名
         */
        $di->set('flash', function () {
            $flash = new NewFlash([
                'error'   => 'alert alert-danger alert-dismissible fade in',
                'success' => 'alert alert-success alert-dismissible fade in',
                'notice'  => 'alert alert-info alert-dismissible fade in',
                'warning' => 'alert alert-warning alert-dismissible fade in'
            ]);
            $flash->setAutoescape(true);

            return $flash;
        });

        /*$di->setShared('acl', function () {
            $acl = new AdminAcl();
            return $acl;
        });*/

        /**
         * 注册错误信息获取服务
         */
        $di->setShared('messageControl', function (){
            $message = new MessageControl();
            return $message;
        });
    }
}
