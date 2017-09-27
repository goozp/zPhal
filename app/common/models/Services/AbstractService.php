<?php

namespace ZPhal\Models\Services;

use Phalcon\DiInterface;
use Phalcon\Di\Injectable;

/**
 * 模型服务抽象入口
 * \Phosphorum\Model\Services\AbstractService
 *
 * @package Phosphorum\Model\Services
 */
abstract class AbstractService extends Injectable
{
    /**
     * AbstractService constructor.
     *
     * @param DiInterface|null $di
     */
    public function __construct(DiInterface $di = null)
    {
        $this->setDI($di ?: container());
    }

}
