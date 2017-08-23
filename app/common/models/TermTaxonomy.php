<?php

namespace ZPhal\Models;

class TermTaxonomy extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Term_taxonomy_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Term_id;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=false)
     */
    protected $Taxonomy;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Description;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Parent;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Count;

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
     * Method to set the value of field Term_id
     *
     * @param integer $Term_id
     * @return $this
     */
    public function setTermId($Term_id)
    {
        $this->Term_id = $Term_id;

        return $this;
    }

    /**
     * Method to set the value of field Taxonomy
     *
     * @param string $Taxonomy
     * @return $this
     */
    public function setTaxonomy($Taxonomy)
    {
        $this->Taxonomy = $Taxonomy;

        return $this;
    }

    /**
     * Method to set the value of field Description
     *
     * @param string $Description
     * @return $this
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * Method to set the value of field Parent
     *
     * @param integer $Parent
     * @return $this
     */
    public function setParent($Parent)
    {
        $this->Parent = $Parent;

        return $this;
    }

    /**
     * Method to set the value of field Count
     *
     * @param integer $Count
     * @return $this
     */
    public function setCount($Count)
    {
        $this->Count = $Count;

        return $this;
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
     * Returns the value of field Term_id
     *
     * @return integer
     */
    public function getTermId()
    {
        return $this->Term_id;
    }

    /**
     * Returns the value of field Taxonomy
     *
     * @return string
     */
    public function getTaxonomy()
    {
        return $this->Taxonomy;
    }

    /**
     * Returns the value of field Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * Returns the value of field Parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->Parent;
    }

    /**
     * Returns the value of field Count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->Count;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_term_taxonomy");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_term_taxonomy';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermTaxonomy[]|ZpTermTaxonomy|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTermTaxonomy|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
