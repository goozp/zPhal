<?php

namespace ZPhal\Library\Options;

use Phalcon\Mvc\User\Plugin;
use ZPhal\Models\Options;

/**
 * Options参数的redis缓存服务类
 * TODO bug 不自动加载的配置没有读取，也就get不到
 *
 * Class Redis
 * @package ZPhal\Library\Options
 */
class Redis extends Plugin
{

    /**
     * @var object Singleton 单例
     */
    private static $instance;

    /**
     * @var object redis对象
     */
    private static $redis;

    /**
     * @var array 参数实例
     */
    private static $options;

    /**
     * @var string redisKey
     */
    public static $optionKey = '_zphal_option';

    /**
     * Redis constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * 初始化options数据
     * @return array|null
     */
    public function init()
    {
        if ( is_null( self::$redis ) ){
            self::$redis = $this->di->getShared('redis');
        }

        if ( is_null( self::$options ) ){
            if (self::$redis->exists(self::$optionKey)){
                self::$options = self::$redis->get(self::$optionKey);
            }else{
                // 查询
                $options = Options::find(
                    [
                        "autoload = 'yes' ",
                        "columns" => "option_name, option_value"
                    ]
                );

                if ($options){
                    self::$redis->save(self::$optionKey, $options); // 存储到redis
                    self::$options = $options; // 赋值到实例中
                }
            }
        }

        return self::$options;
    }

    /**
     * 获取单例
     *
     * @return object|Redis
     */
    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 获取某个key对应的值
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return self::$options[$key];
    }

    /**
     * 检查key对应的option是否存在
     *
     * @param $key
     * @return bool
     */
    public function exist($key)
    {
        return array_key_exists($key, self::$options)? true : false;
    }

    /**
     * 保存option；自动加载的将自动缓存
     *
     * @param $key
     * @param $value
     * @param string $autoload
     */
    public function save($key, $value, $autoload='')
    {
        if (!empty($value)){
            $option = Options::findFirst(
                [
                    "option_name = :name: ",
                    "bind"       => [
                        'name' => $key,
                    ]
                ]
            );

            if ($option){
                $option->option_value = $value;
                if ($autoload != ''){
                    $option->autoload = $autoload;
                }
                $option->save();
            }else{
                $option = new Options();
                $option->option_name = $key;
                $option->option_value = $value;
                $option->autoload = $autoload ?: Options::AUTO_NO;
                $option->create();
            }

            if ($option->autoload == Options::AUTO_YES){
                self::saveCache($key, $value);
            }

            return true;
        }else{
            return false;
        }
    }

    /**
     * 保存到缓存
     *
     * @param $key
     * @param $value
     */
    public function saveCache($key, $value)
    {
        self::$options[$key] = $value;
        self::$redis->save(self::$optionKey, self::$options);
    }

    /**
     * 清除options缓存
     */
    public function clearCache()
    {
        self::$redis->delete(self::$optionKey);
    }

    /**
     * 返回options列表
     *
     * @return null
     */
    public function query()
    {
        return self::$options;
    }
}