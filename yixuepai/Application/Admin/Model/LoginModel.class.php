<?php
namespace Application\Admin\Model;
use Think\Model;
class LoginModel extends Model{
    public $table='yixue_user';
    public function login_do($account,$pwd)
    {
        return M('yixue_login')->where("user_account = '$account' and user_pwd = '$pwd'")->select();
    }
    public function login(){
        return M($this->table)->select();
    }
}
?>