<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style type="text/css">
            body, html{width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
            #allmap{height:550px;width:500px;}
            #r-result{width:100%;}
        </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=7F5AYnFpz4ZsOC0ZjWW11SLn5GMijUlL"></script>
    <script type="text/javascript" src="/xianshang/Public/Admin/js/jquery-1.8.2.min.js"></script>
        <title>添加/删除覆盖物</title>

</head>

<body>

<!--<div class="place">-->
    <!--<span>位置：</span>-->
    <!--<ul class="placeul">-->
        <!--<li><a href="#">首页</a></li>-->
        <!--<li><a href="#">地理位置添加</a></li>-->
    <!--</ul>-->
<!--</div>-->

<!--<div class="formbody">-->
    <!--<div class="formtitle"><span>地理位置添加</span></div>-->
    <!--<form action="<?php echo U('Address/address_add');?>" method="post">-->
        <!--<ul class="forminfo">-->
            <!--<li><label>地理位置名称</label><input name="address" type="text" class="dfinput" /><i>格式(省/市/区/县(乡)/街道)</i></li>-->
            <!--<li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>-->
        <!--</ul>-->
    <!--</form>-->
    <!--<span></span>-->
    <!--<li><label><input type="button" class="btn" onclick="add_overlay();" value="添加覆盖物" /></label>-->
    <!--<label><input type="button" class="btn" onclick="remove_overlay();" value="删除覆盖物" /></label></li>-->
<!--</div>-->
<div id="allmap"></div>
<div id="r-result">

</div>
</body>
</html>
<script type="text/javascript">
    $(function(){
        var map = new BMap.Map("allmap");
        map.centerAndZoom(new BMap.Point(116.4035,39.915),8);
        setTimeout(function(){
            map.setZoom(14);
        }, 2000);  //2秒后放大到14级
        map.enableScrollWheelZoom(true);
        $.ajax({
            type:"post",
            url:"<?php echo U('Address/address_lnt');?>",
            data:{},
            dataType:"json",
            success:function(r){
                alert(r);
                $.each(r,function(k,v){
                    var point = new BMap.Point(v.address_lng, v.address_lat);
                    map.centerAndZoom(point, 15);
                    var circle = new BMap.Circle(point,v.address_scope,{strokeColor:"#9A32CD", strokeWeight:2, strokeOpacity:0.5}); //创建圆
                    //添加覆盖物
                    map.addOverlay(circle);
                })
            }
        })
    })

    // 百度地图API功能
//    var map = new BMap.Map("allmap");
////    var point = new BMap.Point(116.401214, 39.915);
//    map.centerAndZoom(point, 15);
//    var circle = new BMap.Circle(point,250,{strokeColor:"blue", strokeWeight:2, strokeOpacity:0.5}); //创建圆
//    //添加覆盖物
////    function add_overlay(){
//        map.addOverlay(circle);            //增加圆
//    }
    //清除覆盖物
//    function remove_overlay(){
//        map.clearOverlays();
//    }
//    var map = new BMap.Map("allmap");

</script>