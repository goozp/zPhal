<?php

namespace ZPhal\Library\Option;

use ZPhal\Models\Options;

/**
 * TODO
 * Class Option
 * @package ZPhal\Library\Option
 */
class Option{

    const prefix = 'zphal_option';

    public function load()
    {
        $redis = container('redis');

        $options = Options::find([
            "autoload = 'yes'"
        ]);

        if ($options){
            foreach ($options as $option){
                $cacheKey = self::prefix . $option->option_name;
                $redis->save($cacheKey, $option->option_value);
            }
        }
    }

    public function get($name)
    {

    }

    public function save($name, $value)
    {

    }

    public function delete($name)
    {

    }
}