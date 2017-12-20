<?php

namespace ZPhal\Modules\Frontend\Libraries\Widget\Part;

abstract class Taxonomy
{
    protected static $modelsManager = null;

    protected static $urlGenerator = null;

    /**
     * Taxonomy constructor. Initial services.
     *
     * @param $modelsManager
     * @param $urlGenerator
     */
    public function __construct($modelsManager, $urlGenerator)
    {
        if (self::$modelsManager === null){
            self::$modelsManager = $modelsManager ?: container('modelsManager');
        }

        if (self::$urlGenerator === null){
            self::$urlGenerator = $urlGenerator ?: container('url');
        }
    }

    /**
     * get list
     *
     * @return mixed
     */
    abstract public function getList();

    /**
     * get taxonomy data
     *
     * @param string $type taxonomy type
     * @param array $delete value's term_taxonomy_id that need to remove from the output array
     * @return bool
     */
    public function query($type, $delete=[])
    {
        $builder = self::$modelsManager->createBuilder()
            ->columns("tt.term_taxonomy_id, t.term_id, t.name, t.slug, tt.parent")
            ->from(['t' => 'ZPhal\Models\Terms'])
            ->leftJoin('ZPhal\Models\TermTaxonomy', 't.term_id = tt.term_id', "tt")
            ->where("tt.taxonomy = :taxonomy:", ["taxonomy" => $type]);

        if (!empty($delete)){
            $builder->notInWhere("tt.term_taxonomy_id", $delete);
        }

        $taxonomy = $builder
            ->getQuery()
            ->execute();

        if ($taxonomy){
            return $taxonomy->toArray();
        }else{
            return false;
        }
    }

    /**
     * get taxonomy tree
     *
     * @param $list
     * @param int $pid
     * @return array
     */
    public function tree($list, $pid = 0)
    {
        $output = [];

        foreach ($list as $key => $value){

            if ($value['parent'] == $pid){

                $children = $this->tree($list, $value['term_taxonomy_id']);
                if ($children) {
                    $value['children'] = $children;
                }

                $output[] = $value;
            }
        }
        return $output;
    }
}