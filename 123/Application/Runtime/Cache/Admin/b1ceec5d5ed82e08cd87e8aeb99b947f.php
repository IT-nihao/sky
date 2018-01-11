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
    <li><a href="#">权限添加</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>权限添加</span></div>
        <form action="<?php echo U('Power/power_add');?>" method="post">
    <ul class="forminfo">
    <li><label>权限名称</label><input name="power_name" type="text" class="dfinput" /> </li>
    <li><label>控制器名称</label><input name="power_controller" type="text" class="dfinput" /> </li>
    <li><label>方法名称</label><input name="power_action" type="text" class="dfinput" /> </li>
    <li><label>是否显示</label><cite><input name="power_status" type="radio" value="1" checked="checked" />是&nbsp;&nbsp;&nbsp;&nbsp;<input name="power_status" type="radio" value="0" />否</cite></li>
    <li><label>权限分类</label><select name="power_pid" id="" class="dfinput">
        <option value="0">顶级分类</option>
        <?php if(is_array($select)): foreach($select as $key=>$vo): ?><option value="<?php echo ($vo["power_id"]); ?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$vo['level']); echo ($vo["power_name"]); ?></option><?php endforeach; endif; ?>
    </select></li>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
        </form>
    
    </div>
</body>
</html>