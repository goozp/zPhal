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

$router->add('/admin/session/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
        'action'     => 'login',
    ]
);

/* media */
$router->add('/admin/media',
    [
        'module'     => 'admin',
        'controller' => 'media',
        'action'     => 'index',
    ]
);
$router->add('/admin/media/new',
    [
        'module'     => 'admin',
        'controller' => 'media',
        'action'     => 'new',
    ]
);

/* user */
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
$router->add('/admin/user/updateInfo',
    [
        'module'     => 'admin',
        'controller' => 'user',
        'action'     => 'updateInfo',
    ]
);
$router->add('/admin/user/updatePassword',
    [
        'module'     => 'admin',
        'controller' => 'user',
        'action'     => 'updatePassword',
    ]
);



$router->notFound(
    [
        'controller' => 'error',
        'action'     => 'route404',
    ]
);

