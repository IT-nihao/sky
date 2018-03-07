  <?php
  use yii\helpers\Html;
  use yii\bootstrap\Nav;
  use yii\bootstrap\NavBar;
  use yii\widgets\Breadcrumbs;
  use app\assets\AppAsset;
  use yii\helpers\Url;
  use app\models\User;
  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <meta name="description" content="点融网为广大个人和微小企业提供便利的投融资服务。借款产品灵活、大额、费用低、手续快；投资方式人性友好、回报高、百分百本金保护！Dianrong.com provides online efficient investment and financing services for individuals and SMEs. Better rates, lower cost, faster way to borrowers and more flexible investment, higher returns, 100% principal protection to investors." /> 
  <meta name="keywords" content="P2P网贷,P2P网络贷款平台,P2P网络投资平台,P2P投资理财平台,网络贷款平台,团团赚,点融,点融网,点融官网" /> 
  <link rel="shortcut icon" href="images/favicon.ico" />
  <link href="css/bootstrap.min.css" rel="stylesheet" /> 
  <link href="css/components.css?ver=142682356" rel="stylesheet" /> 
  <link href="css/main.css?ver=142682356" rel="stylesheet" /> 
  <link href="css/new-home.css?ver=142682356" rel="stylesheet" />
  <script src="js/jquery.js"></script>
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
  <!--[if lt IE 8]>
<div class="alert alert-warning text-center" style="margin-bottom:0;">
  <p>你的浏览器不支持点融网的一些新特性，请升级你的浏览器至<a href="http://se.360.cn/">360浏览器</a>或<a href="http://browsehappy.com/">Chrome</a>。
  </p>
  <p>正在为你跳转到旧版网站...<a href="index.html">立即跳转</a></p>
  <p>2015年了，IE8老了...</p>
