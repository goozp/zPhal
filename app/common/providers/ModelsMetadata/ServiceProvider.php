<?php

namespace ZPhal\Providers\ModelsMetadata;

use ZPhal\Providers\AbstractServiceProvider;

/**
 * 模型元数据 ServiceProvider
 * @package ZPhal\Providers\ModelsMetadata
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'modelsMetadata';

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
         * If the configuration specify the use of metadata adapter use it or use memory otherwise
         */
        $this->di->set(
            $this->serviceName,
            function () {
                return new MetaDataAdapter();
            }
        );


    }
}