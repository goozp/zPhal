<?php

use Phalcon\Config;
/**
 * ACL 私密资源定义
 * TODO 未完成
 *
 * Class AdminAcl
 * @package ZPhal\Modules\Admin\Library
 */
return new Config([
    'privateResources' => [
        'users' => [
            'index',
            'new',
            'edit',
            'self'
        ]
    ]
]);