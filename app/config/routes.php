<?php

$router = $di->getRouter();

/**
 * 前台路由
 * */
$router->add('/',
    [
        'module'     => 'frontend',
        'controller' => 'index',
        'action'     => 'index',
    ]
);


$router->add('/login',
    [
        'module'     => 'admin',
        'controller' => 'login',
        'action'     => 'index',
    ]
)->setName('admin-login');

/**
 * 后台路由
 */
$router->add('/admin',
    [
        'module'     => 'admin',
        'controller' => 'index',
        'action'     => 'index',
    ]
)->setName('admin-root');

$router->add('/admin/user',
    [
        'module'     => 'admin',
        'controller' => 'user',
        'action'     => 'index',
    ]
);
$router->add('/admin/user/new',
    [
        'module'     => 'admin',
        'controller' => 'user',
        'action'     => 'new',
    ]
);
$router->add('/admin/user/save',
    [
        'module'     => 'admin',
        'controller' => 'user',
        'action'     => 'save',
    ]
);
$router->add('/admin/user/self',
    [
        'module'     => 'admin',
        'controller' => 'user',
        'action'     => 'self',
    ]
);

$router->notFound(
    [
        'controller' => 'error',
        'action'     => 'route404',
    ]
);

