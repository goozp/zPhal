<?php

namespace ZPhal\Modules\Frontend\Controllers;


class ErrorController extends ControllerBase
{
    public function route404Action()
    {
        echo '404 not found';
    }

    public function route503Action()
    {
        echo '503';
    }
}