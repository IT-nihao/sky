<?php
namespace Admin\Controller;
use Think\Controller;
class UsersController extends CommonController {
    //管理员添加
    public function users_add()
    {
        if(IS_GET){
            $session = session('yixue_user');
            $id = $session["user_account"];
            if($id == 'admin'){
                $arr = M("yixue_role")->select();
            }else{
                $arr = M("yixue_role")->where("role_id = 27")->select();
            }
            $this->assign('show',$arr);
            $this->display();
        }
        if(IS_POST){
            $arr['user_account']=I('post.user_account');
            $arr['user_pwd']=I('post.user_pwd','','md5');
            $arr['add_time'] = time();
            foreach($arr as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }
            $role_name=I('post.role_name');
            //用户添加返回ID
            $brr =  M('yixue_user')->add($arr);
            if($role_name){
                $data=array();
                foreach($role_name as $key=>$val){
                    $data[]=array("yixue_user_id"=>$brr,"yixue_role_id"=>$val);
                }
                if(M("yixue_user_role")->addall($data)){
                    $this->success("添加用户成功",U('users_list'));
                }else{
                    $this->error("添加用户失败");
                }
            }
        }
    }
    //管理员列表
    public function users_list(){
        $session = session('yixue_user');
        $id = $session["user_id"];
//        print_r($id);die;
        if($id == '1'){
            $arr=M('yixue_user')->select();
        }else{
            $arr=M('yixue_user')->where("user_pid = $id")->select();
        }
        foreach($arr as $key=>$val){
            if(in_array($val['user_account'],C("SUPERROOT"))) {
                $arr[$key]['role_name'] = "超级管理员";
            }else{
                $brr = M('yixue_user_role')->join("left join yixue_role on yixue_user_role.yixue_role_id = yixue_role.role_id")->where("yixue_user_id = '$val[user_id]'")->getField('role_name',true);
                $arr[$key]['role_name']=implode(",",$brr);
            }
        }
        $this->assign('show',$arr);
        $this->display();
    }
    //管理员修改
    public function users_update(){
        if(IS_GET) {
            $user_id = I('get.user_id');
            $session = session('yixue_user');
            $id = $session["user_account"];
            if($id == 'admin'){
                $role = M("yixue_role")->field('role_id,role_name')->select();
            }else{
                $role = M("yixue_role")->field('role_id,role_name')->where("role_id = 27")->select();
            }
            $arr = M("yixue_user_role")->where("yixue_user_id = '$user_id'")->getField("yixue_role_id",true);
            foreach ($role as $key => $val) {
                if (in_array($val['role_id'],$arr)) {
                    $role[$key]['checked'] = 1;
                } else {
                    $role[$key]['checked'] = 0;
                }
            }
            $this->assign("user",$arr);
            $this->assign('role',$role);
            $this->display();
        }
        if(IS_POST){
            $user_id=I('post.user_id');
            $brr['user_account']=I('post.user_account','','md5');
            $brr['user_pwd']=I('post.user_pwd','','md5');
            foreach($brr as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }

            M('yixue_user')->where("user_id = '$user_id'")->save($brr);
            //删除原先权限
            M('yixue_user_role')->where("yixue_user_id='$user_id'")->delete();
            //获取权限
            $id=I('post.yixue_role_id');
            if($id){
                $data=array();
                foreach($id as $key=>$val){
                    $data[]=array("yixue_user_id"=>$user_id,"yixue_role_id"=>$val);
                }
                if(M('yixue_user_role')->addall($data)){
                    $this->success("修改成功",U('users_list'));
                }else{
                    $this->error("修改失败");
                }
            }
        }
    }
    public function users_delete(){
        $user_id = I('get.user_id');
        if(M("yixue_user")->where("user_id = '$user_id'")->delete()){
            $this->success("删除用户成功",U('users_list'),1);
        }else{
            $this->error("删除用户失败");
        }
    }
}