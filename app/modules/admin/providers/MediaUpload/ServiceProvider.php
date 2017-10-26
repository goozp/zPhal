<?php

namespace ZPhal\Modules\Admin\Providers\MediaUpload;

use ZPhal\Modules\Admin\Providers\AbstractServiceProvider;
use ZPhal\Modules\Admin\Components\Media;
use Phalcon\Events\Manager as EventsManager;

use ZPhal\Modules\Admin\Listeners\AliYunOss;

/**
 * 文件上传
 * @package ZPhal\Modules\Admin\Providers\MediaUpload
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'mediaUpload';

    /**
     * {@inheritdoc}
     *
     * 注册视图服务
     *
     * @return void
     */
    public function register()
    {
        /**
         * 注册一个文件上传服务
         */
        $this->di->set(
            $this->serviceName,
            function (){
                $media = new Media();

                // TODO 判断是否开启阿里云Oss
                // 创建一个事件管理器
                $eventsManager = new EventsManager();
                $eventsManager->attach(
                    "media",
                    new AliYunOss()
                );
                $media->setEventsManager($eventsManager);

                return $media;
            }
        );
    }
}