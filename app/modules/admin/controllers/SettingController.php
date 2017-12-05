<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Posts;
use ZPhal\Models\Services\Service\TaxonomyService;

class SettingController extends ControllerBase
{
    /**
     * 常规设置
     */
    public function generalAction()
    {
        $this->tag->prependTitle("常规设置 - ");

        $this->view->setVars(
            [
                "blogname" => $this->option->get('blogname'),
                "blogdescription" => $this->option->get('blogdescription'),
                "siteurl" => $this->option->get('siteurl'),
                "admin_email" => $this->option->get('admin_email'),
                "users_can_register" => $this->option->get('users_can_register'),
                "timezone_string" => $this->option->get('timezone_string'),
            ]
        );
    }

    /**
     * 保存常规设置
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveGeneralAction()
    {
        try {
            $this->option->save('blogname', $this->request->get('blogname', ['string', 'trim']));
            $this->option->save('blogdescription', $this->request->get('blogdescription', ['string', 'trim']));
            $this->option->save('siteurl', $this->request->get('siteurl', ['string', 'trim']));
            $this->option->save('admin_email', $this->request->get('admin_email', 'email'));
            $this->option->save('users_can_register', $this->request->get('users_can_register'));
            $this->option->save('timezone_string', $this->request->get('timezone_string'));

            $this->flash->success("保存成功!");
            return $this->response->redirect("admin/setting/general");
        } catch (\Exception $e) {
            $this->flash->error('保存出错：' . $e);
            return $this->response->redirect("admin/setting/general");
        }
    }

    /**
     * 撰写设置
     */
    public function writingAction()
    {
        $this->tag->prependTitle("撰写设置 - ");

        // 分类列表
        $taxonomyService = container(TaxonomyService::class);
        $category = $taxonomyService->getTaxonomyListByType('category');
        $categoryTree = makeTree($category, 'term_taxonomy_id', 'parent', 'sun', 0);

        /**
         * 链接分类
         */
        $taxonomyService = container(TaxonomyService::class);
        $linkCategory = $taxonomyService->getTaxonomyListByType('linkCategory');

        $this->view->setVars(
            [
                "categoryTree" => treeHtml($categoryTree, 'term_taxonomy_id', 'name', ' ', 0, $this->option->get('default_category')),
                'linkCategory' => $linkCategory,
                "default_link_category" => $this->option->get('default_link_category'),
            ]
        );
    }

    /**
     * 保存撰写设置
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveWritingAction()
    {
        try {
            $this->option->save('default_category', $this->request->get('default_category'));
            $this->option->save('default_link_category', $this->request->get('default_link_category'));

            $this->flash->success("保存成功!");
            return $this->response->redirect("admin/setting/writing");
        } catch (\Exception $e) {
            $this->flash->error('保存出错：' . $e);
            return $this->response->redirect("admin/setting/writing");
        }
    }

    /**
     * 阅读设置
     */
    public function readingAction()
    {
        $this->tag->prependTitle("阅读设置 - ");

        $pagesList = Posts::find([
            "post_type = 'page' AND post_status = 'publish' ",
            "columns" => "ID, post_title"
        ])->toArray();


        $this->view->setVars(
            [
                'show_on_front' => $this->option->get('show_on_front'),
                'pageList' => $pagesList,
                'show_on_front_page' => $this->option->get('show_on_front_page'),
                'posts_per_page' => $this->option->get('posts_per_page'),
                'open_XML' => $this->option->get('open_XML'),
            ]
        );
    }

    /**
     * 保存阅读设置
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveReadingAction()
    {
        try {
            $this->option->save('show_on_front', $this->request->get('show_on_front'));
            $this->option->save('show_on_front_page', $this->request->get('show_on_front_page'));
            $this->option->save('posts_per_page', $this->request->get('posts_per_page'));
            $this->option->save('open_XML', $this->request->get('open_XML'));

            $this->flash->success("保存成功!");
            return $this->response->redirect("admin/setting/reading");
        } catch (\Exception $e) {
            $this->flash->error('保存出错：' . $e);
            return $this->response->redirect("admin/setting/reading");
        }
    }

    /**
     * 讨论设置
     */
    public function discussAction()
    {
        $this->tag->prependTitle("讨论设置 - ");

        $this->view->setVars(
            [
                'post_comment_status' => $this->option->get('post_comment_status'),
                'page_comment_status' => $this->option->get('page_comment_status'),
                'comment_need_register' => $this->option->get('comment_need_register'),
                'show_comment_page' => $this->option->get('show_comment_page'),
                'comment_per_page' => $this->option->get('comment_per_page'),
                'comment_page_first' => $this->option->get('comment_page_first'),
                'comment_page_top' => $this->option->get('comment_page_top'),
                'comment_before_show' => $this->option->get('comment_before_show'),
                'show_avatar' => $this->option->get('show_avatar'),
            ]
        );
    }

    /**
     * 保存讨论设置
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveDiscussAction()
    {
        try {
            $this->option->save('post_comment_status', $this->request->get('post_comment_status') ? 'open' : 'closed');
            $this->option->save('page_comment_status', $this->request->get('page_comment_status') ? 'open' : 'closed');
            $this->option->save('comment_need_register', $this->request->get('comment_need_register') ? 1 : 0);
            $this->option->save('show_comment_page', $this->request->get('show_comment_page') ? 1 : 0);
            $this->option->save('comment_per_page', $this->request->get('comment_per_page'));
            $this->option->save('comment_page_first', $this->request->get('comment_page_first'));
            $this->option->save('comment_page_top', $this->request->get('comment_page_top'));
            $this->option->save('comment_before_show', $this->request->get('comment_before_show'));
            $this->option->save('show_avatar', $this->request->get('show_avatar') ? 1 : 0);

            $this->flash->success("保存成功!");
            return $this->response->redirect("admin/setting/discuss");
        } catch (\Exception $e) {
            $this->flash->error('保存出错：' . $e);
            return $this->response->redirect("admin/setting/discuss");
        }
    }

    public function mediaAction()
    {
        $this->tag->prependTitle("媒体设置 - ");
    }

    public function permalinkAction()
    {
        $this->tag->prependTitle("固定链接设置 - ");
    }
}