<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
//        echo 4;
        $this->display();
        //        phpinfo();die;
//        $redis = new \Redis();
//        print_r($redis);die;
//        $redis->connect('127.0.0.1',6379);//通过看源码这里的127.0.0.1应该改为Redis 或则直接把这句去掉 都可以
//        $arr[] = array("key","123");
//        $brr = array("y","asd");
//        $arr = json_encode($arr);
//        $redis->set('test',$arr);
//        $ar = $redis->get('test');
//        echo $ar;die;
//        print_r(json_decode($ar));die;
//        $arr = array("a"=>"acc","b"=>"bcc");
//        S('arr',$arr,30);
//        echo 2;die;
    }
    public function left(){
        $id = session("yixue_user.user_id");
//        echo $id;die;
        $user_account = session("yixue_user.user_account");
//        print_r($user_account);die;
        if(in_array($user_account,C("SUPERROOT")))
        {
//            echo 1;die;
            $sql="select DISTINCT CONCAT(power_controller,'/',power_action) as qx,yixue_power.* from yixue_power where power_status=1;";
            $left=M()->query($sql);
            $left=getChild($left);
//            print_r($left);die;
        }else{
//            echo 2;die;
            $sql="select DISTINCT CONCAT(power_controller,'/',power_action) as qx,yixue_power.* from yixue_power_role left join yixue_power on yixue_power_role.yixue_power_id=yixue_power.power_id where yixue_role_id in(select yixue_role_id from yixue_user_role where yixue_user_id='$id') and yixue_power.power_status=1";
            $left=M()->query($sql);
            $left = getChild($left);
        }
//        print_r($left);die;
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