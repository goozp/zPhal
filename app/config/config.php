<?php

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');
defined('THEMES_PATH') || define('THEMES_PATH', BASE_PATH . '/public/themes');

return [
    'version' => '1.0',

    'database' => [
        'adapter'  => env('DB_ADAPTER', 'Mysql'),
        'host'     => env('DB_HOST', 'localhost'), // 如用docker,对应数据库容器的hostname
        'dbname'   => env('DB_DATABASE', 'zphaldb'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'root'),
        'charset'  => env('DB_CHARSET', 'utf8'),
    ],

    'application' => [
        'appDir'         => APP_PATH . '/',
        'modelsDir'      => APP_PATH . '/common/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'themesDir'      => THEMES_PATH. '/', // 主题目录
        'uploadDir'      => BASE_PATH . '/public/uploads/',


        // 动态写法(不支持nginx配置public下为根目录):
        // 'baseUri'        => preg_replace('/([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
        // 静态写法(需设置host或配置域名, 否则为/zPhal/等其它情况) :
        'baseUri'        => '/',
    ],

    /**
     * if true, then we print a new line at the end of each CLI execution
     *
     * If we dont print a new line,
     * then the next command prompt will be placed directly on the left of the output
     * and it is less readable.
     *
     * You can disable this behaviour if the output of your application needs to don't have a new line at end
     */
    'printNewLine' => true
];
