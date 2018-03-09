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
        <li><a href="#">管理员修改</a></li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>管理员修改</span></div>
    <form action="<?php echo U('users/users_update');?>" method="post">
        <input type="hidden" name="user_id" value="<?php echo ($user["user_id"]); ?>">
        <ul class="forminfo">
            <li><label>管理员账号</label><input name="user_account" type="text" class="dfinput" value="<?php echo ($user["user_account"]); ?>" /></li>
            <li><label>管理员密码</label><input name="user_pwd" type="text" class="dfinput" value="<?php echo ($user["user_pwd"]); ?>" /></li>
            <li><label>用户角色</label>
                <cite>
                    <table>
                        <?php if(is_array($role)): foreach($role as $key=>$vo): ?><td>
                                <?php if($vo['checked'] == 1): ?><td><input name="yixue_role_id[]" value="<?php echo ($vo["role_id"]); ?>" type="checkbox" class="" checked /><?php echo ($vo["role_name"]); ?></td>
                            <?php else: ?>
                            <td><input name="yixue_role_id[]" value="<?php echo ($vo["role_id"]); ?>" type="checkbox" class="" /><?php echo ($vo["role_name"]); ?></td><?php endif; ?>
                            </td><?php endforeach; endif; ?>
                    </table>
            <li>

            <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
        </ul>
    </form>

</div>
</body>
</html>