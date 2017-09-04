<?php
namespace ZPhal\Modules\Admin;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;
/*use Phalcon\Flash\Direct as Flash;*/
use ZPhal\Modules\Admin\Components\NewFlash;

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
            'ZPhal\Modules\Admin\Controllers' => __DIR__ . '/controllers/',
            'ZPhal\Modules\Admin\Models' => __DIR__ . '/models/',
            'ZPhal\Modules\Admin\Components' => __DIR__ . '/components/',
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
         * Setting up the view components
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
         * Registering a dispatcher
         */
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('ZPhal\Modules\Admin\Controllers\\');
            return $dispatcher;
        });

        /**
         * Register the session flash service with the Twitter Bootstrap classes
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
    }
}
