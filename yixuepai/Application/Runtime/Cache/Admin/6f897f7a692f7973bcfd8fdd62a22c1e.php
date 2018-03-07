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
    <li><a href="#">角色修改</a></li>
    </ul>
    </div>

    <div class="formbody">

    <div class="formtitle"><span>角色修改</span></div>
        <form action="<?php echo U('Role/role_update');?>" method="post">
    <ul class="forminfo">
        <input type="text" name="power_id" value="<?php echo ($update["power_id"]); ?>">
    <li><label>角色名称</label><input name="role_name" type="text" class="dfinput" value="<?php echo ($role["role_name"]); ?>" /></li>
    <li><label>角色介绍</label><input name="role_depict" value="<?php echo ($role["role_depict"]); ?>" type="text" class="dfinput" /></li>
        <input type="hidden" value="<?php echo ($_GET['role_id']); ?>" name="role_id">
        <li><label>角色所拥有权限</label>
            <cite>
                <table>
                    <?php if(is_array($show)): foreach($show as $key=>$vo): ?><tr>
                            <?php if($vo['checked'] == 1 ): ?><td><input type="checkbox" name="yixue_power_id[]" value="<?php echo ($vo["power_id"]); ?>" class="parent" checked><?php echo ($vo["power_name"]); ?></td>
                                <?php else: ?>
                                <td><input type="checkbox" name="yixue_power_id[]" value="<?php echo ($vo["power_id"]); ?>" class="parent"><?php echo ($vo["power_name"]); ?></td><?php endif; ?>
                            <td>
                                <?php if(is_array($vo['child'])): foreach($vo['child'] as $key=>$v): if($v['checked'] == 1 ): ?><input type="checkbox" name="yixue_power_id[]" value="<?php echo ($v["power_id"]); ?>" class="son" checked><?php echo ($v["power_name"]); ?>
                                        <?php else: ?>
                                        <input type="checkbox" name="yixue_power_id[]" value="<?php echo ($v["power_id"]); ?>" class="son"><?php echo ($v["power_name"]); endif; endforeach; endif; ?>
                            </td>
                        </tr><?php endforeach; endif; ?>
                </table>

        <li>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
        </form>

    </div>
</body>
</html>