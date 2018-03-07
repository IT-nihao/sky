  <?php
  use yii\helpers\Html;
  use yii\bootstrap\Nav;
  use yii\bootstrap\NavBar;
  use yii\widgets\Breadcrumbs;
  use app\assets\AppAsset;
  use yii\helpers\Url;
  ?>
<title>登录</title>
   <!--content--> 
   <div class="container login-container" ng-controller="LoginFormCtrl">
    <div class="login-content"> 
     <div class="row"> 
      <!-- Login Banner --> 
      <div class="col-xs-8 login-content-banner"> 
       <img src="images/login-banner.jpg" /> 
      </div> 
      <!-- Login Form --> 
      <div class="col-xs-4 login-content-form"> 
       <h6 class="login-content-form-title">欢迎回来</h6> 
       <form  name="loginForm" class="loginForm" role="form" action="<?= Url::toRoute('login/login');?>" method="post"> 
        <div ng-repeat="error in errors" ng-show="errors.length &gt; 0" ng-cloak="" class="errorInLogin">
        </div> 
        <div class="form-group"> 
         <div class="input-group"> 
          <span class="input-group-addon sl-icon-personal"></span> 
          <input id="usernameSingle" type="text" class="form-control input-with-icon forcePlaceholder" ng-model="username" ng-focus="inputFocus=true" ng-blur="inputFocus=false" placeholder="请输入注册时的手机号或邮箱" required="" name="uname"/> 
         </div> 
         <span class="errors ng-hide">对不起，请输入正确的用户名</span> 
        </div> 
        <div class="form-group "> 
         <div class="input-group pwd"> 
          <span class="input-group-addon sl-icon-lock lock" ng-class="{active:focus}"></span> 
          <input id="passwordSingle" type="password" class="form-control input-with-icon forcePlaceholder" ng-model="password" ng-focus="focus=true" ng-blur="focus=false" placeholder="请输入登录密码" required="" name="upwd"/> 
         </div> 
         <span class="errors ng-hide">需要输入密码</span> 
        </div> 
        <div class="form-group"> 
         <button type="submit" class="btn btn-block btn-secondary btn-embossed">立即登录</button> 
        </div> 
        <div class="form-group"> 
         <div class="checkbox-inline"> 
          <label><input type="checkbox" name="rememberMe" ng-model="rememberMe" name="rememberMe" value="1"/> 记住用户名</label> 
         </div> 
         <a class="forget-password-link" href="<?= Url::toRoute('login/forget_me');?>" target="_self">忘记密码？</a> 
        </div> 
        <div class="text-center weiboLogin"> 
         <div class="weiboDivider"> 
          <span class="social"> <p>没有帐号？<a href="<?= Url::toRoute('login/reg');?>">立即注册</a> <span class="third-party-login-platform">，或使用合作平台登录</span> </p> 
           <div class="third-party-login-platform" style="display:block"> 
            <a href="#" title="用新浪微博登录" ng-click="weiboLogin()" class="weibo-sina"></a> 
            <a href="#" title="用腾讯QQ登录" ng-click="qqLogin()" class="qq-lgoin-btn"></a> 
           </div> </span> 
         </div> 
        </div> 
       </form> 
      </div> 
     </div> 
    </div> 
   </div> 