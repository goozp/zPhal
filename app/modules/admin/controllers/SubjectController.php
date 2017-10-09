<?php

namespace ZPhal\Modules\Admin\Controllers;

use ZPhal\Models\Subjects;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use ZPhal\Modules\Admin\Library\Paginator\Pager;

class SubjectController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 专题列表
     */
    public function indexAction()
    {
        $this->tag->prependTitle("专题 - ");

        // 当前页数
        $currentPage = abs($this->request->getQuery('page', 'int', 1));
        if ($currentPage == 0) {
            $currentPage = 1;
        }

        $subjects = Subjects::find()->toArray();

        $tree = makeTree($subjects, 'subject_id', 'parent');
        $treeHtmlArray = subjectTreeHtml($tree);


        $pager = new Pager(
            new PaginatorArray(
                [
                    'data' => $treeHtmlArray,
                    'limit' => 20,
                    'page' => $currentPage,
                ]
            ),
            [
                'layoutClass' => 'ZPhal\Modules\Admin\Library\Paginator\Pager\Layout\Bootstrap', // 样式类
                'rangeLength' => 5, // 分页长度
                'urlMask' => '?page={%page_number}', // 额外url传参
            ]
        );

        $this->view->setVars(
            [
                "pager" => $pager,
            ]
        );

    }

    /**
     * 添加专题
     */
    public function newAction()
    {
        $this->tag->prependTitle("添加专题 - ");

        /**
         * 当前专题列表
         */
        $subjects = Subjects::find()->toArray();

        $tree = makeTree($subjects, 'subject_id', 'parent');
        $treeHtml = treeHtml($tree, 'subject_id', 'subject_name');

        $this->view->setVars(
            [
                "subjectTree" => $treeHtml,
            ]
        );
    }

    /**
     * 创建新专题
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveAction()
    {
        if ($this->request->isPost()) {
            $name = $this->request->getPost('name', ['string', 'trim']);
            $slug = $this->request->getPost('slug', ['string', 'trim', 'lower']);
            $parent = $this->request->getPost('parent', 'int', 0);
            $description = $this->request->getPost('description', ['string', 'trim']);

            if (empty($name)) {
                $this->flash->error('请输入专题名称');
                return $this->response->redirect("admin/subject/new");
            }

            if (empty($slug)) {
                $this->flash->error('必须输入别名');
                return $this->response->redirect("admin/subject/new");
            }

            // 检测是否上传文件
            if ($this->request->hasFiles()) {
                $files = $this->request->getUploadedFiles(); // 获取上传的文件

                if (!$files[0]->getName()) {
                    $this->flash->error('请上传一个封面');
                    return $this->response->redirect("admin/subject/new");
                }

                $extra = ['name' => $slug];

                // 上传
                $media = $this->di->get('mediaUpload');
                $upload = $media->uploadMedia($files[0], 'cover', $extra);

                if ($upload['status'] == 'success') {
                    $url = $upload['data']['url'];

                    $subject = new Subjects();
                    $subject->subject_name = $name;
                    $subject->subject_slug = $slug;
                    $subject->subject_image = $url;
                    $subject->subject_description = $description;
                    $subject->parent = $parent;

                    if ($subject->create()) {
                        $this->flash->success("创建成功");
                        return $this->response->redirect("admin/subject");
                    } else {
                        $this->flash->error($this->getErrorMsg($subject, "创建失败"));

                    }
                } else {
                    $this->flash->error("文件上传失败：" . $upload['message']);
                }
            }
        }

        return $this->response->redirect("admin/subject/new");
    }

    /**
     * 编辑专题
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function editAction()
    {
        $id = $this->dispatcher->getParam("id");

        $subject = Subjects::findFirst($id);

        if ($subject) {
            $name = $subject->subject_name;
            $slug = $subject->subject_slug;
            $image = $subject->subject_image;
            $description = $subject->subject_description;
            $parent = $subject->parent;

            // 当前专题列表
            $subjects = Subjects::find()->toArray();
            $tree = makeTree($subjects, 'subject_id', 'parent');
            $treeHtml = treeHtml($tree, 'subject_id', 'subject_name', $html = '', $deep = 0, $parent);

            $this->view->setVars(
                [
                    "id" => $id,
                    "name" => $name,
                    "slug" => $slug,
                    "image" => $this->config->application->baseUri . $image,
                    "description" => $description,
                    "subjectTree" => $treeHtml,
                ]
            );
        } else {
            $this->flash->error("错误操作!");
            return $this->response->redirect("admin/");
        }
    }

    /**
     * 更新专题信息
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function updateAction()
    {
        $id = $this->dispatcher->getParam("id");

        $subject = Subjects::findFirst($id);
        if ($subject){
            if ($this->request->isPost()) {
                $name = $this->request->getPost('name', ['string', 'trim']);
                $slug = $this->request->getPost('slug', ['string', 'trim', 'lower']);
                $parent = $this->request->getPost('parent', 'int', 0);
                $description = $this->request->getPost('description', ['string', 'trim']);

                if (empty($name)) {
                    $this->flash->error('请输入专题名称');
                    return $this->response->redirect("admin/subject/new");
                }

                if (empty($slug)) {
                    $this->flash->error('必须输入别名');
                    return $this->response->redirect("admin/subject/new");
                }

                // 检测是否上传文件
                if ($this->request->hasFiles()) {
                    $files = $this->request->getUploadedFiles(); // 获取上传的文件

                    // 有上传新的图片时
                    if ($files[0]->getName()) {
                        $extra = ['name' => $slug];

                        // 上传
                        $media = $this->di->get('mediaUpload');
                        $upload = $media->uploadMedia($files[0], 'cover', $extra);

                        if ($upload['status'] == 'success') {
                            $url = $upload['data']['url'];
                            $subject->subject_image = $url;
                        } else {
                            $this->flash->error("文件上传失败：" . $upload['message']);
                            return $this->response->redirect("admin/subject/edit/".$id);
                        }
                    }
                }

                $subject->subject_name = $name;
                $subject->subject_slug = $slug;
                $subject->subject_description = $description;
                $subject->parent = $parent;

                if ($subject->update()) {
                    $this->flash->success("编辑成功");
                } else {
                    $this->flash->error($this->getErrorMsg($subject, "编辑失败"));
                }

                return $this->response->redirect("admin/subject/edit/".$id);
            }else{
                $this->flash->error("错误操作!");
                return $this->response->redirect("admin/");
            }
        }else{
            $this->flash->error("错误操作!");
            return $this->response->redirect("admin/");
        }
    }

    /**
     * TODO 删除专题; 同时删除关联文章记录
     */
    public function deleteAction()
    {

    }
}