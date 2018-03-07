<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
    //计算该地址经纬度
    function addresstolatlag($address){
        $url='http://api.map.baidu.com/geocoder/v2/?address='.$address.'&output=json&ak=yXxvn56gMRGefR0nh4Td15f68ZRmjcQY';
        if($result=file_get_contents($url))
        {
            $res= explode(',"lat":', substr($result, 40,36));
            return   $res;
        }
    }
    function getdistance($lng1, $lat1, $lng2, $lat2) {
        // 将角度转为狐度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;
    }
    public function address_lnt(){
        $arr = M('yixue_partner')->field('address_lng,address_lat,address_scope')->select();
        echo json_encode($arr);
    }
    public function address_add(){
        $session = session('yixue_user');
        $id = $session['user_id'];
        $data['address_name'] =I("post.address");
        $arr = $this->addresstolatlag($data['address_name']);
        $data['address_lng'] = $arr[0];
        $data['address_lat'] = $arr[1];
        $data['address_scope'] = I('post.address_scope');
        if($id == 1){
            $now = M('yixue_partner')->field('address_lng,address_lat,address_scope')->select();
        }else{
            $now = M('yixue_partner')->field('address_lng,address_lat,address_scope')->where("user_pid = '$id'")->select();
        }
        $bbb = "";
        foreach($now as $k => $v){
            $a = $this->getdistance($data['address_lng'],$data['address_lat'],$v['address_lng'],$v['address_lat']);
            $b = $v['address_scope']+$data['address_scope'];
            if($a<$b){
                $bbb = 1;
            }
        }
        if($bbb == 1){
            $err['msg'] = "此地已经被地方占领";
            $err['lng'] = $arr[0];
            $err['lat'] = $arr[1];
        }else{
            $err['msg'] = "此地可用";
            $err['lng'] = $arr[0];
            $err['lat'] = $arr[1];
        }
        echo json_encode($err);

    }
    //校区添加
    public function user_add()
    {
        if(IS_GET){
            $session = session('yixue_user');
            $id = $session["user_id"];
            if($id == '1'){
                $arr = M("yixue_role")->select();
                $a = M("yixue_user_role")->field("yixue_user_id")->where("yixue_role_id = 2")->select();
                foreach($a as $v){
                    $b[] = $v['yixue_user_id'];
                }
                $bb = implode(",",$b);
                $where['user_id'] = array("in",$bb);
                $partner = M("yixue_partner")->field("user_id,partner_account")->where($where)->select();
                $admin = array(array("user_id"=>1,"partner_account"=>"总部"));
                $partners = array_merge($admin,$partner);
            }else{
                $a = M("yixue_user_role")->field("yixue_role_id = 2")->select();
                $where['user_id'] = $id;
                $partners = M("yixue_partner")->field("user_id,partner_account")->where($where)->select();
                $arr = M("yixue_role")->where("role_id = 1")->select();
            }

            $data = M("yixue_region")->field("region_id,parent_id,region_name,region_type")->where("parent_id = 1")->select();
            $this->assign("region",$data);
            $this->assign('show',$arr);
            $this->assign('next',$partners);
            $this->display();
        }
        if(IS_POST){
            $data = I('post.');
            $session = session('yixue_user');
            $arr['user_pid'] = I("post.user_pid");
            $region_id = $data['address'][2];
            $diqu = M("yixue_region")->field('region_name')->where("region_id = '$region_id'")->find();
            $code = M("yixue_code")->field('areaid')->where("areaname = '$diqu[region_name]'")->find();
            $arr['user_account']=I('post.user_account');
            $arr['user_pwd']=I('post.user_pwd','','md5');
            $arr['finance_pwd']=I('post.finance_pwd','','md5');
            $arr['open_pwd']=I('post.open_pwd','','md5');
            $arr['region_district'] = $data['address'][0];
            $arr['region_city'] = $data['address'][1];
            $arr['region_province'] = $data['address'][2];
            $arr['partner_account'] = $data['partner_account'];
            $arr['partner_idcard'] = $data['partner_idcard'];
            $arr['partner_sex'] = $data['partner_sex'];
            $arr['partner_tel'] = $data['partner_tel'];
            $arr['partner_operator'] = $data['partner_operator'];
            $arr['detailed_address'] = $data['detailed_address'];
            $arr['partner_time'] = time();
            $address = $data['detailed_address'];
            //获取经纬度
            $lnglat = $this->addresstolatlag($address);
            $arr['lng'] = $lnglat[0];
            $arr['lat'] = $lnglat[1];
            foreach($arr as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }
            $role_name=I('post.role_name');
            //用户添加返回ID
            $brr =  M('yixue_partner')->add($arr);
            if($brr<10){
                $save['partner_code'] = $code['areaid']."0".$brr;
            }else{
                $save['partner_code'] = $code['areaid'].$brr;
            }
            M("yixue_partner")->where("user_id = $brr")->save($save);
            if($role_name){
                $data=array();
                foreach($role_name as $key=>$val){
                    $data[]=array("yixue_user_id"=>$brr,"yixue_role_id"=>$val);
                }
                if(M("yixue_user_role")->addall($data)){
                    $this->success("添加用户成功",U('user_campus'));
                }else{
                    $this->error("添加用户失败");
                }
            }
        }
    }
    //大客户列表
    public function user_list(){
        $session = session('yixue_user');
        $id = $session["user_id"];
        $dakehu = M("yixue_user_role")->field("yixue_user_id")->where("yixue_role_id = 2")->select();
        foreach($dakehu as $v){
            $ap[] = $v['yixue_user_id'];
        }
        $dakehu_ids = implode(",",$ap);
        $wh['user_id'] = array("in","$dakehu_ids");
        $dakehu_select = M("yixue_partner")->field("partner_code,partner_account")->where($wh)->select();
        $search_account = I("get.partner_account");
        $search_home = I("get.partner_home");
        $search_code = I("get.partner_code");
        $partner_tel = I("get.partner_tel");
        $data = partner("yixue_partner",$search_account,$search_home,$search_code,$partner_tel,"user_id,open_close,user_account,user_pwd,finance_pwd,partner_account,partner_idcard,partner_sex,partner_tel,partner_time,partner_government,partner_government,partner_code,detailed_address","user_id","$dakehu_ids");
        $this->assign("count",$data['count']);
        $this->assign("page",$data['page']);
        $this->assign("arr",$data['arr']);
        $this->assign('code',$dakehu_select);
        $this->display();
    }
    //开关校区
    public function partner_location(){
        $user_id = I("post.user_id");
        $partner_location = I("post.partner_location");
        if($partner_location == 1){
            $data = array("open_close"=>2);
            M("yixue_partner")->where("user_id = $user_id")->save($data);
            echo 1;
        }
        if($partner_location == 2){
            $data = array("open_close"=>1);
            M("yixue_partner")->where("user_id = $user_id")->save($data);
            echo 2;
        }
    }
    //校区修改
    public function user_update(){
        if(IS_GET) {
            $user_id = I('get.user_id');
            $session = session('yixue_user');
            $id = $session["user_account"];
            if($id == 'admin'){
                $role = M("yixue_role")->field('role_id,role_name')->select();
                $a = M("yixue_user_role")->field("yixue_user_id")->where("yixue_role_id = 2")->select();
                foreach($a as $v){
                    $b[] = $v['yixue_user_id'];
                }
                $bb = implode(",",$b);
                $where['user_id'] = array("in",$bb);
                $partner = M("yixue_partner")->field("user_id,partner_account")->where($where)->select();
            }else{
                $role = M("yixue_role")->field('role_id,role_name')->where("role_id = 1")->select();
            }
            $arr = M("yixue_user_role")->where("yixue_user_id = '$user_id'")->getField("yixue_role_id",true);
            $region = M("yixue_region")->field("region_id,parent_id,region_name,region_type")->where("parent_id = 1")->select();
            $partner = M('yixue_partner')->field("user_id,user_account,user_pwd,finance_pwd,partner_account,partner_idcard,partner_sex,partner_tel,partner_time,partner_government,partner_code,detailed_address")->where("user_id = '$user_id'")->find();
            $this->assign("region",$region);
            foreach ($role as $key => $val) {
                if (in_array($val['role_id'],$arr)) {
                    $role[$key]['checked'] = 1;
                } else {
                    $role[$key]['checked'] = 0;
                }
            }
            $this->assign("arr",$partner);
            $this->assign('role',$role);
            $this->display();
        }
        if(IS_POST){
            $data = I('post.');
            $session = session('yixue_user');
            $arr['user_pid'] = $session["user_id"];
            $region_id = $data['address'][2];
            $diqu = M("yixue_region")->field('region_name')->where("region_id = '$region_id'")->find();
            $code = M("yixue_code")->field('areaid')->where("areaname = '$diqu[region_name]'")->find();
            $arr['user_account']=I('post.user_account');
            $arr['user_pwd']=I('post.user_pwd','','md5');
            $arr['finance_pwd']=I('post.finance_pwd','','md5');
            $arr['open_pwd']=I('post.open_pwd','','md5');
            $arr['region_district'] = $data['address'][0];
            $arr['region_city'] = $data['address'][1];
            $arr['region_province'] = $data['address'][2];
            $arr['partner_account'] = $data['partner_account'];
            $arr['partner_idcard'] = $data['partner_idcard'];
            $arr['partner_sex'] = $data['partner_sex'];
            $arr['partner_tel'] = $data['partner_tel'];
            $arr['partner_operator'] = $data['partner_operator'];
            $arr['detailed_address'] = $data['detailed_address'];
            $brr['partner_time'] = time();
            $address = $data['detailed_address'];
            //获取经纬度
            $lnglat = $this->addresstolatlag($address);
            $brr['lng'] = $lnglat[0];
            $brr['lat'] = $lnglat[1];
            foreach($brr as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }

            M('yixue_partner')->where("user_id = '$user_id'")->save($brr);
            //删除原先权限
            M('yixue_user_role')->where("yixue_user_id='$user_id'")->delete();
            //获取权限
            $id=I('post.yixue_role_id');
            if($id){
                $data=array();
                foreach($id as $key=>$val){
                    $data[]=array("yixue_user_id"=>$user_id,"yixue_role_id"=>$val);
                }
                if(M('yixue_user_role')->addAll($data)){
                    $this->success("修改成功",U('user_list'));
                }else{
                    $this->error("修改失败");
                }
            }
        }
    }
    //校区删除
    public function user_delete(){
        $user_id = I('get.user_id');
        if(M("yixue_user")->where("user_id = '$user_id'")->delete()){
            $this->success("删除用户成功",U('user_list'),1);
        }else{
            $this->error("删除用户失败");
        }
    }

    public function admin_user_campus(){
        $user_id = I("get.user_id");
        $dakehu = M("yixue_partner")->field("user_id,partner_account,partner_code")->where("user_pid = '$user_id'")->select();
        foreach($dakehu as $v){
            $ap[] = $v['user_id'];
        }
        $dakehu_ids = implode(",",$ap);
        $search_account = I("get.partner_account");
        $search_home = I("get.partner_home");
        $search_code = I("get.partner_code");
        $partner_tel = I("get.partner_tel");
        $data = partner("yixue_partner","$search_account",$search_home,$search_code,$partner_tel,"user_id,user_account,user_pwd,finance_pwd,partner_account,partner_idcard,partner_sex,partner_tel,partner_time,partner_government,partner_code,detailed_address","user_id","$dakehu_ids");
        $this->assign("count",$data['count']);
        $this->assign("page",$data['page']);
        $this->assign("arr",$data['arr']);
        $this->assign("code",$dakehu);
        $this->display('user_campus');
    }

    public function user_campus(){
        $session = session('yixue_user');
        $ids = $session["user_id"];
        $user_id = I("get.user_id","$ids");
        if($ids == 1){
            $dakehu = M("yixue_user_role")->field("yixue_user_id")->where("yixue_role_id = 1")->select();
            foreach($dakehu as $v){
                $ap[] = $v['yixue_user_id'];
            }
            $dakehu_ids = implode(",",$ap);
            $wh['user_id'] = array("in","$dakehu_ids");
            $dakehu=M('yixue_partner')->field("user_id,partner_account,partner_code")->where($wh)->select();
        }else{
            $dakehu = M("yixue_partner")->field("user_id,partner_account,partner_code")->where("user_pid = '$user_id'")->select();
        }
        foreach($dakehu as $v){
            $ap[] = $v['user_id'];
        }
        $dakehu_ids = implode(",",$ap);
        $search_account = I("get.partner_account");
        $search_home = I("get.partner_home");
        $search_code = I("get.partner_code");
        $partner_tel = I("get.partner_tel");
        $data = partner("yixue_partner","$search_account",$search_home,$search_code,$partner_tel,"user_id,open_close,user_account,user_pwd,finance_pwd,partner_account,partner_idcard,partner_sex,partner_tel,partner_time,partner_government,partner_code,detailed_address","user_id","$dakehu_ids");
        $this->assign("count",$data['count']);
        $this->assign("page",$data['page']);
        $this->assign("arr",$data['arr']);
        $this->assign("code",$dakehu);
        $this->display();
    }
    public function pay_campus_partner(){
        $user_id = I("");
    }
}





