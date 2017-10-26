<?php

/**
 * 读取config服务提供者common注册列表进行服务注册
 */
$providers = require APP_PATH.'/config/providers.php';
if (is_array($providers['web']['both'])) {
    foreach ($providers['web']['both'] as $name => $class) {
        $serviceProvider = new $class($di);
        $serviceProvider->register();
        $serviceProvider->boot();
    }
}