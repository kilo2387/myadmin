<?php
return array(
	//'配置项'=>'配置值'
    //开启路由
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
        'count/test'             => 'News/test',
        'news/:year/:month/:day' => array('News/archive', 'status=1'),
        'news/:id'               => 'News/test', //news/5 -> news/test?id=5
        'news/read/:id'          => '/news/:1',
    ),
);