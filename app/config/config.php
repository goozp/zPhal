<?php

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'app');
defined('THEMES_PATH') || define('THEMES_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'themes');

return [
    'version' => '1.0',
    'debug' => env('APP_DEBUG', false),
    'environment' =>env('APP_ENV', 'production'),

    'database' => [
        'adapter'  => env('DB_ADAPTER', 'Mysql'),
        'host'     => env('DB_HOST', 'localhost'), // 如用docker,对应数据库容器的hostname
        'dbname'   => env('DB_DATABASE', 'zphaldb'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'root'),
        'charset'  => env('DB_CHARSET', 'utf8'),
    ],

    'application' => [
        'appDir'         => app_path(),
        'modelsDir'      => app_path('common/models'),
        'migrationsDir'  => app_path('migrations'),
        'cacheDir'       => cache_path(),
        'themesDir'      => THEMES_PATH. DIRECTORY_SEPARATOR, // 主题目录
        'uploadDir'      => BASE_PATH . DIRECTORY_SEPARATOR. 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR,

        // 动态写法(不支持nginx配置public下为根目录):
        // 'baseUri'        => preg_replace('/([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
        // 静态写法(需设置host或配置域名, 否则为/zPhal/等其它情况) :
        'baseUri'        => '/',
    ],

    'error' => [
        'logger'    => BASE_PATH . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'error.log',
        'formatter' => [
            'format' => env('LOGGER_FORMAT', '[%date%][%type%] %message%'),
            'date'   => 'd-M-Y H:i:s',
        ],
        'controller' => 'error',
        'action'     => 'route500',
    ],

    'cache' => [
        'default' => env('DEFAULT_CACHE_DRIVER', 'file'),

        'views'   => env('VIEW_CACHE_DRIVER', 'views'),

        'drivers' => [
            'file' => [
                'adapter'  => 'File',
                'cacheDir' => cache_path('data') . DIRECTORY_SEPARATOR
            ],

            'views' => [
                'adapter'  => 'File',
                'cacheDir' => cache_path('views') . DIRECTORY_SEPARATOR
            ],

            'redis' => [
                'adapter' => 'Redis',
                'host'    => env('REDIS_HOST', '127.0.0.1'), // 如用docker,对应redis的hostname
                'port'    => env('REDIS_PORT', 6379),
                'index'   => env('REDIS_INDEX', 0),
                'persistent' => true,
            ],
        ],

        'prefix' => env('CACHE_PREFIX', '_zphal_cache_'),

        'lifetime' => env('CACHE_LIFETIME', 86400),
    ],

    'session' => [
        'default' => env('SESSION_DRIVER', 'redis'),

        'drivers' => [
            'redis' => [
                'adapter'    => 'Redis',
                'host'       => env('REDIS_HOST', '127.0.0.1'),
                'port'       => env('REDIS_PORT', 6379),
                'index'      => env('REDIS_INDEX', 0),
                'persistent' => true,
            ],

            'file' => [
                'adapter'  => 'Files',
            ],
        ],

        'prefix'   => env('SESSION_PREFIX', '_zphal_session_'),

        'uniqueId' => env('SESSION_UNIQUE_ID', 'zphalcms_'),

        'lifetime' => env('SESSION_LIFETIME', 86400),
    ],

    'security' => [
        'crypt' => [
            'key' => '#zp3hal11$=e?.go3od//j2ob$',
        ],
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
    'printNewLine' => true,
];
