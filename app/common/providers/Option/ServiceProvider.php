<?php

namespace ZPhal\Providers\Option;

use ZPhal\Providers\AbstractServiceProvider;

/**
 * Class ServiceProvider
 * @package ZPhal\Providers\Option
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'option';

    /**
     * {@inheritdoc}
     *
     * 注册option服务
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                /**
                 * TODO 根据配置加载options读取方式；目前为redis
                 */
                return new \ZPhal\Library\Options\Redis();
            }
        );
    }
}