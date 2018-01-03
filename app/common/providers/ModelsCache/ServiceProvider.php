<?php

namespace ZPhal\Providers\ModelsCache;

use Phalcon\Cache\Frontend\Data;
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
    protected $serviceName = 'modelsCache';

    /**
     * {@inheritdoc}
     *
     * 注册model缓存服务
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                $config = container('config')->cache;

                $driver  = $config->drivers->{$config->default};
                $adapter = '\Phalcon\Cache\Backend\\' . $driver->adapter;

                if ($driver->adapter == 'Redis'){
                    $default = [
                        'statsKey' => 'SMC:'.substr(md5($config->prefix), 0, 16).'_',
                        'prefix'   => 'ZD_'.$config->prefix,
                    ];
                }else{
                    $default = [
                        'prefix'   => 'ZD_'.$config->prefix,
                    ];
                }

                return new $adapter(
                    new Data(['lifetime' => $config->lifetime]),
                    array_merge($driver->toArray(), $default)
                );
            }
        );
    }
}