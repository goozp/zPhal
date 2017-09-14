<?php

namespace ZPhal\Modules\Admin\Components;

use Phalcon\Di;
use Phalcon\Events\ManagerInterface;
use Phalcon\Events\EventsAwareInterface;
use ZPhal\Models\Resources;

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
        if (is_object($this->_eventsManager)){
            $this->_eventsManager->fire("media:beforeUploadMedia", $this, $files);
        }

        /**
         * 文件上传操作
         */
        // 上传路径
        $config =  Di::getDefault()->getConfig();
        $uploadBaseDir = $config->application->uploadDir;

        //当前时间
        $now   = time();
        $year  = date('Y', $now);
        $month = date('m', $now);

        if (!file_exists($uploadBaseDir.$year)){
            mkdir($uploadBaseDir.$year, 0777);
        }

        if (!file_exists($uploadBaseDir.$year.'/'.$month)){
            mkdir($uploadBaseDir.$year.'/'.$month, 0777);
        }

        $uploadDir = $uploadBaseDir.$year.'/'.$month.'/';


        // 遍历所有文件
        $output = [];
        $fileInfo = [];
        foreach ($files as $file) {
            // 文件信息
            $fileInfo['filename'] = $file->getName();
            $fileInfo['filesize'] = $file->getSize();
            $fileInfo['filetype'] = $file->getType();
            $fileInfo['url'] = '/uploads/'.$year.'/'.$month.'/'.$fileInfo['filename'];

            // 保存文件
            $newFile = $uploadDir . $fileInfo['filename'];
            if (is_file($newFile)){
                $output['error'] = '文件已存在！';
                return json_encode($output);
            }

            if ( $file->moveTo($newFile) ) {

                /**
                 * 存储到数据库
                 */
                $save = $this->saveInfo($fileInfo);
                if (  $save === true ){
                    $output['success'] = '上传成功！';
                }else{
                    $output['error'] = $save;
                }

            }else{
                $output['error'] = '文件保存失败！';
            }
            return json_encode($output);
        }


        if (is_object($this->_eventsManager)){
            $this->_eventsManager->fire("media:afterUploadMedia", $this, $files);
        }
    }

    /**
     * 存储媒体信息到数据库
     * @param $fileInfo
     * @return bool|string
     */
    public function saveInfo($fileInfo)
    {
        $resource = new Resources();

        $resource->resource_title = $fileInfo['filename'];
        $resource->resource_name  = $fileInfo['filename'];
        $resource->resource_parent = 0;
        $resource->guid = $fileInfo['url'];
        //$resource->resource_type
        $resource->resource_mime_type = $fileInfo['filetype'];


        // TODO 读取配置,是否裁剪图片

        if ($resource->create() === false) {
            $output = "文件信息保存失败：\n";

            $msgs = $resource->getMessages();
            foreach ($msgs as $msg) {
                $output .= $msg->getMessage()."\n";
            }

            return $output;
        } else {
            return true;
        }
    }

    /**
     * 图片处理
     */
}