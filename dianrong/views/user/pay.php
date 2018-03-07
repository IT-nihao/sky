 <?php
  use yii\helpers\Html;
  use yii\bootstrap\Nav;
  use yii\bootstrap\NavBar;
  use yii\widgets\Breadcrumbs;
  use app\assets\AppAsset;
  use yii\helpers\Url;
 ?>
 <title>充值/提现</title>
 <!-- This empty div is a placehodler to avoid extra spaces between content area and the affix header --> 
   <div style="height: 1px;"></div> 
   <div id="my-account" class="container my-account" ng-controller="MyAccountCtrl"> 
    <div class="row">
    <?php include "left.html";?>
     <div class="col-xs-9 ng-scope" autoscroll="false" ui-view="" style="">
<div class="account-transfer content-wrapper ng-scope">
<script src="/p2p/web/layer/layer.js"></script>
<header class="section-header">
<h6 class="section-header-title">充值提现</h6>
</header>
<section class="summary-section">
<div class="row">
<div class="col-xs-8">
<div class="tip-wrapper">
<header class="header">
<h6 class="header-label">温馨提示</h6>
</header>
<div>
<ul class="my-account-tip">
<li>
<p>在你申请提现前，请先在页面下方或"基本信息"账户信息页面绑定银行卡</p>
</li>
<li>
<p>收到你的提现请求后，点融网将在1个工作日（双休日或法定节假日顺延）处理你的提现申请，请你注意查收</p>
</li>
<li>
<p>为保障你的账户资金安全，申请提现时，你选择的银行卡开户名必须与你点融网账户实名认证一致，否则提现申请将不予受理。</p>
</li>
</ul>
</div>
</div>
</div>
<div class="col-xs-4">
<div class="status-wrapper">
<div class="textTop">
<div class="col-xs-6 cashText">可用余额</div>
<div class="col-xs-6 cashNumber ng-binding" ng-bind-html="summary.availableCash|slMoney">
<?=$userinfo['all_gold']?>元
</div>
<div class="col-xs-6 cashText">可提现金额</div>
<div class="col-xs-6 cashNumber ng-binding" ng-bind-html="summary.availableWithdrawCash |slMoney">
<?=$userinfo['all_gold']?>元
</div>
</div>
<div class="buttonBottom">
<a class="btn btn-action btn-embossed" id="tocard">
<span class="sl-icon-credit-card"></span>
提现
</a>
<a class="btn btn-primary btn-embossed" id="tomy">
<span class="sl-icon-piggy-bank"></span>
充值
</a>
</div>
</div>
</div>
</div>
</section>
<?php if($my_card!=""){?>
<select name="" id="my_bank" style="display:none;">
  <?php foreach($my_card as $k=>$v){?>
  <option value="<?=$v['cid']?>"><?=$v['number']?></option>
<?php  }?>
</select>
<?php  }?>
</div>
</div>
</div>
</div>
<script>
status="<?=$status?>";
//提现
$("#tocard").click(function(){
  if(check_status()==true){
    alert_info("提现");
  }
});
//充值
$("#tomy").click(function(){
  if(check_status()==true){
    alert_info("充值");
  }
});
function check_status(){
  if(status==2){
    layer.open({
      title: 'load..'
      ,content: '请绑定后身份信息后重试'
      ,closeBtn:0
      ,yes:function(index){
        layer.close(index);
        location.href="<?=Url::toRoute('user/info');?>";
      }
    });
    return false;
  }
  else if(status==3){
    layer.open({
      title: 'load..'
      ,content: '请绑定后银行卡信息后重试'
      ,closeBtn:0
      ,yes:function(index){
        layer.close(index);
        location.href="<?=Url::toRoute('user/my_card');?>";
      }
    });
    return false;
  }else{
    return true;
  }
}
function alert_info(type){
var card_id="";
var card_number="text";
var pay_type="";
var all_gold="<?=$userinfo['all_gold']?>";
var gold="";
var num=3;
     layer.open({
      title:"请选择你要提现或充值的账户",
      type: 1, 
      content: $("#my_bank"),
      btn: ["确认"],
      yes: function(index, layero){
        layer.close(index);
        card_id=$("#my_bank").val();
        card_number=$("#my_bank").text();
        if(type=="提现"){
          layer.prompt({
            title: '可用余额：'+all_gold+'元',
          },function(value1, index1, elem){
            if(all_gold<=value1){
              layer.msg("钱就那么点，别写那么多...");
            }else{
              layer.close(index1);
              gold=value1;
              layer.prompt({
                title: '请输入您的密码',
              }, function(value2, index2, elem){
                $.get("<?=Url::toRoute('user/checkpwd');?>",{pwd:value2},function(data){
                    if(data==1){
                      layer.close(index2);
                      pay_type="余额";
                      begin("提现",card_id,card_number,pay_type,gold);
                    }else{
                      if(num>1){
                        num--;
                        layer.msg("密码错误!还有"+num+"机会！");
                      }else{
                        layer.close(index2);
                      }
                    }
                });
              });
            }
          });
        }else{
          layer.prompt({
            title: '输入充值金额',
          },function(value1, index1, elem){
           layer.close(index1);
                gold=value1;
                layer.prompt({
                  title: '请输入您的密码',
                }, function(value2, index2, elem){
                  $.get("<?=Url::toRoute('user/checkpwd');?>",{pwd:value2},function(data){
                      if(data==1){
                        layer.close(index2);
                        pay_type="银行卡";
                        begin("充值",card_id,card_number,pay_type,gold);
                      }else{
                        if(num>1){
                          num--;
                          layer.msg("密码错误!还有"+num+"机会！");
                        }else{
                          layer.close(index2);
                        }
                      }
                  });
                });
          });
        }
      }
    });
}
</script>
<script>
/**
 * type 交易类型
 * card_id 银行卡ID
 * card_number 银行卡号
 * pay_type 付款类型
 * gold 消费金额
 */
function begin(type,card_id,card_number,pay_type,gold){
  $.post("<?=Url::toRoute('user/tocard');?>",{type:type,card_id:card_id,card_number:card_number,pay_type:pay_type,gold:gold},function(obj){
      if(obj==1){
        layer.msg("操作成功");
        setTimeout("jump()",1500);
      }else{
        layer.msg("操作失败，请重试");
      }
  });
}
function jump(){
  location.reload();
}
</script>