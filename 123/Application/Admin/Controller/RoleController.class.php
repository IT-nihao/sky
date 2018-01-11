<?php
namespace Admin\Controller;
use Think\Controller;
class roleController extends CommonController {
    //角色列表
    public function role_list(){
        $arr=M('yixue_role')->select();
//        print_r($arr);die;
        foreach($arr as $key=>$val){
            $brr=M('yixue_power_role')->join("left join yixue_power on yixue_power_role.yixue_power_id = yixue_power.power_id")->where("yixue_role_id=$val[role_id]")->getField('power_name',true);
            $arr[$key]['power_name']=implode(",",$brr);
        }
        $this->assign("show",$arr);
        $this->display();

    }
    //角色添加
    public function role_add(){
        //添加页面展示
        if(IS_GET){
            $arr=M('yixue_power')->where("power_pid = 0")->select();
            foreach($arr as $key=>$val){
                $arr[$key]['son'] = M('yixue_power')->where("power_pid = $val[power_id]")->select();
            }
            $arr=getNode($arr);
            $this->assign("show",$arr);
            $this->display();
        }
        if(IS_POST){
            $data=I('post.');
            foreach($data as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }
            $id=I('post.yixue_power_id');
            $arr=M('yixue_role')->add($data);
            if($id){
                $data=array();
                foreach($id as $key=>$val){
                    $data[]=array("yixue_role_id"=>$arr,"yixue_power_id"=>$val);
                }
                if(M('yixue_power_role')->addall($data)){
                    $this->success("添加角色成功",U('role_list'));
                }else{
                    $this->error("添加失败");
                }
            }
        }
    }
    //角色修改
    public function role_update(){
        if(IS_GET){
            //所有的权限
            $role_id = I('get.role_id');
//            print_r($role_id);die;
            $data = M('yixue_power')->select();
            $role = M('yixue_role')->field('role_name,role_depict')->where("role_id = '$role_id'")->find();
            $arr=M('yixue_power_role')->where("yixue_role_id = '$role_id'")->getField("yixue_power_id",true);
            foreach($data as $key=>$val){
                if(in_array($val['power_id'],$arr)){
                    $data[$key]['checked']=1;
                }else{
                    $data[$key]['checked']=0;
                }
            }
            $arr=getChild($data);
            $this->assign("show",$arr);
            $this->assign("role",$role);
            $this->display();
        }
        if(IS_POST){
            $role_id=I('post.role_id');
//            print_r($role_id);die;
            $brr['role_name'] = I('post.role_name');
            $brr['role_depict'] = I('post.role_depict');
            foreach($brr as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }
            M('yixue_role')->where("role_id = '$role_id'")->save($brr);
            //删除原先权限
            M('yixue_power_role')->where("yixue_role_id='$role_id'")->delete();
            //获取权限
            $id=I('post.yixue_power_id');
            if($id){
                $data=array();
                foreach($id as $key=>$val){
                    $data[]=array("yixue_role_id"=>$role_id,"yixue_power_id"=>$val);
                }
                if(M('yixue_power_role')->addall($data)){
                    $this->success("重新赋权成功",U('role_list'));
                }else{
                    $this->error("重新赋权失败");
                }
            }
        }

    }
    public function role_delete(){
        $role_id = I('get.role_id');
        M('yixue_power_role')->where("yixue_role_id = '$role_id'")->delete();
        $del = M('yixue_role')->where("role_id = '$role_id'")->delete();
        if($del){
            $this->success("删除成功",U('role_list'),1);
        }
    }

}