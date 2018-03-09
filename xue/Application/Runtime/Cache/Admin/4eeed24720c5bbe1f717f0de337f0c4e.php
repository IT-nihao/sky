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
    <script type="text/javascript" src="/xianshang/Public/Admin/js/183.js"></script>
    <script type="text/javascript" src="/xianshang/Public/Admin/js/simple.switch.min.js"></script>
    <link rel="stylesheet" href="/xianshang/Public/Admin/css/simple.switch.three.css" type="text/css">
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


<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">课程列表</a></li>
        <input type="text" class="stu_id" value="<?php echo ($students_id["students_id"]); ?>">
        <li><a href="#">学生姓名：<font style="color: orange;" class="students_name"><?php echo ($students_id["students_name"]); ?></font></a></li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <li class="click"><span><img src="/xianshang/Public/Admin/images/t01.png" /></span><a href="<?php echo U('students_add');?>">添加</a></li>
        </ul>
        <input type="text" value="<?php echo ($partner_operator); ?>">
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
            <th>课程ID</th>
            <!--<th>编号<i class="sort"><img src="/xianshang/Public/Admin/images/px.gif" /></i></th>-->
            <th>课程名称</th>
            <th>课程价格</th>
            <th>操作</th>
        </tr>
        </thead>


        <tbody>
        <?php if(is_array($class)): foreach($class as $key=>$vo): ?><tr class="tr" id="0_1" user_id="<?php echo ($vo["user_id"]); ?>">
                <td><?php echo ($vo["class_id"]); ?></td>
                <td><?php echo ($vo["class_name"]); ?></td>
                <td><?php echo ($vo["class_money"]); ?></td>
                <td>
                    <?php if($vo['pay_class'] == 1): ?><input type="checkbox" class_name="<?php echo ($vo["class_name"]); ?>" type_id ="<?php echo ($vo["class_money"]); ?>" class_id="<?php echo ($vo["class_id"]); ?>" status="1" class="checkbox" checked>
                        <?php else: ?>
                        <input type="checkbox" class_name="<?php echo ($vo["class_name"]); ?>" type_id ="<?php echo ($vo["class_money"]); ?>" class_id="<?php echo ($vo["class_id"]); ?>" status="0" class="checkbox"><?php endif; ?>
                </td>

            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <div class="pagin">
        <div class="message">共<i class="blue"><?php echo ($count); ?></i>条记录</div>
        <ul class="paginList">
            <!--<?php echo ($page); ?>-->
        </ul>
    </div>
</div>
</body>

<script>
    $(".checkbox").simpleSwitch({
        "theme": "DefaultMin"
    });
    $(document).on("click",".checkbox",function(){
        var obj = $(this);
        var class_money = $(this).attr("type_id");
        var class_name = $(this).attr("class_name");
        var students_name = $(".students_name").html();

        var status = $(this).attr("status");
        var class_id = $(this).attr("class_id");
//        alert(class_money)
        var students_id = $(".stu_id").val();
        if(status == 1){
            var statu = confirm("确定关闭这门课程么?");
            if(!statu){
                return false;
            }
            $.ajax({
                type:"post",
                url:"<?php echo U('Students/class_close');?>",
                data:{
                    students_id:students_id,
                    class_id:class_id,
                },
                success:function(r){
                    obj.attr("status",0);
                }
            })
        }else{
            var operator = prompt("请输入操作人", ""); //将输入的内容赋给变量 name ，
            var statu = confirm("确定开启这门课程么?");
            if(!statu){
                return false;
            }
            if(operator == ""){
                return false;
            }
            $.ajax({
                type:"post",
                url:"<?php echo U('Students/class_open');?>",
                data:{
                    students_id:students_id,
                    class_id:class_id,
                    class_money:class_money,
                    students_name:students_name,
                    class_name:class_name,
                    pay_operator:operator
                },
                success:function(r){
                    if(r == 1){
                        obj.attr("status",1)
                        alert("开课成功");
                    }else if(r == 2){
                        alert("余额不足，请联系管理员");
                    }
                }
            })
        }
    })
</script>

</html>