<?php
namespace ZPhal\Modules\Admin\Library;

use Phalcon\Mvc\User\Component;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;

/**
 * ACL 范文控制类
 * TODO 未完成 完成功能后再添加
 *
 * Class AdminAcl
 * @package ZPhal\Modules\Admin\Library
 */
class AdminAcl extends Component
{
    /**
     * ACL 对象
     *
     * @var \Phalcon\Acl\Adapter\Memory
     */
    private $acl;

    /**
     * ACL 列表缓存路径
     *
     * @var string
     */
    private $filePath;

    /**
     * 私密资源(controller => actions)
     *
     * @var array
     */
    private $privateResources = array();

    /**
     * 是否私密的
     *
     * @param string $controllerName
     * @return boolean
     */
    public function isPrivate($controllerName)
    {
        $controllerName = strtolower($controllerName);
        return isset($this->privateResources[$controllerName]);
    }

    /**
     * 是否允许返问资源
     *
     * @param string $profile
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public function isAllowed($profile, $controller, $action)
    {
        return $this->getAcl()->isAllowed($profile, $controller, $action);
    }

    /**
     * 返回 ACL 列表
     *
     * @return \Phalcon\Acl\Adapter\Memory
     */
    public function getAcl()
    {
        if (is_object($this->acl)) {
            return $this->acl;
        }

        $filePath = $this->getFilePath();
        // 没有,生成新的
        if (!is_file($filePath)) {
            $acl = new AclList();

            // ... Define roles, resources, access, etc

            // 保存实例化的数据到文本文件中
            file_put_contents(
                $filePath,
                serialize($acl)
            );
            $this->acl = $acl;
        } else {
            // 返序列化
            $this->acl = unserialize(
                file_get_contents($filePath)
            );
        }
        return $this->acl;
    }

    /**
     * 列表存放路径
     *
     * @return string
     */
    protected function getFilePath()
    {
        if (!isset($this->filePath)) {
            $this->filePath = rtrim($this->config->application->cacheDir, '\\/') . '/acl/acl.data';
        }
        return $this->filePath;
    }
}