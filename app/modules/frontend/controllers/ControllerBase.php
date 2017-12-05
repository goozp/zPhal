<?php
namespace ZPhal\Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function onConstruct()
    {
        $this->view->setVars(
            [
                "blogname" => $this->option->get('blogname'),
                "blogdescription" => $this->option->get('blogdescription'),
            ]
        );
    }

    public function initialize()
    {
        if ($timezone = $this->option->get('timezone_string')){
            date_default_timezone_set($timezone);
        }

        $this->tag->setTitle($this->option->get('blogname'));
    }
}
