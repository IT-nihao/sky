<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        $this->display();
    }
    public function left(){
        $id = session("yixue_user.user_id");
        $user_account = session("yixue_user.user_account");
        if(in_array($user_account,C("SUPERROOT")))
        {
            $sql="select DISTINCT CONCAT(power_controller,'/',power_action) as qx,yixue_power.* from yixue_power where power_status=1;";
            $left=M()->query($sql);
            $left=getChild($left);
        }else{
            $sql="select DISTINCT CONCAT(power_controller,'/',power_action) as qx,yixue_power.* from yixue_power_role left join yixue_power on yixue_power_role.yixue_power_id=yixue_power.power_id where yixue_role_id in(select yixue_role_id from yixue_user_role where yixue_user_id='$id') and yixue_power.power_status=1";
            $left=M()->query($sql);
            $left = getChild($left);
        }
        $this->assign('show',$left);
        $this->display();
    }
    public function top(){
        $this->display();
    }
    public function main(){
        $this->display();
    }
}