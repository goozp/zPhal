<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Services\Service\TaxonomyService;

class LinkController extends ControllerBase
{

    public function indexAction()
    {

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

    public function saveAction()
    {
        if ($this->request->isPost()){
            $link_name = $this->request->getPost('link_name', ['string', 'trim']);
            $link_url = $this->request->getPost('link_url', ['string', 'trim']);
            $link_description = $this->request->getPost('link_description', ['string', 'trim']);
            $link_description = $this->request->getPost('link_description', ['string', 'trim']);
            $link_category = $this->request->getPost('link_category');
            // TODO
        }else{
            $this->flash->error("错误操作!");
            return $this->response->redirect("admin/");
        }
    }

}