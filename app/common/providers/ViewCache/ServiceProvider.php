<?php

namespace ZPhal\Providers\ViewCache;

use Phalcon\Cache\Frontend\Output;
use ZPhal\Providers\AbstractServiceProvider;

/**
 * Class ServiceProvider
 * @package ZPhal\Providers\ViewCache
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'viewCache';

    /**
     * {@inheritdoc}
     *
     * 注册视图缓存服务
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                $config = container('config')->cache;

                $driver  = $config->drivers->{$config->views};
                $adapter = '\Phalcon\Cache\Backend\\' . $driver->adapter;

                return new $adapter(
                    new Output(['lifetime' => $config->lifetime]),
                    $driver->toArray()
                );
            }
        );
    }
}