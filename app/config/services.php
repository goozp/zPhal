<?php

use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

/**
 * 读取config服务提供者common注册列表进行服务注册
 */
$providers = require APP_PATH.'/config/providers.php';
if (is_array($providers['common'])) {
    foreach ($providers['common'] as $name => $class) {
        $serviceProvider = new $class($di);
        $serviceProvider->register();
        $serviceProvider->boot();
    }
}
