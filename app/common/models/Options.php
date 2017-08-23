<?php

namespace ZPhal\Models;

class Options extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Option_id;

    /**
     *
     * @var string
     * @Column(type="string", length=191, nullable=false)
     */
    protected $Option_name;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Option_value;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $Autoload;

    /**
     * Method to set the value of field Option_id
     *
     * @param integer $Option_id
     * @return $this
     */
    public function setOptionId($Option_id)
    {
        $this->Option_id = $Option_id;

        return $this;
    }

    /**
     * Method to set the value of field Option_name
     *
     * @param string $Option_name
     * @return $this
     */
    public function setOptionName($Option_name)
    {
        $this->Option_name = $Option_name;

        return $this;
    }

    /**
     * Method to set the value of field Option_value
     *
     * @param string $Option_value
     * @return $this
     */
    public function setOptionValue($Option_value)
    {
        $this->Option_value = $Option_value;

        return $this;
    }

    /**
     * Method to set the value of field Autoload
     *
     * @param string $Autoload
     * @return $this
     */
    public function setAutoload($Autoload)
    {
        $this->Autoload = $Autoload;

        return $this;
    }

    /**
     * Returns the value of field Option_id
     *
     * @return integer
     */
    public function getOptionId()
    {
        return $this->Option_id;
    }

    /**
     * Returns the value of field Option_name
     *
     * @return string
     */
    public function getOptionName()
    {
        return $this->Option_name;
    }

    /**
     * Returns the value of field Option_value
     *
     * @return string
     */
    public function getOptionValue()
    {
        return $this->Option_value;
    }

    /**
     * Returns the value of field Autoload
     *
     * @return string
     */
    public function getAutoload()
    {
        return $this->Autoload;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_options");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_options';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpOptions[]|ZpOptions|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpOptions|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
