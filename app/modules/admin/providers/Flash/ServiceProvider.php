<?php

namespace ZPhal\Modules\Admin\Providers\Flash;

use Phalcon\Flash\Session;
use ZPhal\Modules\Admin\Providers\AbstractServiceProvider;

/**
 * 闪存提示
 * ZPhal\Modules\Admin\Providers\Flash\ServiceProvider
 *
 * @package ZPhal\Modules\Admin\Providers\Flash
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'flash';

    protected $bannerStyle = [
        'error'   => 'alert alert-danger fade in',
        'success' => 'alert alert-success fade in',
        'notice'  => 'alert alert-info fade in',
        'warning' => 'alert alert-warning fade in',
    ];

    /**
     * {@inheritdoc}
     *
     * 注册Flash服务,使用Bootstrap的类
     *
     * @return void
     */
    public function register()
    {
        $bannerStyle = $this->bannerStyle;

        $this->di->set(
            $this->serviceName,
            function () use ($bannerStyle) {
                $flash = new Session($bannerStyle);

                $flash->setAutoescape(true);
                $flash->setDI(container());
                $flash->setCssClasses($bannerStyle);

                return $flash;
            }
        );
    }
}
