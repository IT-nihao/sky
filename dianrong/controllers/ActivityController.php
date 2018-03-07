<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\User;
use app\models\Card;
use app\models\History;
use app\models\Borrow;
use app\models\Activity;
use app\models\Buy;
class ActivityController extends Controller
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
	public function actionBorrow(){
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
		$data['borrow']=Borrow::find()->where("uid=$this->cookie")->asArray()->all();
		if(!empty($data['borrow'])){
			$y=date("Y",time());
			$m=date("m",time());
			foreach($data['borrow'] as $k=>$v){
				$t=explode(",",$v['will_month']);
				if(strtotime($t[$v['ready_month']])>strtotime($y."-".$m."-20")+3600*24*60){
					$data['borrow'][$k]['now_month']=1;
				}else{
					$data['borrow'][$k]['now_month']=0;
				}
			}
		}
		$data['userinfo']=$this->userinfo;
		return $this->render("borrow",$data);
	}
	public function actionSendgold(){
		if(empty($this->cookie)){
			return $this->actionMsg("请先登录","login/login",3);
		}
		$data['activity']=Activity::find()->asArray()->all();
		$data['is_buy']=Buy::find()->where("uid=$this->cookie and status=0")->asArray()->all();
		$data['buied']=array();
		foreach($data['activity'] as $k1=>$v1){
			$data['activity'][$k1]['is_buy']=0;
		}
		$data['all_start_gold']=0;
		$data['all_end_gold']=0;
		if(!empty($data['is_buy'])){
			foreach($data['is_buy'] as $k=>$v){
				$data['buied'][]=array("aid"=>$v['aid'],"id"=>$k);
			}
			foreach($data['activity'] as $k1=>$v1){
				$data['activity'][$k1]['is_buy']=0;
				if(!empty($data['buied'])){
					foreach($data['buied'] as $k=>$v){
						if($v['aid']==$v1['aid']){
							$data['activity'][$k1]['is_buy']=1;
							$data['activity'][$k1]['start_time']=$data['is_buy'][$v['id']]['start_time'];
							$data['activity'][$k1]['end_time']=$data['is_buy'][$v['id']]['end_time'];
							$data['activity'][$k1]['buy_start_gold']=$data['is_buy'][$v['id']]['start_gold'];
							$data['activity'][$k1]['end_gold']=$data['is_buy'][$v['id']]['end_gold'];
							$data['all_start_gold']+=$data['is_buy'][$v['id']]['start_gold'];
							$data['all_end_gold']+=$data['is_buy'][$v['id']]['end_gold'];
						}
					}
				}
			}
		}
		$data['count']=count($data['buied']);
		$data['userinfo']=$this->userinfo;
		return $this->render("sendgold",$data);
	}
}