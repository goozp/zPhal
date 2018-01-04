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


    /**
     * 上传文件
     * @param $files
     * @param string $uploadType 上传类型(决定路径) resource|cover
     * @param array $extra 额外参数
     * @return string
     */
    public function uploadMedia($file, $uploadType, $extra = [])
    {
        if (is_object($this->_eventsManager)) {
            $this->_eventsManager->fire("media:beforeUploadMedia", $this, $file);
        }


        /**
         * 文件上传操作
         */
        $output = [];
        $fileInfo = [];
        $config = Di::getDefault()->getConfig();
        $uploadBaseDir = $config->application->uploadDir; // 上传路径

        if (!file_exists($uploadBaseDir)) {
            mkdir($uploadBaseDir, 0777);
        }

        if ($uploadType == 'resource') {
            // 当前时间
            $now = time();
            $year = date('Y', $now);
            $month = date('m', $now);

            if (!file_exists($uploadBaseDir . $year)) {
                mkdir($uploadBaseDir . $year, 0777);
            }

            if (!file_exists($uploadBaseDir . $year . '/' . $month)) {
                mkdir($uploadBaseDir . $year . '/' . $month, 0777);
            }

            $uploadDir = $uploadBaseDir . $year . '/' . $month . '/';
            $dir = 'uploads/' . $year . '/' . $month . '/';

        } elseif ($uploadType == 'cover') {
            $uploadDir = $uploadBaseDir . 'cover/';

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777);
            }

            $dir = 'uploads/cover/';

        } else {
            return $this->uploadStatus('error', '错误的上传类型！');
        }

        // 文件信息
        $fileInfo['filename'] = $file->getName();
        $fileInfo['filesize'] = $file->getSize();
        $fileInfo['filetype'] = $file->getType();
        $fileInfo['url'] = $dir . $fileInfo['filename'];

        $newFile = $uploadDir . $fileInfo['filename'];
        if (is_file($newFile)) {
            return $this->uploadStatus('error', '文件已存在！');
        }

        // 保存文件
        if ($file->moveTo($newFile)) {

            /**
             * 存储到数据库
             */
            $save = $this->saveInfo($fileInfo);

            if ($save === true) {
                $output = $this->uploadStatus('success', '上传成功！', $fileInfo);
            } else {
                $output = $this->uploadStatus('error', $save);
            }

        } else {
            $error = $file->getError;
            $output = $this->uploadStatus('error', '文件保存失败：' . $error);
        }

        if (is_object($this->_eventsManager)) {
            $this->_eventsManager->fire("media:afterUploadMedia", $this, $file);
        }

        return $output;
    }

    /**
     * 存储媒体信息到数据库
     * @param $fileInfo
     * @return bool|string
     */
    public function saveInfo($fileInfo)
    {
        $resource = new Resources();

        $resource->upload_date  = date('Y-m-d H:i:s', time());
        $resource->upload_date_gmt  = gmdate('Y-m-d H:i:s', time());
        $resource->resource_title   = $fileInfo['filename'];
        $resource->resource_name    = $fileInfo['filename'];
        $resource->resource_parent  = 0;
        $resource->guid = $fileInfo['url'];

        //$resource->resource_type
        $resource->resource_mime_type = $fileInfo['filetype'];


        // TODO 读取配置,是否裁剪图片

        if ($resource->create() === false) {
            $output = "文件信息保存失败：\n";

            $msgs = $resource->getMessages();
            foreach ($msgs as $msg) {
                $output .= $msg->getMessage() . "\n";
            }

            return $output;
        } else {
            return true;
        }
    }

    /**
     * 返回上传状态
     * @param $status
     * @param $message
     * @return array
     */
    public function uploadStatus($status, $message, $data = [])
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * 图片处理
     */
}