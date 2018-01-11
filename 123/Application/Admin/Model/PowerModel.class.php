<?php
namespace Admin\Model;
use Think\Model;
class PowerModel extends Model{
    protected $tablename = 'yixue_power';
    public function power_lists(){
        $m = M($this->tablename)->select();
        return M($this->tablename)->getLastSql();
    }
    public function search($user_account){
        return M('login')->where("user_account='$user_account'")->find();
    }
    public function login_add($user_account,$user_pwd){
        return M('login')->where("user_account = '$user_account' and user_pwd = '$user_pwd'")->select();
    }
}