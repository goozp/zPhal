<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');
defined('THEMES_PATH') || define('THEMES_PATH', BASE_PATH . '/public/themes');

return new \Phalcon\Config([
    'version' => '1.0',

    'database' => [
        'adapter'  => 'Mysql',
        'host'     => '127.0.0.1', // 如用docker,需改为对应数据库容器的hostname
        'username' => 'root',
        'password' => 'root',
        'dbname'   => 'zphaldb',
        'dbprefix' => 'zp_',
        'charset'  => 'utf8',
    ],

    'application' => [
        'appDir'         => APP_PATH . '/',
        'modelsDir'      => APP_PATH . '/common/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'themesDir'      => THEMES_PATH. '/', // 主题目录
        'uploadDir'      => BASE_PATH . '/public/uploads/',

        // baseUri 不是在根目录或者server工作目录时,生成url起作用
        // 通常为指到public/index.php下的路径, 受server rewrite规则影响
        // 官方动态写法(不支持nginx配置public下为根目录):
         'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
        // 获取直接写为静态路径 (需设置host, 否则为/zPhal/等其它情况) :
        // 'baseUri'        => '/',
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
]);
