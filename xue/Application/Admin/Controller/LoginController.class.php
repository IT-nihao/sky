<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
        $this->display();
    }
    public function login_add(){
        $account = I('post.account');
        $password = I('post.pwd','','md5');
        $mima = array("user_account"=>$account,"user_pwd"=>$password);
        $auto = I('post.rem');
        $b = M('yixue_partner')->where("partner_code = '$account' and user_pwd = '$password' and open_close = 1")->find();
        $cishu = S('cishu');
        if($cishu>4){
            $this->error("请一个小时后再来");
        }else{
            if($b){
                if($auto==1)
                {
                    $yixue_user = array("user_id"=>$b['user_id'],"user_account"=>$account,"user_pwd"=>$password);
                    $user = base64_encode(serialize($yixue_user));
                    cookie("yixue_user",$user,3600*7*24);
                }
                session("yixue_user",$yixue_user);
                $this->success("登陆成功",U('Index/index'),'1');
            }else{
                S('cishu',$cishu+1,10);
                if($cishu>4){
                    $this->error("请一个小时后再来");
                }
                $this->error("您已经连续输错入".$cishu."次密码",'',1);
            }
        }
    }
    public function forget_pwd(){
        $this->display();
    }
    public function forget(){
        $partner_code = I('post.partner_code');
        $email = I('post.email');
        $s_num=rand(1000,9999);
        $arr = M("yixue_partner")->field("user_id,email")->where("partner_code = '$partner_code'")->find();

        if($arr){
            $data['msg'] = 1;
            $data['rand'] = $s_num;
            $data['email'] = $arr['email'];
        }else{
            $data['msg'] = 0;
        }
        echo json_encode($data);
    }
    public function forget_code(){

        $partner_code = I('post.partner_code');
        $email = I('post.email');
        $s_num=rand(1000,9999);
        send('易学派找回密码邮件',$s_num,'易学派',$email);
        $arr = M("yixue_partner")->field("user_id,email")->where("partner_code = '$partner_code'")->find();

        if($arr){
            $data['msg'] = 1;
            $data['rand'] = $s_num;
            $data['email'] = $arr['email'];
        }else{
            $data['msg'] = 0;
        }
        echo json_encode($data);
    }
    public function update_pwd(){
        if(IS_GET){
            $partner_code = I('get.code');
            $this->assign('code',$partner_code);
            $this->display();
        }
        if(IS_POST){
            $where['partner_code'] = I('post.partner_code');
            $save['user_pwd'] = I('post.new_pwd','','md5');
            $arr = M("yixue_partner")->where($where)->save($save);
            $sql = M()->getLastSql();
            if($arr){
                $this->success("修改成功",U('Login/login'));
            }else{
                $this->error("修改失败");
            }
        }

    }
}