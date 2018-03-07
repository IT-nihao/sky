  <?php
  use yii\helpers\Html;
  use yii\bootstrap\Nav;
  use yii\bootstrap\NavBar;
  use yii\widgets\Breadcrumbs;
  use app\assets\AppAsset;
  use yii\helpers\Url;
  ?> 
  <script src="/p2p/web/layer/layer.js"></script>
  <title>有钱花</title>
   <!--content--> 
   <!-- This empty div is a placehodler to avoid extra spaces between content area and the affix header --> 
   <div style="height: 1px;"></div> 
   <div id="my-account" class="container my-account" ng-controller="MyAccountCtrl"> 
    <div class="row"> 
      <?php include "left.html";?>
     <div class="col-xs-9 ng-scope" autoscroll="false" ui-view="" style="">
<div class="referral content-wrapper ng-scope">
<header class="section-header">
<h6 class="section-header-title">有钱花     可用额度：<font color="red"><b id="edu"><?=50000-$userinfo['owe_gold'];?></b>元</font></h6>
</header>
<section class="section summary-section section-block">
<div class="row">
<div class="col-xs-12">
<p>
只要绑定卡，我保你有钱花
<br>
利息仅<font color="red"><b>5.5%</b></font>

</p>
<div>
<center>
<table style="line-height:60px;">
  <tr>
    <td>借多少：</td>
    <td><input type="number" id="gold" style="width:40%;height:30px;"></td>
  </tr>
  <tr>
    <td>借多久：</td>
    <td><select name="" id="time" disabled="true">
        <option value="6">6个月</option>
        <option value="12">12个月</option>
      </select>
  </td>
  </tr>
  <tr>
    <td>共需还款：</td>
    <td><span id="num">0</span>元</td>
  </tr>
  <tr>
    <td>每月还款：</td>
    <td><span id="month">0</span>元</td>
  </tr>
  <tr>
    <td>总利息：</td>
    <td><span id="all_lixi">0</span>元</td>
  </tr>
  <tr>
    <td colspan="2"><input type="checkbox" id="box" disabled="true"> 我已仔细阅读并遵守<a href="javascript:alert('点个锤子，我还给你写个借款条例？？？');">《有钱花借款规定》</a></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center;"><button id="iamtrue" style="border:none;width:40%;height:40px;line-height:60%;color:white;background:gray;border-radius:8px;" disabled="true">确定借款</button></td>
    <td></td>
  </tr>