</div>
<![endif]--> 
  <div class="wrapper" style="display:none;"> 
  <script>
    $(function(){
      $(".wrapper").show();
    })
  </script>
   <!--header--> 
   <header class="sl-header new-header ng-scope" ng-controller="HeaderCtrl" id="sl-header"> 
    <nav class="navbar navbar-inverse navbar-static-top site-nav " role="navigation"> 
     <div class="container new-home-container"> 
      <ul class="nav navbar-nav site-nav-sns "> 
       <li> <a href="#" class="icon-sns qq"> 
         <div class="social-content"> 
          <p class="social-title">点融网官方QQ群</p> 
          <p>141444867</p> 
         </div> </a> </li> 
       <li> <a href="http://weibo.com/dianrongwang" target="_blank" class="icon-sns weibo" rel="nofollow"></a> </li> 
       <li> <a href="#" class="icon-sns wechat"> 
         <div class="social-content"> 
          <p class="social-title">扫描关注微信公众号</p> 
          <p><img src="images/qr-code.jpg" /></p> 
         </div> </a> </li> 
      </ul>
      <?php 
      $cookie=Yii::$app->getRequest()->getCookies()->getValue('user');
      if(empty($cookie)){?>
      <ul id="nonLoginBar" class="nav navbar-nav navbar-right navbar-sm site-nav-login"> 
       <li><a id="login-panel" href="<?= Url::toRoute('login/login');?>" rel="nofollow">登录</a></li> 
       <li><a id="create-account" href="<?= Url::toRoute('login/reg');?>" class="btn btn-sm" rel="nofollow">注册账户</a></li> 
      </ul>
      <?php }else{ 
        $arr['id']=$cookie;
        ?>
      <ul class="nav navbar-nav navbar-right navbar-sm site-nav-user"> 
        <li><a id="login-panel" href="<?= Url::toRoute('user/my');?>" rel="nofollow"><?php echo Yii::$app->runAction("login/getname",$arr);?> 的账户</a></li> 
       <li><a id="login-panel" href="<?= Url::toRoute('login/login_out');?>" rel="nofollow">退出</a></li> 
      </ul>
      <?php }?>
     </div> 
    </nav>
        <div class="site-menu"> 
     <div class="header-navbar-container sl-nav-wrapper header-nav-container"> 
      <nav class="navbar navbar-static-top sl-navbar" role="navigation"> 
       <div class="container"> 
        <div class="navbar-header  col-xs-2"> 
         <a class="navbar-brand" href="<?=Url::toRoute('index/index')?>"> <span class="sl-logo">点融网 - DianRong</span> </a> 
        </div> 
        <div class="sl-nav col-xs-10"> 
         <ul class="nav navbar-nav main-menu"> 
          <!--menus--> 
          <li class="main-link-list"> <a class="main-link" href="<?=Url::toRoute('index/help')?>"> <span class="main-link-text">帮助中心</span> </a> </li> 
          <li class="main-link-list"> <a class="main-link" href="<?=Url::toRoute('index/agreement')?>"> <span class="main-link-text">隐私条款</span> </a> </li>  
          <li class="main-link-list"> <a class="main-link" href="<?=Url::toRoute('index/about')?>"> <span class="sl-icon-bold-linkman"></span> <span class="main-link-text">关于我们</span> </a> </li> 
          <li class="main-link-list" ng-class=""> <a class="main-link" href="javascript:;"> <span class="sl-icon-bold-contact"></span> <span class="main-link-text">联系我们</span> </a> </li> 
          <li class="main-link-list phone-contact"> <span class="sl-icon-bold-phone"></span> <span> 400-921-9218</span> </li> 
          <li class="main-link-list contact-bg"> <span class="contact-img"></span> </li> 
         </ul> 
        </div> 
        <!-- /.navbar-collapse --> 
       </div> 
      </nav> 
     </div> 
     <!--secondaryNav--> 
     <!--jumbotron--> 
    </div> 
   </header>
   
 <?= $content ?>
   <div class="bottom-register"> 
    <h3 class="text-center">准备好享受高投资回报了吗？</h3> 
    <div class="text-center"> 
     <a class="btn btn-lg btn-secondary btn-embossed" href="<?=Url::toRoute('login/reg')?>" rel="nofollow" id="scrollToTop">立即注册</a> 
    </div> 
   </div> 
   <!--footer--> 
   <div class="bottom-menu bottom-menu-large bottom-menu-inverse sl-footer open-bottom footer-animate new-footer footer-navbar"> 
    <div class="inside-container"> 
     <div class="row title-row"> 
      <div class="col-xs-4 navbar-logo"> 
       <div class="navbar-brand">
        <a class="logo" href="<?= Url::toRoute('index/index');?>">点融网</a>
       </div> 
      </div> 
      <div class="col-xs-4 navbar-contact"> 
       <div class="support-phone"> 
        <div class="col-xs-3 phone-img"> 
         <span class="phone"></span> 
        </div> 
        <div class="col-xs-9 phone-num"> 
         <span class="number">400-921-9218</span> 
        </div> 
       </div> 
      </div> 
      <div class="col-xs-4 pull-right"> 
       <ul class="bottom-icons social-icons"> 
        <li><a href="#" data-toggle="modal" data-target="#myModal" rel="nofollow"><span class="sl-icon-wechat"></span></a></li> 
        <li><a href="http://weibo.com/dianrongwang" target="_blank" rel="nofollow"><span class="sl-icon-weibo"></span></a></li> 
       </ul> 
      </div> 
     </div> 
     <div class="row"> 
      <div class="col-xs-12"> 
       <div class="row site-map"> 
        <div class="col-xs-4"> 
         <h6 class="title ">公司信息</h6> 
         <ul class="bottom-links"> 
          <li><a href="javascript:;">关于点融网</a></li> 
          <li><a href="javascript:;">公司动态</a></li> 
          <li><a href="javascript:;">媒体报道</a></li> 
          <li><a href="javascript:;">招贤纳士</a></li> 
          <li><a href="javascript:;">联系我们</a></li> 
          <li><a href="javascript:;">点融新享</a></li> 
         </ul> 
        </div> 
        <div class="col-xs-4"> 
         <h6 class="title">相关政策</h6> 
         <ul class="bottom-links"> 
          <li><a href="javascript:;">费率说明</a></li> 
          <li><a href="javascript:;">本金保障</a></li> 
          <li><a href="javascript:;">使用条款</a></li> 
          <li><a href="javascript:;">隐私保护</a></li> 
         </ul> 
        </div> 
        <div class="col-xs-4"> 
         <h6 class="title">手机应用</h6> 
         <ul class="bottom-links"> 
          <li><a href="https://itunes.apple.com/us/app/dian-rong-wang/id725186555?mt=8" target="_blank" ga-event="" ga-category="iosAppLink" ga-action="click" ga-label="footer" ga-value="trackValue" rel="nofollow" class="ng-isolate-scope">iPhone版下载</a></li> 
          <li><a href="http://app.mi.com/detail/56106" target="_blank" ga-event="" ga-category="androidAppLink" ga-action="click" ga-label="footer" ga-value="trackValue" rel="nofollow" class="ng-isolate-scope">Android版下载（测试版）</a></li> 
         </ul> 
         <div class="wechat"> 
          <span class="qr-code">点融网公众号 - dianrongvip</span> 
          <div class="description"> 
           <span class="name">微信公众号</span> 
           <span>点融网</span> 
          </div> 
         </div> 
        </div> 
       </div> 
      </div> 
     </div> 
    </div> 
    <div class="friend-links"> 
     <div class="container friend-container"> 
      <div class="col-xs-1 sign-link"> 
       <p><span class="sl-icon-branch"></span>友情链接</p> 
      </div> 
      <div class="col-xs-11 friend-link-site"> 
       <a href="http://iof.hexun.com/" target="_blank">和讯互联网金融</a> 
       <a href="http://licai.cofool.com/" target="_blank">叩富理财 </a> 
       <a href="http://www.jinfuzi.com/p2p/" target="_blank">金斧子理财</a> 
       <a href="http://www.trustores.cn/" target="_blank">香港保险</a> 
       <a href="http://www.asiafinance.cn/" target="_blank">金融导航</a> 
       <a href="http://www.fxsol-uk.com/" target="_blank">Fxsol官网</a> 
       <a href="http://www.guijinshu.com/" target="_blank">贵金属</a> 
       <a href="http://www.dingniugu.com/" target="_blank">顶牛股网</a> 
       <a href="http://www.ucai123.com/" target="_blank">航运指数</a> 
       <a href="http://www.szjstz.cn/" target="_blank">金苏财富</a> 
      </div> 
     </div> 
     <div class="container"> 
      <div class="text-center copyright">
        &copy;2014 点融网沪ICP备14028311号上海点荣金融信息服务有限责任公司 
      </div> 
     </div> 
    </div> 
   </div> 
   <div class="modal fade wechat-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-sm"> 
     <div class="modal-content"> 
      <div class="modal-header"> 
       <button type="button" class="close sl-icon-cross" data-dismiss="modal" aria-hidden="true"></button> 
       <h6 class="modal-title" id="myModalLabel">关注点融网官方微信</h6> 
      </div> 
      <div class="modal-body"> 
       <div class="wechat-subscription"> 
        <h6>点融网订阅号</h6> 
        <p>了解各种点融咨询</p> 
        <img src="images/qrcode-dianrongapi.jpg" alt="点融网订阅号" /> 
        <p>dianrongapi</p> 
       </div> 
       <div class="wechat-service"> 
        <h6>点融网服务号</h6> 
        <p>查询投资情况</p> 
        <img src="images/qrcode-dianrongvip.jpg" alt="点融网服务号" /> 
        <p>dianrongvip</p> 
       </div> 
      </div> 
      <div class="modal-footer">
        添加方式：打开微信，点击″发现″菜单，使用″扫一扫″功能；或者在微信中点击&quot;联系人&quot;，添加以上英文账号名为好友。 
      </div> 
     </div>
     <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
   </div>
   <!-- /.modal --> 
  </div> 