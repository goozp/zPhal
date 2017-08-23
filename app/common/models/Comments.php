<?php

namespace ZPhal\Models;

class Comments extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Comment_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Comment_post_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Comment_author;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $Comment_author_email;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    protected $Comment_author_url;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    protected $Comment_author_ip;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Comment_date;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Comment_date_gmt;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Comment_content;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $Comment_approved;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $Comment_agent;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Comment_parent;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $User_id;

    /**
     * Method to set the value of field Comment_id
     *
     * @param integer $Comment_id
     * @return $this
     */
    public function setCommentId($Comment_id)
    {
        $this->Comment_id = $Comment_id;

        return $this;
    }

    /**
     * Method to set the value of field Comment_post_id
     *
     * @param integer $Comment_post_id
     * @return $this
     */
    public function setCommentPostId($Comment_post_id)
    {
        $this->Comment_post_id = $Comment_post_id;

        return $this;
    }

    /**
     * Method to set the value of field Comment_author
     *
     * @param string $Comment_author
     * @return $this
     */
    public function setCommentAuthor($Comment_author)
    {
        $this->Comment_author = $Comment_author;

        return $this;
    }

    /**
     * Method to set the value of field Comment_author_email
     *
     * @param string $Comment_author_email
     * @return $this
     */
    public function setCommentAuthorEmail($Comment_author_email)
    {
        $this->Comment_author_email = $Comment_author_email;

        return $this;
    }

    /**
     * Method to set the value of field Comment_author_url
     *
     * @param string $Comment_author_url
     * @return $this
     */
    public function setCommentAuthorUrl($Comment_author_url)
    {
        $this->Comment_author_url = $Comment_author_url;

        return $this;
    }

    /**
     * Method to set the value of field Comment_author_ip
     *
     * @param string $Comment_author_ip
     * @return $this
     */
    public function setCommentAuthorIp($Comment_author_ip)
    {
        $this->Comment_author_ip = $Comment_author_ip;

        return $this;
    }

    /**
     * Method to set the value of field Comment_date
     *
     * @param string $Comment_date
     * @return $this
     */
    public function setCommentDate($Comment_date)
    {
        $this->Comment_date = $Comment_date;

        return $this;
    }

    /**
     * Method to set the value of field Comment_date_gmt
     *
     * @param string $Comment_date_gmt
     * @return $this
     */
    public function setCommentDateGmt($Comment_date_gmt)
    {
        $this->Comment_date_gmt = $Comment_date_gmt;

        return $this;
    }

    /**
     * Method to set the value of field Comment_content
     *
     * @param string $Comment_content
     * @return $this
     */
    public function setCommentContent($Comment_content)
    {
        $this->Comment_content = $Comment_content;

        return $this;
    }

    /**
     * Method to set the value of field Comment_approved
     *
     * @param string $Comment_approved
     * @return $this
     */
    public function setCommentApproved($Comment_approved)
    {
        $this->Comment_approved = $Comment_approved;

        return $this;
    }

    /**
     * Method to set the value of field Comment_agent
     *
     * @param string $Comment_agent
     * @return $this
     */
    public function setCommentAgent($Comment_agent)
    {
        $this->Comment_agent = $Comment_agent;

        return $this;
    }

    /**
     * Method to set the value of field Comment_parent
     *
     * @param integer $Comment_parent
     * @return $this
     */
    public function setCommentParent($Comment_parent)
    {
        $this->Comment_parent = $Comment_parent;

        return $this;
    }

    /**
     * Method to set the value of field User_id
     *
     * @param integer $User_id
     * @return $this
     */
    public function setUserId($User_id)
    {
        $this->User_id = $User_id;

        return $this;
    }

    /**
     * Returns the value of field Comment_id
     *
     * @return integer
     */
    public function getCommentId()
    {
        return $this->Comment_id;
    }

    /**
     * Returns the value of field Comment_post_id
     *
     * @return integer
     */
    public function getCommentPostId()
    {
        return $this->Comment_post_id;
    }

    /**
     * Returns the value of field Comment_author
     *
     * @return string
     */
    public function getCommentAuthor()
    {
        return $this->Comment_author;
    }

    /**
     * Returns the value of field Comment_author_email
     *
     * @return string
     */
    public function getCommentAuthorEmail()
    {
        return $this->Comment_author_email;
    }

    /**
     * Returns the value of field Comment_author_url
     *
     * @return string
     */
    public function getCommentAuthorUrl()
    {
        return $this->Comment_author_url;
    }

    /**
     * Returns the value of field Comment_author_ip
     *
     * @return string
     */
    public function getCommentAuthorIp()
    {
        return $this->Comment_author_ip;
    }

    /**
     * Returns the value of field Comment_date
     *
     * @return string
     */
    public function getCommentDate()
    {
        return $this->Comment_date;
    }

    /**
     * Returns the value of field Comment_date_gmt
     *
     * @return string
     */
    public function getCommentDateGmt()
    {
        return $this->Comment_date_gmt;
    }

    /**
     * Returns the value of field Comment_content
     *
     * @return string
     */
    public function getCommentContent()
    {
        return $this->Comment_content;
    }

    /**
     * Returns the value of field Comment_approved
     *
     * @return string
     */
    public function getCommentApproved()
    {
        return $this->Comment_approved;
    }

    /**
     * Returns the value of field Comment_agent
     *
     * @return string
     */
    public function getCommentAgent()
    {
        return $this->Comment_agent;
    }

    /**
     * Returns the value of field Comment_parent
     *
     * @return integer
     */
    public function getCommentParent()
    {
        return $this->Comment_parent;
    }

    /**
     * Returns the value of field User_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->User_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_comments");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_comments';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpComments[]|ZpComments|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpComments|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
