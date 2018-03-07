
            <div id="notifications" ng-show="notify.messages.msg.length & gt; 0" class="ng-cloak affix-top" data-spy="affix" data-offset-top="0"> 
                <div class="container"> 
                    <div class="msg-fold-up" ng-class="{ 'alert-success' : notify.messages.type == 'success', 'alert-danger' : notify.messages.type == 'error', 'alert-info' : notify.messages.type == 'info' }"> 
                    </div> 
                    <div class="alert msg-content"> 
                        <a type="button" class="close sl-icon-cross" ng-click="notify.dismiss($index)" aria-hidden="true"></a> 
                        <p ng-repeat="m in notify.messages.msg track by $index" ng-bind-html="m"></p> 
                    </div> 
                    <div class="msg-fold-down" ng-class="{ 'alert-success' : notify.messages.type == 'success', 'alert-danger' : notify.messages.type == 'error', 'alert-info' : notify.messages.type == 'info' }"> 
                    </div> 
                </div> 
            </div> 
            <!--content--> 
            <div class="container help-container">
                <div class="ng-scope" autoscroll="false" ui-view="" style="">
                    <div id="faq-main" class="container ng-scope">
                        <div class="row">
                            <div class="col-xs-7">
                                <div class="faq-header">
                                    <h4>问题分类</h4>
                                </div>
                                <div class="faq-content">
                                    <div class="faq-category ng-scope" ng-repeat="cat in faqs">
                                        <div class="row cat-header">
                                            <div class="col-xs-8">
                                                <h6 class="category-header faq-category-icon icon0">关于点融网</h6>
                                            </div>
                                            <div class="col-xs-4 view-all-col">
                                                <a class="view-all ng-binding" ui-sref="faqTopic({ categoryId: cat.cid })" href="#/faq/topic/0">查看所有14个问题</a>
                                            </div>
                                        </div>
                                        <div class="row cat-item">
                                            <ul class="item-ul list-unstyled">
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/0/0">点融网什么时候成立的？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/0/1">点融网和其他P2P网站有什么不同？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/0/2">点融网的合法经营的资质？</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="faq-category ng-scope" ng-repeat="cat in faqs">
                                        <div class="row cat-header">
                                            <div class="col-xs-8">
                                                <h6 class="category-header faq-category-icon icon1">P2P百科与政策</h6>
                                            </div>
                                            <div class="col-xs-4 view-all-col">
                                                <a class="view-all ng-binding" ui-sref="faqTopic({ categoryId: cat.cid })" href="#/faq/topic/1">查看所有9个问题</a>
                                            </div>
                                        </div>
                                        <div class="row cat-item">
                                            <ul class="item-ul list-unstyled">
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/1/0">什么是抵押标？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/1/1">什么是P2P？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/1/2">P2P业务是否是合法的？</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="faq-category ng-scope" ng-repeat="cat in faqs">
                                        <div class="row cat-header">
                                            <div class="col-xs-8">
                                                <h6 class="category-header faq-category-icon icon2">注册与登陆</h6>
                                            </div>
                                            <div class="col-xs-4 view-all-col">
                                                <a class="view-all ng-binding" ui-sref="faqTopic({ categoryId: cat.cid })" href="#/faq/topic/2">查看所有10个问题</a>
                                            </div>
                                        </div>
                                        <div class="row cat-item">
                                            <ul class="item-ul list-unstyled">
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/2/0">注册过程中输入错误信息怎么办？以后可以修改吗？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/2/1">点融网支持哪些网银？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/2/2">点融网支持哪些浏览器？</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="faq-category ng-scope" ng-repeat="cat in faqs">
                                        <div class="row cat-header">
                                            <div class="col-xs-8">
                                                <h6 class="category-header faq-category-icon icon3">利率与费用</h6>
                                            </div>
                                            <div class="col-xs-4 view-all-col">
                                                <a class="view-all ng-binding" ui-sref="faqTopic({ categoryId: cat.cid })" href="#/faq/topic/3">查看所有3个问题</a>
                                            </div>
                                        </div>
                                        <div class="row cat-item">
                                            <ul class="item-ul list-unstyled">
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/3/0">在点融网投资或者贷款，需要支付哪些费用？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/3/1">点融网给投资人提供了什么样的优惠的收益？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/3/2">点融网如何决定借款利率？</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="faq-category ng-scope" ng-repeat="cat in faqs">
                                        <div class="row cat-header">
                                            <div class="col-xs-8">
                                                <h6 class="category-header faq-category-icon icon4">投资团团赚</h6>
                                            </div>
                                            <div class="col-xs-4 view-all-col">
                                                <a class="view-all ng-binding" ui-sref="faqTopic({ categoryId: cat.cid })" href="#/faq/topic/4">查看所有10个问题</a>
                                            </div>
                                        </div>
                                        <div class="row cat-item">
                                            <ul class="item-ul list-unstyled">
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/4/0">团团赚安全吗？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/4/1">什么是团团赚？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/4/2">个标与团团赚有什么不同？</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="faq-category ng-scope" ng-repeat="cat in faqs">
                                        <div class="row cat-header">
                                            <div class="col-xs-8">
                                                <h6 class="category-header faq-category-icon icon5">投资散标</h6>
                                            </div>
                                            <div class="col-xs-4 view-all-col">
                                                <a class="view-all ng-binding" ui-sref="faqTopic({ categoryId: cat.cid })" href="#/faq/topic/5">查看所有22个问题</a>
                                            </div>
                                        </div>
                                        <div class="row cat-item">
                                            <ul class="item-ul list-unstyled">
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/5/0">什么是散标？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/5/1">散标与团团赚有什么不同？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/5/2">投标前我需要注意的事项？</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="faq-category ng-scope" ng-repeat="cat in faqs">
                                        <div class="row cat-header">
                                            <div class="col-xs-8">
                                                <h6 class="category-header faq-category-icon icon6">保障与安全</h6>
                                            </div>
                                            <div class="col-xs-4 view-all-col">
                                                <a class="view-all ng-binding" ui-sref="faqTopic({ categoryId: cat.cid })" href="#/faq/topic/6">查看所有19个问题</a>
                                            </div>
                                        </div>
                                        <div class="row cat-item">
                                            <ul class="item-ul list-unstyled">
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/6/0">本金保障计划是由点融网保障本金吗？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/6/1">点融坏账率是多少？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/6/2">我在点融网的资金安全吗？</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="faq-category ng-scope" ng-repeat="cat in faqs">
                                        <div class="row cat-header">
                                            <div class="col-xs-8">
                                                <h6 class="category-header faq-category-icon icon7">充值、投资与提现</h6>
                                            </div>
                                            <div class="col-xs-4 view-all-col">
                                                <a class="view-all ng-binding" ui-sref="faqTopic({ categoryId: cat.cid })" href="#/faq/topic/7">查看所有9个问题</a>
                                            </div>
                                        </div>
                                        <div class="row cat-item">
                                            <ul class="item-ul list-unstyled">
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/7/0">充值是必须的吗？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/7/1">我们如何充值？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/7/2">手机收不到验证码怎么办？</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="faq-category ng-scope" ng-repeat="cat in faqs">
                                        <div class="row cat-header">
                                            <div class="col-xs-8">
                                                <h6 class="category-header faq-category-icon icon8">借款</h6>
                                            </div>
                                            <div class="col-xs-4 view-all-col">
                                                <a class="view-all ng-binding" ui-sref="faqTopic({ categoryId: cat.cid })" href="#/faq/topic/8">查看所有25个问题</a>
                                            </div>
                                        </div>
                                        <div class="row cat-item">
                                            <ul class="item-ul list-unstyled">
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/8/0">借款申请条件有哪些？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/8/1">借款的申请流程是怎样的？</a>
                                                </li>
                                                <li class="hot-item ng-scope" ng-repeat="item in cat.faq| limitTo:categoryItemLimit">
                                                    <a class="ng-binding" ui-sref="faqArticle({ categoryId: cat.cid, questionId: item.fid })" href="#/faq/article/8/2">借款额度是多少？</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <div class="faq-header">
                                    <h4>新手指南</h4>
                                </div>
                                <div class="faq-content new-user-videos row">
                                    <div class="col-xs-6">
                                        <a class="caption-img text-center" href="javascript:alert('还充钱，智障！');">
                                            <img src="images/how-to-recharge.png">
                                            <span>如何充值 》</span>
                                        </a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a class="caption-img text-center" href="javascript:alert('团团赚？我信吗？？');">
                                            <img src="images/how-to-groupbuy.png">
                                            <span>如何投资团团赚 》</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="faq-header">
                                    <h4>热门问题</h4>
                                </div>
                                <div class="faq-content hot-faq-content">
                                    <ul class="list-unstyled ng-isolate-scope" search="search" simple-limit="10" hot-faq="faqs[0].faq">
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/0">点融网什么时候成立的？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">2012年成立，2013年3月正式上线。</span>
                                            </p>
                                        </li>
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/1">点融网和其他P2P网站有什么不同？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">1. 我们不参与交易，借款人支付的利息100%会给到平台的投资人。 2. 领先的LendingClub技术，使用团团赚投资，让100元也能极度分散到成千上万的项目里面。</span>
                                            </p>
                                        </li>
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/2">点融网的合法经营的资质？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">点融网由上海点荣金融信息服务有限责任公司营运，具有金融信息服务资质，根据我国法律登记成立，完全合法。</span>
                                            </p>
                                        </li>
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/3">点融网是否有从事借贷业务的资格？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">我们公司有上海市金融办支持，持有金融信息服务牌照。民间借贷是受到《中华人民共和国民法通则》、《关于贯彻执行〈中华人民共和国民法通则〉若干问题的意见》、《最高人民法院关于人民法院审理借贷案件的若干意见》等法律法规、司法解释保护的一种借贷关系。我们提供的的是金融信息服务，并非借贷业务。</span>
                                            </p>
                                        </li>
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/4">加入点融网有什么好处？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">当您需要资金时，点融网利用技术真正降低借贷成本，更容易借到款。 当您有闲余资金时，可以选择适合您的借款标来投资，提高您的投资回报收益。</span>
                                            </p>
                                        </li>
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/5">点融网的客户是哪些人？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">点融网借款的客户主要是中小企业，以及有固定收入的个人。点融网的投资者则来自各行各业、五湖四海，他们对互联网理财有着自己见解。</span>
                                            </p>
                                        </li>
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/6">点融网有线下服务网点吗？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">点融网目前在13个城市有服务网点，主要服务有贷款需求的企业以及个人，做地面现审工作。总公司位于上海市蒙自路207号1号楼5层，上班时间为周一到周五，上午9:30到下午18:30 。如需咨询网点，请拨打客服电话：400-921-9218；或者发送邮件到：support@dianrong.com</span>
                                            </p>
                                        </li>
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/7">点融网的诚信怎么体现？点融网的透明高效体现在哪里？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">点融网的投资标的信息对外公开。投资者可以看到所有投资资金的去向及实时还款情况。</span>
                                            </p>
                                        </li>
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/8">加入点融网投资人有什么优惠活动吗？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">我们不定期会举行优惠活动，建议你拨打客服电话400-921-9218，也可关注点融网微信平台（微信搜索点融网或dianrongapi）</span>
                                            </p>
                                        </li>
                                        <li class="hot-qa ng-scope" ng-repeat="sf in simpleFaq| filter:search| limitTo: simpleLimit">
                                            <span class="hot-qa-ask">
                                                <span class="ask">问：</span>
                                                <a class="ng-binding" ng-bind-html="getHtml(sf.question)" href="#/faq/article/0/9">点融网是外资公司吗？</a>
                                            </span>
                                            <p class="hot-qa-answer">
                                                <span class="ask">答：</span>
                                                <span class="only-answer ng-binding" ng-bind-html="getHtml(sf.answer)">点融网是国内合资公司。</span>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>