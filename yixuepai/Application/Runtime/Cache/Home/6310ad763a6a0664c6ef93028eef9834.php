<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>前台</title>
</head>
<script type="text/javascript" src='/yantian/xianshang/Public/Js/jquery-1.8.2.min.js'></script>
<body>
<form action="<?php echo U('index/web');?>" method="post">
	<table>
		<a href="<?php echo ($pay); ?>">支付</a>
	<tr>
		<td>用户名：</td>
		<td><input type="text" name="account" class="tel" placeholder="请输入手机号码....."></td>
	</tr>
	<tr>
		<td>密码：</td>
		<td><input type="password" name="pwd" placeholder="请输入密码.."></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="text" name="yzm" placeholder="请输入验证码..."><a href="javascript:;" class="huoqu_yzm">获取验证码</a></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="登陆"></td>
	</tr>
	</table>
	</form>
</body>
</html>
<script>
$(function(){
	$(".huoqu_yzm").click(function(){
		var tel = $(".tel").val();
		$.ajax({
			type:'post',
			url:"<?php echo U('index/duanxin');?>",
			data:{
				tel:tel,
			},
			success:function(r){
				alert(r);
			}
		})
			
		
	})
})
</script>