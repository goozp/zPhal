<?php

namespace ZPhal\Models;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Id;

    /**
     *
     * @var string
     * @Column(type="string", length=60, nullable=false)
     */
    protected $User_login;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $User_pass;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    protected $User_nicename;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $User_email;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $User_url;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $User_registered;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $User_activation_key;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $User_status;

    /**
     *
     * @var string
     * @Column(type="string", length=250, nullable=false)
     */
    protected $Display_name;

    /**
     * Method to set the value of field Id
     *
     * @param integer $Id
     * @return $this
     */
    public function setId($Id)
    {
        $this->Id = $Id;

        return $this;
    }

    /**
     * Method to set the value of field User_login
     *
     * @param string $User_login
     * @return $this
     */
    public function setUserLogin($User_login)
    {
        $this->User_login = $User_login;

        return $this;
    }

    /**
     * Method to set the value of field User_pass
     *
     * @param string $User_pass
     * @return $this
     */
    public function setUserPass($User_pass)
    {
        $this->User_pass = $User_pass;

        return $this;
    }

    /**
     * Method to set the value of field User_nicename
     *
     * @param string $User_nicename
     * @return $this
     */
    public function setUserNicename($User_nicename)
    {
        $this->User_nicename = $User_nicename;

        return $this;
    }

    /**
     * Method to set the value of field User_email
     *
     * @param string $User_email
     * @return $this
     */
    public function setUserEmail($User_email)
    {
        $this->User_email = $User_email;

        return $this;
    }

    /**
     * Method to set the value of field User_url
     *
     * @param string $User_url
     * @return $this
     */
    public function setUserUrl($User_url)
    {
        $this->User_url = $User_url;

        return $this;
    }

    /**
     * Method to set the value of field User_registered
     *
     * @param string $User_registered
     * @return $this
     */
    public function setUserRegistered($User_registered)
    {
        $this->User_registered = $User_registered;

        return $this;
    }

    /**
     * Method to set the value of field User_activation_key
     *
     * @param string $User_activation_key
     * @return $this
     */
    public function setUserActivationKey($User_activation_key)
    {
        $this->User_activation_key = $User_activation_key;

        return $this;
    }

    /**
     * Method to set the value of field User_status
     *
     * @param integer $User_status
     * @return $this
     */
    public function setUserStatus($User_status)
    {
        $this->User_status = $User_status;

        return $this;
    }

    /**
     * Method to set the value of field Display_name
     *
     * @param string $Display_name
     * @return $this
     */
    public function setDisplayName($Display_name)
    {
        $this->Display_name = $Display_name;

        return $this;
    }

    /**
     * Returns the value of field Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * Returns the value of field User_login
     *
     * @return string
     */
    public function getUserLogin()
    {
        return $this->User_login;
    }

    /**
     * Returns the value of field User_pass
     *
     * @return string
     */
    public function getUserPass()
    {
        return $this->User_pass;
    }

    /**
     * Returns the value of field User_nicename
     *
     * @return string
     */
    public function getUserNicename()
    {
        return $this->User_nicename;
    }

    /**
     * Returns the value of field User_email
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->User_email;
    }

    /**
     * Returns the value of field User_url
     *
     * @return string
     */
    public function getUserUrl()
    {
        return $this->User_url;
    }

    /**
     * Returns the value of field User_registered
     *
     * @return string
     */
    public function getUserRegistered()
    {
        return $this->User_registered;
    }

    /**
     * Returns the value of field User_activation_key
     *
     * @return string
     */
    public function getUserActivationKey()
    {
        return $this->User_activation_key;
    }

    /**
     * Returns the value of field User_status
     *
     * @return integer
     */
    public function getUserStatus()
    {
        return $this->User_status;
    }

    /**
     * Returns the value of field Display_name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->Display_name;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_users");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpUsers[]|ZpUsers|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpUsers|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
