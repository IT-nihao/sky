<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/xianshang/Public/Admin/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=7F5AYnFpz4ZsOC0ZjWW11SLn5GMijUlL"></script>

</head>
<style>
    /*#map1_container,#map2_container {width:100%;height:50%;float:left;overflow: hidden;margin:0;}*/
    /*#allmap1{margin:0 0 3px;height:100%;}*/
    /*#allmap2{margin:3px 0 0;height:100%;}*/
    .forminfo{
        width:500px;
        float: left;
    }
    #allmap{
        float: left;
        width:1300px;
        height:700px;
        background: red;
    }
    /*#map2_container{*/
        /*float: left;*/
        /*width:1300px;*/
        /*height:350px;*/
        /*background: red;*/
    /*}*/
</style>
<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">管理员添加</a></li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>管理员添加</span></div>
    <form action="<?php echo U('user/user_add');?>" method="post">
        <ul class="forminfo">
            <li><label>校区名称</label><input name="user_account" type="text" class="dfinput" /></li>
            <li><label>校区负责人</label><input name="partner_account" type="text" class="dfinput" /></li>
            <li><label>校区电话</label><input name="partner_tel" type="text" class="dfinput" /></li>
            <li><label>校区身份证号</label><input name="partner_idcard" type="text" class="dfinput" /></li>
            <li><label>上级机构</label>
                <select name="user_pid" class="dfinput" style="width: 100px;">
                    <option value="0">请选择</option>
                    <?php if(is_array($next)): foreach($next as $key=>$vo): ?><option value="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["partner_account"]); ?></option><?php endforeach; endif; ?>
                </select>
            </li>

            <li><label>校区性别</label><cite><input name="partner_sex" value="1" type="radio" class="" />男
                <input name="partner_sex" value="2" type="radio" class="" />女</cite></li>
            <li><label>用户角色</label>
                <cite>
                    <table>
                        <?php if(is_array($show)): foreach($show as $key=>$vo): ?><td><td><input name="role_name[]" value="<?php echo ($vo["role_id"]); ?>" type="checkbox" class="" /><?php echo ($vo["role_name"]); ?></td><?php endforeach; endif; ?></td>
                    </table>
            <li>
            <li><label>校区地区</label>
                <select name="address[]" id="" class="aaaa dfinput" style="width: 100px;">
                    <option value="0">请选择</option>
                    <?php if(is_array($region)): foreach($region as $key=>$vo): ?><option value="<?php echo ($vo["region_id"]); ?>"><?php echo ($vo["region_name"]); ?></option><?php endforeach; endif; ?>
                </select></li>
            <li><label>详细地址</label><input name="detailed_address" id="cityName" type="text" class="dfinput addresss"/></li>
            <li><label>登陆密码</label><input name="user_pwd" type="text" value="123456" class="dfinput" /></li>
            <li><label>开课密码</label><input name="open_pwd" type="text" value="123456" class="dfinput" /></li>
            <li><label>财务密码</label><input name="finance_pwd" type="text" value="123456" class="dfinput" /></li>
            <li><label>有效期</label><input name="start_time" type="date" class="dfinput" style="width: 170px;"/>-<input name="end_time" type="date" class="dfinput" style="width: 170px;" /></li>
            <li><label>操作人</label><input name="partner_operator" type="text" class="dfinput" /></li>
            <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
        </ul>

        <div id="allmap"></div>

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
    $(function(){
        var map = new BMap.Map("allmap");
        map.centerAndZoom(new BMap.Point(116.4035,39.915),8);
        map.enableScrollWheelZoom(true);
        setTimeout(function(){
            map.setZoom(14);
        }, 2000);  //2秒后放大到14级
        map.enableScrollWheelZoom(true);

        $.ajax({
            type:"post",
            url:"<?php echo U('User/address_lnt');?>",
            data:{
            },
            dataType:"json",
            success:function(r){
                $.each(r,function(k,v){
                    var point = new BMap.Point(v.address_lng, v.address_lat);
                    map.centerAndZoom(point, 15);
                    var circle = new BMap.Circle(point,v.address_scope,{strokeColor:"#9A32CD", strokeWeight:2, strokeOpacity:0.5}); //创建圆
                    //添加覆盖物
                    map.addOverlay(circle);
                })
            }
        })
        $("#cityName").mouseout(function(){
            var city = $(this).val();
            $.ajax({
                type:"post",
                url:"<?php echo U('User/ssds');?>",
                data:{
                    address:city
                },
                dataType:"json",
                success:function(r){
                    alert(r.msg);
                    var lng = r.lng;
                    var lat = r.lat;
                    var marker = new BMap.Marker(new BMap.Point(lng,lat));
                    map.addOverlay(marker);    //增加点
                }
            })

            theLocation()
        })
        function theLocation(){
            var city = document.getElementById("cityName").value;
            if(city != ""){
                map.centerAndZoom(city,11);      // 用城市名设置地图中心点
            }
        }
//        $(".addresss").click(function(){
//            var address = $(this).val();
//            $.ajax({
//                type:"post",
//                url:"<?php echo U('User/ssds');?>",
//                data:{
//                    address:address,
//                },
//                dataType:"json",
//                success:function(r){
////                    alert(r)
//
//                }
//            })
//        })
    })
</script>