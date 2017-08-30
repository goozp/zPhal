<?php

namespace ZPhal\Models;

class Resources extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Resource_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Upload_author;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Upload_date;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Upload_date_gmt;

    /**
     *
     * @var string
     * @Column(type="string", length=500, nullable=true)
     */
    protected $Resource_content;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $Resource_title;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $Resource_status;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    protected $Resource_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Resource_parent;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $Guid;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $Resource_type;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $Resource_mime_type;

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
     * Method to set the value of field Upload_author
     *
     * @param integer $Upload_author
     * @return $this
     */
    public function setUploadAuthor($Upload_author)
    {
        $this->Upload_author = $Upload_author;

        return $this;
    }

    /**
     * Method to set the value of field Upload_date
     *
     * @param string $Upload_date
     * @return $this
     */
    public function setUploadDate($Upload_date)
    {
        $this->Upload_date = $Upload_date;

        return $this;
    }

    /**
     * Method to set the value of field Upload_date_gmt
     *
     * @param string $Upload_date_gmt
     * @return $this
     */
    public function setUploadDateGmt($Upload_date_gmt)
    {
        $this->Upload_date_gmt = $Upload_date_gmt;

        return $this;
    }

    /**
     * Method to set the value of field Resource_content
     *
     * @param string $Resource_content
     * @return $this
     */
    public function setResourceContent($Resource_content)
    {
        $this->Resource_content = $Resource_content;

        return $this;
    }

    /**
     * Method to set the value of field Resource_title
     *
     * @param string $Resource_title
     * @return $this
     */
    public function setResourceTitle($Resource_title)
    {
        $this->Resource_title = $Resource_title;

        return $this;
    }

    /**
     * Method to set the value of field Resource_status
     *
     * @param string $Resource_status
     * @return $this
     */
    public function setResourceStatus($Resource_status)
    {
        $this->Resource_status = $Resource_status;

        return $this;
    }

    /**
     * Method to set the value of field Resource_name
     *
     * @param string $Resource_name
     * @return $this
     */
    public function setResourceName($Resource_name)
    {
        $this->Resource_name = $Resource_name;

        return $this;
    }

    /**
     * Method to set the value of field Resource_parent
     *
     * @param integer $Resource_parent
     * @return $this
     */
    public function setResourceParent($Resource_parent)
    {
        $this->Resource_parent = $Resource_parent;

        return $this;
    }

    /**
     * Method to set the value of field Guid
     *
     * @param string $Guid
     * @return $this
     */
    public function setGuid($Guid)
    {
        $this->Guid = $Guid;

        return $this;
    }

    /**
     * Method to set the value of field Resource_type
     *
     * @param string $Resource_type
     * @return $this
     */
    public function setResourceType($Resource_type)
    {
        $this->Resource_type = $Resource_type;

        return $this;
    }

    /**
     * Method to set the value of field Resource_mime_type
     *
     * @param string $Resource_mime_type
     * @return $this
     */
    public function setResourceMimeType($Resource_mime_type)
    {
        $this->Resource_mime_type = $Resource_mime_type;

        return $this;
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
     * Returns the value of field Upload_author
     *
     * @return integer
     */
    public function getUploadAuthor()
    {
        return $this->Upload_author;
    }

    /**
     * Returns the value of field Upload_date
     *
     * @return string
     */
    public function getUploadDate()
    {
        return $this->Upload_date;
    }

    /**
     * Returns the value of field Upload_date_gmt
     *
     * @return string
     */
    public function getUploadDateGmt()
    {
        return $this->Upload_date_gmt;
    }

    /**
     * Returns the value of field Resource_content
     *
     * @return string
     */
    public function getResourceContent()
    {
        return $this->Resource_content;
    }

    /**
     * Returns the value of field Resource_title
     *
     * @return string
     */
    public function getResourceTitle()
    {
        return $this->Resource_title;
    }

    /**
     * Returns the value of field Resource_status
     *
     * @return string
     */
    public function getResourceStatus()
    {
        return $this->Resource_status;
    }

    /**
     * Returns the value of field Resource_name
     *
     * @return string
     */
    public function getResourceName()
    {
        return $this->Resource_name;
    }

    /**
     * Returns the value of field Resource_parent
     *
     * @return integer
     */
    public function getResourceParent()
    {
        return $this->Resource_parent;
    }

    /**
     * Returns the value of field Guid
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->Guid;
    }

    /**
     * Returns the value of field Resource_type
     *
     * @return string
     */
    public function getResourceType()
    {
        return $this->Resource_type;
    }

    /**
     * Returns the value of field Resource_mime_type
     *
     * @return string
     */
    public function getResourceMimeType()
    {
        return $this->Resource_mime_type;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_resources");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_resources';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpResources[]|ZpResources|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpResources|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
