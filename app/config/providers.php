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

        ]
    ],

    /**
     * cli模式所需要的服务
     */
    "cli" => [

    ],
];
