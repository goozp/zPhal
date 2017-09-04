<?php
namespace ZPhal\Modules\Admin\Components;

use Phalcon\Paginator\AdapterInterface as PaginatorInterface;

class Paginator implements PaginatorInterface
{
    /**
     * Adapter constructor
     *
     * @param array $config
     */
    public function __construct($config)
    {

    }

    /**
     * Set the current page number
     *
     * @param int $page
     */
    public function setCurrentPage($page)
    {

    }

    /**
     * Returns a slice of the resultset to show in the pagination
     *
     * @return stdClass
     */
    public function getPaginate()
    {

    }

    public function getLimit()
    {
        // TODO: Implement getLimit() method.
    }

    public function setLimit($limit)
    {
        // TODO: Implement setLimit() method.
    }
}