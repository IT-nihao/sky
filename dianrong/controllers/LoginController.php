<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\User;
use yii\filters\VerbFilter;
class LoginController extends Controller
{
	public $layout="public";//设置主题
	public $enableCsrfValidation=false;//关闭表单验证
	public function actionLogin(){//登录模块
		if(Yii::$app->request->isPost){
			$post=Yii::$app->request->post();
			$upwd=md5($post['upwd']);
			if($user=User::find()->where(['or',['and',"email='$post[uname]'","upwd='$upwd'"],['and',"tel='$post[uname]'","upwd='$upwd'"]])->asArray()->one()){//存在的话登录成功
				if(!empty($post['rememberMe'])){
					Yii::$app->response->Cookies->add(new \yii\web\Cookie([
					    'name' => 'user',
					    'value' => $user['uid'],
					    'expire'=>time()+3600*24*365,
					]));
				}else{
					Yii::$app->response->Cookies->add(new \yii\web\Cookie([
					    'name' => 'user',
					    'value' => $user['uid'],
					    'expire'=>0,
					]));
				}
				return $this->actionMsg("登录成功","index/index",3);
			}else{//否则登录失败
				return $this->actionMsg("账号或密码错误","login/login",3);
			}
		}else{
			return $this->render("login");
		}
	}
	public function actionReg(){//注册模块
		if(Yii::$app->request->isPost){
			$user=new User();
			$post=Yii::$app->request->post();
			$user->email="$post[email]";
			$user->uname="$post[email]";
			$user->set_num="0";
			$user->count="5";
			$user->upwd=md5($post['upwd']);
			$user->tel="$post[tel]";
			$user->add_time=time();
			$user->all_gold=0;
			$user->into_gold=0;
			$user->share_gold=0;
			$user->will_gold=0;
			$user->owe_gold=0;
			if($user->insert()){
				//创建友情链接
				$id=Yii::$app->db->getLastInsertId();
				$u=User::find()->where("uid=$id")->one();
				$u->fr_link="http://www.p2p.com/index.php?r=login%2Freg&u=".base64_encode($id);
				$u->save();
				//是否存在被邀请
				if(isset($post['share_id'])){
					$share=User::find()->where("uid=$post[share_id]")->one();
					$share->all_gold=$share->all_gold+1;
					$share->share_gold=$share->share_gold+1;
					$share->save();
				}
				return $this->actionMsg("注册成功","login/login",3);
			}else{
				return $this->actionMsg("注册失败","login/reg",3);
			}
		}else{
			$get=Yii::$app->request->get();
			$data=array();
			if(isset($get['u'])){
				$data['share_id']=base64_decode($get['u']);
			}
			return $this->render("reg",$data);
		}
	}
	public function actionLogin_out(){
		$cookies = Yii::$app->response->cookies;
		$cookies->remove('user');
		return $this->actionMsg("登出成功","login/login",3);
	}
	public function actionCheck_email(){
		$email=Yii::$app->request->get("email");
		if(empty($content=User::find()->where("email='$email'")->asArray()->one())){
			echo 0;die;
		}
		echo 1;
	}
	public function actionSendmail(){
		$mail= Yii::$app->mailer->compose();
		$rand=rand(111111,999999);
		$mail->setTo($email=Yii::$app->request->get("email"));  
		$mail->setSubject("注册申请");
		$mail->setHtmlBody("<h2>注册申请</h2><br/><p>您好，您的验证码为：  <font style='color:red;'><b>".$rand."</b></font> 。</p>");
		if($mail->send()){
			echo $rand;
		}else{
			echo "error";
		}
	}
	public function actionMsg($msg,$url,$time=3){
		$data['msg']=$msg;
		$data['url']=$url;
		$data['time']=$time;
		return $this->renderPartial("show_msg",$data);
	}
	public function actionGetname($id){
		$user=User::find()->where("uid=$id")->asArray()->one();
		return $user['uname'];
	}
}