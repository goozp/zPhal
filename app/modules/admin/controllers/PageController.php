<?php

namespace ZPhal\Modules\Admin\Controllers;
use ZPhal\Models\Posts;

/**
 * 页面
 * Class PageController
 * @package ZPhal\Modules\Admin\Controllers
 */
class PageController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $this->tag->prependTitle("页面 - ");

    }

    /**
     * 创建新页面
     */
    public function newAction()
    {
        $this->tag->prependTitle("创建页面 - ");

        /* 静态资源 */
        $this->assets->addCss("backend/plugins/editor.md/css/editormd.css", true);
        $this->assets->addCss("backend/library/select2/css/select2.min.css", true);
        $this->assets->addCss("backend/library/AdminLTE/css/AdminLTE-select2.min.css", true);
        $this->assets->addJs("backend/plugins/editor.md/editormd.min.js", true);
        $this->assets->addJs("backend/library/select2/js/select2.full.min.js", true);
        $this->assets->addJs("backend/js/page.js", true);

        /**
         * 父级页面选择
         */
        $parentPages = Posts::find([
            "post_type = 'page' AND post_status = 'publish' ",
            "columns" => "ID, post_title"
        ])->toArray();

        /**
         * TODO
         * 模板
         */


        $this->view->setVars(
            [
                'parentPages' => $parentPages,
            ]
        );
    }


    public function saveAction()
    {

    }

    public function autoSaveDraftAction()
    {
        if ($this->request->isPost()) {
            $markdownWord = $this->request->getPost('markdownWord');
            $title = $this->request->getPost('title', 'trim');
            $postId = $this->request->getPost('postId', 'int', 0);
            $slugName = $this->request->getPost('slugName', 'trim', '');

            // 没有记录
            if ($postId == 0) {
                $post = new Posts();
                $post->post_author = $this->getUserId();
                $post->post_content = $markdownWord;
                $post->post_title = $title ? $title : '无题';
                $post->comment_status = $post::COMMENT_OPEN;
                $post->post_name = $slugName ? $slugName : $title;
                $post->post_parent = 0;
                $post->post_type = $post::TYPE_PAGE;
                $post->post_modified = date('Y-m-d H:i:s', time());
                $post->post_modified_gmt = gmdate('Y-m-d H:i:s', time());
                $post->post_status = 'draft';
                if ($post->create()) {
                    $postId = $post->ID;
                    $post = Posts::findFirst($postId);
                    $post->guid = $this->url->get(['for' => 'page', 'params' => $post->post_name]);
                    if ($post->save()) {
                        $data = [
                            'post_id' => $postId,
                            'post_date' => $post->post_modified,
                            'post_url' => $post->guid
                        ];
                    }
                }
            }
            // 已有记录
            else {
                // 查询已有的记录
                $post = Posts::findFirst(
                    [
                        "conditions" => "ID = ?1 AND post_status = 'draft'",
                        "bind" => [
                            1 => $postId,
                        ]
                    ]
                );

                if ($post) {
                    $post->post_content = $markdownWord;
                    $post->post_title = $title ? $title : '无题';
                    $post->post_name = $slugName ? $slugName : $title;
                    $post->post_modified = date('Y-m-d H:i:s', time());
                    $post->post_modified_gmt = gmdate('Y-m-d H:i:s', time());
                    if ($post->update()) {
                        $data = [
                            'post_id' => $postId,
                            'post_date' => $post->post_modified,
                            'post_url' => $post->guid
                        ];
                    }
                }
            }

            return json_encode(['status' => 'success', 'message' => '保存成功', 'data' => $data], JSON_UNESCAPED_UNICODE);
        }
    }
}