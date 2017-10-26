<?php

namespace ZPhal\Providers\Config;

use Phalcon\Config;
use ZPhal\Providers\AbstractServiceProvider;

/**
 * 配置 ServiceProvider
 * @package ZPhal\Provider\Config
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'config';

    /**
     * {@inheritdoc}
     *
     * 注册配置服务
     *
     * @return void
     */
    public function register()
    {
        /**
         * Shared configuration service
         */
        $this->di->set(
            $this->serviceName,
            function () {
                $config = require APP_PATH . "/config/config.php";
                return new Config($config);
            }
        );
    }
}