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
        <form action="<?php echo U('Pay/pay_campus_list');?>" method="get">
            <input name="partner_account" type="text" class="dfinput" placeholder="请在这里输入管理员名称..."/>
            <input name="partner_home" type="text" class="dfinput" placeholder="请在这里输入店铺地址..."/>
            <input name="partner_tel" type="text" class="dfinput" placeholder="请在这里输入负责人电话..."/>
            <input type="date" class="dfinput" style="width: 145px;" name="start_time">-<input type="date" style="width: 145px;" class="dfinput" name="end_time">
            <select name="partner_code" id="" class="aaaa dfinput" style="width: 100px;">
                <option value="">请选择</option>
                <?php if($id == 8): if(is_array($code)): foreach($code as $key=>$vo): ?><option value="<?php echo ($vo["partner_code"]); ?>"><?php echo ($vo["partner_account"]); ?></option><?php endforeach; endif; ?>
                    <?php else: ?>
                    <?php if(is_array($code)): foreach($code as $key=>$vo): ?><option value="<?php echo ($vo["partner_code"]); ?>"><?php echo ($vo["partner_account"]); ?></option><?php endforeach; endif; endif; ?>

            </select>
            <input name="" type="submit" class="btn" value="搜索"/>
        </form>
    </div>
    <table class="tablelist">
        <thead>
        <tr user_pid="0">
            <th>校区ID</th>
            <th>校区账号</th>
            <th>校区负责人</th>
            <!--<th>校区身份证号</th>-->
            <th>校区性别</th>
            <th>校区电话</th>
            <!--<th>校区家庭住址</th>-->
            <th>押金</th>
            <th>余额</th>
            <th>返点</th>
            <th>开户时间</th>
            <!--<th>管辖校区</th>-->
            <th>详细地址</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($arr)): foreach($arr as $key=>$vo): ?><tr class="tr" id="0_1" user_id="<?php echo ($vo["user_id"]); ?>">
                <td width="7%"><?php echo ($vo["user_id"]); ?></td>
                <td><?php echo ($vo["user_account"]); ?></td>
                <td><?php echo ($vo["partner_account"]); ?></td>
                <!--<td><?php echo ($vo["partner_idcard"]); ?></td>-->
                <?php if($vo['partner_sex'] == 1): ?><td>男</td>
                    <?php else: ?>
                    <td>女</td><?php endif; ?>
                <td width="7%"><?php echo ($vo["partner_tel"]); ?></td>
                <td><?php echo ($vo["partner_money"]); ?></td>
                <td><?php echo ($vo["partner_balance"]); ?></td>
                <td><?php echo ($vo["partner_rebate"]); ?></td>
                <td><?php echo (date("Y-m-d H:i:s",$vo["partner_time"])); ?></td>
                <!--<td><?php echo ($vo["partner_government"]); ?></td>-->
                <td><?php echo ($vo["detailed_address"]); ?></td>
                <td>
                    <a href="<?php echo U('Pay/pay_add');?>?user_id=<?php echo ($vo["user_id"]); ?>" class="tablelink"> 充值</a>
                    <a href="<?php echo U('Pay/pay_list');?>?user_id=<?php echo ($vo["user_id"]); ?>" class="tablelink"> 详情</a>
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