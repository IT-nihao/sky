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
        <li><a href="#">学生修改</a></li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>学生修改</span></div>
    <form action="<?php echo U('students/students_update');?>" method="post">
        <ul class="forminfo">
            <input type="hidden" value="<?php echo ($arr["students_id"]); ?>" name="students_id">
            <li><label>学生姓名</label><input name="students_name" type="text" value="<?php echo ($arr["students_name"]); ?>" class="dfinput" /></li>
            <li><label>学生性别</label>
                <?php if($arr['students_sex'] == 1): ?><cite><input name="students_sex" value="1" type="radio" class="" checked />男
                        <input name="students_sex" value="0" type="radio" class="" />女</cite>
                    <?php else: ?>
                    <cite><input name="students_sex" value="1" type="radio" class=""  />男
                        <input name="students_sex" value="0" type="radio" class="" checked/>女</cite><?php endif; ?>
            </li>
            <li><label>学生年级</label>
                <select name="students_garde" id="" class="dfinput">
                    <option value="">请选择</option>
                    <?php if(is_array($garde)): foreach($garde as $key=>$vo): ?><option value="<?php echo ($vo["garde_id"]); ?>"><?php echo ($vo["garde_name"]); ?></option><?php endforeach; endif; ?>
                </select>
            </li>
            <li><label>学生电话</label><input name="students_tel" value="<?php echo ($arr["students_tel"]); ?>" type="text" class="dfinput" /></li>
            <li><label>学生学校</label><input name="students_school" value="<?php echo ($arr["students_school"]); ?>" type="text" class="dfinput" /></li>
            <li><label>家长姓名</label><input name="students_patriarch" value="<?php echo ($arr["students_patriarch"]); ?>" type="text" class="dfinput" /> </li>
            <li><label>家长电话</label><input name="patriarch_tel" value="<?php echo ($arr["patriarch_tel"]); ?>" type="text" class="dfinput" /> </li>
            <li><label>家庭住址</label><input name="students_home" value="<?php echo ($arr["students_home"]); ?>" type="text" class="dfinput" /> </li>
            <li><label>授权码</label>
                <select name="students_accredit" id="" class="dfinput">
                    <option value="">请选择</option>
                    <?php if(is_array($code)): foreach($code as $key=>$vo): ?><option value="<?php echo ($vo["partner_code"]); ?>"><?php echo ($vo["partner_account"]); ?></option><?php endforeach; endif; ?>
                </select>
            </li>
            <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
        </ul>
    </form>

</div>
</body>
</html>