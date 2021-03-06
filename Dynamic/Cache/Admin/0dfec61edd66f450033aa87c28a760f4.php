<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="body-full-height">
<head>
    <!-- META SECTION -->
    <title>回收宝 | Boss管理平台</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <!-- END META SECTION -->
    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="/Public/css/theme-default.css"/>
    <!-- EOF CSS INCLUDE -->
    <!--<script type="text/javascript" src="__JS__/jquery.min.js"></script>-->
    <!--<script type="text/javascript" src="__JS__/canvas.js"></script>-->
</head>
<body>
<!--<canvas></canvas>-->
<div class="login-container lightmode">

    <div class="login-box animated fadeInDown">
        <div class="login-logo"></div>
        <div class="login-body">
            <div class="login-title"><strong>登录</strong><small>你的账户</small></div>
            <div class="form-horizontal">
                <input type="hidden" value="" name="time_password">
                <input type="hidden" value="<?php echo ($callback_url); ?>" name="callback_url">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="user_name" placeholder="用户名"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="password" class="form-control" name="password" placeholder="密码"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-link btn-block">忘记密码?</a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-info btn-block">登录</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                &copy; 2016 Huishoubao
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/Public/js/plugin/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/boss/util.js"></script>
<script type="text/javascript" src="/Public/js/boss/login/login.js"></script>
</body>
</html>