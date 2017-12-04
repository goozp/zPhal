<?php
namespace ZPhal\Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use ZPhal\Library\Options\Redis;

class ControllerBase extends Controller
{
    public function initialize()
    {
        Redis::getInstance();
    }
}
