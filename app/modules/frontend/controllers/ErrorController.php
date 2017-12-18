<?php

namespace ZPhal\Modules\Frontend\Controllers;

/**
 * Class ErrorController
 *
 * @package ZPhal\Modules\Frontend\Controllers
 */
class ErrorController extends ControllerBase
{
    /**
     * @var \stdClass
     */
    protected $error;

    public function initialize()
    {
        parent::initialize();

        $this->view->setTemplateAfter("common");
    }

    public function route400Action()
    {
        $this->createError(
            'Bad request',
            400,
            "Something is not quite right.<br/>错误的请求。",
            __LINE__
        );
    }

    public function route401Action()
    {
        $this->response->setHeader('WWW-Authenticate', 'Digest realm="Access denied"');

        $this->createError(
            'Authorization required',
            401,
            "To access the requested resource requires authentication.<br/>未经授权",
            __LINE__
        );
    }

    public function route403Action()
    {
        $this->createError(
            'Access is denied',
            403,
            "Access to this resource is denied by the administrator.<br/>拒绝访问",
            __LINE__
        );
    }

    public function route404Action()
    {
        $this->createError(
            'Page not found',
            404,
            "Sorry! We can't seem to find the page you're looking for.<br/>页面未找到。",
            __LINE__
        );
    }

    public function route500Action()
    {
        $this->response->setHeader('Retry-After', 3600);

        $this->createError(
            'Something is not quite right',
            500,
            "We&rsquo;ll be back soon!<br/>服务器错误",
            __LINE__
        );
    }

    public function route503Action()
    {
        $this->createError(
            'Site Maintenance',
            503,
            "Unfortunately an unexpected system error occurred.<br/>系统错误",
            __LINE__
        );
    }

    protected function createError($title, $code, $message, $line)
    {
        $error = $this->error;

        if (!is_object($error)) {
            $error = (object) [
                'type'    => -1,
                'message' => $title,
                'file'    => __FILE__,
                'line'    => $line,
                'trace'   => [],
            ];
        }

        $this->tag->prependTitle($code . " - ");
        $this->response->setStatusCode($code);

        $this->view->setVars([
            'code'    => $code,
            'error'   => $error,
            'message' => $message,
        ]);
    }
}