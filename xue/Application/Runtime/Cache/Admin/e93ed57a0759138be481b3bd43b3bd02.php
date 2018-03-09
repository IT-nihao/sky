<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">学生信息</a></li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>学生信息</span></div>
    <form action="<?php echo U('students/students_update');?>" method="post">
        <ul class="forminfo">
            <li><label>学生姓名:</label><cite><?php echo ($arr["students_name"]); ?></cite></li>
            <li><label>学生所属校区:</label><?php echo ($arr["students_campus"]); ?></li>
            <li><label>学生性别:</label>
                <?php if($arr['students_sex'] == 1): ?><cite>男</cite>
                    <?php else: ?>
                    <cite>女</cite><?php endif; ?>
            </li>
            <li><label>学生年级:</label>
                <cite><?php echo ($arr["garde_name"]); ?></cite>
            </li>
            <li><label>学生电话:</label><cite><?php echo ($arr["students_tel"]); ?></cite></li>
            <li><label>学生学校:</label><cite><?php echo ($arr["students_school"]); ?></cite></li>
            <li><label>家长姓名:</label><cite><?php echo ($arr["students_patriarch"]); ?></cite></li>
            <li><label>家长电话:</label><cite><?php echo ($arr["patriarch_tel"]); ?></cite></li>
            <li><label>家庭住址:</label><cite><?php echo ($arr["students_home"]); ?></cite></li>
            <li><label>授权码:</label><cite><?php echo ($arr["students_accredit"]); ?></cite></li>
            <!--<li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>-->
        </ul>
    </form>

</div>
</body>
</html>