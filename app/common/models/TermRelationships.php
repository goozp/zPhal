<?php

namespace ZPhal\Models;

class TermRelationships extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Object_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Term_taxonomy_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Term_order;

    /**
     * Method to set the value of field Object_id
     *
     * @param integer $Object_id
     * @return $this
     */
    public function setObjectId($Object_id)
    {
        $this->Object_id = $Object_id;

        return $this;
    }

    /**
     * Method to set the value of field Term_taxonomy_id
     *
     * @param integer $Term_taxonomy_id
     * @return $this
     */
    public function setTermTaxonomyId($Term_taxonomy_id)
    {
        $this->Term_taxonomy_id = $Term_taxonomy_id;

        return $this;
    }

    /**
     * Method to set the value of field Term_order
     *
     * @param integer $Term_order
     * @return $this
     */
    public function setTermOrder($Term_order)
    {
        $this->Term_order = $Term_order;

        return $this;
    }

    /**
     * Returns the value of field Object_id
     *
     * @return integer
     */
    public function getObjectId()
    {
        return $this->Object_id;
    }

    /**
     * Returns the value of field Term_taxonomy_id
     *
     * @return integer
     */
    public function getTermTaxonomyId()
    {
        return $this->Term_taxonomy_id;
    }

    /**
     * Returns the value of field Term_order
     *
     * @return integer
     */
    public function getTermOrder()
    {
        return $this->Term_order;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_term_relationships");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_term_relationships';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermRelationships[]|ZpTermRelationships|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermRelationships|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
