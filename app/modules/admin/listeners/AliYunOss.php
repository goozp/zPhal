<?php

namespace ZPhal\Modules\Admin\Listeners;

use Phalcon\Events\Event;

class AliYunOss
{
    public function beforeUploadMedia(Event $event, $myComponent, $file)
    {
        return false;
    }

    public function afterUploadMedia(Event $event, $myComponent, $file)
    {
        return false;
    }
}