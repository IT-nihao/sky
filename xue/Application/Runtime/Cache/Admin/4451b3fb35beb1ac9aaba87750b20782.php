<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="/xianshang/Public/Admin/js/jquery.js"></script>

<script type="text/javascript">
$(function(){	
	//导航切换
	$(".menuson li").click(function(){
		$(".menuson li.active").removeClass("active")
		$(this).addClass("active");
	});
	
	$('.title').click(function(){
		var $ul = $(this).next('ul');
		$('dd').find('ul').slideUp();
		if($ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});
})	
</script>


</head>

<body style="background:#f0f9fd;">
	<div class="lefttop"><span></span>菜单栏</div>
    
    <dl class="leftmenu">
        
    <dd>
    <div class="title">
    <span><img src="/xianshang/Public/Admin/images/leftico01.png" /></span>管理信息
    </div>
    	<ul class="menuson">
        <li><cite></cite><a href="<?php echo U('main');?>" target="rightFrame">首页模版</a><i></i></li>
        <li class="active"><cite></cite><a href="right.html" target="rightFrame">财务管理</a><i></i></li>
        <li><cite></cite><a href="imgtable.html" target="rightFrame">分销商管理</a><i></i></li>
        </ul>    
    </dd>
        
    
    <dd>
    <div class="title">
    <span><img src="/xianshang/Public/Admin/images/leftico02.png" /></span>财务管理
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="#">编辑内容</a><i></i></li>
        <li><cite></cite><a href="#">发布信息</a><i></i></li>
        <li><cite></cite><a href="#">档案列表显示</a><i></i></li>
        </ul>     
    </dd> 
    
    
    <dd><div class="title"><span><img src="/xianshang/Public/Admin/images/leftico03.png" /></span>分销商管理</div>
    <ul class="menuson">
        <li><cite></cite><a href="#">自定义</a><i></i></li>
        <li><cite></cite><a href="#">常用资料</a><i></i></li>
        <li><cite></cite><a href="#">信息列表</a><i></i></li>
        <li><cite></cite><a href="#">其他</a><i></i></li>
    </ul>    
    </dd>  
    
    
    <dd><div class="title"><span><img src="/xianshang/Public/Admin/images/leftico04.png" /></span>校区管理</div>
    <ul class="menuson">
        <li><cite></cite><a href="#">自定义</a><i></i></li>
        <li><cite></cite><a href="#">常用资料</a><i></i></li>
        <li><cite></cite><a href="#">信息列表</a><i></i></li>
        <li><cite></cite><a href="#">其他</a><i></i></li>
    </ul>
    
    </dd>
        <dd><div class="title"><span><img src="/xianshang/Public/Admin/images/leftico04.png" /></span>学生管理</div>
            <ul class="menuson">
                <li><cite></cite><a href="#">自定义</a><i></i></li>
                <li><cite></cite><a href="#">常用资料</a><i></i></li>
                <li><cite></cite><a href="#">信息列表</a><i></i></li>
                <li><cite></cite><a href="#">其他</a><i></i></li>
            </ul>

        </dd>
        <dd><div class="title"><span><img src="/xianshang/Public/Admin/images/leftico04.png" /></span>课程管理</div>
            <ul class="menuson">
                <li><cite></cite><a href="#">自定义</a><i></i></li>
                <li><cite></cite><a href="#">常用资料</a><i></i></li>
                <li><cite></cite><a href="#">信息列表</a><i></i></li>
                <li><cite></cite><a href="#">其他</a><i></i></li>
            </ul>

        </dd>
        <dd><div class="title"><span><img src="/xianshang/Public/Admin/images/leftico04.png" /></span>权限管理</div>
            <ul class="menuson">
                <li><cite></cite><a href="<?php echo U('Index/power_list');?>">权限列表</a><i></i></li>
                <!--<li><cite></cite><a href="#">常用资料</a><i></i></li>-->
                <!--<li><cite></cite><a href="#">信息列表</a><i></i></li>-->
                <!--<li><cite></cite><a href="#">其他</a><i></i></li>-->
            </ul>

        </dd>

    </dl>
</body>
</html>