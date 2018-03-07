<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\User;
class IndexController extends Controller
{
	public $layout='public';
	public function actionIndex(){
		$uid=Yii::$app->getRequest()->getCookies()->getValue('user');
		$data=array();
		if(!empty($uid)){
			$data['userinfo']=User::find()->where("uid=$uid")->asArray()->one();
		}
		return $this->render("index",$data);
	}
	public function actionAbout(){//加载关于我们
		return $this->render("about");
	}
	public function actionHelp(){//加载帮助中心
		return $this->render("help");
	}
	public function actionAgreement(){//加载隐私条款
		return $this->render("agreement");
	}
}
?>