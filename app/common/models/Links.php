<?php

namespace ZPhal\Models;

class Links extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Link_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $Link_url;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $Link_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $Link_image;

    /**
     *
     * @var string
     * @Column(type="string", length=25, nullable=false)
     */
    protected $Link_target;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $Link_description;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $Link_visible;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $Link_owner;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $Link_rating;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Link_updated;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $Link_rel;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $Link_notes;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $Link_rss;

    /**
     * Method to set the value of field Link_id
     *
     * @param integer $Link_id
     * @return $this
     */
    public function setLinkId($Link_id)
    {
        $this->Link_id = $Link_id;

        return $this;
    }

    /**
     * Method to set the value of field Link_url
     *
     * @param string $Link_url
     * @return $this
     */
    public function setLinkUrl($Link_url)
    {
        $this->Link_url = $Link_url;

        return $this;
    }

    /**
     * Method to set the value of field Link_name
     *
     * @param string $Link_name
     * @return $this
     */
    public function setLinkName($Link_name)
    {
        $this->Link_name = $Link_name;

        return $this;
    }

    /**
     * Method to set the value of field Link_image
     *
     * @param string $Link_image
     * @return $this
     */
    public function setLinkImage($Link_image)
    {
        $this->Link_image = $Link_image;

        return $this;
    }

    /**
     * Method to set the value of field Link_target
     *
     * @param string $Link_target
     * @return $this
     */
    public function setLinkTarget($Link_target)
    {
        $this->Link_target = $Link_target;

        return $this;
    }

    /**
     * Method to set the value of field Link_description
     *
     * @param string $Link_description
     * @return $this
     */
    public function setLinkDescription($Link_description)
    {
        $this->Link_description = $Link_description;

        return $this;
    }

    /**
     * Method to set the value of field Link_visible
     *
     * @param string $Link_visible
     * @return $this
     */
    public function setLinkVisible($Link_visible)
    {
        $this->Link_visible = $Link_visible;

        return $this;
    }

    /**
     * Method to set the value of field Link_owner
     *
     * @param integer $Link_owner
     * @return $this
     */
    public function setLinkOwner($Link_owner)
    {
        $this->Link_owner = $Link_owner;

        return $this;
    }

    /**
     * Method to set the value of field Link_rating
     *
     * @param integer $Link_rating
     * @return $this
     */
    public function setLinkRating($Link_rating)
    {
        $this->Link_rating = $Link_rating;

        return $this;
    }

    /**
     * Method to set the value of field Link_updated
     *
     * @param string $Link_updated
     * @return $this
     */
    public function setLinkUpdated($Link_updated)
    {
        $this->Link_updated = $Link_updated;

        return $this;
    }

    /**
     * Method to set the value of field Link_rel
     *
     * @param string $Link_rel
     * @return $this
     */
    public function setLinkRel($Link_rel)
    {
        $this->Link_rel = $Link_rel;

        return $this;
    }

    /**
     * Method to set the value of field Link_notes
     *
     * @param string $Link_notes
     * @return $this
     */
    public function setLinkNotes($Link_notes)
    {
        $this->Link_notes = $Link_notes;

        return $this;
    }

    /**
     * Method to set the value of field Link_rss
     *
     * @param string $Link_rss
     * @return $this
     */
    public function setLinkRss($Link_rss)
    {
        $this->Link_rss = $Link_rss;

        return $this;
    }

    /**
     * Returns the value of field Link_id
     *
     * @return integer
     */
    public function getLinkId()
    {
        return $this->Link_id;
    }

    /**
     * Returns the value of field Link_url
     *
     * @return string
     */
    public function getLinkUrl()
    {
        return $this->Link_url;
    }

    /**
     * Returns the value of field Link_name
     *
     * @return string
     */
    public function getLinkName()
    {
        return $this->Link_name;
    }

    /**
     * Returns the value of field Link_image
     *
     * @return string
     */
    public function getLinkImage()
    {
        return $this->Link_image;
    }

    /**
     * Returns the value of field Link_target
     *
     * @return string
     */
    public function getLinkTarget()
    {
        return $this->Link_target;
    }

    /**
     * Returns the value of field Link_description
     *
     * @return string
     */
    public function getLinkDescription()
    {
        return $this->Link_description;
    }

    /**
     * Returns the value of field Link_visible
     *
     * @return string
     */
    public function getLinkVisible()
    {
        return $this->Link_visible;
    }

    /**
     * Returns the value of field Link_owner
     *
     * @return integer
     */
    public function getLinkOwner()
    {
        return $this->Link_owner;
    }

    /**
     * Returns the value of field Link_rating
     *
     * @return integer
     */
    public function getLinkRating()
    {
        return $this->Link_rating;
    }

    /**
     * Returns the value of field Link_updated
     *
     * @return string
     */
    public function getLinkUpdated()
    {
        return $this->Link_updated;
    }

    /**
     * Returns the value of field Link_rel
     *
     * @return string
     */
    public function getLinkRel()
    {
        return $this->Link_rel;
    }

    /**
     * Returns the value of field Link_notes
     *
     * @return string
     */
    public function getLinkNotes()
    {
        return $this->Link_notes;
    }

    /**
     * Returns the value of field Link_rss
     *
     * @return string
     */
    public function getLinkRss()
    {
        return $this->Link_rss;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zphaldb");
        $this->setSource("zp_links");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'zp_links';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpLinks[]|ZpLinks|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ZpLinks|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
