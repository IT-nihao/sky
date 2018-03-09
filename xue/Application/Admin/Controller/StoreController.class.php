<?php
namespace Admin\Controller;
use Think\Controller;
class StoreController extends Controller {
    public function store_add(){
        if(IS_GET){
            $arr = M("yixue_region")->field("region_id,parent_id,region_name,region_type")->where("parent_id = 1")->select();
            $this->assign("region",$arr);
            $this->display();
        }
        if(IS_POST){
            $session=session('yixue_user');
            $data = I('post.');
            $region_id = $data['address'][2];
            $diqu = M("yixue_region")->field('region_name')->where("region_id = '$region_id'")->find();
            $code = M("yixue_code")->field('areaid')->where("areaname = '$diqu[region_name]'")->find();
            $arr['code'] = $code['areaid'].rand(1,9999);
            $arr['region_district'] = $data['address'][0];
            $arr['user_id'] = $session['user_id'];
            $arr['region_city'] = $data['address'][1];
            $arr['region_province'] = $data['address'][2];
            $arr['store_user'] = $data['store_account'];
            $arr['store_idcard'] = $data['store_idcard'];
            $arr['store_sex'] = $data['store_sex'];
            $arr['store_tel'] = $data['store_tel'];
            $arr['store_home'] = $data['store_home'];
            $arr['store_money'] = $data['store_money'];
            $arr['store_operator'] = $data['store_operator'];
            $arr['detailed_address'] = $data['detailed_address'];
            $arr['store_time'] = time();
            if(!preg_match("/^[\x7f-\xff]+$/", $arr['store_user'])){
                $this->error("负责人不能是除中文以外的字符！");
            }
            if(!preg_match("/^1[34578]\d{9}$/", $arr['store_tel'])){
                $this->error("请输入正确的电话号码");
            }
            if(!preg_match("/^([\d]{17}[xX\d]|[\d]{15})$/", $arr['store_idcard'])){
                $this->error("请输入正确的身份证号码");
            }
            foreach($arr as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }
            //详细地址
            $address = $data['detailed_address'];
            //获取经纬度
            $lnglat = $this->addresstolatlag($address);
            $arr['lng'] = $lnglat[0];
            $arr['lat'] = $lnglat[1];
            $res = M("yixue_store")->add($arr);
            if($res){
                $this->success("添加成功",U('store_list'));
            }else{
                $this->error("添加失败");
            }
        }
    }
    public function store_list(){
        $session=session('yixue_user');
        $id = $session['user_id'];
        //分销商下的用户ID
        if($id != 8){
            $ids = M("yixue_user")->field("user_id")->where("user_pid = $id")->select();
        }else{
            $ids = M("yixue_user")->field("user_id")->select();
        }
        foreach($ids as $v){
            $store_ids[] = $v['user_id'];
        }
        $idss = implode(",",$store_ids);
        //拼接当前用户ID和所管理的ID
        $idsss = $idss.",".$id;
        $where["user_id"] = array("in",$idsss);
        if($id != 8){
            $select_store = M("yixue_store")->field("code,store_user")->where($where)->select();
        }else{
            $select_store = M("yixue_store")->field("code,store_user")->select();
        }
        $search_user = I("get.store_user");
        $search_home = I("get.store_home");
        $search_code = I("get.store_code");
        $store_tel = I("get.store_tel");
        $arr = store("yixue_store",$search_user,$search_home,$search_code,$store_tel,"user_id,store_id,store_user,store_idcard,store_sex,store_tel,store_home,store_time,store_money,detailed_address,code","store_id,store_user,store_idcard,store_sex,store_tel,store_home,store_time,detailed_address",$idsss);
        $this->assign("count",$arr['count']);
        $this->assign("page",$arr['page']);
        $this->assign("arr",$arr['arr']);
        $this->assign("user_id",$id);
        $this->assign("select_store",$select_store);
        $this->display();
    }
    public function store_delete(){
        $store_id = I('get.store_id');
        $del = M("yixue_store")->where("store_id = $store_id")->delete();
        if($del){
            $this->success("删除成功",U('store_list'));
        }else{
            $this->error("删除失败");
        }
    }
    public function store_update(){
        if(IS_GET){
            $arr = M("yixue_region")->field("region_id,parent_id,region_name,region_type")->where("parent_id = 1")->select();
            $this->assign("region",$arr);
            $store_id = I('get.store_id');
            $arr = M('yixue_store')->field("store_id,store_user,store_idcard,store_sex,store_tel,store_home,store_time,store_money,detailed_address")->where("store_id = '$store_id'")->find();
            $this->assign("arr",$arr);
            $this->display();
        }
        if(IS_POST){
            $data = I('post.');
            $store_id = $data['store_id'];
            $arr['region_district'] = $data['address'][0];
            $arr['region_city'] = $data['address'][1];
            $arr['region_province'] = $data['address'][2];
            $arr['store_user'] = $data['store_user'];
            $arr['store_idcard'] = $data['store_idcard'];
            $arr['store_sex'] = $data['store_sex'];
            $arr['store_tel'] = $data['store_tel'];
            $arr['store_home'] = $data['store_home'];
            $arr['store_money'] = $data['store_money'];
            $arr['store_operator'] = $data['store_operator'];
            $arr['detailed_address'] = $data['detailed_address'];
            $arr['store_time'] = time();
            if(!preg_match("/^[\x7f-\xff]+$/", $arr['store_user'])){
                $this->error("负责人不能是除中文以外的字符！");
            }
            if(!preg_match("/^1[34578]\d{9}$/", $arr['store_tel'])){
                $this->error("请输入正确的电话号码");
            }
            if(!preg_match("/^([\d]{17}[xX\d]|[\d]{15})$/", $arr['store_idcard'])){
                $this->error("请输入正确的身份证号码");
            }
            foreach($arr as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }
            //详细地址
            $address = $data['detailed_address'];
            //获取经纬度
            $lnglat = $this->addresstolatlag($address);
            $arr['lng'] = $lnglat[0];
            $arr['lat'] = $lnglat[1];
            $res = M("yixue_store")->where("store_id = '$store_id'")->save($arr);
            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
        }
    }
    public function region(){
        $region_id = I('get.region_id');
        $region = M("yixue_region")->field("region_id,parent_id,region_name,region_type")->where("parent_id = $region_id")->select();
        $data['region'] = $region;
        if($region){
            $data['err'] = 1;
        }else{
            $data['err'] = 0;
        }
        echo json_encode($data);
    }
    function addresstolatlag($address){
        $url='http://api.map.baidu.com/geocoder/v2/?address='.$address.'&output=json&ak=yXxvn56gMRGefR0nh4Td15f68ZRmjcQY';
        if($result=file_get_contents($url))
        {
            $res= explode(',"lat":', substr($result, 40,36));
            return   $res;
        }
    }
}