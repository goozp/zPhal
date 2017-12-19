<?php

return [
    /**
     * 基础服务; web和cli都会用到
     */
    "common" => [
        ZPhal\Providers\Config\ServiceProvider::class, // 配置
        ZPhal\Providers\Db\ServiceProvider::class, // 数据库
        ZPhal\Providers\ModelsMetadata\ServiceProvider::class, // 模型元数据
    ],

    /**
     * web所需的服务
     */
    "web" => [
        /**
         * 前后台共有的服务
         */
        "both" => [
            ZPhal\Providers\Router\ServiceProvider::class, // 路由
            ZPhal\Providers\Session\ServiceProvider::class, // session
            ZPhal\Providers\Url\ServiceProvider::class, // Url
            ZPhal\Providers\ViewCache\ServiceProvider::class, // viewCache(前台缓存,后台删除更新)
            ZPhal\Providers\ModelsCache\ServiceProvider::class, // modelsCache
            ZPhal\Providers\Redis\ServiceProvider::class, // redis
            ZPhal\Providers\Option\ServiceProvider::class, // option读取配置参数
        ],

        /**
         * 后台管理需要加载的服务
         */
        "admin" => [
            ZPhal\Modules\Admin\Providers\Dispatcher\ServiceProvider::class, // 分发器
            ZPhal\Modules\Admin\Providers\View\ServiceProvider::class,  // 视图
            ZPhal\Modules\Admin\Providers\Flash\ServiceProvider::class, // 闪存提示
            ZPhal\Modules\Admin\Providers\MessageControl\ServiceProvider::class, // 错误信息获取
            ZPhal\Modules\Admin\Providers\MediaUpload\ServiceProvider::class, // 文件上传
            ZPhal\Modules\Admin\Providers\Transactions\ServiceProvider::class, // 事务处理器
        ],

        /**
         * 前台展示需要的服务
         */
        "frontend" => [
            ZPhal\Modules\Frontend\Providers\Dispatcher\ServiceProvider::class, // 分发器
            ZPhal\Modules\Frontend\Providers\View\ServiceProvider::class,  // 视图
            ZPhal\Modules\Frontend\Providers\Widget\ServiceProvider::class,  // Widget
        ]
    ],

    /**
     * cli模式所需要的服务
     */
    "cli" => [

    ],
];
