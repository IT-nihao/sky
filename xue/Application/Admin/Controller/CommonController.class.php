<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller
{
    public function __construct(){
        parent::__construct();
        $session=session('yixue_user');
        $cookie=cookie('yixue_user');
        if(!empty($cookie)&&empty($session)){
            session("yixue_user",$cookie);
            $session=session('yixue_user');
        }
        if(empty($session)){
            $this->error("非法登录",U('Login/login'));
        }
        $this->checkPriv();
    }
    public function checkPriv(){
        $id = session("yixue_user.user_id");
        $ff=ACTION_NAME;
        $kzq=CONTROLLER_NAME;
        $user_name=session('yixue_user.user_account');
        if(in_array($user_name,C('SUPERROOT'))){
            return true;
        }
        if(in_array($kzq,C('SUPERCONTROLLER'))){
            return true;
        }
        $l=$kzq.'|'.$ff;
        $sql="select DISTINCT CONCAT(power_controller,'|',power_action) as qx from yixue_power_role left join yixue_power on yixue_power_role.yixue_power_id = yixue_power.power_id where yixue_role_id in(select yixue_role_id from yixue_user_role where yixue_user_id='$id'
)";
        $assoc=M()->query($sql);
        $data=array();
        foreach($assoc as $val){
            $data[]=$val['qx'];
        }
        if(!in_array($l,$data)){
            $this->error('无权','',1);
        }
    }
}
