  <?php
  use yii\helpers\Html;
  use yii\bootstrap\Nav;
  use yii\bootstrap\NavBar;
  use yii\widgets\Breadcrumbs;
  use app\assets\AppAsset;
  use yii\helpers\Url;
  ?>
<!DOCTYPE html>
<html dir="ltr" lang="zh-CN" xml:lang="zh-CN">
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <meta name="description" content="点融网为广大个人和微小企业提供便利的投融资服务。借款产品灵活、大额、费用低、手续快；投资方式人性友好、回报高、百分百本金保护！Dianrong.com provides online efficient investment and financing services for individuals and SMEs. Better rates, lower cost, faster way to borrowers and more flexible investment, higher returns, 100% principal protection to investors." /> 
  <meta name="keywords" content="P2P网贷,P2P网络贷款平台,P2P网络投资平台,P2P投资理财平台,网络贷款平台,团团赚,点融,点融网,点融官网" /> 
  <link rel="shortcut icon" href="images/favicon.ico" /> 
  <title>基本信息</title> 
  <link href="css/bootstrap.min.css" rel="stylesheet" /> 
  <link href="css/components.css?ver=142682356" rel="stylesheet" /> 
  <link href="css/main.css?ver=142682356" rel="stylesheet" /> 
  <link href="css/new-home.css?ver=142682356" rel="stylesheet" />
  <style>
  .file {
    position: relative;
    display: inline-block;
    background: #D0EEFF;
    border: 1px solid #99D3F5;
    border-radius: 4px;
    padding: 4px 12px;
    overflow: hidden;
    color: #1E88C7;
    text-decoration: none;
    text-indent: 0;
    line-height: 20px;
}
.file input {
    position: absolute;
    font-size: 100px;
    right: 0;
    top: 0;
    opacity: 0;
}
.file:hover {
    background: #AADFFD;
    border-color: #78C3F3;
    color: #004974;
    text-decoration: none;
}</style>
  <script src="/p2p/web/layer/layer.js"></script> 
  <style type="text/css">
    @media (min-width: 992px) {
      @font-face {
        font-family: 'proxima-nova';
        src: url('fonts/proximanova-regular-webfont.eot');
        src: url('fonts/proximanova-regular-webfont.eot?#iefix') format('embedded-opentype'),
          url('fonts/proximanova-regular-webfont.woff') format('woff'),
          url('fonts/proximanova-regular-webfont.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
      }

      @font-face {
        font-family: 'proxima-nova';
        src: url('fonts/proximanova-bold-webfont.eot');
        src: url('fonts/proximanova-bold-webfont.eot?#iefix') format('embedded-opentype'),
          url('fonts/proximanova-bold-webfont.woff') format('woff'),
          url('fonts/proximanova-bold-webfont.ttf') format('truetype');
        font-weight: bold;
        font-style: normal;
      }
    }
  </style> 
  <!-- Add support for bootstrap in IE8 --> 
  <!--[if lt IE 9]>
  <link href="css/ie8.css?ver=142682356" rel="stylesheet">
  <![endif]--> 
  <!--[if IE 9]>
  <link href="css/ie9.css?ver=142682356" rel="stylesheet">
  <![endif]--> 

 </head> 
 <body> 
  <!--[if lt IE 8]>
<div class="alert alert-warning text-center" style="margin-bottom:0;">
  <p>你的浏览器不支持点融网的一些新特性，请升级你的浏览器至<a href="http://se.360.cn/">360浏览器</a>或<a href="http://browsehappy.com/">Chrome</a>。
  </p>
  <p>正在为你跳转到旧版网站...<a href="index.html">立即跳转</a></p>
  <p>2015年了，IE8老了...</p>
</div>
<![endif]--> 
  <div class="wrapper "> 
   <!--content--> 
   <!-- This empty div is a placehodler to avoid extra spaces between content area and the affix header --> 
   <div style="height: 1px;"></div> 
   <div id="my-account" class="container my-account" ng-controller="MyAccountCtrl"> 
    <div class="row">
    <?php include "left.html";?>
     <div class="col-xs-9 ng-scope" autoscroll="false" ui-view="" style="">
<div class="account-profile content-wrapper ng-scope">
<header class="section-header">
<h6 class="section-header-title">基本信息</h6>
</header>
<section class="basic summary-section">
<div class="basic-profile clearfix">
<div class="pull-left">
<a class="profile-header" data-toggle="modal" data-target="#upload-profile-image-modal" href="">
<img width="100%" src="<?php if($userinfo['face']==""){echo 'uploads/1.jpg';}else{echo $userinfo['face'];}?>">
</a>
</div>
<div class="pull-left">
<div class="field">
<h6 class="username ng-binding" ng-bind="basicProfile.name"><?=$userinfo['uname']?></h6>
</div>
<div class="field clearfix">
<span class="pull-left">资料完整度</span>
<div class="pull-left">
<div class="progress">
<div id="security-tooltip" class="progress-bar" ng-style="{width:basicProfile.securityLevel + '%'}" data-original-title="" title="" style="width:<?=($userinfo['count']/8)*100?>%;"></div>
</div>
<div class="verify-icons">
<ul class="list-unstyled list-inline">
<li class="ng-scope" ng-repeat="v in basicProfile.securityIcons">
<a class="verify-icon sl-icon-email <?php if($userinfo['email']!=''){echo 'active';}?>"  title="" data-toggle="tooltip" href="" data-original-title="邮件认证"></a>
</li>
<li class="ng-scope" ng-repeat="v in basicProfile.securityIcons">
<a class="verify-icon sl-icon-profile <?php if($userinfo['id_card']){echo 'active';}?>"  title="" data-toggle="tooltip" href="" data-original-title="身份认证"></a>
</li>
<li class="ng-scope" ng-repeat="v in basicProfile.securityIcons">
<a class="verify-icon sl-icon-mobile <?php if($userinfo['tel']){echo 'active';}?>"  title="" data-toggle="tooltip" href="" data-original-title="手机号码验证"></a>
</li>
</ul>
</div>
</div>
<div class="pull-left">
<span class="security-level ng-binding" ng-bind="basicProfile.securityText"><?php
         if(0<=$userinfo['count']&&$userinfo['count']<=3){
          echo "低";
         }else if(3<$userinfo['count']&&$userinfo['count']<=6){
          echo "中";
         }else{
          echo "高";
         }
         ?></span>
</div>
</div>
</div>
</div>
</section>
<section class="summary-section">
<ul id="account-tabs" class="nav nav-tabs section-nav-tabs">
<li class="active">
<a data-toggle="tab" href="javascript:;">个人信息</a>
</li>
</ul>
<div class="tab-content">
<div id="personalInfo" class="tab-pane active personal-info">
<div class="alert alert- ng-hide" ng-show="msg.length > 0" timeout="msgTimeout" msg="msg" type="msgType">
<a class="close sl-icon-cross" aria-hidden="true" ng-click="close()" type="button"></a>
</div>
<div class="info-content row">
<div class="col-xs-9">
<div class="info-row" ng-class="{editing:username.editing}">
<div class="row">
<div class="col-xs-3 info-value text-center">用户名</div>
<div class="col-xs-5" ng-show="!username.editing">
<span class="ng-binding" ng-bind="basicProfile.profile.userName"><?=$userinfo['uname']?></span>
</div>
<div class="col-xs-8 ng-hide" ng-show="username.editing">
<input class="form-control input-sm ng-pristine ng-valid" maxlength="24" placeholder="输入用户名，可用用户名直接登录" ng-model="username.userName" ng-class="{inputError:username.userNameError}">
</div>
<div class="col-xs-4" ng-show="!username.editing && !basicProfile.profile.isUserNameSet">
<div>
<a class="btn btn-secondary bind-blue btn-hollow" href="javascript:;" title="用户名仅可修改一次" old="<?=$userinfo['uname']?>" uid="<?=$userinfo['uid']?>" <?php if($userinfo['set_num']!=0){echo "disabled=true";}?> id="upName">修改</a>
</div>
<script>
$("#upName").click(function(){
  var old=$(this).attr("old");
  layer.prompt({
    formType: 2,
    value: old,
    title: '请输入新用户名',
    area: ['150px', '60px'] //自定义文本域宽高
  }, function(value, index, elem){
      set("uname",value,0);
      layer.close(index);
  });
});
</script>
</div>
</div><div class="info-row" ng-show="showId">
<div class="row">
<div class="col-xs-3 info-value text-center" style="line-height:100px;">头像</div>
<div class="col-xs-9">
<span class="ng-binding" ng-bind="actorId" style="float:left;"><img src="<?php if($userinfo['face']==""){echo '/p2p/web/uploads/1.jpg';}else{echo $userinfo['face'];}?>" alt="" style="width:100px;height:100px;"></span>
<a href="javascript:;" class="file" style="margin-left:34%;margin-top:9%;" id="fileupload">本地上传
    <input type="file" name="myfile" id="uploadFile">
</a>
</div>
</div>
</div>
<script src="./js/ajaxfileupload.js"></script>
<script>
$("#fileupload").change(function(){
   var imgPath = $("#uploadFile").val();
    $.ajaxFileUpload({
       url:"<?=Url::toRoute('user/faceupload');?>", //你处理上传文件的服务端
       secureuri:false,
       type:"post",
       fileElementId:'uploadFile',
       dataType: 'JSON',
       success: function (obj)
       {
         if(obj!=0){
          set("face",obj,1)
         }
       }
    }) 
});
</script>
<div class="info-row row-line">
<div class="row" ng-show="!pwdChange.editing && !pwdSet.editing">
<div class="col-xs-3 info-value text-center">登录密码</div>
<div class="col-xs-5">
<span class="" ng-show="isLandingPwdSet(basicProfile.profile)">*********</span>
</div>
<div class="col-xs-4">
<div class="ng-hide" ng-show="!isLandingPwdSet(basicProfile.profile)">
<a class="btn btn-secondary bind-blue btn-hollow btn-bg-blue" ng-click="pwdSet.editing = true" href="">设置</a>
</div>
<div class="sl-icons" ng-show="isLandingPwdSet(basicProfile.profile)">
<a class="btn btn-secondary bind-blue btn-hollow" ng-click="pwdChange.editing = true" href="javascript:;" uid="<?=$userinfo['uid']?>" id="uppwd">修改</a>
</div>
<script>
$("#uppwd").click(function(){
    var reg_pwd=/^\w{6,16}$/;
    layer.prompt({
    formType: 2,
    title: '请输入旧密码',
    area: ['150px', '60px'] //自定义文本域宽高
    }, function(value, index, elem){
        if(reg_pwd.test(value)){
          $.get("<?=Url::toRoute('user/checkpwd');?>",{pwd:value},function(data){
            if(data==1){
               layer.prompt({
                formType: 2,
                title: '请输入新密码',
                area: ['150px', '60px'] //自定义文本域宽高
              }, function(value1, index, elem){
                if(reg_pwd.test(value1)){
                  set("upwd",value1,0);
                  layer.closeAll();
                }else{
                  layer.msg("密码不合法");
                }
              });
            }else{
              layer.closeAll();
              layer.msg("密码错误");
            }
          });
        }else{
          layer.msg("密码不合法");
        }
    });
});
</script>
</div>
</div>
<div class="info-row row-line" ng-class="{editing:userIdentity.editing}">
<div class="ng-scope" ng-if="!basicProfile.profile.isForeigner && !basicProfile.profile.isEnterprise">
<div class="row">
<div class="col-xs-3 info-value text-center">真实姓名</div>
<div class="col-xs-5" ng-show="!userIdentity.editing">
<span class="bind-gray ng-scope" ng-if="!basicProfile.profile.realName"><?=$userinfo['real_name']?></span>
</div>
<div class="col-xs-8 ng-hide" ng-show="userIdentity.editing">
<input class="form-control input-sm ng-pristine ng-valid" ng-focus="userIdentity.realNameError = false" placeholder="输入您的真实姓名" ng-model="userIdentity.realName" ng-class="{inputError:userIdentity.realNameError}">
</div>
<div class="col-xs-4" ng-show="!userIdentity.editing && !basicProfile.securityIcons.idCard.active && !basicProfile.securityIcons.idCard.isNeedVerify">
<div class="sl-icons">
<a class="btn btn-secondary bind-blue btn-hollow btn-bg-blue" href="javascript:;" <?php if(!empty($userinfo['real_name'])){echo "disabled=true";}?> uid="<?=$userinfo['uid']?>" id="id_card">立即验证</a>
</div>
<script>
$("#id_card").click(function(){
  var reg_name=/^[\u4e00-\u9fa5]{2,5}$/;
  var reg_id_card=/^(\d{17}[X0-9]$)|(^\d{15}$)$/;
  layer.prompt({
    formType: 2,
    title: '请输入您的真实姓名',
    area: ['150px', '60px'] //自定义文本域宽高
  }, function(value, index, elem){
      if(reg_name.test(value)){
        set("real_name",value,1);
        layer.prompt({
            formType: 2,
            title: '请输入您的身份证号码',
            area: ['150px', '60px'] //自定义文本域宽高
          }, function(value1, index, elem){
              if(reg_id_card.test(value1))
              {
                set("id_card",value1,1);
                layer.closeAll();
              }else{
                layer.msg("身份证号码不合法!");
              }
          });
      }else{
        layer.msg("姓名不合法");
      }
  });
});
</script>
</div>
<div class="col-xs-4 ng-hide" ng-show="!userIdentity.editing && !basicProfile.securityIcons.idCard.active && basicProfile.securityIcons.idCard.isNeedVerify">
<div class="sl-icons">
<a class="btn btn-secondary bind-blue btn-hollow btn-bg-blue" href="" data-target="#informationModal" data-toggle="modal">完善信息</a>
</div>
</div>
</div>
<div class="row">
<div class="col-xs-3 info-value text-center">身份证号</div>
<div class="col-xs-5" ng-show="!userIdentity.editing">
<span class="bind-gray ng-scope" ng-if="!basicProfile.profile.idCard"><?=$userinfo['id_card']?></span>
</div>
</div>
</div>
<div class="info-row">
<form class="ng-pristine ng-valid ng-valid-required" name="verifyEmailForm">
<div class="row" ng-class="{editing:(userEmail.editing),'close-edit':userEmail.emailSent}">
<div class="col-xs-3 info-value text-center">绑定邮箱</div>
<div class="col-xs-5">
<div class="" ng-show="!userEmail.editing">
<span class="ng-binding ng-scope" ng-bind="userEmail.email" ng-if="!userEmail.isVerified && userEmail.email"><?=$userinfo['email']?></span>
</div>
</div>
<div class="col-xs-8 ng-hide" ng-show="userEmail.editing">
<input id="account-email" class="form-control email input-sm ng-pristine ng-valid ng-valid-required" type="text" sl-email="" autocomplete="off" placeholder="输入绑定的邮箱地址，提升安全等级" required="" ng-model="userEmail.email" ng-class="{inputError:userEmail.emailError}" name="email">
<div class="ng-hide ng-scope" name="email" sl-validation-errors="">
<span class="hide" ng-transclude="">
<span class="ng-scope" for="email" sl-error-message="">请输入有效的邮箱地址</span>
</span>
</div>
</div>
<div class="col-xs-4" ng-show="!userEmail.emailSent">
<div class="sl-icons" ng-show="!userEmail.isVerified && !userEmail.editing">
<a class="btn btn-secondary bind-blue btn-hollow btn-bg-blue ng-scope" href="javascript:;" uid="<?=$userinfo['uid']?>" id="upemail">更换绑定邮箱</a>
<script>
$("#upemail").click(function(){
  var reg_email=/^[0-9a-z]{5,18}@[0-9a-z]{2,5}.com|cn|net$/;
  layer.prompt({
    formType: 2,
    title: '请输入新邮箱',
    area: ['150px', '60px'] //自定义文本域宽高
  }, function(value, index, elem){
    if(reg_email.test(value)){
           $.get("<?=Url::toRoute('login/check_email');?>",{email:value},function(obj){
              if(obj==1){
                layer.msg("邮箱已被注册!");
              }else{
                  $.get("http://www.guodong666.com/demo/email/index.php",{to:value},function(data){
                  layer.prompt({
                  formType: 2,
                  title: '请输入验证码',
                  area: ['150px', '60px'] //自定义文本域宽高
                }, function(value1, index, elem){
                    if(data==value1){
                      set("email",value,0);
                      layer.closeAll();
                    }else{
                      layer.closeAll();
                      layer.alert("验证码错误!");
                    }
                })
              });
            }
        });
    }else{
          layer.closeAll();
          layer.msg("邮箱不合法");
    }
  });
});
</script>
</div>
</div>
</div>
</div>
<div class="info-row">
<div class="row" ng-show="!cellphoneVerification.phoneEditing">
<div class="col-xs-3 info-value text-center">绑定手机</div>
<div class="col-xs-5">
<span class="ng-binding ng-scope" ng-if="cellphoneVerification.isVerified"><?php echo substr($userinfo['tel'],0,3)."****".substr($userinfo['tel'],7,11);?></span>
</div>
<div class="col-xs-3">
<div class="sl-icons bind-green ng-scope" ng-if="cellphoneVerification.isVerified">
<a class="btn btn-secondary bind-blue btn-hollow" href="javascript:;" old="<?=$userinfo['tel']?>" uid="<?=$userinfo['uid']?>" id="uptel">修改</a>
<script>
  $("#uptel").click(function(){
    var reg_tel=/^[1]{1}\d{10}$/;
    var old=$(this).attr("old");
     layer.prompt({
      formType: 2,
      title: '请输入手机号码',
      area: ['150px', '60px'] //自定义文本域宽高
    }, function(value, index, elem){
      if(old!=value&&reg_tel.test(value)){
        set("tel",value,0);
        layer.close(index);
      }else{
        layer.msg("手机号码不合法");
        layer.close(index);
      }
    });
  });
</script>
<script>
function set(cluname,value,count){
  $.get("<?=Url::toRoute('user/up');?>",{clu:cluname,value:value,count:count},function(obj){
    if(obj==1){
      if(cluname!="real_name"){ 
        layer.msg("操作成功!");
        location.reload();
      }
    }
  });
}
</script>
</div>
</div>
</div>
<div class="row editing ng-hide" ng-show="cellphoneVerification.phoneEditing">
<div class="row">
<div class="col-xs-3 info-value text-center">绑定手机</div>
<div class="col-xs-8">
<input class="form-control phone input-sm ng-pristine ng-invalid ng-invalid-required" type="text" sl-mobile-phone="" autocomplete="off" placeholder="输入新的手机号码" maxlength="11" required="" ng-model="verificationInfo.phone" ng-class="{inputError:cellphoneVerification.phoneError}" name="phone">
<div class="ng-hide ng-scope" name="phone" sl-validation-errors="">
<span class="hide" ng-transclude="">
<span class="ng-scope" for="mobilePhone" sl-error-message="">手机号码格式不正确</span>
</span>
</div>
</div>
</div>
<div>ahahaahhaahahahahahah </div>
</div>
</div>
</div>
</section>
<div class="row">
<div class="col-xs-3 info-value text-center"></div>
</div>
</div>
        <div class="new-user-footer hidden"> 
         <img src="images/new-user-footer.png" /> 
        </div> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div> 
 </body>
</html>