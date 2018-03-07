<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>网站后台管理系统HTML模板--模板之家 www.cssmoban.com</title>
    <link href="/xianshang/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/js/jquery-1.8.2.min.js" rel="stylesheet" type="text/css" />
    <link href="/xianshang/Public/Admin/css/page1.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/xianshang/Public/Admin/js/jquery.js"></script>
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
        <li><a href="#">店铺列表</a></li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">

        <ul class="toolbar">
            <li class="click"><span><img src="/xianshang/Public/Admin/images/t01.png" /></span><a href="<?php echo U('store_add');?>">添加</a></li>
        </ul>

        <form action="<?php echo U('Store/store_list');?>" method="get">
            <input name="store_user" type="text" class="dfinput" placeholder="请在这里输入店铺名称..."/>
            <input name="store_home" type="text" class="dfinput" placeholder="请在这里输入店铺地址..."/>
            <input name="store_tel" type="text" class="dfinput" placeholder="请在这里输入负责人电话..."/>
            <select name="store_code" id="" class="aaaa dfinput" style="width: 100px;">
                <option value="">请选择</option>
                <?php if($id == 8): if(is_array($select_store)): foreach($select_store as $key=>$vo): ?><option value="<?php echo ($vo["code"]); ?>"><?php echo ($vo["store_user"]); ?></option><?php endforeach; endif; ?>
                    <?php else: ?>
                    <?php if(is_array($select_store)): foreach($select_store as $key=>$vo): ?><option value="<?php echo ($vo["code"]); ?>"><?php echo ($vo["store_user"]); ?></option><?php endforeach; endif; endif; ?>

            </select>
            <input name="" type="submit" class="btn" value="搜索"/>
        </form>

    </div>


    <table class="tablelist">
        <thead>
        <tr>
            <th>店铺ID</th>
            <th>店铺负责人</th>
            <th>店铺负责人身份证号</th>
            <th>店铺负责人性别</th>
            <th>店铺负责人电话</th>
            <th>店铺负责人家庭住址</th>
            <th>详细地址</th>
            <th>授权码</th>
            <th>开户时间</th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody>
        <?php if(is_array($arr)): foreach($arr as $key=>$vo): ?><tr>
                <td width="7%"><?php echo ($vo["store_id"]); ?></td>
                <?php if($vo['user_id'] == $user_id): ?><td><font style="color: red;"><?php echo ($vo["store_user"]); ?></font></td>
                    <?php else: ?>
                    <td><?php echo ($vo["store_user"]); ?></td><?php endif; ?>

                <td><?php echo ($vo["store_idcard"]); ?></td>
                <?php if($vo['store_sex'] == 1): ?><td>男</td>
                    <?php else: ?>
                    <td>女</td><?php endif; ?>
                <td width="7%"><?php echo ($vo["store_tel"]); ?></td>
                <td><?php echo ($vo["store_home"]); ?></td>
                <td><?php echo ($vo["detailed_address"]); ?></td>
                <td><?php echo ($vo["code"]); ?></td>
                <td><?php echo (date("Y-m-d H:i:s",$vo["store_time"])); ?></td>
                <td><a href="<?php echo U('Store/store_update');?>?store_id=<?php echo ($vo["store_id"]); ?>" class="tablelink">修改</a>
                    <a href="<?php echo U('Store/store_delete');?>?store_id=<?php echo ($vo["store_id"]); ?>" class="tablelink"> 删除</a>
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

<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>
</body>
</html>
<script>

</script>