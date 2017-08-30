<?php

namespace ZPhal\Models;

class Resourcemeta extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Meta_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Resource_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $Meta_key;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $Meta_value;

    /**
     * Method to set the value of field Meta_id
     *
     * @param integer $Meta_id
     * @return $this
     */
    public function setMetaId($Meta_id)
    {
        $this->Meta_id = $Meta_id;

        return $this;
    }

    /**
     * Method to set the value of field Resource_id
     *
     * @param integer $Resource_id
     * @return $this
     */
    public function setResourceId($Resource_id)
    {
        $this->Resource_id = $Resource_id;

        return $this;
    }

    /**
     * Method to set the value of field Meta_key
     *
     * @param string $Meta_key
     * @return $this
     */
    public function setMetaKey($Meta_key)
    {
        $this->Meta_key = $Meta_key;

        return $this;
    }

    /**
     * Method to set the value of field Meta_value
     *
     * @param string $Meta_value
     * @return $this
     */
    public function setMetaValue($Meta_value)
    {
        $this->Meta_value = $Meta_value;

        return $this;
    }

    /**
     * Returns the value of field Meta_id
     *
     * @return integer
     */
    public function getMetaId()
    {
        return $this->Meta_id;
    }

    /**
     * Returns the value of field Resource_id
     *
     * @return integer
     */
    public function getResourceId()
    {
        return $this->Resource_id;
    }

    /**
     * Returns the value of field Meta_key
     *
     * @return string
     */
    public function getMetaKey()
    {
        return $this->Meta_key;
    }

    /**
     * Returns the value of field Meta_value
     *
     * @return string
     */
    public function getMetaValue()
    {
        return $this->Meta_value;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_resourcemeta");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_resourcemeta';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpResourcemeta[]|ZpResourcemeta|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpResourcemeta|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
