<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget\Part;

abstract class Taxonomy
{
    protected $chunkLength = 0;

    public function __construct()
    {

    }

    abstract public function getList();
}