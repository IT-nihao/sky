<?php

use Phalcon\Mvc\Controller;
class SignupController extends Controller
{
    /**
     * 登陆页面
     */
	public function indexAction()
	{
//	    echo 1;die;
	    $arr = $this->request->getPost();
	    //验证是否为post传值
        if($this->request->isPost()){
            $name = $arr['name'];
            $pwd = $arr['pwd'];
        }
        Users::findfirstAction($name,$pwd);
	}

    /**
     * 注册页面
     */
	public function registerAction(){
        $arr = $this->request->getPost();
        if($this->request->isPost()){
            if(!empty($arr['name'])&&!empty($arr['pwd'])){
                $user = new Users();
                $ret = $user->save($arr);
                if($ret){
                    $this->response->redirect("index");
                }
            }else{
                $this->response->redirect("Signup/fourzerofour");
            }
        }
    }

//	public function registerAction()
//	{
//		$user = new Users();
//		// Store and check for errors
//		$success = $user->save(
//			$this->request->getPost(),
//			array('name', 'email')
//		);
//		if ($success) {
//			echo "Thanks for registering!";
//		} else {
//			echo "Sorry, the following problems were generated: ";
//			foreach ($user->getMessages() as $message) {
//				echo $message->getMessage(), "<br/>";
//			}
//		}
//		$this->view->disable();
//	}

/*
 * 404页面
 */
    public function fourzerofourAction(){

    }

}

