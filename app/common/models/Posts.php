<?php

namespace ZPhal\Models;

class Posts extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Post_author;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Post_date;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Post_date_gmt;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Post_content;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Post_title;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $Post_status;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $Comment_status;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    protected $Post_name;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Post_modified;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Post_modified_gmt;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Post_parent;

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
    protected $Post_type;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $Post_mime_type;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Comment_count;

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
     * Method to set the value of field Post_author
     *
     * @param integer $Post_author
     * @return $this
     */
    public function setPostAuthor($Post_author)
    {
        $this->Post_author = $Post_author;

        return $this;
    }

    /**
     * Method to set the value of field Post_date
     *
     * @param string $Post_date
     * @return $this
     */
    public function setPostDate($Post_date)
    {
        $this->Post_date = $Post_date;

        return $this;
    }

    /**
     * Method to set the value of field Post_date_gmt
     *
     * @param string $Post_date_gmt
     * @return $this
     */
    public function setPostDateGmt($Post_date_gmt)
    {
        $this->Post_date_gmt = $Post_date_gmt;

        return $this;
    }

    /**
     * Method to set the value of field Post_content
     *
     * @param string $Post_content
     * @return $this
     */
    public function setPostContent($Post_content)
    {
        $this->Post_content = $Post_content;

        return $this;
    }

    /**
     * Method to set the value of field Post_title
     *
     * @param string $Post_title
     * @return $this
     */
    public function setPostTitle($Post_title)
    {
        $this->Post_title = $Post_title;

        return $this;
    }

    /**
     * Method to set the value of field Post_status
     *
     * @param string $Post_status
     * @return $this
     */
    public function setPostStatus($Post_status)
    {
        $this->Post_status = $Post_status;

        return $this;
    }

    /**
     * Method to set the value of field Comment_status
     *
     * @param string $Comment_status
     * @return $this
     */
    public function setCommentStatus($Comment_status)
    {
        $this->Comment_status = $Comment_status;

        return $this;
    }

    /**
     * Method to set the value of field Post_name
     *
     * @param string $Post_name
     * @return $this
     */
    public function setPostName($Post_name)
    {
        $this->Post_name = $Post_name;

        return $this;
    }

    /**
     * Method to set the value of field Post_modified
     *
     * @param string $Post_modified
     * @return $this
     */
    public function setPostModified($Post_modified)
    {
        $this->Post_modified = $Post_modified;

        return $this;
    }

    /**
     * Method to set the value of field Post_modified_gmt
     *
     * @param string $Post_modified_gmt
     * @return $this
     */
    public function setPostModifiedGmt($Post_modified_gmt)
    {
        $this->Post_modified_gmt = $Post_modified_gmt;

        return $this;
    }

    /**
     * Method to set the value of field Post_parent
     *
     * @param integer $Post_parent
     * @return $this
     */
    public function setPostParent($Post_parent)
    {
        $this->Post_parent = $Post_parent;

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
     * Method to set the value of field Post_type
     *
     * @param string $Post_type
     * @return $this
     */
    public function setPostType($Post_type)
    {
        $this->Post_type = $Post_type;

        return $this;
    }

    /**
     * Method to set the value of field Post_mime_type
     *
     * @param string $Post_mime_type
     * @return $this
     */
    public function setPostMimeType($Post_mime_type)
    {
        $this->Post_mime_type = $Post_mime_type;

        return $this;
    }

    /**
     * Method to set the value of field Comment_count
     *
     * @param integer $Comment_count
     * @return $this
     */
    public function setCommentCount($Comment_count)
    {
        $this->Comment_count = $Comment_count;

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
     * Returns the value of field Post_author
     *
     * @return integer
     */
    public function getPostAuthor()
    {
        return $this->Post_author;
    }

    /**
     * Returns the value of field Post_date
     *
     * @return string
     */
    public function getPostDate()
    {
        return $this->Post_date;
    }

    /**
     * Returns the value of field Post_date_gmt
     *
     * @return string
     */
    public function getPostDateGmt()
    {
        return $this->Post_date_gmt;
    }

    /**
     * Returns the value of field Post_content
     *
     * @return string
     */
    public function getPostContent()
    {
        return $this->Post_content;
    }

    /**
     * Returns the value of field Post_title
     *
     * @return string
     */
    public function getPostTitle()
    {
        return $this->Post_title;
    }

    /**
     * Returns the value of field Post_status
     *
     * @return string
     */
    public function getPostStatus()
    {
        return $this->Post_status;
    }

    /**
     * Returns the value of field Comment_status
     *
     * @return string
     */
    public function getCommentStatus()
    {
        return $this->Comment_status;
    }

    /**
     * Returns the value of field Post_name
     *
     * @return string
     */
    public function getPostName()
    {
        return $this->Post_name;
    }

    /**
     * Returns the value of field Post_modified
     *
     * @return string
     */
    public function getPostModified()
    {
        return $this->Post_modified;
    }

    /**
     * Returns the value of field Post_modified_gmt
     *
     * @return string
     */
    public function getPostModifiedGmt()
    {
        return $this->Post_modified_gmt;
    }

    /**
     * Returns the value of field Post_parent
     *
     * @return integer
     */
    public function getPostParent()
    {
        return $this->Post_parent;
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
     * Returns the value of field Post_type
     *
     * @return string
     */
    public function getPostType()
    {
        return $this->Post_type;
    }

    /**
     * Returns the value of field Post_mime_type
     *
     * @return string
     */
    public function getPostMimeType()
    {
        return $this->Post_mime_type;
    }

    /**
     * Returns the value of field Comment_count
     *
     * @return integer
     */
    public function getCommentCount()
    {
        return $this->Comment_count;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_posts");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_posts';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpPosts[]|ZpPosts|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpPosts|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
