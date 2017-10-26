<?php

namespace ZPhal\Providers\Url;

use ZPhal\Providers\AbstractServiceProvider;
use Phalcon\Mvc\Url as UrlResolver;

/**
 * Class ServiceProvider
 * @package ZPhal\Providers\Url
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'url';

    /**
     * {@inheritdoc}
     *
     * 注册URL服务
     *
     * @return void
     */
    public function register()
    {
        /**
         * The URL components is used to generate all kinds of URLs in the application
         */
        $this->di->setShared(
            $this->serviceName,
            function () {
                $config = $this->getConfig();

                $url = new UrlResolver();
                $url->setBaseUri($config->application->baseUri);

                return $url;
            }
        );
    }
}