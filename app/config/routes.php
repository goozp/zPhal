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
)->setName('index');
$router->add("/{param:[a-zA-Z]+}",
    [
        'module'     => 'frontend',
        'controller' => 'pages',
        'action'     => 'index',
        "param"   => 1,
    ]
)->setName('page');
$router->add("/article/{id:[0-9]+}.html",
    [
        'module'     => 'frontend',
        'controller' => 'articles',
        'action'     => 'index',
        "id"     => 1,
    ]
)->setName('article');
$router->add("/subject/:params",
    [
        'module'     => 'frontend',
        'controller' => 'subjects',
        'action'     => 'subject',
        "params"   => 1,
    ]
)->setName('subject');
$router->add("/subject/item/:params",
    [
        'module'     => 'frontend',
        'controller' => 'subjects',
        'action'     => 'detail',
        "params"   => 1,
    ]
)->setName('subject-detail');
$router->add("/archive",
    [
        'module'     => 'frontend',
        'controller' => 'archives',
        'action'     => 'index',
    ]
)->setName('archive');
$router->add("/product",
    [
        'module'     => 'frontend',
        'controller' => 'products',
        'action'     => 'index',
    ]
)->setName('product');
$router->add("/link",
    [
        'module'     => 'frontend',
        'controller' => 'links',
        'action'     => 'index',
    ]
)->setName('link');

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

/* subject */
$router->add('/admin/subject',
    [
        'module'    =>  'admin',
        'controller'=>  'subject',
        'action'    =>  'index'
    ]
)->setName('list-subject');
$router->add('/admin/subject/new',
    [
        'module'    =>  'admin',
        'controller'=>  'subject',
        'action'    =>  'new'
    ]
)->setName('new-subject');
$router->add('/admin/subject/save',
    [
        'module'    =>  'admin',
        'controller'=>  'subject',
        'action'    =>  'save'
    ]
)->setName('save-subject');
$router->add('/admin/subject/edit/{id:[0-9]+}',
    [
        'module'    =>  'admin',
        'controller'=>  'subject',
        'action'    =>  'edit',
        'id'        =>  1,
    ]
)->setName('edit-subject');
$router->add('/admin/subject/update/{id:[0-9]+}',
    [
        'module'    =>  'admin',
        'controller'=>  'subject',
        'action'    =>  'update',
        'id'        =>  1,
    ]
)->setName('update-subject');
$router->add('/admin/subject/delete/{id:[0-9]+}',
    [
        'module'    =>  'admin',
        'controller'=>  'subject',
        'action'    =>  'delete',
        'id'        =>  1,
    ]
)->setName('delete-subject');

/* post */
$router->add('/admin/post/:params',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'index',
        'params'       => 1
    ]
)->setName('list-article');
$router->add('/admin/post/new',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'new',
    ]
);
$router->add('/admin/post/save',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'save',
    ]
);
$router->add('/admin/post/autodraft',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'autoSaveDraft',
    ]
);
$router->add('/admin/post/edit/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'edit',
        'id'         => 1,
    ]
)->setName('edit-post');
$router->add('/admin/post/update',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'update',
    ]
)->setName('update-post');
$router->add('/admin/post/trash/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'trash',
        'id'         => 1,
    ]
)->setName('trash-post');
$router->add('/admin/post/restore/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'restore',
        'id'         => 1,
    ]
)->setName('restore-post');
$router->add('/admin/post/delete/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'post',
        'action'     => 'delete',
        'id'         => 1,
    ]
)->setName('delete-post');

/* taxonomy */
$router->add('/admin/taxonomy/{type:[a-zA-Z]+}',
    [
        'module'     => 'admin',
        'controller' => 'taxonomy',
        'action'     => 'taxonomy',
        'type'       => 1,
    ]
);
$router->add('/admin/taxonomy/quickAddTaxonomy/{type:[a-zA-Z]+}',
    [
        'module'     => 'admin',
        'controller' => 'taxonomy',
        'action'     => 'quickAddTaxonomy',
        'type'       => 1,
    ]
);
$router->add('/admin/taxonomy/addTaxonomy/{type:[a-zA-Z]+}',
    [
        'module'     => 'admin',
        'controller' => 'taxonomy',
        'action'     => 'addTaxonomy',
        'type'       => 1,
    ]
)->setName('new-taxonomy');
$router->add('/admin/taxonomy/editTaxonomy/{type:[a-zA-Z]+}/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'taxonomy',
        'action'     => 'editTaxonomy',
        'type'       => 1,
        'id'         => 2,
    ]
)->setName('edit-taxonomy');
$router->add('/admin/taxonomy/updateTaxonomy/{type:[a-zA-Z]+}/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'taxonomy',
        'action'     => 'updateTaxonomy',
        'type'       => 1,
        'id'         => 2,
    ]
)->setName('update-taxonomy');
$router->add('/admin/taxonomy/deleteTaxonomy/{type:[a-zA-Z]+}/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'taxonomy',
        'action'     => 'deleteTaxonomy',
        'type'       => 1,
        'id'         => 2,
    ]
)->setName('delete-taxonomy');


