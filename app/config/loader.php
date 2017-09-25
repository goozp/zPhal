<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * Register Namespaces
 */
$loader->registerNamespaces([
    'ZPhal\Models'  => APP_PATH . '/common/models/',
    'ZPhal\Library' => APP_PATH . '/common/library/',
    'ZPhal\Plugins' => APP_PATH . '/common/plugins/',
]);

/**
 * Register module classes
 */
$loader->registerClasses([
    'ZPhal\Modules\Frontend\Module' => APP_PATH . '/modules/frontend/Module.php',
    'ZPhal\Modules\Cli\Module'      => APP_PATH . '/modules/cli/Module.php',
    'ZPhal\Modules\Admin\Module'      => APP_PATH . '/modules/admin/Module.php'
]);

/**
 * Register Files, composer autoloader
 */
$loader->registerFiles(
    [
        APP_PATH . '/common/vendor/autoload.php'
    ]
);

$loader->register();

