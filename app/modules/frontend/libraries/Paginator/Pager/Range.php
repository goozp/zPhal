<?php

namespace ZPhal\Modules\Frontend\Libraries\Paginator\Pager;

use ZPhal\Modules\Frontend\Libraries\Paginator\Pager;

/**
 * ZPhal\Modules\Frontend\Libraries\Paginator\Pager\Range
 * Base class for ranges objects.
 */
abstract class Range
{
    /**
     * Pager object.
     *
     * @var \Phalcon\Paginator\Pager
     */
    protected $pager = null;

    /**
     * Window size.
     *
     * @var integer
     */
    protected $chunkLength = 0;

    /**
     * Class constructor.
     *
     * @param \Phalcon\Paginator\Pager $pager
     * @param integer                  $chunkLength
     */
    public function __construct(Pager $pager, $chunkLength)
    {
        $this->pager = $pager;
        $this->chunkLength = abs(intval($chunkLength));

        if ($this->chunkLength == 0) {
            $this->chunkLength = 1;
        }
    }

    /**
     * Calculate and returns an array representing the range around the current page.
     *
     * @return array
     */
    abstract public function getRange();
}