/* page */
$router->add('/admin/page/:params',
    [
        'module'     => 'admin',
        'controller' => 'page',
        'action'     => 'index',
        'params'       => 1
    ]
)->setName('list-page');
$router->add('/admin/page/new',
    [
        'module' => 'admin',
        'controller' => 'page',
        'action'    => 'new'
    ]
)->setName('new-page');
$router->add('/admin/page/save',
    [
        'module' => 'admin',
        'controller' => 'page',
        'action'    => 'save'
    ]
)->setName('save-page');
$router->add('/admin/page/autodraft',
    [
        'module'     => 'admin',
        'controller' => 'page',
        'action'     => 'autoSaveDraft',
    ]
);
$router->add('/admin/page/edit/{id:[0-9]+}',
[
    'module'     => 'admin',
    'controller' => 'page',
    'action'     => 'edit',
    'id'         => 1,
]
)->setName('edit-page');
$router->add('/admin/page/update',
[
    'module'     => 'admin',
    'controller' => 'page',
    'action'     => 'update',
]
)->setName('update-page');
$router->add('/admin/page/trash/{id:[0-9]+}',
[
    'module'     => 'admin',
    'controller' => 'page',
    'action'     => 'trash',
    'id'         => 1,
]
)->setName('trash-page');
$router->add('/admin/page/restore/{id:[0-9]+}',
[
    'module'     => 'admin',
    'controller' => 'page',
    'action'     => 'restore',
    'id'         => 1,
]
)->setName('restore-page');
$router->add('/admin/page/delete/{id:[0-9]+}',
[
    'module'     => 'admin',
    'controller' => 'page',
    'action'     => 'delete',
    'id'         => 1,
]
)->setName('delete-page');

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

/* links */
$router->add('/admin/link',
    [
        'module'     => 'admin',
        'controller' => 'link',
        'action'     => 'index',
    ]
)->setName('list-link');
$router->add('/admin/link/new',
    [
        'module'     => 'admin',
        'controller' => 'link',
        'action'     => 'new',
    ]
);
$router->add('/admin/link/save',
    [
        'module'     => 'admin',
        'controller' => 'link',
        'action'     => 'save',
    ]
);
$router->add('/admin/link/edit/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'link',
        'action'     => 'edit',
        'id'         => 1,
    ]
)->setName('edit-link');
$router->add('/admin/link/update/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'link',
        'action'     => 'update',
        'id'         => 1,
    ]
)->setName('update-link');
$router->add('/admin/link/delete/{id:[0-9]+}',
    [
        'module'     => 'admin',
        'controller' => 'link',
        'action'     => 'delete',
        'id'         => 1,
    ]
)->setName('delete-link');


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

/* setting */
$router->add('/admin/setting/general',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'general',
    ]
);
$router->add('/admin/setting/saveGeneral',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'saveGeneral',
    ]
);
$router->add('/admin/setting/writing',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'writing',
    ]
);
$router->add('/admin/setting/saveWriting',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'saveWriting',
    ]
);
$router->add('/admin/setting/reading',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'reading',
    ]
);
$router->add('/admin/setting/saveReading',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'saveReading',
    ]
);
$router->add('/admin/setting/discuss',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'discuss',
    ]
);
$router->add('/admin/setting/saveDiscuss',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'saveDiscuss',
    ]
);
$router->add('/admin/setting/media',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'media',
    ]
);
$router->add('/admin/setting/permalink',
    [
        'module'     => 'admin',
        'controller' => 'setting',
        'action'     => 'permalink',
    ]
);


$router->notFound(
    [
        'controller' => 'error',
        'action'     => 'route404',
    ]
);