<?php

namespace ZPhal\Providers\Session;

use ZPhal\Providers\AbstractServiceProvider;

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
    protected $serviceName = 'session';

    /**
     * {@inheritdoc}
     *
     * 注册session服务
     *
     * @return void
     */
    public function register()
    {
        /**
         * Starts the session the first time some components requests the session service
         */
        $this->di->setShared(
            $this->serviceName,
            function () {
                $config = container('config')->session;

                $driver   = $config->drivers->{$config->default};
                $adapter  = '\Phalcon\Session\Adapter\\' . $driver->adapter;
                // 公共配置参数,将用于与adapter配置参数合并
                $defaults = [
                    'prefix'   => $config->prefix,
                    'uniqueId' => $config->uniqueId,
                    'lifetime' => $config->lifetime,
                ];

                /** @var \Phalcon\Session\AdapterInterface $session */
                $session = new $adapter(array_merge($driver->toArray(), $defaults));
                $session->start();

                return $session;
            }
        );
    }
}