<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Links;
use ZPhal\Models\Services\Service\LinkService;
use ZPhal\Models\Services\Service\TaxonomyService;
use ZPhal\Models\TermRelationships;

class LinkController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 链接列表页
     */
    public function indexAction()
    {
        $this->tag->prependTitle("链接 - ");

        $currentPage = $this->request->getQuery('page', 'int');
        $selectedCategory = $this->request->get('linkCategory');
        $search = $this->request->get('search', ['string', 'trim']);

        /**
         * 链接分类
         */
        $taxonomyService = container(TaxonomyService::class);
        $linkCategory = $taxonomyService->getTaxonomyListByType('linkCategory');

        /**
         * 查询数据
         */
        $condition = [
            'categorySelected' => $selectedCategory ? $selectedCategory : 0 ,
            'search' => $search ? $search : '',
        ];
        $linkService = container(LinkService::class);
        $links = $linkService->getLinkList($currentPage, $condition);

        $this->view->setVars(
            [
                'search' => $search,
                'linkCategory' => $linkCategory,
                'selectedCategory' => $selectedCategory,
                'links' => $links,
            ]
        );
    }

    /**
     * 添加链接页面
     */
    public function newAction()
    {
        $this->tag->prependTitle("添加链接 - ");

        // 分类目录
        $taxonomyService = container(TaxonomyService::class);
        $linkCategory = $taxonomyService->getTaxonomyListByType('linkCategory');

        $this->view->setVars([
            'linkCategory' => $linkCategory,
        ]);
    }

    /**
     * 保存添加链接
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveAction()
    {
        if ($this->request->isPost()){
            $link_name = $this->request->getPost('link_name', ['string', 'trim']);
            $link_url = $this->request->getPost('link_url', ['string', 'trim']);
            $link_description = $this->request->getPost('link_description', ['string', 'trim']);
            $link_category = $this->request->getPost('link_category');
            $link_target = $this->request->getPost('link_target');
            $link_image = $this->request->getPost('link_image', ['string', 'trim']);
            $link_rss = $this->request->getPost('link_rss', ['string', 'trim']);
            $link_notes = $this->request->getPost('link_notes', ['string', 'trim']);
            $link_visible = $this->request->getPost('link_visible');

            $link = new Links();
            $link->link_url = $link_url;
            $link->link_name = $link_name;
            $link->link_image = $link_image;
            $link->link_target = $link_target;
            $link->link_description = $link_description;
            $link->link_visible = $link_visible;
            $link->link_owner = $this->getUserId();
            $link->link_updated = date('Y-m-d H:i:s');
            $link->link_notes = $link_notes;
            $link->link_rss = $link_rss;
            if ($link->create()) {
                $linkId = $link->link_id;
                if (!empty($link_category)){
                    foreach ($link_category as $category){
                        $termRelationship = new TermRelationships();
                        $termRelationship->term_taxonomy_id = $category;
                        $termRelationship->object_id = $linkId;
                        $termRelationship->create();
                    }
                }

                $this->flash->success("创建成功");
                return $this->response->redirect("admin/link");
            } else {
                $this->flash->error($this->getErrorMsg($link, "创建失败"));
                return $this->response->redirect("admin/link/new");
            }

        }else{
            $this->flash->error("错误操作!");
            return $this->response->redirect("admin/");
        }
    }

    public function editAction($id)
    {
        $this->tag->prependTitle("编辑链接 - ");

        /**
         * 查询链接信息
         */
        $linkInfo = Links::findFirst($id);

        if ($linkInfo){
            // 分类目录
            $taxonomyService = container(TaxonomyService::class);
            $linkCategory = $taxonomyService->getTaxonomyListByType('linkCategory');

            /**
             * 查询链接分类
             */
            // TODO 查询
            TermRelationships::find(

            );

            $this->view->setVars([
                'linkCategory' => $linkCategory,
                'linkInfo' => $linkInfo->toArray(),
            ]);
        }else{
            $this->flash->error("错误的操作！");
            return $this->response->redirect("admin/link");
        }
    }

    public function updateAction()
    {

    }

    public function deleteAction()
    {

    }

}