<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>loading...</title>
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="css/style1.css" />
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="js/jquery.js"></script>
<script src="js/verificationNumbers.js"></script>
<script src="js/Particleground.js"></script>
<script>
$(document).ready(function() {
  //粒子背景特效
  $('body').particleground({
    dotColor: '#5cbdaa',
    lineColor: '#5cbdaa'
  });
});
</script>
</head>
<body>
<dl class="admin_login">
 <dt>
  <strong><?=$msg;?></strong>
 </dt>
 <dt>
  <strong><font color="white" id="time"><?=$time;?></font> 秒后跳转...</strong>
 </dt>
 <dd>
  <a href="<?=Url::toRoute($url);?>"><input type="button" value="立即跳转" class="submit_btn"/></a>
 </dd>
</dl>
</body>
</html>
<script>
url="<?=Url::toRoute($url);?>";
t="<?=$time?>";
function jian(){
  if(t>0){
    t--;
    $("#time").html(t);
  }else{
    clearInterval(index);
    location.href=url;
  }
}
index=setInterval(jian,1000);
</script>
