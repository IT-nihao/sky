<?php
namespace Admin\Controller;
use Think\Controller;
class PartnerController extends Controller {
    public function partner_add(){
        if(IS_GET){
           $arr = M("yixue_region")->field("region_id,parent_id,region_name,region_type")->where("parent_id = 1")->select();
           $this->assign("region",$arr);
           $this->display();
        }
        if(IS_POST){
            $data = I('post.');
            $arr['region_district'] = $data['address'][0];
            $arr['region_city'] = $data['address'][1];
            $arr['region_province'] = $data['address'][2];
            $arr['partner_account'] = $data['partner_account'];
            $arr['partner_idcard'] = $data['partner_idcard'];
            $arr['partner_sex'] = $data['partner_sex'];
            $arr['partner_tel'] = $data['partner_tel'];
            $arr['partner_government'] = $data['partner_government'];
            $arr['partner_operator'] = $data['partner_operator'];
            $arr['detailed_address'] = $data['detailed_address'];
            $arr['partner_time'] = time();
            if(!preg_match("/^[\x7f-\xff]+$/", $arr['partner_account'])){
                $this->error("负责人不能是除中文以外的字符！");
            }
            if(!preg_match("/^1[34578]\d{9}$/", $arr['partner_tel'])){
                $this->error("请输入正确的电话号码");
            }
            if(!preg_match("/^([\d]{17}[xX\d]|[\d]{15})$/", $arr['partner_idcard'])){
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
//            print_r($arr);die;
            $res = M("yixue_partner")->add($arr);
            if($res){
                $this->success("添加成功",U('partner_list'));
            }else{
                $this->error("添加失败");
            }
        }
    }
    public function partner_list(){
        $search = I("get.partner_account");
        $arr = page("yixue_partner","partner_account",$search,"user_id,partner_account,partner_idcard,partner_sex,partner_tel,partner_home,partner_time,partner_government,partner_government,partner_money,partner_code,detailed_address","partner_id,partner_account,partner_idcard,partner_sex,partner_tel,partner_home,partner_time,partner_government,partner_government,partner_code,detailed_address");
//        $arr = M('yixue_partner')->field("partner_id,partner_account,partner_idcard,partner_sex,partner_tel,partner_home,partner_time,partner_government,partner_government,partner_code,detailed_address")->select();
//        print_r($arr);die;
        $this->assign("count",$arr['count']);
        $this->assign("page",$arr['page']);
        $this->assign("arr",$arr['arr']);
        $this->display();
    }
    public function partner_update(){
        if(IS_GET){
            $region = M("yixue_region")->field("region_id,parent_id,region_name,region_type")->where("parent_id = 1")->select();
            $partner_id = I('get.partner_id');
            $arr = M('yixue_partner')->field("partner_id,partner_account,partner_idcard,partner_sex,partner_tel,partner_home,partner_time,partner_government,partner_government,partner_money,partner_code,detailed_address")->where("partner_id = '$partner_id'")->find();
            $this->assign("region",$region);
            $this->assign("arr",$arr);
            $this->display();
        }
        if(IS_POST){
            $partner_id = I('post.partner_id');
            $data = I('post.');
            $arr['region_district'] = $data['address'][0];
            $arr['region_city'] = $data['address'][1];
            $arr['region_province'] = $data['address'][2];
            $arr['partner_account'] = $data['partner_account'];
            $arr['partner_idcard'] = $data['partner_idcard'];
            $arr['partner_sex'] = $data['partner_sex'];
            $arr['partner_tel'] = $data['partner_tel'];
            $arr['partner_home'] = $data['partner_home'];
            $arr['partner_government'] = $data['partner_government'];
            $arr['partner_money'] = $data['partner_money'];
            $arr['partner_operator'] = $data['partner_operator'];
            $arr['detailed_address'] = $data['detailed_address'];
            $arr['partner_time'] = time();
            if(!preg_match("/^[\x7f-\xff]+$/", $arr['partner_account'])){
                $this->error("负责人不能是除中文以外的字符！");
            }
            if(!preg_match("/^1[34578]\d{9}$/", $arr['partner_tel'])){
                $this->error("请输入正确的电话号码");
            }
            if(!preg_match("/^([\d]{17}[xX\d]|[\d]{15})$/", $arr['partner_idcard'])){
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
            $res = M("yixue_partner")->where("partner_id = '$partner_id'")->save($arr);
            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
        }
    }
    public function partner_delete(){
        $partner_id = I("get.partner_id");
        $arr = M("yixue_partner")->where("partner_id = $partner_id")->delete();
        if($arr){
            $this->success("删除成功",U('partner_list'));
        }else{
            $this->error("删除失败");
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