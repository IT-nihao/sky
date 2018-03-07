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
  <title>我的账户</title> 
  <link href="css/bootstrap.min.css" rel="stylesheet" /> 
  <link href="css/components.css?ver=142682356" rel="stylesheet" /> 
  <link href="css/main.css?ver=142682356" rel="stylesheet" /> 
  <link href="css/new-home.css?ver=142682356" rel="stylesheet" /> 
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
   <!--content--> 
   <!-- This empty div is a placehodler to avoid extra spaces between content area and the affix header --> 
   <div style="height: 1px;"></div> 
   <div id="my-account" class="container my-account" ng-controller="MyAccountCtrl"> 
    <div class="row">
    <?php include "left.html";?>
     <div class="col-xs-9 ng-scope" autoscroll="false" ui-view="" style="">
<div class="account-summary content-wrapper ng-scope">
<section class="row simple-summary">
<div class="col-xs-7 simple-summary-section total-net-income">
<div id="column-chart" class="total-interest">
<div class="text-center ng-hide" ng-show="!gotSummary">
<h4 class="loading-animation summary-loading">
<i class="spinner sl-icon-loading"></i>
</h4>
</div>
<div class="monthly-income" ng-show="gotSummary">
<ul class="list-inline monthly-income-bars" ng-class="{invisible:loadingColumn}">
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 0px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2014-04净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency"><?=$userinfo['into_gold']?>元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 38.9167px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2014-05净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 77.8333px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2014-06净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 116.75px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2014-07净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 155.667px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2014-08净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 194.583px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2014-09净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 233.5px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2014-10净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 272.417px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2014-11净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 311.333px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2014-12净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 350.25px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2015-01净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 389.167px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">2015-02净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<li class="every-month ng-scope noMargin" ng-style="{left:m.left}" ng-class="{noMargin:$last}" ng-repeat="m in monthlyIncome" style="left: 428.083px;">
<a ng-style="{width:m.width,height:m.height}" href="" style="width: 33.9167px; height: 8px;">
<div class="income-info">
<span class="ng-binding">月净收入</span>
<br>
<span class="ng-binding" ng-bind="m.interest | slCurrency">0.00元</span>
</div>
</a>
</li>
<div class="sum-number inside-column">
<h3 class="highlighted-sum">
<abbr class="ng-binding ng-scope" ng-bind-html="summary.interestReceived|slMoney" tooltip-placement="right" tooltip="=已收利息+已收罚息" title="">
<?=$userinfo['into_gold']?>元
</abbr>
</h3>
<p class="highlighted-sum-caption">累计净收益</p>
</div>
</ul>
</div>
</div>
</div>
<div class="col-xs-5 simple-summary-section balance-sheet">
<div class="text-center ng-hide" ng-show="!gotSummary">
<h4 class="loading-animation summary-loading">
<i class="spinner sl-icon-loading"></i>
</h4>
</div>
<div class="sum-number" ng-show="gotSummary">
<h3 class="highlighted-sum ng-binding" ng-bind-html="summary.availableCash|slMoney">
<?=$userinfo['all_gold']?>元
</h3>
<p class="highlighted-sum-caption">可用余额</p>
<a class="btn btn-secondary btn-embossed" href="<?=Url::toRoute('user/pay');?>">
<span class="sl-icon-piggy-bank"></span>
充值
</a>
</div>
</div>
</section>
<section class="summary-section my-asset">
<div class="asset-content">
<div class="ng-scope" ng-if="gotSummary">
<div class="asset-chart">
<div id="asset-chart" data-highcharts-chart="0">
<div id="highcharts-0" class="highcharts-container asset-chart-div" style="position: relative; overflow: hidden; width: 300px; height: 300px; text-align: left; line-height: normal; z-index: 0; font-family: "Lucida Grande","Lucida Sans Unicode",Verdana,Arial,Helvetica,sans-serif; font-size: 12px; left: 0.633301px; top: 0px;">
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="300" height="300">
<defs>
<clipPath id="highcharts-1">
<rect fill="none" x="0" y="0" width="280" height="275">
</clipPath>
</defs>
<rect rx="5" ry="5" fill="#FFFFFF" x="0" y="0" width="300" height="300">
<g class="highcharts-series-group" zIndex="3">
<g class="highcharts-series highcharts-tracker" visibility="visible" zIndex="0.1" transform="translate(10,10) scale(1 1)" style="">
<path fill="#ff9311" d="M 139.97403166652887 10.000002644526859 A 127.5 127.5 0 0 1 267.4999362500053 137.37250002125 L 252.7999436000047 137.3872000188 A 112.8 112.8 0 0 0 139.9770256626232 24.70000233962847 Z" stroke="#FFFFFF" stroke-width="1" stroke-linejoin="round" transform="translate(0,0)" visibility="visible">
<path fill="#141d26" d="M 267.5 137.5 A 127.5 127.5 0 0 1 29.645175264213577 201.35971075360317 L 42.36843741022189 193.9970617490701 A 112.8 112.8 0 0 0 252.8 137.5 Z" stroke="#FFFFFF" stroke-width="1" stroke-linejoin="round" transform="translate(0,0)" visibility="visible">
<path fill="#0dba8f" d="M 29.581370741511023 201.24932401740716 A 127.5 127.5 0 0 1 139.82290505789587 10.000122990720172 L 139.84332306298552 24.700108810613614 A 112.8 112.8 0 0 0 42.311989173666234 193.89940195422372 Z" stroke="#FFFFFF" stroke-width="1" stroke-linejoin="round" transform="translate(0,0)" visibility="visible">
</g>
<g class="highcharts-markers" visibility="visible" zIndex="0.1" transform="translate(10,10) scale(1 1)">
</g>
<g class="highcharts-legend" zIndex="7">
<rect rx="5" ry="5" fill="none" x="0.5" y="0.5" width="7" height="7" stroke="#909090" stroke-width="1" visibility="show">
<g zIndex="1">
<g>
</g>
</g>
</svg>
</div>
</div>
<div class="con-top con-top-a loaded" ng-class="{loaded:loaded}">
<div class="top">
<span class="text">可用余额</span>
<span class="value ng-binding" ng-bind-html="summary.availableCash | slMoney" title="0.00元">
<?=$userinfo['all_gold']?>元
</span>
</div>
<div>
<a class="link" href="<?=Url::toRoute('user/share');?>"></a>
<a class="link" href="<?=Url::toRoute('user/share');?>">邀请好友获得：<?=$userinfo['share_gold']?>元</a>
</div>
</div>
<div class="con-top con-top-b loaded" ng-class="{loaded:loaded}">
<div class="top">
<span class="text">有钱花借款</span>
<span class="value ng-binding" ng-bind-html="summary.inFundingAmount | slMoney" title="">
<?=$userinfo['owe_gold']?>元
</span>
</div>
<div>
<?php if($userinfo['owe_gold']!=""){?>
<a class="link" href="<?=Url::toRoute('activity/borrow');?>">查看还款进度</a>
<?php }else{?>
<a class="link" href="javascript:;">没有欠款</a>
<a class="link" href="<?=Url::toRoute('activity/borrow');?>">去借钱</a>
<?php }?>
</div>
</div>
<div class="con-top con-top-c loaded" ng-class="{loaded:loaded}">
<div class="top">
<span class="text">待收本金</span>
<span class="value ng-binding" ng-bind-html="chartSummary.OutstandingCash.value | slMoney" title="0">
<?=$userinfo['will_gold']?>元
</span>
</div>
<div>
</div>
</div>
</div>
<div id="total-asset" class="total-asset text-center loaded" ng-class="{loaded:loaded}">
<h3 class="ng-binding" ng-bind-html="chartSummary.totalAssets|slMoney">
<?=sprintf("%.2f",$userinfo['all_gold']+$userinfo['will_gold'])?>元
</h3>
<h6 class="text">总资产 </h6></div>
<div class="date-widget">
<span class="plans">团团赚</span>
<div>
<span>持有</span>
<span class="periodNumber">
<a class="ng-binding" href="<?=Url::toRoute('activity/sendgold');?>"><?=$count;?>个项目</a>
</span>
</div>
</div>
</div>
</div>
</section>
<section class="summary-section asset-activity">
</section>
</div>
</div>
</div>
</div>
</div>
</div>