<?php
/*
  +------------------------------------------------------------------------+
  | ZPhal 辅助函数                                                          |
  +------------------------------------------------------------------------+
  | Copyright (c) 2017 ZPhal                                               |
  +------------------------------------------------------------------------+
*/

use Phalcon\Di;

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
