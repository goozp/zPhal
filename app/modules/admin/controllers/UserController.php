<?php

namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use ZPhal\Models\Users;

class UserController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $currentPage = $this->request->getQuery('page', 'int'); // GET
        $userSearch  = trim($this->request->getPost('user_search', 'string')); // POST

        // sql builder
        $builder = $this->modelsManager->createBuilder()
            ->columns('ID, user_login, user_email, user_registered, user_status')
            ->from('ZPhal\Models\Users');

        if (isset($userSearch)){
            $builder->where("user_login LIKE :user:", ["user" => "%" . $userSearch . "%"]);
        }
        $builder->orderBy('ID');

        // 分页查询
        $paginator = new PaginatorQueryBuilder(
            [
                'builder' => $builder,
                'limit'   => 20,
                'page'    => $currentPage,
            ]
        );
        $page = $paginator->getPaginate();

        // 输出
        $this->view->setVars(
            [
                'page'=>$page,
                'userSearch' => $userSearch
            ]
        );
    }

    public function newAction()
    {

        // 使用会话闪存
        /*$this->flash->message('error',"Your information was stored correctly!");*/

        // 返回一个完整的HTTP重定向
        /*return $this->response->redirect("admin/user/self");*/
    }

    public function saveAction()
    {
        if ($this->request->isPost()) {
            $inputUser      = $this->request->getPost('inputUser', ['string','trim']);
            $inputEmail     = $this->request->getPost('inputEmail', 'email');
            $inputPassword  = $this->request->getPost('inputPassword', 'string');
            $inputPassword2 = $this->request->getPost('inputPassword2', 'string');
            $inputSite      = $this->request->getPost('inputSite', ['string','trim']);
            $inputRole      = $this->request->getPost('inputRole', 'string');

            if ($inputPassword !== $inputPassword2){
                $this->flash->error("两次密码输入不一致!");
                return $this->response->redirect("admin/user/new");
            }

            /**
             * TODO 各种验证   密码
             */
            $user = new Users();

            $user->user_login = $inputUser;
            $user->user_pass  = $inputPassword;
            $user->user_email = $inputEmail;
            $user->user_url   = $inputSite;

            if ($user->save() === false) {
                $messages = "创建失败: \n";
                $msg = $user->getMessages();

                foreach ($msg as $message) {
                    $messages .= $message->getMessage()."\n";
                }
                $this->flash->error($messages);
                return $this->response->redirect("admin/user/new");
            } else {
                $this->flash->success("创建成功!");
                return $this->response->redirect("admin/user");
            }
        }
    }

    public function selfAction()
    {

    }
}

