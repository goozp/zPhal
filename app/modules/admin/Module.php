<?php
namespace ZPhal\Modules\Admin;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

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
         * 读取config服务提供者注册列表进行服务注册
         */
        $providers = require APP_PATH.'/config/providers.php';    
        if (is_array($providers['web']['admin'])) {
            foreach ($providers['web']['admin'] as $name => $class) {
                $serviceProvider = new $class($di);
                $serviceProvider->register();
                $serviceProvider->boot();
            }
        }
    }
}
