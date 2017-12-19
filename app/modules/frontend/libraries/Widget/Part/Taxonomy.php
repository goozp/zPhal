<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget\Part;

abstract class Taxonomy
{
    protected static $modelsManager = null;

    public function __construct($modelsManager)
    {
        if (self::$modelsManager === null){
            self::$modelsManager = $modelsManager ?: container('modelsManager');
        }
    }

    abstract public function getList();

    /**
     * get taxonomy list
     *
     * @param $type
     * @return bool
     */
    public function query($type)
    {
        $taxonomy = self::$modelsManager->createBuilder()
            ->columns("t.term_id, t.name, t.slug, tt.parent")
            ->from(['t' => 'ZPhal\Models\Terms'])
            ->leftJoin('ZPhal\Models\TermTaxonomy', 't.term_id = tt.term_id', "tt")
            ->where("tt.taxonomy = :taxonomy:", ["taxonomy" => $type])
            ->getQuery()
            ->execute();
        if ($taxonomy){
            return $taxonomy->toArray();
        }else{
            return false;
        }
    }
}