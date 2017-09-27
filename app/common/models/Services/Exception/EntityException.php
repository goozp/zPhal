<?php

namespace ZPhal\Models\Services\Exception;

use Exception;
use Phalcon\Mvc\ModelInterface;

/**
 * 模型服务异常实现类
 * Phosphorum\Model\Services\Exception\EntityException
 *
 * @package Phosphorum\Model\Services\Exception
 */
class EntityException extends Exception implements ServiceExceptionInterface
{
    /**
     * @var ModelInterface
     */
    protected $entity;

    /**
     * EntityNotFoundException constructor.
     *
     * @param ModelInterface $entity
     * @param string         $message
     * @param string         $type
     * @param int            $code
     * @param Exception|null $prev
     */
    public function __construct(ModelInterface $entity, $message = '', $type = 'id', $code = 0, Exception $prev = null)
    {
        $this->entity = $entity;

        $messages = [];
        foreach ((array) $entity->getMessages() as $entityMessage) {
            $messages[] = (string) $entityMessage;
        }

        array_unshift($messages, $message);

        $message = implode('. ', array_map(function ($value) {
            return rtrim($value, '.');
        }, $messages));

        parent::__construct($message, $code, $prev);
    }

    /**
     * Get the entity associated with exception.
     *
     * @return ModelInterface
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
