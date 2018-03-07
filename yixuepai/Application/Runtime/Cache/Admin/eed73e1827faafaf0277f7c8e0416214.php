<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jquery-1.8.2.min.js" rel="stylesheet" type="text/css" />
</head>
<script src="/xianshang/Public/Admin/js/jquery-1.8.2.min.js"></script>
<style>
    .tabless{
        margin-left:65px;
    }
    textarea{
        height:200px;
        width:300px;
        border-top: solid 1px #a7b5bc;
        border-left: solid 1px #a7b5bc;
        border-right: solid 1px #ced9df;
        border-bottom: solid 1px #ced9df;
    }
</style>
<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">文章查看</a></li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>文章查看</span></div>
    <form action="<?php echo U('Read/read_update');?>" method="post">

        <ul class="forminfo">
            <li><label>文章内容:</label>
                <cite><?php echo ($arr["read_text"]); ?></cite></li>

            <label>建议答题时间:</label>
                <cite><?php echo ($arr["read_time"]); ?>分钟</cite>

            <li><label>文章类型:</label>
                    <?php if($arr['read_type_id'] == 1): ?><cite>阅读理解</cite>
                        <?php else: ?>
                        <cite>完形填空</cite><?php endif; ?>
            </li>
            <li><label>文章标题:</label>
                <cite><?php echo ($arr["read_title"]); ?></cite></li>
            <?php if(is_array($crr)): foreach($crr as $k=>$vv): ?><li>
                    <table style="border-collapse:separate; border-spacing:0px 13px;" border="1" cellspacing="10" class="tabless">
                        <?php if($arr['read_type_id'] == 1): ?><label class="jiass"><span style="width: 1000px">标题<?php echo ($k+1); ?>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo ($vv["topic_timu"]); ?></span></label>
                            <?php else: ?>
                            <label class="jiass"><span style="width: 1000px">标题:<?php echo ($vv["topic_timu"]); ?></span></label><?php endif; ?>
                    <cite></cite>
                    <!--<cite>-->
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>A、</td>
                            <td><?php echo ($vv['daan'][0]['topic_text']); ?></td>
                            <td>B、</td>
                            <td><?php echo ($vv['daan'][1]['topic_text']); ?></td>
                        </tr>
                        <tr>
                            <td>C、</td>
                            <td><?php echo ($vv['daan'][2]['topic_text']); ?></td>
                            <td>D、</td>
                            <td><?php echo ($vv['daan'][3]['topic_text']); ?></td>
                        </tr>
                        <?php
 foreach($vv['daan'] as $vv){?>
                        <?php if($vv['yes_no']==1){?>
                        <tr>
                            <td>正确答案:</td>
                            <td>
                                <?php echo $vv['topic_text']?>
                            </td>
                        </tr>
                        <tr>
                            <td>详细解析:</td>
                            <td><?php echo $vv['topic_spell']?></td>
                        </tr>
                        <?php }?>
                        <?php }?>
                    </table><?php endforeach; endif; ?><li>
        </li>
        </ul>
    </form>

</div>
</body>
<script>
    $(function(){
        var v= $('.ti').html();
        var font = parseInt(v);
        $(".jiass").click(function(){
            font++;
            var clone = $(this).parent();
            clone.after(clone.clone());
            clone.next().find('font').html(font);
            clone.next().find('.jian').html('[-]').attr('class','j');
            $(".j").click(function(){
                var jian = $(this).parent();
                $(this).parent().parent().remove();
            })
        })


    })
</script>
</html>