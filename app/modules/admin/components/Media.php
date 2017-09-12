<?php

namespace ZPhal\Modules\Admin\Components;

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

    public function uploadMedia()
    {
        $this->_eventsManager->fire("media:beforeUploadMedia", $this);

        // 做一些你想做的事情
        echo "这里, someTask\n";

        $this->_eventsManager->fire("media:afterUploadMedia", $this);
    }
}