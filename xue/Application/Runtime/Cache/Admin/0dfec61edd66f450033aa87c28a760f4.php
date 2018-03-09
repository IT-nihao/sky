<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎登录后台管理系统--模板之家 www.cssmoban.com</title>
<link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="/xianshang/Public/Admin/js/jquery.js"></script>
<script src="/xianshang/Public/Admin/js/cloud.js" type="text/javascript"></script>

<script language="javascript">
	$(function(){
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
	$(window).resize(function(){  
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
    })  
});  
</script> 

</head>

<body style="background-color:#1c77ac; background-image:url(/xianshang/Public/Admin/images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">



    <div id="mainBody">
      <div id="cloud1" class="cloud"></div>
      <div id="cloud2" class="cloud"></div>
    </div>  


<div class="logintop">    
    <span>欢迎登录后台管理界面平台</span>
    <ul>
    <li><a href="#">回首页</a></li>
    <li><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    </ul>    
    </div>
    
    <div class="loginbody">
    
    <span class="systemlogo"></span>
        <form action="<?php echo U('login_add');?>" method="post">
    <div class="loginbox">

    <ul>
    <li><input name="account" type="text" class="loginuser" value="" onclick=""/></li>
    <li><input name="pwd" type="text" class="loginpwd" value="" onclick=""/></li>
    <li><input name="" type="submit" class="loginbtn" value="登录"  onclick=""  /><label><input name="rem" type="checkbox" value="1" checked="checked" />记住密码</label><label><a href="<?php echo U('Login/forget_pwd');?>">忘记密码？</a></label></li>
    </ul>
    </div>
    </form>
    </div>
    
    
    
    <!--<div class="loginbm">版权所有  2013  .com 仅供学习交流，勿用于任何商业用途</div>-->
</body>
</html>