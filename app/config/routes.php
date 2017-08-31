<?php

$router = $di->getRouter();

/*foreach ($application->getModules() as $key => $module) {
    $namespace = preg_replace('/Module$/', 'Controllers', $module["className"]);
    $router->add('/'.$key.'/:params', [
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 'index',
        'action' => 'index',
        'params' => 1
    ])->setName($key);
    $router->add('/'.$key.'/:controller/:params', [
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 1,
        'action' => 'index',
        'params' => 2
    ]);
    $router->add('/'.$key.'/:controller/:action/:params', [
        'namespace' => $namespace,
        'module' => $key,
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ]);
}

$router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'login',
        'action'     => 'index',
    ]
);

$router->add(
    '/articles/:int',
    [
        'module'     => 'frontend',
        'controller' => 'Articles',
        'action'     => 'index',
        'aid'         => 1
    ]
);*/

/**
 * 前台路由
 * */
$router->add(
    '/',
    [
        'module'     => 'frontend',
        'controller' => 'index',
        'action'     => 'index',
    ]
);

$router->add('/:controller/:action', [
    'module'     => 'frontend',
    'controller' => 1,
    'action'     => 2,
])->setName('frontend');

$router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'login',
        'action'     => 'index',
    ]
)->setName('admin-login');

/**
 * 后台路由
 */
$router->add(
    '/admin',
    [
        'module'     => 'admin',
        'controller' => 'index',
        'action'     => 'index',
    ]
);

$router->add(
    '/admin/:controller',
    [
        'module'     => 'admin',
        'controller' => 1,
        'action'     => 'index'
    ]
);

$router->add(
    '/admin/:controller/:action',
    [
        'module'     => 'admin',
        'controller' => 1,
        'action'     => 2
    ]
);

$router->add(
    '/admin/:controller/',
    [
        'module'     => 'admin',
        'controller' => 1,
        'action'     => 2
    ]
);

$router->add(
    '/admin/:controller/:action/:param',
    [
        'module'     => 'admin',
        'controller' => 1,
        'action'     => 2,
        'param'      => 3
    ]
)->setName('admin-default');

$router->notFound(
    [
        'controller' => 'error',
        'action'     => 'route404',
    ]
);

