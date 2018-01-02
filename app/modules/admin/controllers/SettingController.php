<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Posts;
use ZPhal\Models\Services\Service\TaxonomyService;
use ZPhal\Modules\Admin\Library\GitHub\GitHub;

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
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveGeneralAction()
    {
        try {
            $this->option->save('blogname', $this->request->get('blogname', ['string', 'trim']), true);
            $this->option->save('blogdescription', $this->request->get('blogdescription', ['string', 'trim']), true);
            $this->option->save('siteurl', $this->request->get('siteurl', ['string', 'trim']), true);
            $this->option->save('admin_email', $this->request->get('admin_email', 'email'), true);
            $this->option->save('users_can_register', $this->request->get('users_can_register'), true);
            $this->option->save('timezone_string', $this->request->get('timezone_string'), true);

            $this->flash->success("保存成功!");
            return $this->response->redirect("admin/setting/general");
        } catch (\Exception $e) {
            $this->flash->error('保存出错：' . $e);
            return $this->response->redirect("admin/setting/general");
        }
    }

    /**
     * 网站属性设置
     */
    public function propertyAction()
    {
        $this->tag->prependTitle("网站属性设置 - ");

        $this->view->setVars(
            [
                "siteDescription" => $this->option->get('site_description'),
                "siteKeywords" => $this->option->get('site_keywords'),
                "footerCopyright" => $this->option->get('footer_copyright'),
            ]
        );
    }

    /**
     * 保存网站属性设置
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function savePropertyAction()
    {
        try {
            $this->option->save('site_description', $this->request->get('site_description', ['string', 'trim']), true);
            $this->option->save('site_keywords', $this->request->get('site_keywords', ['string', 'trim']), true);
            $this->option->save('footer_copyright', $this->request->get('footer_copyright'), true);

            $this->flash->success("保存成功!");
            return $this->response->redirect("admin/setting/property");
        } catch (\Exception $e) {
            $this->flash->error('保存出错：' . $e);
            return $this->response->redirect("admin/setting/property");
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
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveWritingAction()
    {
        try {
            $this->option->save('default_category', $this->request->get('default_category'), true);
            $this->option->save('default_link_category', $this->request->get('default_link_category'), true);

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
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveReadingAction()
    {
        try {
            $this->option->save('show_on_front', $this->request->get('show_on_front'), true);
            $this->option->save('show_on_front_page', $this->request->get('show_on_front_page'), true);
            $this->option->save('posts_per_page', $this->request->get('posts_per_page'), true);
            $this->option->save('open_XML', $this->request->get('open_XML'), true);

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
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveDiscussAction()
    {
        try {
            $this->option->save('post_comment_status', $this->request->get('post_comment_status') ? 'open' : 'closed', true);
            $this->option->save('page_comment_status', $this->request->get('page_comment_status') ? 'open' : 'closed', true);
            $this->option->save('comment_need_register', $this->request->get('comment_need_register') ? 1 : 0, true);
            $this->option->save('show_comment_page', $this->request->get('show_comment_page') ? 1 : 0, true);
            $this->option->save('comment_per_page', $this->request->get('comment_per_page'), true);
            $this->option->save('comment_page_first', $this->request->get('comment_page_first'), true);
            $this->option->save('comment_page_top', $this->request->get('comment_page_top'), true);
            $this->option->save('comment_before_show', $this->request->get('comment_before_show'), true);
            $this->option->save('show_avatar', $this->request->get('show_avatar') ? 1 : 0, true);

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

    public function saveMediaAction()
    {

    }

    public function permalinkAction()
    {
        $this->tag->prependTitle("固定链接设置 - ");
    }

    public function savePermalinkAction()
    {

    }

    /**
     * 作品配置
     * TODO repo列表用ajax异步做
     */
    public function projectAction()
    {
        $this->tag->prependTitle("作品设置 - ");

        $this->assets->addCss("backend/library/dragula/dragula.min.css", true);
        $this->assets->addJs("backend/library/dragula/dragula.min.js", true);
        $this->assets->addJs("backend/js/project.js", true);

        $allRepos = [];
        $user = $this->option->get('github_user', false, true);
        if ($user){
            $github = new GitHub();
            $allRepos = $github->getRepoList($user);
        }

        $showRepos = $this->option->get('github_show_repo', false, true);
        if ($showRepos){
            $showRepos = json_decode($showRepos, true);
        }

        $this->view->setVars(
            [
                'showProject' => $this->option->get('show_project'),
                'GitHubUser' => $this->option->get('github_user', false, true),
                'allRepo' => $allRepos,
                'showRepo' => $showRepos,
            ]
        );
    }

    /**
     * 保存作品配置
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveProjectAction()
    {
        try {
            $this->option->save('show_project', $this->request->get('show_project'), true);
            $this->option->save('github_user', $this->request->get('github_name', ['string', 'trim']));

            $viewCache = $this->getDI()->getShared('viewCache');
            $viewCache->delete('projects');

            $this->flash->success("保存成功!");
            return $this->response->redirect("admin/setting/project");
        } catch (\Exception $e) {
            $this->flash->error('保存出错：' . $e);
            return $this->response->redirect("admin/setting/project");
        }
    }

    /**
     * 保存展示repo配置
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveShowRepoAction()
    {
        try {
            $showRepos = $this->request->get('showRepo');

            $arr = [];
            if (!empty($showRepos)){
                foreach ($showRepos as $repo){
                    $github = new GitHub();
                    $repoInfo = $github->getRepo($repo);
                    $arr[] = [
                        'id' => $repoInfo['id'],
                        'full_name' => $repoInfo['full_name'],
                        'html_url' => $repoInfo['html_url'],
                        'description' => $repoInfo['description'],
                        'language' => $repoInfo['language'],
                        'forks' => $repoInfo['forks'],
                        'watchers' => $repoInfo['watchers'],
                    ];
                }
            }
            $this->option->save('github_show_repo', json_encode($arr));

            $viewCache = $this->getDI()->getShared('viewCache');
            $viewCache->delete('projects');

            $this->flash->success("保存成功!");
            return $this->response->redirect("admin/setting/project");
        } catch (\Exception $e) {
            $this->flash->error('保存出错：' . $e);
            return $this->response->redirect("admin/setting/project");
        }
    }
}