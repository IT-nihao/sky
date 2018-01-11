<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jquery-1.8.2.min.js" rel="stylesheet" type="text/css" />
    <!--<script type="text/javascript" src="/xianshang/Public/Admin/js/jquery.js"></script>-->
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">角色添加</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>角色添加</span></div>
        <form action="<?php echo U('Role/role_add');?>" method="post">
    <ul class="forminfo">
    <li><label>角色名称</label><input name="role_name" type="text" class="dfinput" /></li>
    <li><label>角色介绍</label><input name="role_depict" type="text" class="dfinput" /></li>
    <li><label>角色所拥有权限</label>
        <cite>
            <table>
                <?php if(is_array($show)): foreach($show as $key=>$vo): ?><tr>
                        <td><input type="checkbox" name="yixue_power_id[]" value="<?php echo ($vo["power_id"]); ?>" class="parent"><?php echo ($vo["power_name"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                        <td>
                            <?php if(is_array($vo['son'])): foreach($vo['son'] as $key=>$v): ?><input type="checkbox" name="yixue_power_id[]" value="<?php echo ($v["power_id"]); ?>" class="son"><?php echo ($v["power_name"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endforeach; endif; ?>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </table>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
        </form>
    
    </div>
</body>
</html>
<script>
    $(function(){
        $('.parent').click(function(){
            $(this).parent().next().find('.son').prop("checked",$(this).prop('checked'));
        })
        //子寻父
        $('.son').click(function(){
            if($(this).parent().find(":checked").size()){
                if($(this).parent().prev().find(".parent").prop("checked",true));
            }else{
                if($(this).parent().prev().find(".parent").prop("checked",false));
            }
        })
    })
</script>