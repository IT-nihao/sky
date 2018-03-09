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
        <li><a href="#">学生添加</a></li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>文章修改</span></div>
    <form action="<?php echo U('Read/read_update');?>" method="post">

        <ul class="forminfo">
            <li><label>文章内容</label>
                <input type="hidden" value="<?php echo ($arr["read_level_id"]); ?>" name="read_level_id">
                <input type="hidden" value="<?php echo ($arr["read_type_id"]); ?>" name="read_type_id">
                <textarea name="read_text" class=""><?php echo ($arr["read_text"]); ?></textarea>
                </li>
            <li>
            <li><label>建议答题时间</label>
                <input name="read_time" value="<?php echo ($arr["read_time"]); ?>" type="text" class="dfinput" /><i>请输入数字，例如：五分钟，输入数字5即可</i>
                </li>
            <li><label>文章类型</label>
                <select name="read_type_id" class="dfinput type_id">
                    <?php if($arr['read_type_id'] == 1): ?><option value="">请选择</option>
                    <option value="1" selected>阅读理解</option>
                    <option value="2">完型填空</option>
                        <?php else: ?>
                        <option value="">请选择</option>
                        <option value="1">阅读理解</option>
                        <option value="2" selected>完型填空</option><?php endif; ?>
                </select>
            </li>
            <li><label>文章教材</label>
                <select name="read_textbook_id" class="dfinput textbook_id">
                    <option value="">请先选择文章类型</option>
                </select>
            </li>
            <li><label>文章关卡</label>
                <select name="read_level_id" class="dfinput level_id">
                    <option value="">请先选择文章所属教材</option>
                    <!--</foreach>-->
                </select>
            </li>
            <li><label>文章难度</label>
                <select name="read_difficulty_id" class="dfinput">
                    <option value="">请选择</option>
                    <option value="1">一星</option>
                    <option value="2">二星</option>
                    <option value="3">三星</option>
                    <option value="4">四星</option>
                    <option value="4">五星</option>
                    <!--</foreach>-->
                </select>
            </li>
            <li><label>文章标题</label>
                <cite><input name="read_title" value="<?php echo ($arr["read_title"]); ?>" type="text" class="dfinput" /></cite></li>
            <?php if(is_array($crr)): foreach($crr as $k=>$vv): ?><li>

                <label class="jiass"><font class="jian"></font>题目 &nbsp;<font class="ti"><?php echo ($k+1); ?></font></label>
                <input name="topic_timu[]" type="text" value="<?php echo ($vv["topic_timu"]); ?>" class="dfinput" />
                <!--<cite>-->
                <table style="border-collapse:separate; border-spacing:0px 13px;" border="1" cellspacing="10" class="tabless">
                    <tr>
                        <td>A、</td>
                        <td><input style="width: 172px; height: 32px;" name="topic_text[]" type="text" value="<?php echo ($vv['daan'][0]['topic_text']); ?>" class="dfinput" /></td>
                        <input style="width: 172px;height: 32px;" name="read_id[]" value="<?php echo ($vv['daan'][0]['read_id']); ?>" type="hidden" class="dfinput" />

                        <td>B、</td>
                        <td><input style="width: 172px;height: 32px;" name="topic_text[]" type="text" value="<?php echo ($vv['daan'][1]['topic_text']); ?>" class="dfinput" /></td>
                        <input style="width: 172px;height: 32px;" name="read_id[]" value="<?php echo ($vv['daan'][1]['read_id']); ?>" type="hidden" class="dfinput" />

                    </tr>
                    <tr>
                        <td>C、</td>
                        <td><input style="width: 172px;height: 32px;" name="topic_text[]" type="text" value="<?php echo ($vv['daan'][2]['topic_text']); ?>" class="dfinput" /></td>
                        <input style="width: 172px;height: 32px;" name="read_id[]" value="<?php echo ($vv['daan'][2]['read_id']); ?>" type="hidden" class="dfinput" />

                        <td>D、</td>
                        <td><input style="width: 172px;height: 32px;" name="topic_text[]" type="text" value="<?php echo ($vv['daan'][3]['topic_text']); ?>" class="dfinput" /></td>
                        <input style="width: 172px;height: 32px;" name="read_id[]" value="<?php echo ($vv['daan'][3]['read_id']); ?>" type="hidden" class="dfinput" />

                    </tr>
                    <?php
 foreach($vv['daan'] as $vv){?>
                        <?php if($vv['yes_no']==1){?>
                    <tr>
                        <td>正确答案</td>
                        <td>
                            <input style="width: 172px;height: 32px;" name="yes_no[]" value="<?php echo $vv['topic_text']?>" type="text" class="dfinput" />
                        </td>
                    </tr>

                    <!--<td>正确答案</td>-->
                    <!--<?php if(is_array($$vv['daan'])): foreach($$vv['daan'] as $kk=>$v): ?>-->
                        <!--<?php if($vv['daan'][$kk]['yes_no'] == 1): ?>-->
                            <!--<td><input style="width: 172px;height: 32px;" name="yes_no[]" value="<?php echo ($vv['daan'][$kk]['topic_text']); ?>" type="text" class="dfinput" /></td>-->
                            <!--<?php else: ?>-->
                            <!--<td><input style="width: 172px;height: 32px;" name="yes_no[]" value="<?php echo ($vv['daan'][$kk]['topic_text']); ?>" type="text" class="dfinput" /></td>-->
                        <!--<?php endif; ?>-->
                    <!--<?php endforeach; endif; ?>-->
                    <tr>
                        <td>详细解析</td>
                        <td><textarea name="topic_spell[]" type="text" class=""><?php echo $vv['topic_spell']?></textarea></td>
                    </tr>
                    <?php }?>
                    <?php }?>
                </table><?php endforeach; endif; ?><li>
            </li>


            <!--<li><label>学生电话</label>-->
            <!--<input name="students_tel" type="text" class="dfinput" /><i>多个关键字用,隔开</i></li>-->
            <!--<li><label>学生学校</label><input name="students_school" type="text" class="dfinput" /><i>多个关键字用,隔开</i></li>-->
            <!--<li><label>家长姓名</label><input name="students_patriarch" type="text" class="dfinput" /><i>多个关键字用,隔开</i></li>-->
            <!--<li><label>家长电话</label><input name="patriarch_tel" type="text" class="dfinput" /><i>多个关键字用,隔开</i></li>-->
            <!--<li><label>家庭住址</label><input name="students_home" type="text" class="dfinput" /><i>多个关键字用,隔开</i></li>-->
            <!--<li><label>授权码</label><input name="students_accredit" type="text" class="dfinput" /><i>多个关键字用,隔开</i></li>-->
            <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
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
    $(function(){
        $(document).on("change",".type_id",function(){
            var object = $(".textbook_id");
            var type_id = $(this).val();
            $.ajax({
                type:"post",
                url:"<?php echo U('Read/read_textbook');?>",
                data:{
                    type_id:type_id,
                },
                dataType:"json",
                success:function(res){
                    var str = ' <select name="textbook_id" class="dfinput"><option value="">请先选择文章所属教材</option>';
                    $.each(res,function(k,v){
                        str+='<option value="'+v.textbook_id+'">'+v.textbook_name+'</option>';
                    })
                    str+='</select>';
                    object.html(str);
                }
            })
            $(".textbook_id").change(function(){
                var object = $(".level_id");
                var textbook_id = $(this).val();
//                alert(textbook_id)
                $.ajax({
                    type:"post",
                    url:"<?php echo U('Read/read_level');?>",
                    data:{
                        textbook_id:textbook_id,
                    },
                    dataType:"json",
                    success:function(res){
                        var str = ' <select name="read_level_id" class="dfinput textbook_id"><option value="">请选择</option>';
                        $.each(res,function(k,v){
                            str+='<option value="'+v.level_id+'">'+v.level_name+'</option>';
                        })
                        str+='</select>';
                        object.html(str);
                    }
                })
            })
        })
    })
</script>
</html>