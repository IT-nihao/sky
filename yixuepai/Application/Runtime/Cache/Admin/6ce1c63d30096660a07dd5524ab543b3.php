<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jquery-1.8.2.min.js" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jQuery.print.js" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/html5-3.6-respond-1.1.0.min.js" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/xianshang/Public/Admin/js/jquery.js"></script>
    <script src="/xianshang/Public/Admin/js/jquery-1.8.2.min.js"></script>

    <script src="/xianshang/Public/Admin/js/jquery.printarea.js"></script>
    <script src="/xianshang/Public/Admin/js/jQuery.print.js"></script>
    <script src="/xianshang/Public/Admin/js/html5-3.6-respond-1.1.0.min.js"></script>
</head>

<style>
    div{
        font-size: 18px;
    }
    .text{
        width:1100px;
        float: left;
        text-indent:2em;
        line-height: 40px;
        margin-top: 20px;
    }
    .biaoti{
        font-size: 18px;
        float: left;
        width:1000px;
        height: 20px;
    }
    .xuanxiang{
        float: left;
        width:1100px;
        height: 30px;
        /*line-height: 70px;*/
    }
    font{
        float: left;
        margin-left: 180px;
        font-size: 20px;
    }
    #ddd{

        width:1100px;
        height: 1000px;
        /*background: red;*/
    }
    .xuan{
        margin-left:75px;
        /*border:1px solid #F00;*/
        width: 1100px;
        height:200px;
        float: left;
        /*margin-top:60px;*/
        /*background: yellow;*/
    }
    .xinxi{
        width:1100px;
        /*font-size: 30px;*/
    }
    .biaoti{
        font-size: 25px;
        float: left;
        width:1100px;
        height:50px;
    }
    .biaotis{
        font-size: 18px;
        float: left;
        width:1100px;
        height:50px;
        line-height: 50px;
    }
    .title{
        margin-top: 20px;
        float: left;
        width:1100px;
    }
    .kuai{
        float: left;
        width:1100px;
        height:150px;
        margin-top: 10px;
        margin-left:65px;
    }
</style>
<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">文章查看</a></li>
    </ul>
    <div class="operator">
        <button class="print-link no-print">
            打印
        </button>
    </div>

</div>

<div class="formbody">

    <div class="formtitle"><span>文章查看</span></div>
    <!--<form action="<?php echo U('Read/read_update');?>" method="post">-->

    <div id="ddd">
        <center><div class="biaoti">阅读星级：<?php echo ($arr["read_difficulty_id"]); ?>星&nbsp;&nbsp;&nbsp;&nbsp;
            建议时间:<?php echo ($arr["read_time"]); ?>分钟&nbsp;&nbsp;&nbsp;&nbsp;
            文章类型：<?php if($arr['read_type_id'] == 1): ?>阅读理解
            <?php else: ?>
            完形填空<?php endif; ?>
        </div>
            <div class="xinxi"><font>姓名:<?php echo ($students_name["students_name"]); ?></font>
                <font>助教:</font>
                <font>时间:</font>
                <font>成绩:</font>
            </div>
            <div class="title"><?php echo ($arr["read_title"]); ?></div></center>
        <div class="text"><?php echo ($arr["read_text"]); ?></div>
        <?php if(is_array($crr)): foreach($crr as $k=>$vv): ?><div class="xuan">
                <?php if($arr['read_type_id'] == 1): ?><div class="biaotis">题目<?php echo ($k+1); ?>：<?php echo ($vv["topic_timu"]); ?></div>
                    <?php else: ?>
                    <div class="xuanxiang">标题:<?php echo ($vv["topic_timu"]); ?></div><?php endif; ?>
                <div class="kuai">
                <div class="xuanxiang">A、<?php echo ($vv['daan'][0]['topic_text']); ?>；</div >
                <div class="xuanxiang">B、<?php echo ($vv['daan'][1]['topic_text']); ?>；</div>
                <div class="xuanxiang">C、<?php echo ($vv['daan'][2]['topic_text']); ?>；</div>
                <div class="xuanxiang">D、<?php echo ($vv['daan'][3]['topic_text']); ?></div>
                </div>
            </div><?php endforeach; endif; ?><li>

    </div>


    </li>
    </ul>

    <!--</form>-->

</div>
</body>
</html>
<script language="javascript">
    $(function(){
//        $("#ddd").find('.print-link').on('click', function() {
//            //Print ele2 with default options
//            $.print("#ddd");
//        });
        $(".print-link").click(function(){
            $.print("#ddd");
        })
    })
</script>