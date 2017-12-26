<?php

namespace ZPhal\Modules\Frontend\Providers\VisitCounter;

use ZPhal\Modules\Frontend\Libraries\Visit\Counter;
use ZPhal\Providers\AbstractServiceProvider;

/**
 * Class ServiceProvider
 * @package ZPhal\Modules\Frontend\Providers\VisitCounter
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'visitCounter';

    /**
     * {@inheritdoc}
     *
     * 注册浏览量统计visitCounter服务
     *
     * @return void
     */
    public function register()
    {
        $this->di->set(
            $this->serviceName,
            function () {
                return new Counter();
            }
        );
    }
}