<?php

namespace ZPhal\Modules\Admin\Providers\Transactions;

use ZPhal\Modules\Admin\Providers\AbstractServiceProvider;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

/**
 * Class ServiceProvider
 * @package ZPhal\Modules\Admin\Providers\Transactions
 */
class ServiceProvider extends AbstractServiceProvider
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'transactions';

    /**
     * {@inheritdoc}
     *
     * 注册错误信息获取服务
     *
     * @return void
     */
    public function register()
    {
        /**
         * 注册事务管理器
         */
        $this->di->setShared(
            $this->serviceName,
            function () {
                return new TransactionManager();
            }
        );
    }
}