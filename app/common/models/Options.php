<?php

namespace ZPhal\Models;

class Options extends ModelBase
{

    public $option_id;

    public $option_name;

    public $option_value;

    public $autoload;

    const AUTO_YES = 'yes';

    const AUTO_NO = 'no';

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_options");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_options';
    }

    public function afterSave()
    {

    }

    /**
     * 是否自动加载
     *
     * @return bool
     */
    public function ifAutoload(){
        if($this->autoload === self::AUTO_YES){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 重新编排查询到的数据
     *
     * @param null $parameters
     * @return array
     */
    public static function find($parameters = null)
    {
        $options = parent::find($parameters);

        $output = [];

        if ($options){
            foreach ($options as $option){
                $output[$option['option_name']] = $option['option_value'];
            }
        }

        return $output;
    }
}
