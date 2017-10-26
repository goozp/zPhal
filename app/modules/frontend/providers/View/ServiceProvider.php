<?php

namespace ZPhal\Modules\Frontend\Providers\View;

use ZPhal\Modules\Frontend\Providers\AbstractServiceProvider;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;

/**
 * 视图
 * Class ServiceProvider
 * @package ZPhal\Modules\Frontend\Providers\Dispatcher
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'view';

    /**
     * {@inheritdoc}
     *
     * 注册视图服务
     *
     * @return void
     */
    public function register()
    {
        $this->di->set(
            $this->serviceName,
            function () {
                $view = new View();
                $view->setDI(container());
                $view->setViewsDir( BASE_PATH . '/public/themes/default/' );

                $view->registerEngines([
                    '.phtml' => PhpEngine::class
                ]);

                return $view;
            }
        );
    }
}