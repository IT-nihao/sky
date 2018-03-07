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
        <form action="<?php echo U('Print/print_list');?>" method="get">
            <input name="students_name" type="text" class="dfinput" placeholder="请在这里输入学生姓名..." /><input name="" type="submit" class="btn" value="搜索"/>
        </form>
    </div>
    <table class="tablelist" style="table-layout: fixed">
        <thead>
        <tr user_pid="0">
            <th>打印人</th>
            <th>打印内容</th>
            <th>提交时间</th>
            <th>操作</th>
        </tr>
        </thead>


        <tbody>
        <?php if(is_array($arr)): foreach($arr as $key=>$vo): ?><tr class="tr" id="0_1" user_id="<?php echo ($vo["user_id"]); ?>" style="">
                <td width="7%"><?php echo ($vo["students_name"]); ?></td>
                <td width="7%" style="white-space:nowrap;overflow:hidden;text-overflow: ellipsis;">单词</td>
                <td width="7%"><?php echo (date("Y-m-d H:i:s",$vo["time"])); ?></td>
                <td><a href="<?php echo U('Print/print_word');?>?id=<?php echo ($vo["students_id"]); ?>&time=<?php echo ($vo["time"]); ?>">打印</a>
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
    <!--<div class="tip">-->
        <!--<div class="tiptop"><span>提示信息</span><a></a></div>-->

        <!--<div class="tipinfo">-->
            <!--<span><img src="/xianshang/Public/Admin/images/ticon.png" /></span>-->
            <!--<div class="tipright">-->
                <!--<p>是否确认对信息的修改 ？</p>-->
                <!--<cite>如果是请点击确定按钮 ，否则请点取消。</cite>-->
            <!--</div>-->
        <!--</div>-->

        <!--<div class="tipbtn">-->
            <!--<input name="" type="button"  class="sure" value="确定" />&nbsp;-->
            <!--<input name="" type="button"  class="cancel" value="取消" />-->
        <!--</div>-->

    <!--</div>-->




</div>

<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>
</body>
</html>