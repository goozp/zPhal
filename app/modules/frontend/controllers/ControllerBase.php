<?php
namespace ZPhal\Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function onConstruct()
    {

    }

    public function initialize()
    {
        if ($timezone = $this->option->get('timezone_string')){
            date_default_timezone_set($timezone);
        }
    }
}
