<?php
namespace Admin\Controller;
use Think\Controller;
class PowerController extends CommonController {
    //权限列表
    public function power_list(){
//        $power_name = I("get.power_name");
//        $arr= page("yixue_power","power_name",$power_name,"power_id,power_name,power_controller,power_action,power_pid,power_status","power_name");
        $arr = M('yixue_power')->field('power_id,power_name,power_controller,power_action,power_pid,power_status')->select();
//        print_r($data);die;
//        $data =  getNode($arr['arr']);
//        print_r($arr);
//        $this->assign('count',$arr['count']);
//        $this->assign('page',$arr['page']);
        $this->assign('power',$arr);
        $this->display();
    }
    //权限添加
    public function power_add(){
        //添加页面展示
        if(IS_GET){
            $arr = M('yixue_power')->select();
            $arr =  getNode($arr);
            $this->assign('select',$arr);
            $this->display();
        }
        //权限添加
        if(IS_POST){
            $data = I('post.');
//            print_r($data);die;
            if(!preg_match("/^[\x7f-\xff]+$/", $data['power_name'])){
                $this->error("权限名称不能是除中文以外的字符！");
            }
            if(preg_match("/^[\x7f-\xff]+$/", $data['power_controller'])){
                $this->error("控制器名称不能是除英文以外的字符！");
            }
            if(preg_match("/^[\x7f-\xff]+$/", $data['power_action'])){
                $this->error("方法名称不能是除英文以外的字符！");
            }
//            foreach($data as $v){
//                if(empty($v)){
//                    $this->error("每个选项都要填哦！");
//                }
//            }
            $arr = M('yixue_power')->add($data);
            if($arr){
                $this->success("添加权限成功",U('power_list'),1);
            }else{
                $this->error("添加权限失败",'',1);
            }
        }
//        $data['power_name'] = I('post.power_name');
//        $data['power_controller'] = I('post.power_controller');
//        $data['power_action'] = I('post.power_action');
//        $data['power_pid'] = I('post.power_pid');
//        $data['power_status'] = I('post.power_status');
    }
    //权限修改
    public function power_update(){
        if(IS_GET){
            $brr = M('yixue_power')->select();
            $select =  getNode($brr);
            $power_id=I('get.power_id');
//            echo $power_id;die;
            $arr=M('yixue_power')->where("power_id = '$power_id'")->find();
//            print_r($arr);die;
            $this->assign("update",$arr);
            $this->assign("select",$select);
            $this->display();
        }
        if(IS_POST){
            $power_id=I('post.power_id');
            $data=array("power_pid"=>I('power_pid'),"power_status"=>I('power_status'),"power_controller"=>I('post.power_controller'),"power_action"=>I('post.power_action'),"power_name"=>I('post.power_name'));
            if(!preg_match("/^[\x7f-\xff]+$/", $data['power_name'])){
                $this->error("权限名称不能是除中文以外的字符！");
            }
            if(preg_match("/^[\x7f-\xff]+$/", $data['power_controller'])){
                $this->error("控制器名称不能是除英文以外的字符！");
            }
            if(preg_match("/^[\x7f-\xff]+$/", $data['power_action'])){
                $this->error("方法名称不能是除英文以外的字符！");
            }
            $arr=M('yixue_power')->where("power_id = '$power_id'")->save($data);
            if($arr){
                $this->success("修改成功",U("power_list"),1);
            }else{
                $this->error("修改失败",'',1);
            }
        }
    }
    public function power_delete(){
        $power_id = I('get.power_id');
        $del = M('yixue_power')->where("power_id = '$power_id'")->delete();
        if($del){
            $this->success("删除成功",U('power_list'),0);
        }
    }

}