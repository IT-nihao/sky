<?php
namespace Admin\Controller;
use Think\Controller;
class AddressController extends CommonController {
    public function address_add()
    {
        if (IS_GET) {
            $this->display();
        }
        if (IS_POST) {
            $data['address_name'] = $_POST['address'];
            $arr = $this->addresstolatlag($data['address_name']);
            $data['address_lng'] = $arr[0];
            $data['address_lat'] = $arr[1];
            $data['address_scope'] = I('post.address_scope');
            if (!preg_match("/^[\x7f-\xff]+$/", $data['address_name'])) {
                $this->error("地址不能是除中文以外的字符！");
            }
            if (!preg_match("/^\d*$/", $data['address_scope'])) {
                $this->error("经营范围只能输入数字！");
            }
            foreach ($data as $v) {
                if (empty($v)) {
                    $this->error("每个选项都需要填哦！");
                }
            }
            $now = M('yixue_address')->field('address_lng,address_lat,address_scope')->select();
            $bbb = "";
            foreach($now as $k => $v){
               $a = $this->getdistance($data['address_lng'],$data['address_lat'],$v['address_lng'],$v['address_lat']);
               $b = $v['address_scope']+$data['address_scope'];
               if($a<$b){
                    $bbb = 1;
               }
            }
            if($bbb == 1){
                $this->error("此地已经被敌方占领！请绕道！");
            }else{
                $arr = M("yixue_address")->add($data);
                if ($arr) {
                    $this->success("添加成功", U('address_list'));
                } else {
                    $this->error("失败");
                }
            }
        }
    }
    public function address_lnt(){
        $arr = M('yixue_address')->field('address_id,address_lng,address_lat,address_scope')->select();
//        print_r($arr);
        echo json_encode($arr);
    }
    public function address_list(){
        $this->display();
    }

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
}