<?php
namespace ZPhal\Modules\Admin\Library\Message;

use Phalcon\Mvc\User\Component;

/**
 * Message
 *
 * 信息控制
 */
class MessageControl extends Component
{
    /**
     * 获取错误信息
     * @param $object
     * @param $message
     * @return mixed
     */
    public function getErrorMsg($object, $message)
    {
        $output = $message."：\n";

        $msgs = $object->getMessages();
        foreach ($msgs as $msg) {
            $output .= $msg->getMessage()."\n";
        }

        return $output;
    }
}