<?php

namespace ZPhal\Providers\Redis;

use ZPhal\Providers\AbstractServiceProvider;
use Phalcon\Cache\Backend\Redis as redisAdapter;
use Phalcon\Cache\Frontend\Data as FrontData;

/**
 * Class ServiceProvider
 * @package ZPhal\Providers\Session
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'redis';

    /**
     * {@inheritdoc}
     *
     * 注册redis服务
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                $config = container('config')->cache;

                $driver   = $config->drivers->redis;

                $redis = new redisAdapter(
                    new FrontData(
                        [
                            "lifetime" => $config->lifetime,
                        ]
                    ),
                    $driver->toArray()
                );

                return $redis;
            }
        );
    }
}