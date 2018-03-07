<?php if (!defined('THINK_PATH')) exit(); $id = session('yixue_user.user_account'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/xianshang/Public/Admin/js/jquery.js"></script>
    <script src="/xianshang/Public/Admin/js/jquery-1.8.2.min.js"></script>
    <script src="http://files.cnblogs.com/mofish/md5.js"></script>


</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    </ul>
    </div>
    
    <div class="mainindex">
    
    
    <div class="welinfo">
    <span><img src="/xianshang/Public/Admin/images/sun.png" alt="天气" /></span>
    <b><?php echo $id?>早上好，欢迎来到易学派后台管理系统</b>
    <!--<a href="#">帐号设置</a>-->
    </div>
        <a href="<?php echo U('Index/index');?>" class="aasd">加密</a>
    <div class="welinfo">
    <span><img src="/xianshang/Public/Admin/images/time.png" alt="时间" /></span>
    <i id="logInfo"></i>
        <!--（不是您登录的？<a href="#">请点这里</a>）-->
    </div>
    
    <div class="xline"></div>
    
    <!--<ul class="iconlist">-->
    
    <!--<li><img src="/xianshang/Public/Admin/images/ico01.png" /><p><a href="#">管理设置</a></p></li>-->
    <!--<li><img src="/xianshang/Public/Admin/images/ico02.png" /><p><a href="#">发布文章</a></p></li>-->
    <!--<li><img src="/xianshang/Public/Admin/images/ico03.png" /><p><a href="#">数据统计</a></p></li>-->
    <!--<li><img src="/xianshang/Public/Admin/images/ico04.png" /><p><a href="#">文件上传</a></p></li>-->
    <!--<li><img src="/xianshang/Public/Admin/images/ico05.png" /><p><a href="#">目录管理</a></p></li>-->
    <!--<li><img src="/xianshang/Public/Admin/images/ico06.png" /><p><a href="#">查询</a></p></li> -->
            
    <!--</ul>-->
    
    <div class="ibox"><a class="ibtn"><img src="/xianshang/Public/Admin/images/iadd.png" />添加新的快捷功能</a></div>
    
    <div class="xline"></div>
    <div class="box"></div>
    
    <div class="welinfo">
    <span><img src="/xianshang/Public/Admin/images/dp.png" alt="提醒" /></span>
    <b>信息管理系统使用指南</b>
    </div>
    
    <ul class="infolist">
    <li><span>您可以快速进行文章发布管理操作</span><a class="ibtn">发布或管理文章</a></li>
    <li><span>您可以快速发布产品</span><a class="ibtn">发布或管理产品</a></li>
    <li><span>您可以进行密码修改、账户设置等操作</span><a class="ibtn">账户管理</a></li>
    </ul>
    
    <div class="xline"></div>
    
    <div class="info"><b>查看网站使用指南，您可以了解到多种风格的B/S后台管理界面,软件界面设计，图标设计，手机界面等相关信息</b>(More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a>)</div>
    
    <ul class="umlist">
    <li><a href="#">如何发布文章</a></li>
    <li><a href="#">如何访问网站</a></li>
    <li><a href="#">如何管理广告</a></li>
    <li><a href="#">后台用户设置(权限)</a></li>
    <li><a href="#">系统设置</a></li>
    </ul>
    
    
    </div>
</body>
</html>
<script language="javascript">
   $(function(){
       $(".aasd").mouseover(function(){
           var hash = $(this).attr("href");n
           var w = hex_md5(hash);
            $(this).attr("href",w)
       })
   })
function getCurDate()
    {
        var d = new Date();
        var week;
        switch (d.getDay()){
            case 1: week="星期一"; break;
            case 2: week="星期二"; break;
            case 3: week="星期三"; break;
            case 4: week="星期四"; break;
            case 5: week="星期五"; break;
            case 6: week="星期六"; break;
            default: week="星期天";
        }
        var years = d.getFullYear();
        var month = add_zero(d.getMonth()+1);
        var days = add_zero(d.getDate());
        var hours = add_zero(d.getHours());
        var minutes = add_zero(d.getMinutes());
        var seconds=add_zero(d.getSeconds());
        var ndate = years+"年"+month+"月"+days+"日 "+hours+":"+minutes+":"+seconds+" "+week;
        var divT=document.getElementById("logInfo");
        divT.innerHTML= ndate;
    }
    function add_zero(temp)
    {
        if(temp<10) return "0"+temp;
        else return temp;
    }
    setInterval("getCurDate()",100);
</script>