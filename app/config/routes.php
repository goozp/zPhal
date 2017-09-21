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

$router->add('/admin/session/logout',
    [
        'module'     => 'admin',
        'controller' => 'session',
        'action'     => 'logout',
    ]
)->setName('admin-logout');

/* post */
$router->add('/admin/post',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'index',
    ]
);
$router->add('/admin/post/new',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'new',
    ]
);
$router->add('/admin/post/addTaxonomy/{type:[a-z]+}',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'addTaxonomy',
        'type'       => 1,
    ]
)->setName('new-taxonomy');
$router->add('/admin/post/taxonomy/{type:[a-z]+}',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'taxonomy',
        'type'       => 1,
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
$router->add('/admin/media/upload',
    [
        'module'     => 'admin',
        'controller' => 'media',
        'action'     => 'upload',
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

