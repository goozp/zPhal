<?php
namespace ZPhal\Modules\Frontend;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'ZPhal\Modules\Frontend\Controllers' => __DIR__ . '/controllers/',
            'ZPhal\Modules\Frontend\Models' => __DIR__ . '/models/',
            'ZPhal\Modules\Frontend\Plugins' => __DIR__ . '/plugins/',
            'ZPhal\Modules\Frontend\Providers' => __DIR__ . '/providers/',
        ]);

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * 读取config服务提供者frontend注册列表进行服务注册
         */
        $providers = require APP_PATH.'/config/providers.php';
        if (is_array($providers['web']['frontend'])) {
            foreach ($providers['web']['frontend'] as $name => $class) {
                $serviceProvider = new $class($di);
                $serviceProvider->register();
                $serviceProvider->boot();
            }
        }

    }
}
