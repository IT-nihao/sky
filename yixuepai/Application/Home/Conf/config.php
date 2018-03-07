<?php
return array(
    //'配置项'=>'配置值'
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'yixue', // 数据库名
    'DB_USER'   => 'yantian', // 用户名
    'DB_PWD'    => 'yantian123', // 密码
    'DB_PORT'   => 3306, // 端口
    'DATA_CACHE_TYPE' => 'Memcached',
    'MEMCACHED_SERVER' => array(
        array('39.106.59.81', 11211,3600)
    ),
   'DATA_CACHE_TYPE' => 'Memcache',
   'DATA_CACHE_TIME' => '3600',
   'DB_PREFIX' => 'yixue_', // 数据库表前缀
   'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
    "SUPERCONTROLLER"=>array('Index'),
    "SUPERROOT"=>array('admin'),
);
