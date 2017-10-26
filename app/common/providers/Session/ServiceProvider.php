<?php

namespace ZPhal\Providers\Session;

use ZPhal\Providers\AbstractServiceProvider;
use Phalcon\Session\Adapter\Files as SessionAdapter;

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
                $session = new SessionAdapter();
                $session->start();

                return $session;
            }
        );
    }
}