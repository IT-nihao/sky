<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>网站后台管理系统HTML模板--模板之家 www.cssmoban.com</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/css/page1.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jquery-1.8.2.min.js" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/xianshang/Public/Admin/js/jquery.js"></script>
    <script src="/xianshang/Public/Admin/js/jquery-1.8.2.min.js"></script>
    <script src="http://files.cnblogs.com/mofish/md5.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".click").click(function(){
                $(".tip").fadeIn(200);
            });

            $(".tiptop a").click(function(){
                $(".tip").fadeOut(200);
            });

            $(".sure").click(function(){
                $(".tip").fadeOut(100);
            });

            $(".cancel").click(function(){
                $(".tip").fadeOut(100);
            });

        });
    </script>


</head>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">学生列表</a></li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <li class="click"><span><img src="/xianshang/Public/Admin/images/t01.png" /></span><a href="<?php echo U('students_add');?>">添加</a></li>
        </ul>

        <form action="<?php echo U('Students/students_list');?>" method="get">
            <input name="students_name" type="text" class="dfinput" placeholder="请在这里输入学生姓名..." />
            <input name="students_tel" type="text" class="dfinput" placeholder="请在这里输入学生电话..." />
            <input name="students_home" type="text" class="dfinput" placeholder="请在这里输入学生家庭住址..." />
            <select name="students_accredit" id="" class="aaaa dfinput" style="width: 100px;">
                <option value="">请选择</option>
                <?php if($id == 8): if(is_array($partner_code)): foreach($partner_code as $key=>$vo): ?><option value="<?php echo ($vo["partner_code"]); ?>"><?php echo ($vo["partner_account"]); ?></option><?php endforeach; endif; ?>
                    <?php else: ?>
                    <?php if(is_array($partner_code)): foreach($partner_code as $key=>$vo): ?><option value="<?php echo ($vo["partner_code"]); ?>"><?php echo ($vo["partner_account"]); ?></option><?php endforeach; endif; endif; ?>

            </select>
            <input name="" type="submit" class="btn" value="搜索"/>
        </form>
    </div>
    <table class="tablelist">
        <thead>
        <tr user_pid="0">
            <th>学生ID</th>
            <!--<th>编号<i class="sort"><img src="/xianshang/Public/Admin/images/px.gif" /></i></th>-->
            <th>学生名称</th>
            <th>学生年级</th>
            <th>学生学校</th>
            <th>学生电话</th>
            <th>家庭住址</th>
            <th>学生性别</th>
            <th>已经购买课程</th>
            <th>学生家长姓名</th>
            <th>家长电话</th>
            <th>操作</th>
        </tr>
        </thead>


        <tbody>
        <input type="hidden" value="<?php echo ($open_pwd["open_pwd"]); ?>" class="open_pwd">
        <?php if(is_array($arr)): foreach($arr as $key=>$vo): ?><tr class="tr" id="0_1" user_id="<?php echo ($vo["user_id"]); ?>">
                <td width="7%"><?php echo ($vo["students_id"]); ?></td>
                <td width=""><?php echo ($vo["students_name"]); ?></td>
                <td width=""><?php echo ($vo["students_garde"]); ?></td>
                <td width=""><?php echo ($vo["students_school"]); ?></td>
                <td width=""><?php echo ($vo["students_tel"]); ?></td>
                <td width=""><?php echo ($vo["students_home"]); ?></td>
                <?php if($vo['students_sex'] == 1): ?><td width="">男</td>
                    <?php else: ?>
                    <td width="">女</td><?php endif; ?>
                <td width=""><?php echo ($vo["students_course"]); ?></td>
                <td width=""><?php echo ($vo["students_patriarch"]); ?></td>
                <td width=""><?php echo ($vo["patriarch_tel"]); ?></td>
                <td><?php if($id == 1): ?><a href="<?php echo U('Students/students_look');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink"> 查看</a>
                    <a href="<?php echo U('Students/students_update');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink">修改</a>
                    <a href="<?php echo U('Students/students_delete');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink"> 删除</a>
                    <!--<a href="<?php echo U('Students/students_class');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink"> 开课</a>-->
                    <a href="#" class="tablelink form-control attract" > 开课</a>
                    <a href="<?php echo U('Read/read_add');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink"> 添加私人定制文章</a>
                    <?php if($vo['students_location'] == 1): ?><font><a href="#" location="<?php echo ($vo["students_location"]); ?>" id="<?php echo ($vo["students_id"]); ?>" class="tablelink location" style="color: orange;">定位开启</a></font>
                        <?php else: ?>
                        <font><a href="#" location="<?php echo ($vo["students_location"]); ?>" id="<?php echo ($vo["students_id"]); ?>" class="tablelink location" style="color: red;">定位关闭</a></font><?php endif; ?>
                        <?php elseif($vo['is_me_students'] == 1): ?>
                    <a href="<?php echo U('Students/students_look');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink"> 查看</a>
                    <a href="<?php echo U('Students/students_update');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink">修改</a>
                    <a href="<?php echo U('Students/students_delete');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink"> 删除</a>
                    <a href="#" class="tablelink form-control attract"> 开课</a>
                    <a href="<?php echo U('Read/read_add');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink"> 添加私人定制文章</a>

                    <?php else: ?><a href="<?php echo U('Students/students_look');?>?students_id=<?php echo ($vo["students_id"]); ?>" class="tablelink"> 查看</a><?php endif; ?>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <div class="pagin">
        <div class="message">共<i class="blue"><?php echo ($count); ?></i>条记录</div>
        <ul class="paginList">
            <?php echo ($page); ?>
        </ul>
    </div>
</div>
</body>
<script>
    jQuery(function () {
        jQuery('.attract').click(function () {
            var open_pwd = $(".open_pwd").val();
            var name = prompt("请输入您的开课密码", ""); //将输入的内容赋给变量 name ，
//            var operator = prompt("请输入操作人", ""); //将输入的内容赋给变量 name ，
            var md = hex_md5(name)
            //这里需要注意的是，prompt有两个参数，前面是提示的话，后面是当对话框出来后，在对话框里的默认值
//            if (operator)//如果返回的有内容
//            {
                if (md == open_pwd)//如果返回的有内容
                {
                    alert("密码正确！")
                    location.href="<?php echo U('Students/students_class');?>?students_id=<?php echo ($vo["students_id"]); ?>";
                }else{
                    alert("密码错误！")
                }
//            }else{
//                alert("操作人不能为空")
//            }


        });
    });
//    $('.tablelist tbody tr:odd').addClass('odd');
$(function(){
    $(document).on("click",".location",function(){
        var object = $(this);
        //定位状态
        var students_location = $(this).attr("location");
        //学生ID
        var id = $(this).attr("id");
        $.ajax({
            type:"post",
            url:"<?php echo U('Students/students_location');?>",
            data:{
                students_id:id,
                students_location:students_location,
            },
            success:function(r){
                if(r==1){
                    object.parent().html('<a href="#" location="2" id="'+id+'" class="tablelink location" style="color: red;">定位关闭</a>')
                }else if(r==2){
                    object.parent().html('<a href="#" location="1" id="'+id+'" class="tablelink location" style="color: orange;">定位开启</a>')
                }
            }
        })
    })
})
</script>
</html>