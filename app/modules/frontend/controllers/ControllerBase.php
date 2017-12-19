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
                "siteDescription" => $this->option->get('site_description'),
                "siteKeywords" => $this->option->get('site_keywords'),
                "footer" => $this->option->get('footer_copyright'),
            ]
        );

        $this->tag->setTitle($this->option->get('blogname'));

        // TODO general description and keywords
    }

    public function initialize()
    {
        if ($timezone = $this->option->get('timezone_string')){
            date_default_timezone_set($timezone);
        }
    }
}
