<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $dataList[] = array('name'=>'thinkphp','email'=>'thinkphp@gamil.com');
        $dataList[] = array('name'=>'onethink','email'=>'onethink@gamil.com');
        print_r($dataList);die;
    }
    /*
    * 登陆接口
    * 需要数据：students_tel,students_pwd,code,students_accredit
    * 返回数据：status,message,data=array('students_id','token')
    * */
    public function login(){
        $username = isset($_POST['students_tel']) ? trim($_POST['students_tel']) : '';
        //$accredit = isset($_POST['students_accredit']) ? trim($_POST['students_accredit']) : '';
        $password = isset($_POST['students_pwd']) ? trim($_POST['students_pwd']) : '';
        $passwords = md5(md5($password));
        //时间
        $time = I('post.students_time');
        //连接超时
//        if((time()-$time)>30){
//            $results = array('status'=>'1001', 'message'=>'请求超时,请检查网络连接');
//            exit(json_encode($results, JSON_UNESCAPED_UNICODE));
//        }
        //参数为空返回false
        if (empty($username)||empty($password)) {
            $results = array('status' => '-1', 'message' => '缺少必要参数');
                exit(json_encode($results,JSON_UNESCAPED_UNICODE));
        } else {
            //登陆
            $arr = M("yixue_students")->field('students_id,students_tel,students_pwd,students_time,students_garde,students_school,students_sex,students_name')->where("students_tel = '$username'")->find();
            if($arr){
                $key = "students".$arr['students_id'];
                $cishu = S($key)?:"1";
                if($cishu>5){
                    $results = array('status'=>'-1','message'=>'登陆频繁，建议点击下方的忘记密码重置登陆密码');
                    echo json_encode($results,JSON_UNESCAPED_UNICODE);
                }else{
                    $res = M("yixue_students")->field('students_id,students_tel,students_pwd,students_time')->where("students_tel = '$username' and students_pwd = '$passwords'")->find();
                    if ($res) {
                        $token = base64_encode($arr['students_id'].'-'.md5(md5(time()."yixue!")));
                        S($arr['students_id'],$token,3*24*3600);
                        $user['students_id'] = $token;
                        $data = array(
                            'students_id' => $arr['students_id'],
                            'token' => $user['students_id'],
                        );
                        if(empty($arr['students_name'])||empty($arr['students_sex'])||empty($arr['students_garde'])||empty($arr['students_school'])){
                            $results = array('status' => '200', 'message' => '登录成功','data'=>$data,'perfect'=>'10');
                            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
                        }else{
                            $results = array('status' => '200', 'message' => '登录成功','data'=>$data,'perfect'=>'20');
                            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
                        }
                    } else {
                        S($key,$cishu+1,10);
                        $results = array('status' => '-1', 'message' => '密码'.$cishu.'次错误，休息会再试~');
                        echo json_encode($results,JSON_UNESCAPED_UNICODE);
                    }
                }
            }else{
                $results = array('status' => '-1', 'message' => '该手机号未注册！亲~');
                echo json_encode($results,JSON_UNESCAPED_UNICODE);
            }

        }
    }
    //判断token是否过期
    public function upToken($arr){
        M('yixue_students')->field('students_tel')->select();
        $token = S($arr);
        if($token){
            S($arr,$token,1000);
        }else{
            $results = array('status'=>'-1','message'=>'重新登陆');
            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
        }
    }
    /*
    * 年级接口
    * 需要数据：
    * 返回数据：status,message,data=array('garde')
    * */
    public function garde(){
        $garde = M("yixue_garde")->field("garde_id,garde_name")->select();
        $results = array('status' => '200', 'message' => '成功','data'=>$garde);
        echo json_encode($results,JSON_UNESCAPED_UNICODE);
    }
    /*
    * 注册接口
    * 需要数据：students_tel,students_accredit,students_pwd,code
    * 返回数据：status,message,students_id,
    * */
	public function register(){
        //用户名
        $username = I('post.students_tel');
        //时间
        $time = time();
        //授权码
        $accredit = I('post.students_accredit');
        //密码
        $password = isset($_POST['students_pwd']) ? trim($_POST['students_pwd']) : '';
        //验证码
        $code = isset($_POST['code']) ? trim($_POST['code']) : '';
        //加密密码
        $password = md5(md5($password));
        //判断验证码
//        if($this->CheckSmsYzm($username,$code)){
//            $results = array('status' => '1001','message'=>'验证码不正确');
//            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
//        }
        //判断唯一性
        $names = M('yixue_students')->field('students_tel')->where("students_tel = '$username'")->find();
        if($names){
            $results = array('status' => '-1','message'=>'手机号已注册');
            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
        }
        //判断参数
        if (empty($username)||empty($password)||empty($code)||empty($accredit)) {
            $results = array('status' => '-1', 'message' => '缺少必要参数');
            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
        } else {
            $data['students_tel'] = $username;
            $data['students_pwd'] = $password;
            $data['students_time'] = $time;
            $data['students_accredit'] = $accredit;
            $res = M("yixue_students")->add($data);
            $id = M('yixue_students')->getLastInsID();
            if ($res) {
                $results = array('status' => '200', 'message' => '注册成功','students_id'=>$id);
            } else {
                $results = array('status' => '-1', 'message' => '注册失败');
            }
            echo json_encode($results,JSON_UNESCAPED_UNICODE);
        }
	}
    /*
     * 个人信息
     * 需要数据：student_id,students_grade,students_school,students_sex
     * 返回数据：status,message
     * */
	public function personal(){
        $students_id = I('post.students_id');
        $students['students_name'] = I('post.students_name');
        $students['students_garde'] = I('post.students_garde');
        $students['students_school'] = I('post.students_school');
        $students['students_sex'] = I('post.students_sex');
        $students['students_time'] = time();
        if (empty($students['students_time'])||empty($students['students_name'])||empty($students['students_garde'])||empty($students['students_school'])||empty($students['students_sex'])) {
            $results = array('status' => '-1', 'message' => '缺少必要参数');
            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
        }else{
            $arr = M('yixue_students')->where("students_id = '$students_id'")->save($students);
            if($arr){
                $result = array('status'=>'200','message'=>'录入学生信息成功');
                exit(json_encode($result,JSON_UNESCAPED_UNICODE));
            }
        }

    }
    /*
    * 验证码接口
    * 需要数据：students_tel
    * 返回数据：status,message
    * */
    public function SendSmsCode(){
        $mobile = I('post.students_tel');
        $cishu = S($mobile)?:"1";
        if($cishu>4){
            $result = array('status'=>'-1','message'=>'验证过于频繁，休息会再试吧');
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }
        if(empty($mobile)){
            $result = array('status' => '-1','message'=>'电话号码不能为空');
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        }else{
            S($mobile,$cishu+1,100);
            $appKey = "7d9a4927d5ca88639bcafe2a0ee861a6";
            $appSecret = "5c32a24cebaf";
            $nonce = '100';
            $curTime = time();
            $checkSum = sha1($appSecret . $nonce . $curTime);
            $data  = array(
                'mobile'=> $mobile,
            );
            $data = http_build_query($data);
            $opts = array (
                'http' => array(
                    'method' => 'POST',
                    'header' => array(
                        'Content-Type:application/x-www-form-urlencoded;charset=utf-8',
                        "AppKey:$appKey",
                        "Nonce:$nonce",
                        "CurTime:$curTime",
                        "CheckSum:$checkSum"
                    ),
                    'content' =>  $data
                ),
            );
            $context = stream_context_create($opts);
            $result = file_get_contents("https://api.netease.im/sms/sendcode.action", false, $context);
            if($result['code']!=200){
                $results = array("status"=>"-1","message"=>"验证码获取失败");
                exit(json_encode($results,JSON_UNESCAPED_UNICODE));
            }else{
                $results = array("status"=>200,"message"=>"验证码已经发送到您手机，请注意查收,十五分钟内有效！");
                exit(json_encode($results,JSON_UNESCAPED_UNICODE));
            }

        }
    }
    /*
    * 验证验证码
    * */
    function CheckSmsYzm($mobile = "",$Code=""){
        $appKey = "7d9a4927d5ca88639bcafe2a0ee861a6";
        $appSecret = "5c32a24cebaf";
        $nonce = '100';
        $curTime = time();
        $checkSum = sha1($appSecret . $nonce . $curTime);
        $data  = array(
            'mobile'=> $mobile,
            'code' => $Code,
        );
        $data = http_build_query($data);
        $opts = array (
            'http' => array(
                'method' => 'POST',
                'header' => array(
                    'Content-Type:application/x-www-form-urlencoded;charset=utf-8',
                    "AppKey:$appKey",
                    "Nonce:$nonce",
                    "CurTime:$curTime",
                    "CheckSum:$checkSum"
                ),
                'content' =>  $data
            ),
        );
        $context = stream_context_create($opts);
        $html = file_get_contents("https://api.netease.im/sms/verifycode.action", false, $context);
        return $html;

    }

    /*
    * 忘记密码接口
    * 需要数据：student_tel,code,students_pwd
    * 返回数据：status,message
    * */
    public function update_pwd(){
        $students_tel = I('post.students_tel');
        $code = I('post.code');
        $students_pwd = I('post.students_pwd');
        $password = md5(md5($students_pwd));
//        if($this->CheckSmsYzm($students_tel,$code)){
//            $results = array('status' => '1001','message'=>'验证码不正确');
//            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
//        }
        if(empty($students_tel)||empty($code)||empty($students_pwd)){
            $results = array('status'=>'-1','message'=>"缺少必要参数");
            echo json_encode($results,JSON_UNESCAPED_UNICODE);
        }else{
            $data = array('students_pwd'=>$password);
            $res = M('yixue_students')->where("students_tel = '$students_tel'")->save($data);
            if($res){
                $results = array('status'=>200,'message'=>"修改密码成功");
                echo json_encode($results,JSON_UNESCAPED_UNICODE);
            } else {
                $results = array('status'=>'-1','message'=>"不能使用之前的密码！");
                echo json_encode($results,JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function user_feedback(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $text = I("post.text");
        if(empty($text)){
            $results = array('status'=>'-1','message'=>"不能为空！");
            echo json_encode($results,JSON_UNESCAPED_UNICODE);
        }else{
            $name = M("yixue_students")->field("students_name")->where("students_id = '$id'")->find();
            print_r($name);
            $arr['name'] = $name['students_name'];
            $arr['text'] = $text;
            $arr['time'] = time();
            M("yixue_feedback")->add($arr);
            $results = array('status'=>'200','message'=>"感谢您提出的宝贵意见！");
            echo json_encode($results,JSON_UNESCAPED_UNICODE);
        }
    }
    /*
     * 支付
     */
    public function Pay($rand)
    {
        header("Content-type:text/html;charset=utf-8");

        // ******************************************************配置 start*************************************************************************************************************************
        //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        //合作身份者id，以2088开头的16位纯数字
        $alipay_config['partner']		= '2088121321528708';
        //收款支付宝账号
        $alipay_config['seller_email']	= 'itbing@sina.cn';
        //安全检验码，以数字和字母组成的32位字符
        $alipay_config['key']	= '1cvr0ix35iyy7qbkgs3gwymeiqlgromm';
        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        //签名方式 不需修改
        $alipay_config['sign_type']    = strtoupper('MD5');
        //字符编码格式 目前支持 gbk 或 utf-8
        //$alipay_config['input_charset']= strtolower('utf-8');
        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        //$alipay_config['cacert']    = getcwd().'\\cacert.pem';
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport']    = 'http';
        // ******************************************************配置 end*************************************************************************************************************************

        // ******************************************************请求参数拼接 start*************************************************************************************************************************
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => $alipay_config['partner'], // 合作身份者id
            "seller_email" => $alipay_config['seller_email'], // 收款支付宝账号
            "payment_type"	=> '1', // 支付类型
            "notify_url"	=> "http://localhost/res.php", // 服务器异步通知页面路径
            "return_url"	=> "to_pay", // 页面跳转同步通知页面路径
            "out_trade_no"	=> $rand, // 商户网站订单系统中唯一订单号
            "subject"	=> "YT集团", // 订单名称
            "total_fee"	=> "0.01", // 付款金额
            "body"	=> "YT集团", // 订单描述 可选
            "show_url"	=> "", // 商品展示地址 可选
            "anti_phishing_key"	=> "", // 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
            "exter_invoke_ip"	=> "", // 客户端的IP地址
            "_input_charset"	=> 'utf-8', // 字符编码格式
        );
        // 去除值为空的参数
        foreach ($parameter as $k => $v) {
            if (empty($v)) {
                unset($parameter[$k]);
            }
        }
        // 参数排序
        ksort($parameter);
        reset($parameter);

        // 拼接获得sign
        $str = "";
        foreach ($parameter as $k => $v)
        {
            if (empty($str)) {
                $str .= $k . "=" . $v;
            } else {
                $str .= "&" . $k . "=" . $v;
            }
        }
        $parameter['sign'] = md5($str . $alipay_config['key']);	// 签名
        $parameter['sign_type'] = $alipay_config['sign_type'];
        // ******************************************************请求参数拼接 end*************************************************************************************************************************


        // ******************************************************模拟请求 start*************************************************************************************************************************
        $pay_url = "https://mapi.alipay.com/gateway.do?_input_charset=utf-8";
        foreach ($parameter as $k => $v) {
            $pay_url.= "&" . $k . "=" . $v;
        }
        return $pay_url;
    }


}