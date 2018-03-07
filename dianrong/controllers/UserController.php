<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\User;
use app\models\Card;
use app\models\History;
use app\models\Borrow;
use app\models\Buy;
class UserController extends Controller
{
	public $layout='user';
	public $cookie="";
	public $userinfo="";
	public $enableCsrfValidation = false;
	public function init(){
		$this->cookie=Yii::$app->getRequest()->getCookies()->getValue('user');
		if(!empty($this->cookie)){
			$this->userinfo=User::find()->where("uid=$this->cookie")->asArray()->one();
		}
	}
	public function actionMy(){//我的主页
		if(empty($this->cookie)){
			return $this->actionMsg("请先登录","login/login",3);
		}
		$data['count']=count(Buy::find("uid=$this->cookie and status=0")->asArray()->all());
		$data['userinfo']=$this->userinfo;
		return $this->render("index",$data);
	}
	public function actionInfo(){//我的信息
		if(empty($this->cookie)){
			return $this->actionMsg("请先登录","login/login",3);
		}
		$data['userinfo']=$this->userinfo;
		return $this->render("info",$data);
	}
	public function actionShare(){//邀请好友
		if(empty($this->cookie)){
			return $this->actionMsg("请先登录","login/login",3);
		}
		$data['userinfo']=$this->userinfo;
		return $this->render("share",$data);
	}
	public function actionPay(){//充值提现
		if(empty($this->cookie)){
			return $this->actionMsg("请先登录","login/login",3);
		}
		$data['status']=1;//默认全部验证成功
		if($this->userinfo['id_card']==''){
			$data['status']=2;//设置为没有绑定身份信息
		}
		$my_card=Card::find()->where("uid=$this->cookie")->asArray()->all();
		$data['my_card']=$my_card;
		if(empty($my_card)){
			$data['my_card']="";
			$data['status']=3;//没有绑定银行卡信息
		}
		$data['userinfo']=$this->userinfo;
		return $this->render("pay",$data);
	}
	public function actionMy_card(){
		if(empty($this->cookie)){
			return $this->actionMsg("请先登录","login/login",3);
		}
		$data['status']=1;
		if($this->userinfo['id_card']==''){
			$data['status']=2;//设置为没有绑定身份信息
		}
		$my_card=Card::find()->where("uid=$this->cookie")->asArray()->all();
		$data['my_card']=$my_card;
		if(empty($my_card)){
			$data['my_card']="";
		}
		$data['userinfo']=$this->userinfo;
		return $this->render("my_card",$data);
	}
	public function actionMsg($msg,$url,$time=3){//跳转方法
		$data['msg']=$msg;
		$data['url']=$url;
		$data['time']=$time;
		return $this->renderPartial("show_msg",$data);
	}
	public function actionAdd_mycard(){//添加银行卡
		$info=Yii::$app->request->get();
		if(Card::find()->where("number=$info[number]")->one()){
			echo 2;die;
		}
		$card= new Card();
		$card->uid=$info['uid'];
		$card->user_name=$info['user_name'];
		$card->number=$info['number'];
		if($card->insert()){
			echo 1;
		}else{
			echo 0;
		}
	}
	public function actionTocard(){//提现和充值操作 执行方法
		$post=Yii::$app->request->post();
		$user=User::find()->where("uid=$this->cookie")->one();
		if($post['type']=="提现"){
			if($this->userinfo['all_gold']>=$post['gold']){
				$user->all_gold=$this->userinfo['all_gold']-$post['gold'];
				$user->save();
				$this->actionAddhistory("提现到银行卡：".trim($post['card_number']),"余额",$post['gold']);
				echo 1;die;
			}else{
				echo 0;die;
			}
		}else{
			$user->all_gold=$this->userinfo['all_gold']+$post['gold'];
			$user->save();
			$this->actionAddhistory("充值","银行卡：".trim($post['card_number']),$post['gold']);
			echo 1;die;
		}
	}
	public function actionBorrow_do(){//有钱花借款
		$post=Yii::$app->request->post();
		$user=User::find()->where("uid=$this->cookie")->one();
		$t=date("m",time());
		$y=date("Y",time());
		$str='';
		for($i=1;$i<=$post['type'];$i++){
			if($t>=12){
				$t=1;
				$y++;
				$str.=",".$y."-".$t."-20";
			}else{
				$t++;
				$str.=",".$y."-".$t."-20";
			}
		}
		$str=substr($str,1);
		$borrow=new Borrow();
		$borrow->type=$post['type'];
		$borrow->gold=$post['gold'];
		$borrow->all_gold=$post['all_gold'];
		$borrow->lixi=$post['lixi'];
		$borrow->month_gold=$post['month_gold'];
		$borrow->last_month_gold=$post['last_month_gold'];
		$borrow->add_time=time();
		$borrow->will_month=$str;
		$borrow->ready_month=0;
		$borrow->uid=$this->cookie;
		$this->actionAddhistory("有钱花借款","有钱花",$post['gold']);
		if($borrow->insert()){
			$user->owe_gold=$this->userinfo['owe_gold']+$post['all_gold'];
			$user->all_gold=$this->userinfo['all_gold']+$post['gold'];
			$user->save();
			echo 1;
		}else{
			echo 0;
		}
	}
	public function actionHuan(){//有钱花还款
		$post=Yii::$app->request->post();
		$borrow=Borrow::find()->where("bid=$post[bid]")->one();
		$borrow->ready_month=$post['ready_month']+1;
		$borrow->save();
		$user=User::find()->where("uid=$this->cookie")->one();
		$user->all_gold=$this->userinfo['all_gold']-$post['gold'];
		$user->owe_gold=$this->userinfo['owe_gold']-$post['gold'];
		if($post['ready_month']+1==$post['type']){
			$user->owe_gold=0;
		}
		if($user->save()){
			$this->actionAddhistory("有钱花还款第$borrow[ready_month]期","余额",$post['gold']);
			echo 1;
		}else{
			echo 0;
		}
	}
	public function actionBuyactivity(){//购买理财产品
		$post=Yii::$app->request->post();
		$user=User::find()->where("uid=$this->cookie")->one();
		$user->all_gold=$this->userinfo['all_gold']-$post['start_gold'];
		$user->will_gold=$post['end'];
		$user->save();
		$buy= new Buy();
		$buy->aid=$post['aid'];
		$buy->uid=$this->cookie;
		$buy->start_time=time();
		$buy->end_time=time()+3600*24*$post['t'];
		$buy->start_gold=$post['start_gold'];
		$buy->end_gold=$post['end'];
		$buy->is_back=0;
		$buy->status=0;
		$buy->insert();
		if($this->actionAddhistory("购买".$post['title'],"余额",$post['start_gold']))
		{
			echo 1;
		}else{
			echo 0;
		}
	}
	public function actionAddhistory($message,$type,$gold){//增加历史交易记录方法
		$history= new History();
		$history->message=$message;
		$history->no=date("YmdHis",time()).rand(111111,999999);
		$history->type=$type;
		$history->gold=$gold;
		$history->uid=$this->cookie;
		$history->addtime=time();
		$history->insert();
		return true;
	}
	public function actionHistory(){//历史记录列表
		if(empty($this->cookie)){
			return $this->actionMsg("请先登录","login/login",3);
		}
		$get=Yii::$app->request->get();
		$p= isset($get['p']) ? $get['p'] : 1;
		$where="uid=".$this->cookie;
		if(!empty($get['t'])){
			$arr=explode("-",$get['t']);
			$where="uid=".$this->cookie." and addtime>=".strtotime($arr[0])." and addtime <".strtotime($arr[1]);
		}
		$offset=($p-1)*10;
		$data['list']=History::find()->where($where)->offset($offset)->limit(10)->asArray()->all();
		$data['max']=ceil(History::find()->where($where)->count()/10);
		$data['p']=$p;
		$data['userinfo']=$this->userinfo;
		if(Yii::$app->request->isAjax){
			if($data['list']!=""){
				foreach($data['list'] as $k=>$v){
					$data['list'][$k]['addtime']=date("Y-m-d H:i:s",$v['addtime']);
				}
			}
			echo json_encode($data);
		}else{
			return $this->render("history",$data);
		}
	}
	public function actionUp(){//个人信息修改方法
		$clu=Yii::$app->request->get("clu");
		$value=Yii::$app->request->get("value");
		if($clu=="upwd"){
			$value=md5($value);
		}
		$count=Yii::$app->request->get("count");
		$user=User::find()->where("uid=$this->cookie")->one();
		$user->$clu=$value;
		if($count!=0&&$this->userinfo['count']<8){
			$user->count=$this->userinfo['count']+1;
		}
		if($clu=="uname"){
			$user->set_num=1;
		}
		echo $user->save();
	}
	public function actionCheckpwd(){//检查密码
		$pwd=Yii::$app->request->get("pwd");
		if(md5($pwd)!=$this->userinfo['upwd']){
			echo 0;
		}else{
			echo 1;
		}
	}
	public function actionFaceupload(){//上传用户头像
		$return=array("success"=>1,"src"=>"");
		$myfile=$_FILES['myfile'];
		$arr=explode(".",$myfile['name']);
		$file_type=array_pop($arr);
		$newName="uploads/".time().rand(11111,99999).".".$file_type;
		if(move_uploaded_file($myfile['tmp_name'],$newName)){
			echo $newName;
		}else{
			echo 0;
		}
	}
}
?>