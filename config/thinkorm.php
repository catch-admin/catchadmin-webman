<?php

return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            // 数据库类型
            'type' => 'mysql',
            // 服务器地址
            'hostname' => env('DB_HOST','127.0.0.1'),
            // 数据库名
            'database' => env('DB_NAME','webman'),
            // 数据库用户名
            'username' => env('DB_USER','root'),
            // 数据库密码
            'password' => env('DB_PASS','123456'),
            // 数据库连接端口
            'hostport' => env('DB_PORT','3306'),
            // 数据库连接参数
            'params' => [
                // 连接超时3秒
                \PDO::ATTR_TIMEOUT => 3,
            ],
            // 数据库编码默认采用utf8
            'charset' => env('DB_CHARSET','utf8'),
            // 数据库表前缀
            'prefix' => '',
            // 断线重连
            'break_reconnect' => true,
            // 关闭SQL监听日志
            'trigger_sql' => false,
            // 自定义分页类
            'bootstrap' =>  '',
            'query' => \app\admin\support\CatchQuery::class
        ],
    ],
];
