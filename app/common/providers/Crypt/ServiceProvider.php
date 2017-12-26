<?php

namespace ZPhal\Providers\Crypt;

use Phalcon\Crypt;
use ZPhal\Providers\AbstractServiceProvider;

/**
 * Class ServiceProvider
 * @package ZPhal\Providers\Crypt
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'crypt';

    /**
     * {@inheritdoc}
     *
     * 注册crypt加密服务
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
                $config = container('config');
                $key = $config->security->crypt->key;

                $crypt = new Crypt();
                $crypt->setKey($key); // 加密key

                return $crypt;
            }
        );
    }
}