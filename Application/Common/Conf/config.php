<?php
return array(
	//'配置项'=>'配置值'
//    'CONTROLLER_LEVEL'      =>  2, //多层控制器

    //'配置项'=>'配置值'
        'DB_TYPE'               =>  'mysql',                        // 数据库类型
        'DB_HOST'               =>  'localhost',              // 服务器地址
        'DB_NAME'               =>  'open',                      // 数据库名
        'DB_USER'               =>  'root',                          // 用户名
<<<<<<< HEAD
        'DB_PWD'                =>  'jkljkl',           // 密码
=======
        'DB_PWD'                =>  UC_DBPWD,           // 密码
>>>>>>> dc00bc8... none
        'DB_PORT'               =>  '3306',                         // 端口
        'DB_PREFIX'             =>  'oc_',                           // 数据库表前缀
        'DB_PARAMS'          	=>  array(),                        // 数据库连接参数
        'DB_DEBUG'  			=>  TRUE,                           // 数据库调试模式 开启后可以记录SQL日志
        'DB_FIELDS_CACHE'       =>  false,                          // 启用字段缓存
        'DB_CHARSET'            =>  'utf8',                         // 数据库编码默认采用utf8
        'TMPL_CACHE_ON'         =>  false,
        'READ_DATA_MAP'         =>  true,                           //开启字段映射
        'DATA_CACHE_SUBDIR'     =>  true,                            //是否开启子目录
        'DATA_PATH_LEVEL'       =>  2,                                //目录层级

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
//        '__CSS__'   => __ROOT__ . 'http://plugin.huishoubao.com.cn/Public/widget/css',
//        '__JS__'    => __ROOT__ . 'http://plugin.huishoubao.com.cn/Public/widget/js',
//        '__IMG__'   => __ROOT__ . 'http://plugin.huishoubao.com.cn/Public/widget/images',

        /* 本地静态资源文件 */
//        '__LOCAL_CSS__'   => __ROOT__ . '/Public/css',
//        '__LOCAL_JS__'    => __ROOT__ . '/Public/js/boss',
//        '__PLUGIN_JS__'    => __ROOT__ . '/Public/js/plugin',
//        '__LOCAL_IMG__'   => __ROOT__ . '/Public/images',
        '__LOCAL_CSS__'   => '/Public/css',

        '__BOSS_JS__'     => '/Public/js/boss',
        '__PLUGIN_JS__'   => '/Public/js/plugin',

        '__LOCAL_IMG__'   => '/Public/images',
    ),

    /* 系统配置 */
    'USER_MAX_CACHE' => 1000, //最大缓存用户数
//    'URL_CASE_INSENSITIVE' =>true,
);