</table>
<script>
h=3;
status="<?=$status?>";
gold="";
$(function(){
  $("#gold").blur(function(){//将时间选项开启
    if(status==1){
      if($(this).val()>$("#edu").text()){
        layer.msg("别闹，哪有那么多额度啊!");
        $("#time").attr("disabled",true);
        $("#box").attr("disabled",true);
      }else{
          if($(this).val()!=""){
          gold=$(this).val();
          $("#time").attr("disabled",false);
          $("#box").attr("disabled",false);
          check_gold();
        }else{
          $("#time").attr("disabled",true);
          $("#box").attr("disabled",true);
          $("#num").html(0);
          $("#month").html(0);
          $("#all_lixi").html(0);
        }
      }
    }else{
        layer.open({
        title: '有钱花提示'
        ,content: '您还未绑定银行卡,前往绑定!',
        yes:function(index){
          layer.close(index);
          location.href="<?=Url::toRoute('user/my_card');?>";
        }
      });
    }
  });
  $("#time").change(function(){
    gold=$("#gold").val();
    time=$(this).val();
    check_gold();
  });
  $("#box").click(function(){
    if($(this).attr("checked")=="checked"){
      $("#iamtrue").attr("disabled",false).css("background","#abcdef");
    }else{
      $("#iamtrue").attr("disabled",true).css("background","gray");
    }
  });
})
function check_gold(){
all_lixi=(gold*5.5/100);
all_lixi=setgold(all_lixi)
all_gold=parseFloat(gold)+parseFloat(all_lixi);
month_gold=all_gold/$("#time").val();
month_gold=setgold(month_gold);
last_month_gold=(all_gold-(month_gold*($("#time").val()-1))).toFixed(2);
$("#month").html(month_gold);
$("#num").html(all_gold);
$("#all_lixi").html(all_lixi);
}
function setgold(aa){
//保留两位小数
  if((aa.toString()).indexOf('.')>0){
    var a=aa.toFixed(2);
    return a;
  }else{
    return aa;
  }
}
</script>
</center>
</div>
</div>
</div>
</section>
<span>每月20号中午12点自动还款   当天请确保您的余额充足，否则将影响您的信誉度！！</span><br/>
<span>也可提前还一期</span>
<table class="table data-table table-hover table-striped ">
<thead>
<tr>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">借款日期</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">借款金额</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">每月还款</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">剩余欠款</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">已还</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">操作</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
</tr>
</thead>
<tbody id="show_list">
<?php if($borrow!=""){
  foreach($borrow as $k=>$v){?>
<tr>
  <td><?=date("Y-m-d H:i:s",$v['add_time']);?></td>
  <td><?=$v['gold']?></td>
  <td><?=$v['month_gold']?></td>
  <td><?=$userinfo['owe_gold']?></td>
  <td><?=$v['ready_month']?>/<?=$v['type']?></td>
  <td><?php if($v['ready_month']>=$v['type']){?>
    <button disabled="true">已还完</button>
    <?php }else{
      if($v['now_month']==0){
      ?>
    <button class="huan" id="<?=$v['bid']?>" month_gold="<?=$v['month_gold']?>" all_month="<?=$v['type']?>" last_month_gold="<?=$v['last_month_gold']?>" ready_month="<?=$v['ready_month']?>" >立即还款</button>
    <?php }else{?>
    <button disabled="true">已提前还款</button>
    <?php } }?>
  </td>
</tr>
<?php } }?>
</tbody>
</table>
<script>
//提前还款
$(function(){
  $(".huan").click(function(){
    if(($(this).attr("all_month")-$(this).attr("ready_month"))==1){
      mgold=$(this).attr("last_month_gold");
    }else{
      mgold=$(this).attr("month_gold");
    }
    if(confirm("确认提前还款"+mgold+"元？？")){
      bid=$(this).attr("id");
      ready_month=$(this).attr("ready_month");
      atype=$(this).attr("all_month");
      layer.prompt({
        title: '请输入您的密码',
      }, function(value2, index2, elem){
        $.get("<?=Url::toRoute('user/checkpwd');?>",{pwd:value2},function(data){
            if(data==1){
              $.ajax({
                url:"<?=Url::toRoute('user/huan');?>",
                type:"post",
                data:{gold:mgold,bid:bid,ready_month:ready_month,type:atype},
                dataType:"JSON",
                success:function(obj){
                  layer.close(index2);
                  if(obj==1){
                    layer.msg("还款成功!");
                    setTimeout("jump()",1500);
                  }else{
                    layer.msg("还款失败!");
                  }
                }
              })
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
})
function jump(){
  location.reload();
}
</script>
</div>
</div>
</div>
</div>
<script>
$("#iamtrue").click(function(){
  layer.prompt({
    title: '请输入您的密码',
  }, function(value2, index2, elem){
    $.get("<?=Url::toRoute('user/checkpwd');?>",{pwd:value2},function(data){
        if(data==1){
          $.ajax({
            url:"<?=Url::toRoute('user/borrow_do');?>",
            type:"post",
            data:{type:$("#time").val(),gold:$("#gold").val(),lixi:all_lixi,month_gold:month_gold,last_month_gold:last_month_gold,all_gold:all_gold},
            dataType:"JSON",
            success:function(obj){
              layer.close(index2);
              if(obj==1){
                layer.msg("借款成功!");
                setTimeout("jump()",1500);
              }else{
                layer.msg("借款失败!");
              }
            }
          })
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
});
</script>