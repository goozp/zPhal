<?php

/*
 +------------------------------------------------------------------------+
 | ZPhal                                                                  |
 +------------------------------------------------------------------------+
 | Copyright (c) 2017 ZPhal Team and contributors                         |
 +------------------------------------------------------------------------+
 | This source file is subject to the New BSD License that is bundled     |
 | with this package in the file docs/LICENSE.txt.                        |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to gzp@goozp.com so we can send you a copy immediately.                |
 +------------------------------------------------------------------------+
*/

use Phalcon\Di;

if (!function_exists('value')) {
    /**
     * 获取默认值Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('env')) {
    /**
     * 获取环境变量值
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return value($default);
        }
        switch (strtolower($value)) {
            case 'true':
                return true;
            case 'false':
                return false;
            case 'empty':
                return '';
            case 'null':
                return null;
        }
        return $value;
    }
}

if (!function_exists('container')) {
    /**
     * 唤醒默认依赖注入容器
     *
     * @param  mixed
     * @return mixed|\Phalcon\DiInterface
     */
    function container()
    {
        $default = Di::getDefault();

        $args = func_get_args();

        if (empty($args)) {
            return $default;
        }

        if (!$default) {
            trigger_error('Unable to resolve Dependency Injection container.', E_USER_ERROR);
        }

        return call_user_func_array([$default, 'getShared'], $args);
    }
}

if (!function_exists('environment')) {
    /**
     * 检查当前的应用部署环境
     *
     * @param  mixed
     * @return string|bool
     */
    function environment()
    {
        if (func_num_args() > 0) {
            return call_user_func_array([container(), 'getEnvironment'], func_get_args());
        }

        return container()->getEnvironment();
    }
}