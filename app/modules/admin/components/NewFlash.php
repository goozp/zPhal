<?php
namespace ZPhal\Modules\Admin\Components;

use Phalcon\Flash\Session as Flash;

class NewFlash extends Flash
{
    public function __construct($cssClasses = null)
    {
        if ($cssClasses === null) {
            $cssClasses = array(
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning',
                'error'   => 'alert alert-danger',
            );
        }
        parent::__construct($cssClasses);
    }

    public function message($type, $message)
    {
        switch ($type){
            case 'success':
                $messageType = '信息';
                break;
            case 'notice':
                $messageType = '提示';
                break;
            case 'warning':
                $messageType = '警告';
                break;
            case 'error':
                $messageType = '错误';
                break;
            default:
                $messageType = '信息';
                break;
        }
        $button = "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-ban'></i> ".$messageType."</h4>";
        $message = $button.$message;
        parent::message($type, $message);
    }

    public function output($remove = true)
    {
        parent::output($remove);
    }
}