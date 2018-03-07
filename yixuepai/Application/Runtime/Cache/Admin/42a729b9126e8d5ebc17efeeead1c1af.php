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
        <li><a href="#">管理员列表</a></li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <form action="<?php echo U('Pay/pay_my');?>" method="get">
            我的余额：<?php echo ($partner_balance["partner_balance"]); ?>元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            我的返点余额：<?php echo ($partner_balance["partner_rebate"]); ?>元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期 <input type="date" class="dfinput" style="width: 145px;"  name="start_time">-<input type="date" style="width: 145px;" class="dfinput" name="end_time">
            <select name="pay_type" id="" class="dfinput" style="width: 100px;">
                <option value="">请选择</option>
                <option value="1">消费记录</option>
                <option value="2">充值记录</option>
                <option value="3">返点记录</option>
            </select>
            <input name="" type="submit" class="btn" value="搜索"/>
        </form>
    </div>
    <table class="tablelist">
        <thead>
        <tr user_pid="0">
            <th>消费校区</th>
            <th>消费账号</th>
            <th>消费金额</th>
            <th>消费返点金额</th>
            <th>余额</th>
            <th>返点余额</th>
            <th>消费类型</th>
            <th>用途</th>
            <th>描述</th>
            <th>操作人</th>
            <th>操作时间</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($arr)): foreach($arr as $key=>$vo): ?><tr class="tr" id="0_1" user_id="<?php echo ($vo["user_id"]); ?>">
                <td><?php echo ($vo["pay_campus"]); ?></td>
                <td><?php echo ($vo["pay_user"]); ?></td>
                <td><?php echo ($vo["pay_money"]); ?></td>
                <td><?php echo ($vo["pay_rebates"]); ?></td>
                <td><?php echo ($vo["pay_balance"]); ?></td>
                <td><?php echo ($vo["pay_fanyue"]); ?></td>
                <td><?php if($vo['pay_type'] == 1): ?>消费记录
                    <?php else: ?>
                    充值记录<?php endif; ?></td>
                <td><?php if($vo['pay_spend'] == 1): ?>校区充值
                    <?php else: ?>
                    购买课程<?php endif; ?></td>
                <td><?php echo ($vo["pay_describe"]); ?></td>
                <td><?php echo ($vo["pay_operator"]); ?></td>
                <td><?php echo (date("Y-m-d H:i:s",$vo["pay_time"])); ?></td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <div class="pagin">
        <div class="message">共<i class="blue"><?php echo ($count); ?></i>条记录</div>
        <ul class="paginList">
            <?php echo ($page); ?>
        </ul>
    </div>


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
    <!---->



</div>

<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>
</body>
</html>