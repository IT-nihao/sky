 <?php
  use yii\helpers\Html;
  use yii\bootstrap\Nav;
  use yii\bootstrap\NavBar;
  use yii\widgets\Breadcrumbs;
  use app\assets\AppAsset;
  use yii\helpers\Url;
 ?>
<title>银行卡管理</title>
<script src="/p2p/web/layer/layer.js"></script>
   <!--content--> 
   <!-- This empty div is a placehodler to avoid extra spaces between content area and the affix header --> 
   <div style="height: 1px;"></div> 
   <div id="my-account" class="container my-account" ng-controller="MyAccountCtrl"> 
    <div class="row"> 
    <?php include "left.html";?>
     <div class="col-xs-9 ng-scope" autoscroll="false" ui-view="" style="">
<div class="bank-cards content-wrapper ng-scope">
<header class="section-header">
<h6 class="section-header-title">银行卡管理</h6>
<span class="section-header-action ng-binding">当前绑定<span id="card_num">0</span>张银行卡</span>
</header>
<section class="summary-section">
<section class="cards-content">
<?php if(!empty($my_card)){
  $count=0;
  foreach($my_card as $k=>$v){
    $count++;?>
<div class="row">
<div class="col-xs-6 card-col ng-scope" ng-repeat="card in cards">
<div class="bank-card">
<header class="clearfix">
<div class="pull-left">
<a class="icon-bank">
<span class="form-control bank-logo bank-abc"></span>
</a>
<span class="card-type ng-binding" ng-bind="card.type"></span>
</div>
<h6 class="pull-right ng-binding" ng-bind="card.typeName"></h6>
</header>
<div class="text-center">
<h5 class="card-number ng-binding" ng-bind="card.number"><?=$v['number']?></h5>
</div>
</div>
<script>
 $("#card_num").html("<?=$count?>"); 
</script>
</div>
<?php } }?>
<!-- 添加 -->
<div class="col-xs-6 card-col ng-show" ng-show="showCard">
<div class="bank-card add-card text-center" id="add_card">
<h6 class="add-card-now">添加银行卡</h6>
</div>
</div>
</div>
</section>
<script>
status="<?=$status;?>"
$("#add_card").click(function(){
  if(check_status()==true){
      //页面层
    layer.prompt({
      title: '请输入您名下的银行卡号',
    },
      function(value, index, elem){
        var regex = /^\d{16,19}$/;
        if(regex.test(value)){
          $.ajax({
            url:"<?=Url::toRoute('user/add_mycard')?>",
            data:{uid:"<?=$userinfo['uid']?>",user_name:"<?=$userinfo['uname']?>",number:value},
            dataType:"json",
            success:function(obj){
              if(obj==2){
                layer.msg("该卡号已被使用");
              }else if(obj==0){
                layer.msg("添加失败，请重试！");
              }else{
                layer.msg("添加成功!");
                layer.close(index);
                setTimeout("jump()",1500);
              }
            }
          })
        }else{
          layer.msg("银行卡格式错误");
        }
      });
  }
  
})
function jump(){
  location.reload();
}
function check_status(){
  if(status==2){
    layer.open({
      title: 'load..'
      ,content: '请绑定后身份信息后重试'
      
      ,yes:function(index){
        layer.close(index);
        location.href="<?=Url::toRoute('user/info');?>";
      }
    });
    return false;
  }else{
    return true;
  }
}
</script>
</section>
<div sl-add-card="">
<div id="addCardModal" class="modal fade add-card" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button class="close sl-icon-cross" aria-hidden="true" data-dismiss="modal" type="button"></button>
<h4 id="myModalLabel" class="modal-title">添加银行卡</h4>
</div>
<div class="modal-body summary-section">
<div class="addCard-container">
<div class="alert alert-info warning-info ng-hide" ng-show="tipShow">
<p class="ng-binding"></p>
</div>
<div class="alert alert-info">
<p>
为保证提现成功，请确认该银行卡开户姓名必须为
<strong class="ng-binding">黄金</strong>
</p>
</div>
<form class="form-horizontal ng-pristine ng-invalid ng-invalid-required" name="addCardForm">
<div class="form-group">
<label class="col-xs-3 col-xs-offset-1 control-label">持卡人</label>
<div class="col-xs-7">
<p class="form-control-static ng-binding">黄金</p>
</div>
</div>
<div class="form-group">
<label class="col-xs-3 col-xs-offset-1 control-label">银行账号</label>
<div class="col-xs-7">
<input class="form-control ng-pristine ng-invalid ng-invalid-required" type="text" sl-bank-card="" required="" ng-model="user.account" name="account">
<div class="ng-hide ng-scope" name="account" sl-validation-errors="">
<span class="hide" ng-transclude="">
<span class="ng-scope" for="required" sl-error-message="">对不起，请输入卡号</span>
<span class="ng-scope" for="bankCard" sl-error-message="">银行卡格式错误，须为数字或卡号位数不符</span>
</span>
</div>
</div>
</div>
<div class="form-group">
<label class="col-xs-3 col-xs-offset-1 control-label">确认银行账号</label>
<div class="col-xs-7">
<input class="form-control ng-pristine ng-invalid ng-invalid-required" type="text" sl-bank-card="" sl-equal-to="user.account" required="" ng-model="user.accountSure" ng-paste="noPaste($event)" name="accounts">
<div class="ng-hide ng-scope" name="accounts" sl-validation-errors="">
<span class="hide" ng-transclude="">
<span class="ng-scope" for="required" sl-error-message="">对不起，请确认卡号</span>
<span class="ng-scope" for="bankCard" sl-error-message="">银行卡格式错误，须为数字或卡号位数不符</span>
<span class="ng-scope" for="equalTo" sl-error-message="">卡号两次输入不一致</span>
</span>
</div>
</div>
</div>
<div class="form-group">
<label class="col-xs-3 col-xs-offset-1 control-label">选择银行</label>
<div class="col-xs-7">
<div class="drop btn-group select select-block mbn ng-isolate-scope" selected-name="selectBank" btn-style="btn-add" options="withdrawBanklist">
<button class="btn dropdown-toggle clearfix btn-add" data-toggle="dropdown">
<span class="filter-option pull-left ng-binding"></span>
<span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu"> </ul>
<select class="form-control hide" name=""> </select>
</div>
</div>
</div>
<div class="form-group">
<label class="col-xs-3 col-xs-offset-1 control-label">开户省份</label>
<div class="col-xs-7">
<div class="drop btn-group select select-block mbn ng-isolate-scope" selected-name="selectProvince" btn-style="btn-add pro" options="province">
<button class="btn dropdown-toggle clearfix btn-add pro" data-toggle="dropdown">
<span class="filter-option pull-left ng-binding"></span>
<span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu"> </ul>
<select class="form-control hide" name=""> </select>
</div>
</div>
</div>
<div class="form-group">
<label class="col-xs-3 col-xs-offset-1 control-label">开户城市</label>
<div class="col-xs-7">
<div class="drop btn-group select select-block mbn ng-isolate-scope" selected-name="selectCity" btn-style="btn-add pro" options="city[selectProvince]">
<button class="btn dropdown-toggle clearfix btn-add pro" data-toggle="dropdown">
<span class="filter-option pull-left ng-binding"></span>
<span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu"> </ul>
<select class="form-control hide" name=""> </select>
</div>
</div>
</div>
<div class="form-group">
<label class="col-xs-3 col-xs-offset-1 control-label">支行名称</label>
<div class="col-xs-7">
<input id="bankBranchName" class="form-control ng-scope ng-pristine ng-invalid ng-invalid-required" type="text" required="" tooltip-placement="right" tooltip-trigger="focus" tooltip="请输入支行名称" autocomplete="off" ng-model="user.bankBranchName" name="bankBranchName">
</div>
</div>
<div class="form-group">
<div class="card-set-as-default col-xs-4 col-xs-offset-4">
<span class="sl-icon-checkbox-checked"></span>
设为默认
</div>
</div>
</form>
</div>
</div>
<div class="modal-footer">
<a class="btn btn-link " data-dismiss="modal">取消</a>
<button id="bankChoose" class="btn btn-secondary" ng-disabled="user.account==''||user.accountSure==''||user.bankBranchName==''||user.account!=user.accountSure||addCardForm.bankBranchName.$invalid || confirming" ng-click="confirmAddCard()" type="submit" disabled="disabled">确定</button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
    </div> 
    <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-hidden="true"> 
     <div class="modal-dialog"> 
      <div class="modal-content"> 
       <div class="modal-body"> 
        <button type="button" class="close sl-icon-cross" data-dismiss="modal" aria-hidden="true"></button> 
        <div class="new-user-title text-center"> 
         <img src="images/new-user-title.png" /> 
        </div> 
        <div class="row new-user-wrapper"> 
         <div class="col-xs-4 col-xs-offset-1 new-user-text text-center"> 
          <h2 ng-show="!fromLC">一手消息</h2> 
          <h2 ng-show="!fromLC">马上掌握</h2> 
          <div class="bg-new-share-wel" ng-show="fromLC"></div> 
          <div class="info-new-share text-center" ng-show="fromLC">
           14%预期年化收益率 只给首次投资的你哦
          </div> 
          <div class="btn-invest" ng-show="fromLC">
           <a class="btn  btn-action" href="index.html" ng-click="linkToRecharge()">立即充值投资</a>
          </div> 
          <div ng-show="!fromLC">
           <a class="btn btn-block btn-action" href="market.html" target="_blank">立即投资</a>
          </div> 
         </div> 
         <div class="col-xs-5 col-xs-offset-1 qr"> 
          <img src="images/qr-sub.png" /> 
          <p>立即扫描或搜索&quot;dianrongapi&quot;</p> 
          <p>关注点融网官方微信</p> 
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
   </div>
   </div>