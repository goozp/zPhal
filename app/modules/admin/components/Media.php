<?php

namespace ZPhal\Modules\Admin\Components;

use DateTime;
use DateTimeZone;
use Phalcon\Di;
use Phalcon\Events\ManagerInterface;
use Phalcon\Events\EventsAwareInterface;

class Media implements EventsAwareInterface
{
    protected $_eventsManager;

    public function setEventsManager(ManagerInterface $eventsManager)
    {
        $this->_eventsManager = $eventsManager;
    }

    public function getEventsManager()
    {
        return $this->_eventsManager;
    }

    public function uploadMedia($files)
    {
        //$this->_eventsManager->fire("media:beforeUploadMedia", $this, $files);

        /**
         * 文件上传操作
         */
        // 上传路径
        $config =  Di::getDefault()->getConfig();
        $uploadDir = $config->application->uploadDir;

        //当前时间
        $datetime = new Datetime(
            new DateTimeZone("Asia/Shanghai")
        );
        $year =  $datetime->format("Y");
        $month =  $datetime->format("m");

        // TODO
         
        // 遍历所有文件
        foreach ($files as $file) {
            // Print file details
            /*echo $file->getName(), " ", $file->getSize(), "\n";*/

            // 保存文件
            if ($file->moveTo( $uploadDir . $file->getName() )){
                $output['success'] = 'upload success';
                return json_encode($output);
            }
        }

        //$this->_eventsManager->fire("media:afterUploadMedia", $this, $files);
    }
}