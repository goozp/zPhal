<?php

namespace ZPhal\Modules\Admin\Controllers;

use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use ZPhal\Modules\Admin\Library\Paginator\Pager;
use ZPhal\Models\Usermeta;
use ZPhal\Models\Users;

class UserController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 用户列表
     */
    public function indexAction()
    {
        $this->tag->prependTitle("用户列表 - ");

        $currentPage = $this->request->getQuery('page', 'int'); // GET
        $userSearch  = $this->request->getPost('user_search', ['string','trim']); // POST

        // sql builder
        $builder = $this->modelsManager->createBuilder()
            ->columns('ID, user_login, user_email, user_registered, user_status')
            ->from('ZPhal\Models\Users');

        if (isset($userSearch)){
            $builder->where("user_login LIKE :user:", ["user" => "%" . $userSearch . "%"]);
        }
        $builder->orderBy('ID');

        // 分页查询
        $pager = new Pager(
            new PaginatorQueryBuilder(
                [
                    'builder' => $builder,
                    'limit'   => 20,
                    'page'    => $currentPage,
                ]
            ),
            [
                'layoutClass' => 'ZPhal\Modules\Admin\Library\Paginator\Pager\Layout\Bootstrap', // 样式类
                'rangeLength' => 5, // 分页长度
                'urlMask'     => '?page={%page_number}', // 额外url传参
            ]
        );

        // 输出
        $this->view->setVars(
            [
                'pager'=>$pager,
                'userSearch' => $userSearch
            ]
        );
    }

    /**
     * 添加用户
     */
    public function newAction()
    {
        $this->tag->prependTitle("添加用户 - ");
    }

    /**
     * 保存用户信息
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function saveAction()
    {
        if ($this->request->isPost()) {
            $inputUser      = $this->request->getPost('inputUser', ['string','trim']);
            $inputEmail     = $this->request->getPost('inputEmail', 'email');
            $inputPassword  = $this->request->getPost('inputPassword');
            $inputPassword2 = $this->request->getPost('inputPassword2');
            $inputSite      = $this->request->getPost('inputSite', ['string','trim']);
            $inputRole      = $this->request->getPost('inputRole', 'string');

            if ($inputPassword !== $inputPassword2){
                $this->flash->error("两次密码输入不一致!");
                return $this->response->redirect("admin");
            }

            $user = new Users();

            $user->user_login = $inputUser;
            $user->user_pass  = $this->security->hash($inputPassword);
            $user->user_email = $inputEmail;
            $user->user_url   = $inputSite;
            $user->user_role  = $inputRole;
            $user->user_registered = date('Y-m-d H:i:s', time());

            if ($user->create() === false) {
                $messages = $this->getErrorMsg($user, "创建失败");
                $this->flash->error($messages);

                return $this->response->redirect("admin/user/new");
            } else {
                /**
                 * 添加其它设置属性
                 */
                $meta = [
                    'description' => '',
                    'session_tokens' => '',
                ];
                $theUser = Users::findFirst(
                    "user_login = '{$inputUser}'"
                );

                foreach ($meta as $key => $value){
                    $userMeta = new Usermeta();
                    $userMeta->user_id  = $theUser->ID;
                    $userMeta->meta_key = $key;
                    $userMeta->meta_value = $value;

                    if ($userMeta->create() === false){
                        $theUser->user_status = 9; // 出错的
                        $theUser->save();

                        $messages = $this->getErrorMsg($user, "出错");
                        $this->flash->error($messages);

                        return $this->response->redirect("admin/user/new");
                    }
                }

                $this->flash->success("创建成功!");
                return $this->response->redirect("admin/user");
            }
        }
    }

    /**
     * 个人资料页
     */
    public function selfAction()
    {
        $this->tag->prependTitle("个人资料 - ");

        $userAuth = $this->session->get("userAuth");
        $userId   = $userAuth['userId'];

        $user = Users::findFirst($userId);


        $userMeta = Usermeta::findFirst(
            [
                "user_id = :id: AND meta_key = :key:",
                "bind" => [
                    "id" => $user->ID,
                    "key" => "description",
                ]
            ]
        );

        $this->view->setVars(
            [
                'user_login'    => $user->user_login,
                'user_nickname' => $user->user_nickname,
                'user_email'    => $user->user_email,
                'display_name'  => $user->display_name,
                'user_url'      => $user->user_url,
                'description'   => $userMeta->meta_value,
            ]
        );
    }

    /**
     * 更新个人信息
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function updateInfoAction()
    {
        if ($this->request->isPost()) {
            $nickname       = $this->request->getPost('nickname', ['string','trim']);
            $displayName    = $this->request->getPost('displayName');
            $inputEmail     = $this->request->getPost('inputEmail', 'email');
            $inputSite      = $this->request->getPost('inputSite', ['string','trim']);
            $description    = $this->request->getPost('description', ['string','trim']);

            $userAuth = $this->session->get("userAuth");
            $userId   = $userAuth['userId'];

            $user = Users::findFirst($userId);
            $user->user_nickname = $nickname;
            $user->display_name  = $displayName;
            $user->user_email = $inputEmail;
            $user->user_url   = $inputSite;

            if ($user->update() === false) {
                $messages = $this->getErrorMsg($user, "更新出错");
                $this->flash->error($messages);

                return $this->response->redirect("admin/user/self");
            }else{
                $userMeta = Usermeta::findFirst(
                    [
                        "user_id = :id: AND meta_key = :key:",
                        "bind" => [
                            "id" => $userId,
                            "key" => "description",
                        ]
                    ]
                );

                if ($userMeta){
                    $userMeta->meta_value = $description;
                    if ($userMeta->save() === false){
                        $messages = $this->getErrorMsg($userMeta, "更新出错");
                        $this->flash->error($messages);

                        return $this->response->redirect("admin/user/self");
                    }
                }
            }

            $this->flash->success("更新成功!");
            return $this->response->redirect("admin/user/self");
        }
    }

    /**
     * 更新密码
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function updatePasswordAction()
    {
        if ($this->request->isPost()) {
            $inputPassword  = $this->request->getPost('inputPassword');
            $inputPassword2 = $this->request->getPost('inputPassword2');

            if ($inputPassword !== $inputPassword2){
                $this->flash->error("两次密码输入不一致!");
                return $this->response->redirect("admin/user/self");
            }

            $userAuth = $this->session->get("userAuth");
            $userId   = $userAuth['userId'];

            $user = Users::findFirst(
                [
                    "ID = :id:",
                    'bind' => [
                        'id'    => $userId,
                    ]
                ]
            );

            if ($user) {

                if ($this->security->checkHash($inputPassword, $user->user_pass)) {
                    $this->flash->error("不能使用原密码！");

                    return $this->response->redirect("admin/user/self");
                }else{
                    // 更新密码
                    $user->user_pass  = $this->security->hash($inputPassword);

                    if ($user->save() === false) {
                        $messages = $this->getErrorMsg($user, "更新出错");
                        $this->flash->error($messages);

                        return $this->response->redirect("admin/user/self");
                    }
                }

                $this->flash->success("更新成功!");
                return $this->response->redirect("admin/user/self");
            }
        }
    }

    /**
     * TODO
     */
    public function deleteAction()
    {

    }
}

