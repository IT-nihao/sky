  <title>友情链接</title>
   <!--content--> 
   <!-- This empty div is a placehodler to avoid extra spaces between content area and the affix header --> 
   <div style="height: 1px;"></div> 
   <div id="my-account" class="container my-account" ng-controller="MyAccountCtrl"> 
    <div class="row"> 
      <?php include "left.html";?>
     <div class="col-xs-9 ng-scope" autoscroll="false" ui-view="" style="">
<div class="referral content-wrapper ng-scope">
<header class="section-header">
<h6 class="section-header-title">友情邀请</h6>
</header>
<section class="section summary-section section-block">
<div class="row">
<div class="col-xs-12">
<p>
复制你的邀请链接发送给好友
<br>
好友通过你的邀请链接进行注册
<br>
您将获取到一元的现金奖励！！！
<br/>
已获得：<font color="red"><b><?=$userinfo['share_gold']?>元</b></font>
</p>
<div>
<span>你的邀请链接：</span>
<input type="text" value="<?=$userinfo['fr_link']?>" id="link" onclick="copyUrl2(this)" style="width:70%;border:none;color:green;">
</div>
</div>
</div>
</section>
</div>
</div>
</div>
</div>
<script>
function copyUrl2(){
  var Url2=document.getElementById("link");
  Url2.select(); // 选择对象
  document.execCommand("Copy"); // 执行浏览器复制命令
  alert("复制成功");
}
</script>