  <?php
  use yii\helpers\Html;
  use yii\bootstrap\Nav;
  use yii\bootstrap\NavBar;
  use yii\widgets\Breadcrumbs;
  use app\assets\AppAsset;
  use yii\helpers\Url;
  ?>
  <title>快速注册</title>
   <!--content--> 
   <div class="container create-account-container" ng-controller="CreateCtrl">
    <div class="create-account-content">
    <script src="layer/layer.js"></script>
     <div class="row"> 
      <!-- Reg Form--> 
      <div class="col-xs-4 create-account-content-form">
<div class="tab-content">
<div id="lender" class="tab-pane active">
<div class="create-account-form ng-isolate-scope" referral-name="">
<script>
sendFlag=false;
telFlag=false;
verFlag=false;
pwdFlag=false;
verify='';
</script>
<h5 class="create-account-form-title">利滚利滚利滚利滚利滚利滚利</h5>
<form class="ng-pristine ng-invalid ng-invalid-required" action="<?=Url::toRoute('login/reg');?>" method="post">
<?php if(isset($share_id)){?>
<input type="hidden" name="share_id" value="<?=$share_id?>">
<?php }?>
<div class="form-group" ng-show="formType==2">
<span class="input-group-addon tag sl-icon-bold-email"></span>
<input id="email" class="form-control forcePlaceholder inputRemoveBorder ng-pristine ng-animate ng-valid-remove ng-invalid-add ng-valid-remove-active ng-invalid ng-invalid-add-active ng-invalid-required" type="text" sl-email-available="" sl-email="" ng-blur="inputFocusMail=false" ng-focus="inputFocusMail=true" autocomplete="off" placeholder="电子邮箱" required="" ng-model="user.email" name="email" style="">
</div>
<script>
$(function(){
  var reg_email=/^[0-9a-z]{5,18}@[0-9a-z]{2,5}.com|cn|net$/;
  $("#email").blur(function(){
      if(reg_email.test($("#email").val()))
      {
        sendFlag=true;
        $("#sendVer").attr("disabled",false);
      }else{
        sendFlag=false;
         $("#sendVer").attr("disabled",true);
        layer.msg("邮箱有字母和数字组成，前面5-10位前缀@类型，后缀可以有.com|cn|net");
      }
  });  
})
</script>
<div class="form-group" ng-show="formType==2">
<span class="input-group-addon tag sl-icon-bold-mobile" ng-class="{active:inputFocusPhone}"></span>
<input id="tel" class="form-control forcePlaceholder inputRemoveBorder ng-pristine ng-animate ng-valid-remove ng-invalid-add ng-valid-remove-active ng-invalid ng-invalid-add-active ng-invalid-required" type="text" sl-mobile-phone="" ng-blur="inputFocusPhone=false" ng-focus="inputFocusPhone=true" autocomplete="off" placeholder="手机号码" required="" ng-model="user.phone" name="tel" style="">
<div class="ng-scope" ng-class="ng-hide" name="phone" sl-validation-errors="">
<span class="hide" ng-transclude="">
</span>
</div>
</div>
<script>
$(function(){
  var reg_tel=/^[1]{1}\d{10}$/;
  $("#tel").blur(function(){
      if(reg_tel.test($("#tel").val()))
      {
        telFlag=true;
      }else{
        telFlag=false;
        layer.msg("手机号码有11位数字组成");
      }
  });  
})
</script>
<div class="form-group" ng-show="formType==2 || (createAccountForm.emailOrPhone.$dirty && !createAccountForm.emailOrPhone.$error.required && !createAccountForm.emailOrPhone.$error.mobilePhone)">
<div class="form-inline">
<span class="input-group-addon tag sl-icon-bold-verify" ng-class="{active:inputFocusCode}"></span>
<input id="verifyss" class="form-control phone-verify-input forcePlaceholder inputRemoveBorder specifyInput ng-pristine ng-valid" type="text" placeholder="输入验证码" ng-model="user.phoneVerifyCode" maxlength="6">
<script>
$(function(){
  $("#verifyss").blur(function(){
    if($(this).val()!=verify){
      verFlag=false;
    }else{
      verFlag=true;
    }
  });
})
</script>
<a class="btn btn-secondary sub-btn" ng-disabled="phoneCodeSent || phoneCodeSending" title="点击发送验证码" id="sendVer" disabled="disabled">
发送
<span class="ng-binding ng-hide" ng-show="phoneCodeSent" id="daoji">（<span id="daojishi">60</span>）</span>
</a>
</div>
</div>
<script>
$(function(){
  $("#sendVer").click(function(){
    $.get("<?=Url::toRoute('login/check_email');?>",{email:$("#email").val()},function(obj){
      if(obj==1){
        layer.msg("邮箱已被注册");
        sendFlag=false;
      }else{
        layer.alert("请前往 "+$("#email").val()+" 查看验证码");
        $.get("http://www.guodong666.com/demo/email/index.php",{to:$("#email").val()},function(data){
          verify=data;
          $("#daoji").attr("class","ng-binding ng-show")
          $("#sendVer").attr("disabled",true);
          $("#daojishi").html('60');
          dao=setInterval(settime,1000);
        });
      }
    });
  });  
})
function settime(){
var t=$("#daojishi").text();
  if(t>0){
    t--;
    $("#daojishi").html(t);
  }else{
    clearInterval(dao);
    $("#daoji").attr("class","ng-binding ng-hide")
    $("#sendVer").attr("disabled",false);
  }
}
</script>
<div class="form-group">
<span class="input-group-addon tag sl-icon-bold-pwd" ng-class="{active:inputFocusPwd}"></span>
<input id="upwd" class="form-control forcePlaceholder inputRemoveBorder ng-pristine ng-animate ng-valid-remove ng-invalid-add ng-valid-remove-active ng-invalid ng-invalid-add-active ng-invalid-required" type="password" sl-atmost-forty-chars="" sl-atleast-eight-chars="" sl-contains-digits="" sl-contains-letters="" required="" ng-blur="inputFocusPwd=false" ng-focus="inputFocusPwd=true" placeholder="密码为8个以上字母和数字组合" ng-model="user.password" name="upwd" style="">
</div>
<script>
$(function(){
  var reg_pwd=/^\w{6,16}$/;
  $("#upwd").blur(function(){
      if(reg_pwd.test($("#upwd").val()))
      {
        pwdFlag=true;
      }else{
        pwdFlag=false;
        layer.msg("密码由数字、字母和下划线组成6-16位");
      }
  });  
})
</script>
<div class="accept-agreement form-group">
创建账户，代表我同意并接受点融网
<a class="open-agreement-popup" href="<?=Url::toRoute('index/agreement');?>">注册协议</a>
,
<div class="business-personal-deal">
<a class="open-agreement-popup" href="<?=Url::toRoute('index/agreement');?>">商业借款协议</a>
和
<a class="open-agreement-popup" href="<?=Url::toRoute('index/agreement');?>">个人借款协议</a>
</div>
</div>
<div class="form-group text-left">
<script>
$("form").submit(function(){
  if(sendFlag==false||telFlag==false||pwdFlag==false||verFlag==false){
    layer.msg("有东西写错了哦");
    return false;
  }else{
    return true;
  }
})
</script>
<button class="btn btn-block btn-secondary btn-embossed" type="submit"> 立即注册 </button>
</div>
<div class="text-center weiboLogin ng-scope" ng-if="!disableTpLogin" style="">
<p class="social third-party-login-platform">
你还可以使用合作平台登录
<a class="weibo-sina" ng-click="weiboLogin()" title="用新浪微博登录" href="javascript:;"></a>
<a class="qq-lgoin-btn" ng-click="qqLogin()" title="用腾讯QQ登录" href="javascript:;"></a>
</p>
</div>
</form>
</div>
</div>
<div id="borrower" class="tab-pane">
<div class="text-center">
<h6>申请，审批，放款，迅速有效</h6>
<a class="btn btn-action btn-embossed ng-isolate-scope" target="_blank" url="reg.html"sl-old-href="" href="https://www2.dianrong.com/new-borrower">注册申请贷款</a>
</div>
</div>
</div>
</div>
      <!-- Reg Banner --> 
      <div class="col-xs-8 create-account-content-banner"> 
       <img src="images/create-account-banner.jpg" /> 
      </div> 
     </div> 
    </div> 
   </div> 
  <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/common.js" type="text/javascript"></script>