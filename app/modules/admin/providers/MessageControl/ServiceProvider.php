<?php

namespace ZPhal\Modules\Admin\Providers\MessageControl;

use ZPhal\Modules\Admin\Providers\AbstractServiceProvider;
use ZPhal\Modules\Admin\Library\Message\MessageControl;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'messageControl';

    /**
     * {@inheritdoc}
     *
     * 注册错误信息获取服务
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function (){
                $message = new MessageControl();
                return $message;
            }
        );
    }
}