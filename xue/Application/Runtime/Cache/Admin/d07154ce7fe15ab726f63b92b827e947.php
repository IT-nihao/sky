<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>网站后台管理系统HTML模板--模板之家 www.cssmoban.com</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jquery-1.8.2.min.js" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/css/page1.css" rel="stylesheet" type="text/css" />
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
        <li><a href="#">文章列表</a></li>
    </ul>
</div>
<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <li class="click"><span><img src="/xianshang/Public/Admin/images/t01.png" /></span><a href="<?php echo U('dedicated_add');?>">添加</a></li>
        </ul>
        <form action="<?php echo U('Read/dedicated_list');?>" method="get">
            <input name="read_title" type="text" class="dfinput" placeholder="请在这里输入文章标题..." /><input name="" type="submit" class="btn" value="搜索"/>
        </form>
    </div>
    <table class="tablelist" style="table-layout: fixed">
        <thead>
        <tr user_pid="0">
            <th>阅读级别</th>
            <!--<th>编号<i class="sort"><img src="/xianshang/Public/Admin/images/px.gif" /></i></th>-->
            <th>文章所属类型</th>
            <th>文章标题</th>
            <th>文章内容</th>
            <th>建议答题时长</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($arr)): foreach($arr as $key=>$vo): ?><tr class="tr" id="0_1" user_id="<?php echo ($vo["user_id"]); ?>" style="">
                <td width="7%"><?php echo ($vo["level_name"]); ?></td>
                <td width="7%"><?php echo ($vo["type_name"]); ?></td>
                <td width="7%" style="white-space:nowrap;overflow:hidden;text-overflow: ellipsis;"><?php echo ($vo["read_title"]); ?></td>
                <td width="7%" style="white-space:nowrap;overflow:hidden;text-overflow: ellipsis;"><?php echo ($vo["read_text"]); ?></td>
                <td width="7%"><?php echo ($vo["read_time"]); ?>分钟</td>
                <td width="7%"><?php echo (date("Y-m-d H:i:s",$vo["add_time"])); ?></td>
                <td><a href="<?php echo U('Read/dedicated_look');?>?read_level_id=<?php echo ($vo["read_level_id"]); ?>&read_type_id=<?php echo ($vo["read_type_id"]); ?>" class="tablelink"> 查看</a>
                    <a href="<?php echo U('Read/dedicated_update');?>?read_level_id=<?php echo ($vo["read_level_id"]); ?>&read_type_id=<?php echo ($vo["read_type_id"]); ?>" class="tablelink">修改</a>
                    <a href="<?php echo U('Read/dedicated_delete');?>?read_level_id=<?php echo ($vo["read_level_id"]); ?>&read_type_id=<?php echo ($vo["read_type_id"]); ?>" class="tablelink"> 删除</a>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <div class="pagin">
        <div class="message">共<i class="blue"><?php echo ($count); ?></i>条记录</div>
        <ul class="paginList">
            <?php echo ($page); ?>
        </ul>
    </div>




</div>

<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>
</body>
</html>