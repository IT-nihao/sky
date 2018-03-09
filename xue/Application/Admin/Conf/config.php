<?php
return array(
    //'配置项'=>'配置值'
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '39.106.59.81', // 服务器地址
    'DB_NAME'   => 'yixue', // 数据库名
    'DB_USER'   => 'yantian', // 用户名
    'DB_PWD'    => 'yantian123', // 密码
    'DB_PORT'   => 3306, // 端口
    'MEMCACHED_SERVER' => array(
        array('39.106.59.81', 11211, 0)
    ),
//    'TMPL_PARSE_STRING' =>  array('__PUBLIC__' => '/my/xianshang/Public/Admin'),
//    'DATA_CACHE_TYPE' => 'Memcache',
//    'MEMCACHE_HOST'   => 'tcp://39.106.59.81:11211',
//    'DATA_CACHE_TIME' => '3600',
//    'DB_PREFIX' => 'yixue_', // 数据库表前缀
//    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
    "SUPERCONTROLLER"=>array('Index'),
    "SUPERROOT"=>array('123456'),
//    "URL_MODEL" => '2',
//    'THINK_EMAIL' => array(
//
//        'SMTP_HOST' => 'smtp.qq.com', //SMTP服务器
//
//        'SMTP_PORT' => '465', //SMTP服务器端口
//
//        'SMTP_USER' => '1072568257@qq.com', //SMTP服务器用户名
//
//        'SMTP_PASS' => 'ozrniellkeilbdgj', //SMTP服务器密码
//
//        'FROM_EMAIL' => '1072568257@qq.com',
//
//        'FROM_NAME' => 'demo', //发件人名称
//
//        'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
//
//        'REPLY_NAME' => '', //回复名称（留空则为发件人名称）
//
//        'SESSION_EXPIRE'=>'72',
//    ),
//    'MAIL_SMTP'             =>  'smtp.163.com',
//    'MAIL_USER'             =>  '13611369402@163.com',
//    'MAIL_PASS'             =>  'yt258963',    //是smtp发送密码,不是登录密码
//    'MAIL_FROM_ADDRESS'         =>  '13611369402@163.com',
//    'MAIL_FROM_USER'          =>  '易学派',
);
