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
<body>
<style>
    .box{
        width: 289px;
        height: 300px;
        /*margin-left: 28px;*/
        float: left;
        margin-top: 10px;
    }
    #max{
        width:1100px;
        height: 1500px;
    }
    .tab{
        width: 288px;
        height: 59px;
    }
    .word{
        border:1px solid black;
        font-size:18px;
        font-family:;
        width:140px;
        height:55px;
        float: left;
        text-align: center;
        line-height:59px;
    }
    .mean{
        border:1px solid black;
        font-size:18px;
        width:140px;
        height:55px;
        float: left;
        text-align: center;
        line-height:59px;
    }
    .vword{
         font-size: 18px;
         font-weight:bold;
     }
    .vmean{
        font-size: 18px;
        font-weight:lighter ;
    }
    .xinxi{
        float: left;

        width:1100px;
        height:50px;

    }
    .xixi{
        /*float: left;*/
        /*margin-left: 60px;*/
        font-size: 23px;
        font-weight:bold;
    }
    .xixis{
        /*float: left;*/
        margin-left: 150px;
        font-size: 23px;
        font-weight:bold;
    }
    .title{
        width:1100px;
        height:80px;
        float: left;
        margin-left: 485px;
        font-size: 28px;
        font-weight:bold;
    }
    .hide_word{
        margin-left:60px;
        width: 290px;
        height:50px;
        line-height: 50px;
        border-radius: 5px;
        background: #e1e1e8;
    }
    .hide_mean{
        width: 290px;
        height:50px;
        line-height: 50px;
        border-radius: 5px;
        background: #e1e1e8;
    }
    .print-link{
        width: 290px;
        height:50px;
        line-height: 50px;
        border-radius: 5px;
        background: #e1e1e8;
    }
    .hr{
        width: 1100px;
        height:2px;
        float: left;
        /*background: black;*/
        border: 1px solid black;
    }
</style>
<div>

</div>
<div id="max">
    <button class="hide_word no-print">隐藏单词</button>
    <!--<div class="operator">-->
        <button class="print-link no-print">
            打印
        </button>
    <!--<hr />-->
    <!--</div>-->
    <button class="hide_mean no-print">隐藏意思</button>

    <div class="title">生词本单词</div>

    <div class="xinxi"><font class="xixi">姓名:<?php echo ($students_name["students_name"]); ?></font><font class="xixis">助教:</font><font class="xixis">时间:</font><font class="xixis">成绩:</font></div>
    <!--<hr />-->
    <div class="hr"></div>
    <?php if(is_array($word)): foreach($word as $key=>$vo): ?><div class='box'>
        <?php if(is_array($vo)): foreach($vo as $key=>$v): ?><div class="tab">
                <div class="word"><font class="vword"><?php echo ($v["word"]); ?></font></div>
                <div class="mean"><font class="vmean"><?php echo ($v["mean"]); ?></font></div>
            </div><?php endforeach; endif; ?>

    </div><?php endforeach; endif; ?>

</div>
</body>
</html>
<script>
    $(function(){
        $("#max").find('.print-link').on('click', function() {
            //Print ele2 with default options
            $.print("#max");
        });
//        $(".hide_word").click(function(){
//            var html = $(".word").html();
//            $(".word").hide(html)
//        })
        $(document).ready(function(){
            $(".hide_word").click(function(){
                $(".vword").toggle();
            });
        });
        $(document).ready(function(){
            $(".hide_mean").click(function(){
                $(".vmean").toggle();
            });
        });
    })
</script>