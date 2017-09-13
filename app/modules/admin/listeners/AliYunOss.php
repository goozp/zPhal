<?php

namespace ZPhal\Modules\Admin\Listeners;

use Phalcon\Events\Event;

class AliYunOss
{
    public function beforeUploadMedia(Event $event, $myComponent, $files)
    {
        echo "这里, beforeUploadMedia\n";
    }

    public function afterUploadMedia(Event $event, $myComponent, $files)
    {
        echo "这里, afterUploadMedia\n";
    }
}