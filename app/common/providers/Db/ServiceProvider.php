<?php

namespace ZPhal\Providers\Db;

use ZPhal\Providers\AbstractServiceProvider;

/**
 * 数据库 ServiceProvider
 * @package ZPhal\Provider\Config
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'db';

    /**
     * {@inheritdoc}
     *
     * 注册配置服务
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                $config = container('config');

                $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
                $params = [
                    'host'     => $config->database->host,
                    'username' => $config->database->username,
                    'password' => $config->database->password,
                    'dbname'   => $config->database->dbname,
                    'charset'  => $config->database->charset
                ];

                if ($config->database->adapter == 'Postgresql') {
                    unset($params['charset']);
                }

                $connection = new $class($params);

                return $connection;
            }
        );
    }
}