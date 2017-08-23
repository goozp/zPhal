<?php

namespace ZPhal\Models;

class Terms extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Term_id;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    protected $Name;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    protected $Slug;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $Term_group;

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
     * Method to set the value of field Name
     *
     * @param string $Name
     * @return $this
     */
    public function setName($Name)
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * Method to set the value of field Slug
     *
     * @param string $Slug
     * @return $this
     */
    public function setSlug($Slug)
    {
        $this->Slug = $Slug;

        return $this;
    }

    /**
     * Method to set the value of field Term_group
     *
     * @param integer $Term_group
     * @return $this
     */
    public function setTermGroup($Term_group)
    {
        $this->Term_group = $Term_group;

        return $this;
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
     * Returns the value of field Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Returns the value of field Slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->Slug;
    }

    /**
     * Returns the value of field Term_group
     *
     * @return integer
     */
    public function getTermGroup()
    {
        return $this->Term_group;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_terms");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_terms';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTerms[]|ZpTerms|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpTerms|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
