<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
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
    <span>修改密码</span>
    <ul>
    <li><a href="#">回首页</a></li>
    <li><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    </ul>    
    </div>
    
    <div class="loginbody">
    
    <span class="systemlogo"></span>
        <form action="<?php echo U('Login/update_pwd');?>" method="post">
    <div class="loginbox">

    <ul>
        <li><input name="partner_code" type="hidden" class="loginuser" value="<?php echo ($code); ?>" onclick="" /></li>

        <li><input name="" type="text" class="loginuser" value="<?php echo ($code); ?>" onclick="" disabled/></li>
    <li><input name="new_pwd" type="text" class="loginpwd" value="" onclick="" placeholder="请输入输入新密码...."/></li>
    <li><input name="" type="submit" class="loginbtn" value="登录"  onclick=""  /></li>
    </ul>
    </div>
    </form>
    </div>
    
    
    
    <!--<div class="loginbm">版权所有  2013  .com 仅供学习交流，勿用于任何商业用途</div>-->
</body>
</html>