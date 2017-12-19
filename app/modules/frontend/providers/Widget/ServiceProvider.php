<?php

namespace ZPhal\Modules\Frontend\Providers\Widget;

use ZPhal\Modules\Frontend\Libraries\Widget\Widget;
use ZPhal\Providers\AbstractServiceProvider;

/**
 * Class ServiceProvider
 * @package ZPhal\Providers\Widget
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'widget';

    /**
     * {@inheritdoc}
     *
     * 注册widget服务
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new Widget();
            }
        );
    }
}