<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站后台管理系统HTML模板--模板之家 www.cssmoban.com</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jquery-1.8.2.min.js" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/xianshang/Public/Admin/js/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });
  
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
</script>


</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">角色列表</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    <div class="tools">
    
    	<ul class="toolbar">
        <li class=""><span><img src="/xianshang/Public/Admin/images/t01.png" /></span><a href="<?php echo U('role_add');?>">添加</a></li>
        </ul>
    
    </div>
    
    
    <table class="tablelist">
    	<thead>
    	<tr power_pid="0">
        <!--<th>编号<i class="sort"><img src="/xianshang/Public/Admin/images/px.gif" /></i></th>-->
        <th>角色ID</th>
            <th>角色名称</th>
            <th>角色描述</th>
            <th>角色所拥有权限</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($show)): foreach($show as $key=>$vo): ?><tr>
            <td width="7%"><?php echo ($vo["role_id"]); ?></td>
            <td><?php echo ($vo["role_name"]); ?></td>
            <td><?php echo ($vo["role_depict"]); ?></td>
            <td><?php echo ($vo["power_name"]); ?></td>
            <td><a href="<?php echo U('Role/role_update');?>?role_id=<?php echo ($vo["role_id"]); ?>" class="tablelink">重新覆权</a>
                <a href="<?php echo U('Role/role_delete');?>?role_id=<?php echo ($vo["role_id"]); ?>" class="tablelink"> 删除</a></td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <!--<div class="pagin">-->
    	<!--<div class="message">共<i class="blue">1256</i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>-->
        <!--<ul class="paginList">-->
        <!--<li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>-->
        <!--<li class="paginItem"><a href="javascript:;">1</a></li>-->
        <!--<li class="paginItem current"><a href="javascript:;">2</a></li>-->
        <!--<li class="paginItem"><a href="javascript:;">3</a></li>-->
        <!--<li class="paginItem"><a href="javascript:;">4</a></li>-->
        <!--<li class="paginItem"><a href="javascript:;">5</a></li>-->
        <!--<li class="paginItem more"><a href="javascript:;">...</a></li>-->
        <!--<li class="paginItem"><a href="javascript:;">10</a></li>-->
        <!--<li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>-->
        <!--</ul>-->
    <!--</div>-->
    
    <!---->
    <!--<div class="tip">-->
    	<!--<div class="tiptop"><span>提示信息</span><a></a></div>-->
        <!---->
      <!--<div class="tipinfo">-->
        <!--<span><img src="/xianshang/Public/Admin/images/ticon.png" /></span>-->
        <!--<div class="tipright">-->
        <!--<p>是否确认对信息的修改 ？</p>-->
        <!--<cite>如果是请点击确定按钮 ，否则请点取消。</cite>-->
        <!--</div>-->
        <!--</div>-->
        <!---->
        <!--<div class="tipbtn">-->
        <!--<input name="" type="button"  class="sure" value="确定" />&nbsp;-->
        <!--<input name="" type="button"  class="cancel" value="取消" />-->
        <!--</div>-->
    <!---->
    <!--</div>-->
    
    
    
    
    </div>
    
    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>
</body>
</html>
<script>
//$(function(){
//    $("tr[power_pid!=0]").hide();
//    $(".span").toggle(function(){
//        $(this).html("[-]");
//        var power_id = $(this).parents(".tr").attr("power_id");
//        //				alert(power_id);
//        $("tr[power_pid='"+power_id+"']").show();
//        // var power_id = $(this).parent().parent().attr("power_id");
//        // alert(power_id);
//        },
//        function(){
//            $(this).html('[+]');
//            var power_id = $(this).parents(".tr").attr("power_id");
//            $("tr[power_pid='"+power_id+"']").hide();
//    })
//})
</script>