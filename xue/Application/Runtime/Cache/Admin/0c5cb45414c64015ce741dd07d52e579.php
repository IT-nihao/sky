<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>网站后台管理系统HTML模板--模板之家 www.cssmoban.com</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jquery-1.8.2.min.js" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/xianshang/Public/Admin/js/jquery.js"></script>
    <link href="/xianshang/Public/Admin/css/page1.css" rel="stylesheet" type="text/css" />

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
        <li><a href="#">分销商列表</a></li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">

        <ul class="toolbar">
            <li class="click"><span><img src="/xianshang/Public/Admin/images/t01.png" /></span><a href="<?php echo U('partner_add');?>">添加</a></li>
        </ul>

        <form action="<?php echo U('Partner/partner_list');?>" method="get">
            <input name="partner_account" type="text" class="dfinput" placeholder="请在这里输入负责人名称..."/><input name="" type="submit" class="btn" value="搜索"/>
        </form>

    </div>


    <table class="tablelist">
        <thead>
        <tr>
            <th>分销商ID</th>
            <th>分销商负责人</th>
            <th>分销商身份证号</th>
            <th>分销商性别</th>
            <th>分销商电话</th>
            <th>分销商家庭住址</th>
            <th>开户时间</th>
            <th>管辖校区</th>
            <th>详细地址</th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody>
        <?php if(is_array($arr)): foreach($arr as $key=>$vo): ?><tr>
                <td width="7%"><?php echo ($vo["partner_id"]); ?></td>
                <td><?php echo ($vo["partner_account"]); ?></td>
                <!--<td>王金平幕僚：马英九声明字字见血 人活着没意思</td>-->
                <td><?php echo ($vo["partner_idcard"]); ?></td>
                <?php if($vo['partner_sex'] == 1): ?><td>男</td>
                    <?php else: ?>
                    <td>女</td><?php endif; ?>
                <td width="7%"><?php echo ($vo["partner_tel"]); ?></td>
                <td><?php echo ($vo["partner_home"]); ?></td>
                <!--<td>王金平幕僚：马英九声明字字见血 人活着没意思</td>-->
                <td><?php echo (date("Y-m-d H:i:s",$vo["partner_time"])); ?></td>
                <td><?php echo ($vo["partner_government"]); ?></td>
                <td><?php echo ($vo["detailed_address"]); ?></td>
                <td><a href="<?php echo U('Partner/partner_update');?>?partner_id=<?php echo ($vo["partner_id"]); ?>" class="tablelink">修改</a>
                    <a href="<?php echo U('Partner/partner_delete');?>?partner_id=<?php echo ($vo["partner_id"]); ?>" class="tablelink"> 删除</a></td>
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
<script>

</script>