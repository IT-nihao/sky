  <?php
  use yii\helpers\Html;
  use yii\bootstrap\Nav;
  use yii\bootstrap\NavBar;
  use yii\widgets\Breadcrumbs;
  use app\assets\AppAsset;
  use yii\helpers\Url;
  ?> 
  <script src="/p2p/web/layer/layer.js"></script>
  <title>团团赚</title>
   <!--content--> 
   <!-- This empty div is a placehodler to avoid extra spaces between content area and the affix header --> 
   <div style="height: 1px;"></div> 
   <div id="my-account" class="container my-account" ng-controller="MyAccountCtrl"> 
    <div class="row">
    <?php include 'left.html';?>
  <div class="col-xs-9 ng-scope" autoscroll="false" ui-view="" style="">
<div class="group-buy content-wrapper ng-scope">
<header class="plans-header plans-subsection" ng-show="showPlanList">
<p class="plans-header-title">团团赚总览</p>
</header>
<h2 class="text-center ng-hide" ng-show="pageLoading">
<i class="spinner sl-icon-loading"></i>
</h2>
<div class="tab-content" ng-show="!pageLoading && showPlanList">
<div class="plans-summary clearfix row">
<div class="col-xs-2 summary-subsection">
<img class="tuan-summary-img" src="images/plan-tuan.png">
<p class="tuan-summary-title text-center">团团赚</p>
</div>
<div class="col-xs-2 text-center summary-subsection highlighted-cont">
<h3 class="highlighted-sum ng-binding" ng-bind-html="allInterestReceived | slMoney">
<?=$all_end_gold;?>
<small>元</small>
</h3>
<p class="font-gray">预计总收益</p>
</div>
<div class="col-xs-2 summary-subsection text-center highlighted-cont">
<h4 class="default-sum ng-binding">
<?=$all_start_gold;?>
<small>元</small>
</h4>
<p class="font-gray">总本金</p>
</div>
<div class="col-xs-2 summary-subsection text-center highlighted-cont">
<h4 class="default-sum ng-binding">
<?=$count;?>
<small>笔</small>
</h4>
<p class="font-gray">持有标数量</p>
</div>
</div>
<div class="bg-content">
<div class="plan-invest-header row">
<div class="col-xs-1 font-gray text-center">名称</div>
<div class="col-xs-2 font-gray text-left interest-info">本息共计</div>
<div class="col-xs-2 font-gray text-left annual-rate">购买利率</div>
<div class="col-xs-2 font-gray text-left">操作</div>
<div class="col-xs-2 font-gray text-left">投入本金</div>
<div class="col-xs-2 font-gray text-left">最低投资</div>
</div>
<?php foreach($activity as $k=>$v){
  if($v['is_buy']==1){
  ?>
<div class="plan-invest-info row ng-scope" ng-repeat="w in linkLoansArray">
<div class="col-xs-1 text-left">
<img class="sl-plan-pic" src="<?=$v['img']?>">
</div>
<div class="col-xs-2 text-left text-words interest-num"><?=$v['end_gold']?>元</div>
<div class="col-xs-2 text-left text-num rate-red annual-rate ng-binding"><?=$v['lilu']?>%</div>
<div class="col-xs-2 text-left text-words" style="font-size:12px;">
<a class="go-invest" href="javascript:;" style="border:1px red solid;color:red;">等待结算</a>
</div>
<div class="col-xs-2 text-left text-words interest-num">
<?=$v['buy_start_gold'];?>元
</div>
<div class="col-xs-2 text-left text-words ng-binding"><font color="red"><b><?=$v['start_gold']?></b></font>元</div>
<div class="col-xs-1 text-left text-words">
<a href="javascript:;"><?=date("Y-m-d",$v['end_time']);?></a>
</div>
</div>
<?php }else{?>
<div class="plan-invest-info row ng-scope" ng-repeat="w in linkLoansArray">
<div class="col-xs-1 text-left">
<img class="sl-plan-pic" src="<?=$v['img']?>">
</div>
<div class="col-xs-2 text-left text-words interest-num" aid="<?=$v['aid']?>">当前未投资</div>
<div class="col-xs-2 text-left text-num rate-red annual-rate ng-binding"><?=$v['lilu']?>%</div>
<div class="col-xs-2 text-left text-words">
<a class="go-invest" href="javascript:;" mclass="go_gold" aid="<?=$v['aid']?>" start_gold="<?=$v['start_gold']?>" lixi="<?=$v['lilu']?>" mtitle="<?=$v['title']?>" t="<?=$v['time']?>">去投资</a>
</div>
<div class="col-xs-2 text-left text-words interest-num">
未投资
</div>
<div class="col-xs-2 text-left text-words ng-binding"><font color="red"><b><?=$v['start_gold']?></b></font>元</div>
<div class="col-xs-1 text-left text-words">
<a href="javascript:;"><?=$v['time']?>天结算</a>
</div>
</div>
<?php } }?>
</div>
</div>
</section>
<script>
y="<?=$userinfo['all_gold']?>";
h=3;
$(function(){
  $("a[mclass='go_gold']").click(function(){
      var start_gold=$(this).attr("start_gold");
      var aid=$(this).attr("aid");
      var lixi=$(this).attr("lixi");
      var title=$(this).attr("mtitle");
      var t=$(this).attr("t");
      var end="";
      layer.prompt({
        value:start_gold,
        title: '投资越多收入越多哟',
        area: ['150px', '50px'] //自定义文本域宽高
      }, function(value, index, elem){
        if(value<1000){
          layer.msg("最低投资"+start_gold+"元哟");
        }else{
          layer.close(index);
          end=(value*lixi/100).toFixed(2);
          end=parseFloat(end)+parseFloat(start_gold);
          layer.prompt({
              title: '请输入您的密码',
            }, function(value2, index2, elem){
              $.get("<?=Url::toRoute('user/checkpwd');?>",{pwd:value2},function(data){
                  if(data==1){
                    if(parseFloat(y)<parseFloat(start_gold)){
                      layer.msg("余额不足!请前往充值");
                      layer.close(index2);
                    }else{
                      $.ajax({
                        url:"<?=Url::toRoute('user/buyactivity');?>",
                        type:"post",
                        data:{start_gold:start_gold,end:end,aid:aid,title:title,t:t},
                        dataType:"JSON",
                        success:function(obj){
                          layer.close(index2);
                          if(obj==1){
                            layer.msg("购买成功，请等待利滚利滚利滚利滚利滚利滚利滚利");
                            setTimeout("jump()",1500);
                          }else{
                            layer.msg("购买错误！请重试！");
                          }
                        }
                      })
                    }
                  }else{
                    if(h>1){
                      h--;
                      layer.msg("密码错误!还有"+h+"机会！");
                    }else{
                      layer.close(index2);
                    }
                  }
              });
            });
        }
      });
  });
})
function jump(){
  location.reload();
}
</script>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>