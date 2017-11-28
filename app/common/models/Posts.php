<?php

namespace ZPhal\Models;

class Posts extends ModelBase
{

    public $ID;

    public $post_author;

    public $post_date;

    public $post_date_gmt;

    public $post_content;

    public $post_title;

    public $post_status;

    public $comment_status;

    public $post_name;

    public $post_modified;

    public $post_modified_gmt;

    public $post_parent;

    public $cover_picture;

    public $guid;

    public $post_type;

    public $post_mime_type;

    public $comment_count;

    public $view_count;

    const PUBLISH_DEFAULT_TIME = '1000-01-01 00:00:00'; //默认发布时间

    const TYPE_ARTICLE = 'post';

    const TYPE_PAGE = 'page';

    const COMMENT_OPEN = 'open';

    const COMMENT_CLOSE = 'closed';

    const STATUS_PUBLISH = 'publish';

    const STATUS_DRAFT = 'draft';

    const STATUS_TRASH = 'trash';

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSource("zp_posts");

        $this->hasMany(
            "ID",
            "ZPhal\\Models\\Postmeta",
            "post_id",
            [
                'alias' => 'PostMeta'
            ]
        );

        $this->hasManyToMany(
            "ID",
            "ZPhal\\Models\\TermRelationships",
            "object_id",
            "term_taxonomy_id",
            "ZPhal\\Models\\TermTaxonomy",
            "term_taxonomy_id",
            [
                'alias' => 'TermTaxonomy'
            ]
        );
    }

    /**
     * 插入新数据时验证前
     */
    public function beforeValidationOnCreate()
    {
        if(!$this->post_date){
            $this->post_date = self::PUBLISH_DEFAULT_TIME;
        }

        if(!$this->post_date_gmt){
            $this->post_date_gmt = self::PUBLISH_DEFAULT_TIME;
        }

        if (!$this->post_name){
            $this->post_name = '';
        }

        $this->comment_count = 0;
        $this->view_count = 0;
    }

    /**
     * 更新数据时验证前
     */
    public function beforeValidationOnUpdate()
    {
        if(!$this->post_modified){
            $this->post_modified = date('Y-m-d H:i:s', time());
        }

        if (!$this->post_modified_gmt){
            $this->post_modified_gmt = gmdate('Y-m-d H:i:s', time());
        }

    }

    /**
     * 生成url
     */
    public function generateUrl()
    {
        $url = $this->getDI()->getShared('url');
        if ($this->post_type == self::TYPE_ARTICLE){
            $this->guid = $url->get(['for' => 'article', 'id' => $this->ID]);
        }elseif ($this->post_type == self::TYPE_PAGE){
            $this->guid = $url->get(['for' => 'page', 'id' => $this->ID]);
        }
        $this->save();
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
}
