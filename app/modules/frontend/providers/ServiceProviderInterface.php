<?php

namespace ZPhal\Modules\Frontend\Providers;

use Phalcon\Di\InjectionAwareInterface;

/**
 * 服务提供者接口
 * ZPhal\Modules\Admin\Providers\ServiceProviderInterface
 *
 * @package ZPhal\Modules\Admin\Providers
 */
interface ServiceProviderInterface extends InjectionAwareInterface
{
    /**
     * 注册应用服务
     * Register application service.
     *
     * @return void
     */
    public function register();

    /**
     * 启动方法
     * Package boot method.
     *
     * @return void
     */
    public function boot();

    /**
     * 配置当前服务提供者
     * Configures the current service provider.
     *
     * @return void
     */
    public function configure();
    /**
     * 获取服务名称
     * Get the Service name.
     *
     * @return string
     */
    public function getName();
}
