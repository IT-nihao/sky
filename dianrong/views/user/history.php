  <?php
  use yii\helpers\Html;
  use yii\bootstrap\Nav;
  use yii\bootstrap\NavBar;
  use yii\widgets\Breadcrumbs;
  use app\assets\AppAsset;
  use yii\helpers\Url;
  ?> 
<title>交易记录</title>
   <!--content--> 
   <!-- This empty div is a placehodler to avoid extra spaces between content area and the affix header --> 
   <div style="height: 1px;"></div> 
   <div id="my-account" class="container my-account" ng-controller="MyAccountCtrl"> 
    <div class="row"> 
     <?php include "left.html";?>
      <div class="col-xs-9 ng-scope" autoscroll="false" ui-view="" style="">
<div class="trade-history content-wrapper ng-scope">
<header class="section-header">
<h6 class="section-header-title">交易记录</h6>
</header>
<section class="summary-section">
<div class="trade-header">
<div id="date-choose" class="row date-choose">
<div class="col-xs-2 date-dropdown month-dropdown text-center pdSpace ng-scope" ng-if="tradedHistoryParams.range==''">
<div class="drop btn-group select select-block mbn ng-isolate-scope" selected-name="monthData.year" btn-style="btn-add" options="yearSelectData">
<div class="col-xs-1 text-center pdSpace yearAndMonth">年：</div>
<select class="" name="" id="select_year">
<option value="">不限</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
</select>
</div>
</div>
<div class="col-xs-1 text-center pdSpace yearAndMonth">月：</div>
<select class="" id="select_month">
<option value="0" selected>不限</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>
</div>
</div>
<script>
year="";
month="";
p="<?=$p?>";
nowp="";
$(function(){
  $("#select_year").change(function(){
    var val=$(this).val();
    if(val==""){
      year=val;
    }else{
      year=val+"/1/1-"+val+"/12/31";
    }
    settime();
  });
  $("#select_month").change(function(){
    if(year==""){
      alert("你还没有选择年份");
      month="";
    }else{
      month=$(this).val();
      settime();
    }
  });
})
</script>
<h2 class="text-center ng-hide" ng-show="tradeHistoryLoading">
<i class="spinner sl-icon-loading"></i>
</h2>
<div id="table-tradeHistoryItems" class="" ng-show="!tradeHistoryLoading">
<div class="notes-table">
<div class="data-table-wrapper ng-isolate-scope" init="intialDetail(ele)" params="tradedHistoryParams" data="tradeHistoryData" columns="tradeHistoryColumns">
<table class="table data-table table-hover table-striped ">
<thead>
<tr>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">流水号</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">交易详情</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">付款方式</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">交易时间</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
<th class="ng-scope" ng-repeat="a in columns" ng-class="a.headerCssClass">
<span ng-click="sort(a.sortBy ? a.sortBy : a.field)" ng-class="{'active':params.sortBy==a.sortBy,'sortable':a.sortable}">
<span class="ng-binding" ng-bind-html="escapeHtml(a.name)">交易金额</span>
<span ng-class="{'sl-icon-pointer-down-dark':(a.sortable && ((params.sortBy!=a.sortBy && defaultDesc==true)||(params.sortBy==a.sortBy&&params.sortDir=='desc'))), 'sl-icon-pointer-up-dark':a.sortable &&((params.sortBy!=a.sortBy && defaultDesc==false)|| (params.sortBy==a.sortBy&&params.sortDir == 'asc'))}"></span>
</span>
</th>
</tr>
</thead>
<tbody id="show_list">
<?php if($list){foreach($list as $k=>$v){?>
<tr>
  <td><?=$v['no']?></td>
  <td><?=$v['message']?></td>
  <td><?=$v['type']?></td>
  <td><?=date("Y-m-d H:i:s",$v['addtime'])?></td>
  <td><?=$v['gold']?>元</td>
</tr>
<?php }}?>
</tbody>
</table>
</div>
</div>
<div class="notes-pagination">
<div class="sl-pagination pagination ng-isolate-scope" total-records="tradeHistoryTotalRecords" page-size="tradedHistoryParams.pageSize" page="tradedHistoryParams.page">
<ul>
<li class="previous">
<a href="javascript:;" ass="click" click="prev">
<i class="sl-icon-arrow-left"></i>
</a>
</li>
<li style="color:black;">
<span><span id="np"><?=$p?></span>/<span id="mp"><?=$max;?></span></span>
</li>
<li class="next">
<a href="javascript:;" ass="click" click="down">
<i class="sl-icon-arrow-right"></i>
</a>
</li>
</ul>
</div>
</div>
</div>
</section>
<script>
$("a[ass='click']").click(function(){
if($(this).attr("click")=="prev"){
  if($(this).text()-1<1){
    nowp=1;
  }else{
    nowp=$("#np").text()-1;
  }
}else{
  if(parseInt($(this).text())+1>$("#mp").text()){
    nowp=parseInt($("#mp").text());
  }else{
    nowp=parseInt($("#np").text())+1;
  }
}
settime();
});
</script>
</div>
</div>
</div>
</div>
<script>
function settime(){
  t="";
  if(year==""&&month==""){
  t='';
  }else if(year!=""&&month==""){
    t=year;
  }else if(year!=""&&month!=""){
    mon=$("#select_month").val();
     if(mon==1|mon==3|mon==5|mon==7|mon==8|mon==10|mon==12)
      {
        t=$("#select_year").val()+"/"+mon+"/1-"+$("#select_year").val()+"/"+mon+"/31";
      }else{
        t=$("#select_year").val()+"/"+mon+"/1-"+$("#select_year").val()+"/"+mon+"/30";
      }
  }
  if(nowp==""){
    select_data(1,t);
  }else{
    select_data(nowp,t);
  }
}
//ajax分页
function select_data(page,t){
  $.ajax({
    url:"<?=Url::toRoute('user/history');?>",
    data:{p:page,t:t},
    type:"get",
    dataType:"JSON",
    success:function(data){
      if(data.list==""){
        alert("暂无数据");
      }else{
        str='';
        $.each(data.list,function(i,v){
          str+='<tr><td>'+v.no+'</td>';
          str+='<td>'+v.message+'</td>';
          str+='<td>'+v.type+'</td>';
          str+='<td>'+v.addtime+'</td>';
          str+='<td>'+v.gold+'元</td>';
          str+='</tr>';
        });
        $("#show_list").html(str);
        $("#np").html(data.p);
        $("#mp").html(data.max);
      }
    }
  })  
}
</script>