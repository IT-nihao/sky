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
        <li><a href="#">账户充值</a></li>
    </ul>
</div>

<div class="formbody">
    <div class="formtitle"><span>账户充值</span></div>
    <form action="<?php echo U('Pay/pay_add');?>" method="post">
        <ul class="forminfo">
            <input type="text" name="user_id" value="<?php echo ($user["user_id"]); ?>">
            <li><label>充值账户：</label><input name="user_account" type="text" class="dfinput" value="<?php echo ($user["user_account"]); ?>" disabled/></li>
            <li><label>充值金额：</label><input name="partner_money" type="text" class="dfinput" /></li>
            <li><label>返点金额：</label><input name="partner_rebate" type="text" class="dfinput" /></li>
            <li><label>操作人</label><input name="pay_operator" type="text" class="dfinput" /></li>
            <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
        </ul>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
//    $(function(){
//        $(document).on("change",".aaaa",function(){
//            var object = $(this);
//            var region_id = $(this).val();
//            if(region_id==0){
//                return false;
//            }
//            $.ajax({
//                type:"get",
//                url:"<?php echo U('store/region');?>?region_id="+region_id,
//                dataType:'json',
//                success:function(res){
//                    if(res.err==0){
//                        return false;
//                    }
//                    object.parent().find('#detailed').remove();
//                    getstr(res.region,object)
//                }
//            })
//        })
//        function getstr(res,object){
//            var str = ' <select name="address[]" id="" class="aaaa dfinput" style="width: 100px;"><option value="0">请选择</option>';
//            $.each(res,function(k,v){
//                str+='<option value="'+v.region_id+'">'+v.region_name+'</option>';
//            })
//            str+='</select>';
//            object.next().remove();
//            object.after(str);
//        }
//    })
</script>