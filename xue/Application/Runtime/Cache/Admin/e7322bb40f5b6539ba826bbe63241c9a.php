<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jquery-1.8.2.min.js" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/xianshang/Public/Admin/js/jquery-1.8.2.min.js"></script>
</head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">分销商修改</a></li>
    </ul>
</div>

<div class="formbody">
    <div class="formtitle"><span>分销商修改</span></div>
    <form action="<?php echo U('Partner/partner_update');?>" method="post">
        <ul class="forminfo">
            <input type="hidden" name="partner_id" value="<?php echo ($arr["partner_id"]); ?>">
            <li><label>分销商负责人</label><input name="partner_account" type="text" class="dfinput" value="<?php echo ($arr["partner_account"]); ?>" /><i>标题不能超过30个字符</i></li>
            <li><label>分销商身份证号</label><input name="partner_idcard" type="text" class="dfinput" value="<?php echo ($arr["partner_idcard"]); ?>"/><i>标题不能超过30个字符</i></li>
            <li><label>分销商电话</label><input name="partner_tel" type="text" class="dfinput" value="<?php echo ($arr["partner_tel"]); ?>" /><i>标题不能超过30个字符</i></li>
            <li><label>分销商家庭住址</label><input name="partner_home" type="text" class="dfinput" value="<?php echo ($arr["partner_home"]); ?>" /><i>多个关键字用,隔开</i></li>
            <li><label>分销商性别</label><cite>
                <?php if($arr['partner_sex'] == 1): ?><input name="partner_sex" value="1" type="radio" class=""  checked/>男
                    <input name="partner_sex" value="2" type="radio" class="" />女
                    <?php else: ?>
                    <input name="partner_sex" value="1" type="radio" class="" />男
                    <input name="partner_sex" value="2" type="radio" class="" checked/>女<?php endif; ?> <i>多个关键字用,隔开</i></cite>
            </li>
            <li><label>押金</label><input name="partner_money" type="text" class="dfinput" value="<?php echo ($arr["partner_money"]); ?>"  /><i>多个关键字用,隔开</i></li>
            <li><label>管辖校区</label><input name="partner_government" type="text" class="dfinput" value="<?php echo ($arr["partner_government"]); ?>"  /><i>多个关键字用,隔开</i></li>
            <li><label>详细地址</label><input name="detailed_address" type="text" class="dfinput" value="<?php echo ($arr["detailed_address"]); ?>"  /><i>多个关键字用,隔开</i></li>
            <li><label>分销商地区</label>
                <select name="address[]" id="" class="aaaa dfinput" style="width: 100px;">
                    <option value="0">请选择</option>
                    <?php if(is_array($region)): foreach($region as $key=>$vo): ?><option value="<?php echo ($vo["region_id"]); ?>"><?php echo ($vo["region_name"]); ?></option><?php endforeach; endif; ?>
                </select></li>
            <li><label>操作人</label><input name="partner_operator" type="text" class="dfinput" /><i>多个关键字用,隔开</i></li>
            <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
        </ul>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    $(function(){
        $(document).on("change",".aaaa",function(){
            var object = $(this);
            var region_id = $(this).val();
            if(region_id==0){
                return false;
            }
            $.ajax({
                type:"get",
                url:"<?php echo U('Partner/region');?>?region_id="+region_id,
                dataType:'json',
                success:function(res){
                    if(res.err==0){
                        return false;
                    }
                    object.parent().find('#detailed').remove();
                    getstr(res.region,object)
                }
            })
        })
        function getstr(res,object){
            var str = ' <select name="address[]" id="" class="aaaa dfinput" style="width: 100px;"><option value="0">请选择</option>';
            $.each(res,function(k,v){
                str+='<option value="'+v.region_id+'">'+v.region_name+'</option>';
            })
            str+='</select>';
            object.next().remove();
            object.after(str);
        }
    })
</script>