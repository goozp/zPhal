<?php

namespace ZPhal\Modules\Frontend\Controllers;


class ErrorController extends ControllerBase
{
    public function route404Action()
    {
        $this->tag->prependTitle("404 - ");

        // 发送一个HTTP 404 响应的header
        $this->response->setStatusCode(404, "Not Found");
        echo '404 not found';
    }

    public function route503Action()
    {
        $this->response->setStatusCode(503, "Service Unavailable");
        echo '503';
    }
}