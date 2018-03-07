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
    <li><a href="#">权限修改</a></li>
    </ul>
    </div>

    <div class="formbody">

    <div class="formtitle"><span>权限修改</span></div>
        <form action="<?php echo U('Power/power_update');?>" method="post">
    <ul class="forminfo">
        <input type="hidden" name="power_id" value="<?php echo ($update["power_id"]); ?>">
    <li><label>权限名称</label><input name="power_name" type="text" class="dfinput" value="<?php echo ($update["power_name"]); ?>" /> </li>
    <li><label>控制器名称</label><input name="power_controller" value="<?php echo ($update["power_controller"]); ?>" type="text" class="dfinput" /> </li>
    <li><label>方法名称</label><input name="power_action" value="<?php echo ($update["power_action"]); ?>" type="text" class="dfinput" /> </li>
    <li><label>是否显示</label><cite>
        <?php if($update['power_status'] == 1): ?><input name="power_status" type="radio" value="1" checked="checked"/>是&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="power_status" type="radio" value="0" />否</cite></li>
        <?php else: ?>
        <input name="power_status" type="radio" value="1" />是&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="power_status" type="radio" value="0" checked="checked"/>否</cite></li><?php endif; ?>
    <li><label>权限分类</label><select name="power_pid" id="" class="dfinput">
        <option value="0">顶级分类</option>
        <?php if(is_array($select)): foreach($select as $key=>$vo): if($update['power_id'] == $select['power_id']): ?><option value="<?php echo ($vo["power_id"]); ?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo['level']); echo ($vo["power_name"]); ?></option>
            <?php else: ?>
                <option value="<?php echo ($vo["power_id"]); ?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo['level']); echo ($vo["power_name"]); ?></option><?php endif; endforeach; endif; ?>
    </select></li>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
        </form>

    </div>
</body>
</html>