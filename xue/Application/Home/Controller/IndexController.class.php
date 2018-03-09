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
       if((time()-$time)>30){
           $results = array('status'=>'1001', 'message'=>'请求超时,请检查网络连接');
           exit(json_encode($results, JSON_UNESCAPED_UNICODE));
       }
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
       if($this->CheckSmsYzm($username,$code)){
           $results = array('status' => '1001','message'=>'验证码不正确');
           exit(json_encode($results,JSON_UNESCAPED_UNICODE));
       }
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
       if($this->CheckSmsYzm($students_tel,$code)){
           $results = array('status' => '1001','message'=>'验证码不正确');
           exit(json_encode($results,JSON_UNESCAPED_UNICODE));
       }
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
     * 获取阅读分类
     * 需要数据:token
     * 返回数据:data
     * */
    public function read_type(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $arr = M("read_type")->field("type_id,type_name")->select();
        $result = array("status" => '200',"message"=>"获取阅读分类成功","data"=>$arr);
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    /*
     * 获取阅读等级
     * 需要参数：type_id
     * 返回数据：data
     * */
    public function read_textbook(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $type_id = I('post.type_id',"");
        if($type_id != ""){
            $arr = M("read_textbook")->field("textbook_id,textbook_name")->where("textbook_type_id = $type_id")->select();
            $result = array("status" => '200',"message"=>"获取阅读教材成功","data"=>$arr);
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
//            $where['level_id'] = array("in","1,2,3,4,5,6,7,8,9,10");
            $arr = M("level_type_id")->field("level_id,level_name")->limit(0,10)->select();
            $result = array("status" => '200',"message"=>"获取私人定制关卡成功","data"=>$arr);
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
    /*
    * 阅读接口
    * 需要数据：read_level_id,token,read_type_id,read_textbook_id
    * 返回数据：status,message,read_text,read_title,read_time,read_type_id,data=array(topic_timu,array(topic_text,yes_no,topic_spell));
    * */
    public function read(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);

        $read_level_id = I('read_level_id');
        $read_type_id = I('read_type_id');
        $read_textbook_id = I('read_textbook_id',"");
        if($read_textbook_id != ""){
            $sql = "select distinct read_level_id,read_textbook_id,read_type_id,read_title,read_text,add_time,read_difficulty_id,read_time,level_name,textbook_name from class_dedicated,yixue_level,read_textbook where class_dedicated.read_textbook_id=read_textbook.textbook_id and read_textbook.textbook_id = yixue_level.level_textbook_id  and  read_level_id = '$read_level_id' and read_type_id = '$read_type_id' and read_textbook_id = '$read_textbook_id'";
            $arr = M()->query($sql);
            if($arr){
                $topic_timu = M()->query("select distinct topic_timu from class_dedicated where read_level_id = $read_level_id and read_type_id = $read_type_id and read_textbook_id = $read_textbook_id");
                foreach($topic_timu as $k=>$v){
                    $topic_text = M('class_dedicated')->field('topic_text,yes_no,topic_spell,read_id')->where("topic_timu = '$v[topic_timu]' and read_level_id = '$read_level_id' and read_type_id = '$read_type_id' and read_textbook_id = '$read_textbook_id'")->select();
                    $topic_timu = $v['topic_timu'];
                    foreach($topic_text as $kk => $vv){
                        $one = $vv['topic_text'];
                        $two = $vv['yes_no'];
                        $three = $vv['topic_spell'];
                        $bbb[$kk] = array(
                            "topic_text"=>$one,
                            "yes_no"=>$two,
                        );
                    }
                    $mmm[] = array(
                        "topic_timu" => $topic_timu,
                        "res" => $bbb,
                    );
                }
                $result = array(
                    "status" => 200,
                    "message" => "获取文章成功",
                    "data" => array(
                        "read_text"=>$arr[0]['read_text'],
                        "read_title"=>$arr[0]['read_title'],
                        "read_time"=>$arr[0]['read_time'],
                        "read_level"=>$arr[0]['level_name'],
                        "textbook_name"=>$arr[0]['textbook_name'],
                        "read_difficulty"=>$arr[0]['read_difficulty_id'],
                        "arr"=>$mmm
                    ),
                );
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }else{
                $result = array("status" => '-1',"message"=>"该等级没有文章");
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }
        }else{
            $sql = "select distinct read_level_id,read_type_id,read_title,read_text,add_time,read_difficulty_id,read_time from class_read where read_level_id = '$read_level_id' and read_type_id = '$read_type_id' and students_id = $id";
            $arr = M()->query($sql);
//            print_r($arr);die;
            if($arr){
                $topic_timu = M()->query("select distinct topic_timu from class_read where read_level_id = $read_level_id and read_type_id = $read_type_id and students_id = $id");
                foreach($topic_timu as $k=>$v){
                    $topic_text = M('class_read')->field('topic_text,yes_no,topic_spell,read_id')->where("topic_timu = '$v[topic_timu]' and read_level_id = '$read_level_id' and read_type_id = '$read_type_id' and students_id ='$id'")->select();
                    $topic_timu = $v['topic_timu'];
                    foreach($topic_text as $kk => $vv){
                        $one = $vv['topic_text'];
                        $two = $vv['yes_no'];
                        $three = $vv['topic_spell'];
                        $bbb[$kk] = array(
                            "topic_text"=>$one,
                            "yes_no"=>$two,
                        );
                    }
                    $mmm[] = array(
                        "topic_timu" => $topic_timu,
                        "res" => $bbb,
                    );
                }
                $result = array(
                    "status" => 200,
                    "message" => "获取文章成功",
                    "data" => array(
                        "read_text"=>$arr[0]['read_text'],
                        "read_title"=>$arr[0]['read_title'],
                        "read_time"=>$arr[0]['read_time'],
                        "read_level"=>$arr[0]['read_level_id'],
                        "read_difficulty"=>$arr[0]['read_difficulty_id'],
                        "arr"=>$mmm
                    ),
                );
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }else{
                $result = array("status" => '-1',"message"=>"你还没有订制文章");
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }
        }
    }
    /*
     * 搜索单词
     * 需要数据:read_word,token,
     * 返回数据：danci(read_danci,read_jieshi)
     */
    public function read_word(){
        $read_word = I('post.read_word');
        $ar = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_word'")->find();
        $word = str_split($read_word);
        $wordlength = count(str_split($read_word));
        if($ar){
            $result = array("status" => '200',"message"=>"搜索单词成功","danci" => $ar);
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
            if($word[$wordlength-1]=="s"||$word[$wordlength-2].$word[$wordlength-1]=="es"){
                if($word[$wordlength-2].$word[$wordlength-1]=="es"){
                    if($word[$wordlength-3]=="i"){
                        $read_w = substr($read_word,0,$wordlength-3)."y";
                        $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                        if($danci){
                            $result = array("status" => '200',"message"=>"搜索变形单词(ies)成功","danci" => $danci);
                            echo json_encode($result,JSON_UNESCAPED_UNICODE);
                        }else{
                            $result = array("status" => '-1',"message"=>"没有该单词");
                            echo json_encode($result,JSON_UNESCAPED_UNICODE);
                        }
                    }else{
                        $read_w = substr($read_word,0,$wordlength-2);
                        $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                        if($danci){
                            $result = array("status" => '200',"message"=>"搜索变形单词(es)成功","danci" => $danci);
                            echo json_encode($result,JSON_UNESCAPED_UNICODE);
                        }else{
                            $read_w = substr($read_word,0,$wordlength-1);
                            $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                            if($danci){
                                $result = array("status" => '200',"message"=>"搜索变形单词(s)成功","danci" => $danci);
                                echo json_encode($result,JSON_UNESCAPED_UNICODE);
                            }else{
                                $result = array("status" => '-1',"message"=>"没有该单词");
                                echo json_encode($result,JSON_UNESCAPED_UNICODE);
                            }
                        }
                    }
                }else{
                    $read_w = substr($read_word,0,$wordlength-1);
                    $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                    if($danci){
                        $result = array("status" => '200',"message"=>"搜索变形单词(s)成功","danci" => $danci);
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    }else{
                        $result = array("status" => '-1',"message"=>"没有该单词");
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    }
                }
            }else if($word[$wordlength-1]=="d"||$word[$wordlength-2].$word[$wordlength-1] == "ed"){
                if($word[$wordlength-2].$word[$wordlength-1]=="ed"){
                    if($word[$wordlength-3]=="i"){
                        $read_w = substr($read_word,0,$wordlength-3)."y";
                        $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                        if($danci){
                            $result = array("status" => '200',"message"=>"搜索变形单词(ied)成功","danci" => $danci);
                            echo json_encode($result,JSON_UNESCAPED_UNICODE);
                        }else{
                            $result = array("status" => '-1',"message"=>"没有该单词");
                            echo json_encode($result,JSON_UNESCAPED_UNICODE);
                        }
                    }else{
                        $read_w = substr($read_word,0,$wordlength-2);
                        $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                        if($danci){
                            $result = array("status" => '200',"message"=>"搜索变形单词(ed)成功","danci" => $danci);
                            echo json_encode($result,JSON_UNESCAPED_UNICODE);
                        }else{
                            $read_w = substr($read_word,0,$wordlength-1);
                            $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                            if($danci){
                                $result = array("status" => '200',"message"=>"搜索变形单词(d)成功","danci" => $danci);
                                echo json_encode($result,JSON_UNESCAPED_UNICODE);
                            }else{
                                $result = array("status" => '-1',"message"=>"没有该单词");
                                echo json_encode($result,JSON_UNESCAPED_UNICODE);
                            }
                        }
                    }
                }else{
                    $read_w = substr($read_word,0,$wordlength-1);
                    $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                    if($danci){
                        $result = array("status" => '200',"message"=>"搜索变形单词(d)成功","danci" => $danci);
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    }else{
                        $result = array("status" => '-1',"message"=>"没有该单词");
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    }
                }
            }else if($word[$wordlength-3].$word[$wordlength-2].$word[$wordlength-1] == "ing"){
                if($word[$wordlength-4] == "y"){
                    $read_w = substr($read_word,0,$wordlength-4)."ie";
                    $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                    if($danci){
                        $result = array("status" => '200',"message"=>"搜索变形单词(y变ie)成功","danci" => $danci);
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    }else{
                        $result = array("status" => '-1',"message"=>"没有该单词");
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    }
                }else{
                    $read_w = substr($read_word,0,$wordlength-3)."e";
                    $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                    if($danci){
                        $result = array("status" => '200',"message"=>"搜索变形单词(去e+ing)成功","danci" => $danci);
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    }else{
                        $read_w = substr($read_word,0,$wordlength-3);
                        $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                        if($danci){
                            $result = array("status" => '200',"message"=>"搜索变形单词(直接+ing)成功","danci" => $danci);
                            echo json_encode($result,JSON_UNESCAPED_UNICODE);
                        }else{
                            $read_w = substr($read_word,0,$wordlength-4);
                            $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                            if($danci){
                                $result = array("status" => '200',"message"=>"搜索变形单词(双写ing)成功","danci" => $danci);
                                echo json_encode($result,JSON_UNESCAPED_UNICODE);
                            }else{
                                $result = array("status" => '-1',"message"=>"没有该单词");
                                echo json_encode($result,JSON_UNESCAPED_UNICODE);
                            }
                        }
                    }
                }
            }else{
                $result = array("status" => '-1',"message"=>"没有该单词");
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }
        }
    }
    /*
     * 单词读音
     * 需要参数：read_word,token
     * 返回参数：无
     */
    public function word_music(){
        $read_word = I("post.read_word");
        $url = "http://dict.youdao.com/dictvoice?type=2&audio=".$read_word."";
        $result = array("status" => '200',"message"=>"获取读音Url成功","music_url" => $url);
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    /*
     * 添加文章所在生词本
     * 需要参数：token,new_word,read_type_id,read_level_id,
     * 返回数据：无
     */
    public function add_word(){
       $token = I('post.token');
       $id = token_id($token);
       token_no($id,$token);
        $id = 5;
        $new_word = I('post.new_word');
        $new_word = explode(",",$new_word);
        foreach($new_word as $vv){
            $v = trim($vv);
            $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$v'")->find();
            $word = str_split($v);
            $wordlength = count(str_split($v));
            if(!$danci){
                if($word[$wordlength-1]=="s"||$word[$wordlength-2].$word[$wordlength-1]=="es"){
                    if($word[$wordlength-2].$word[$wordlength-1]=="es"){
                        if($word[$wordlength-3]=="i"){
                            $read_w = substr($v,0,$wordlength-3)."y";
                            $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                        }else{
                            $read_w = substr($v,0,$wordlength-2);
                            $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                            if(!$danci){
                                $read_w = substr($v,0,$wordlength-1);
                                $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                            }
                        }
                    }else{
                        $read_w = substr($v,0,$wordlength-1);
                        $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                    }
                }else if($word[$wordlength-1]=="d"||$word[$wordlength-2].$word[$wordlength-1] == "ed"){
                    if($word[$wordlength-2].$word[$wordlength-1]=="ed"){
                        if($word[$wordlength-3]=="i"){
                            $read_w = substr($v,0,$wordlength-3)."y";
                            $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                        }else{
                            $read_w = substr($v,0,$wordlength-2);
                            $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                            if(!$danci){
                                $read_w = substr($v,0,$wordlength-1);
                                $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                            }
                        }
                    }else{
                        $read_w = substr($v,0,$wordlength-1);
                        $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                    }
                }else if($word[$wordlength-3].$word[$wordlength-2].$word[$wordlength-1] == "ing"){
                    if($word[$wordlength-4] == "y"){
                        $read_w = substr($v,0,$wordlength-4)."ie";
                        $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                    }else{
                        $read_w = substr($v,0,$wordlength-3)."e";
                        $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                        if(!$danci){
                            $read_w = substr($v,0,$wordlength-3);
                            $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                            if(!$danci){
                                $read_w = substr($v,0,$wordlength-4);
                                $danci = M("danci_one")->field("read_danci,read_jieshi,read_ciyi")->where("read_danci = '$read_w'")->find();
                            }
                        }
                    }
                }
            }
            $arr = array();
            $arr[] = array(
                'new_word' => $danci['read_danci'],
                'new_mean' => $danci['read_jieshi'],
                'read_type_id' =>I('post.read_type_id'),
                'read_level_id' => I('post.read_level_id'),
                'read_textbook_id' => I('post.read_textbook_id',""),
                'students_id' => $id,
                'add_time' => date("Y-m-d"),
                'old_word' =>$v,
                'status'=>2
            );
            print_r($arr);
            $arr = M('yixue_new')->addAll($arr);
        }
        if($arr){
            $result = array("status" => '200',"message"=>"添加生词本成功");
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
    /*
     * 获取生词
     * 需要参数：token,read_type_id,read_level_id,read_textbook_id
     * 返回数据：data
     */
    public function list_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
//        $id = 5;
        $read_type_id = I("post.read_type_id");
        $read_level_id = I("post.read_level_id");
        $read_textbook_id = I("post.read_textbook_id");
        if($read_textbook_id != ""){
            $arr = M("yixue_new")->field('new_word,new_mean,new_word,add_time,old_word')->where("students_id = $id and read_type_id = $read_type_id and read_level_id = $read_level_id and read_textbook_id = '$read_textbook_id'")->select();
        }else{
            $arr = M("yixue_new")->field('new_word,new_mean,new_word,add_time,old_word')->where("students_id = $id and read_type_id = $read_type_id and read_level_id = $read_level_id and read_textbook_id = '0'")->select();
        }
        $word = array();
        foreach($arr as $v){
            $word[] = $v['new_word'];
            $old[] = $v['old_word'];
        }
//        去除重复单词
        foreach($word as $k => $v){
            $data[] = M("danci_two")->field('read_danci,read_jieshi')->where("read_danci = '$v'")->find();
            $data[$k]['old'] = $old[$k];
        }
        $result = array("status" => '200',"message"=>"获取生词成功",'data'=>$data);
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    /*
     * 获取文章等级and文章所做次数and是否过关
     * 需要参数：token,read_type_id,read_textbook_id
     */
    public function read_level(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        //教材ID
//        $id = 1;
        $read_type_id = I("post.read_type_id");
        $read_textbook_id = I("post.read_textbook_id","");
//        $level_type_id = I("post.level_type_id");
        if($read_textbook_id != ""){
            $level = M("read_textbook")->field("level_id,level_name,level_textbook_id,textbook_name,type_id,type_name")->join('yixue_level ON read_textbook.textbook_id = yixue_level.level_textbook_id')->join('read_type on read_textbook.textbook_type_id = read_type.type_id')->where("type_id = $read_type_id and textbook_id = $read_textbook_id")->select();
//        print_r($level);die;
            //查询拼接文章所做的次数
            foreach($level as $k => $v){
                $nums = M("read_nums")->field("read_num,read_level_id,read_type_id,read_textbook_id")->where("students_id = $id and read_type_id = $v[type_id] and read_level_id = $v[level_id] and read_textbook_id = $v[level_textbook_id]")->find();
                if($nums['read_level_id'] == $v['level_id']){
                    $level[$k]['nums'] = $nums['read_num'];
                }else{
                    $level[$k]['nums'] = 0;
                }
            }
            $result = array("status" => '200',"message"=>"获取文章等级成功","level" => $level);
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
            $level = M("read_type")->field("level_id,level_name,type_id,type_name")->join('level_type_id on level_type_id.level_type_id = read_type.type_id')->where("type_id = $read_type_id ")->select();
//            print_r($level);die;
            foreach($level as $k => $v){
                $nums = M("read_nums")->field("read_num,read_level_id,read_type_id")->where("students_id = $id and read_type_id = $v[type_id] and read_level_id = $v[level_id] and read_textbook_id = 0")->find();
                if($nums['read_level_id'] == $v['level_id']){
                    $level[$k]['nums'] = $nums['read_num'];
                }else{
                    $level[$k]['nums'] = 0;
                }
            }
            $result = array("status" => '200',"message"=>"获取文章等级成功","level" => $level);
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
    /*
     * 提交文章
     * 需要参数：token,read_type_id,read_level_id,read_textbook_id
     * 返回数据：status,message,num,time
     */
    public function read_submit(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $arr['read_type_id'] = I('post.read_type_id');
        $arr['read_level_id'] = I('post.read_level_id');
        $arr['read_textbook_id'] = I('post.read_textbook_id','');

        $arr['students_id'] = $id;
        if($arr['read_textbook_id'] != ""){
            $data = M('read_nums')->field('students_id,read_type_id,read_level_id,read_textbook_id,read_num')->where("students_id = $id and read_type_id = $arr[read_type_id] and read_level_id = $arr[read_level_id] and read_textbook_id = $arr[read_textbook_id]")->find();
            if($data){
                if($data['read_num'] >= 3){
                    $result = array("status" => '-1',"message"=>"该题已经做过三次了，不能在做了");
                    echo json_encode($result,JSON_UNESCAPED_UNICODE);
                }else{
                    $num['read_num'] = $data['read_num']+1;
                    $data1 = M('read_nums')->where("students_id = $id and read_type_id = $arr[read_type_id] and read_level_id = $arr[read_level_id] and read_textbook_id = $arr[read_textbook_id]")->save($num);
                    $result = array("status" => '200',"message"=>"提交成功","nums" => $num['read_num'],"time"=>time());
                    echo json_encode($result,JSON_UNESCAPED_UNICODE);
                }
            }else{
                $arr['read_num'] = 1;
                $data2 = M('read_nums')->add($arr);
                $result = array("status" => '200',"message"=>"成功","nums"=>1,"time"=>time());
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }
        }else{
            $data = M('read_nums')->field('students_id,read_type_id,read_level_id,read_num')->where("students_id = $id and read_type_id = $arr[read_type_id] and read_level_id = $arr[read_level_id] and read_textbook_id = 0")->find();
            if($data){
                if($data['read_num'] >= 3){
                    $result = array("status" => '-1',"message"=>"该题已经做过三次了，不能在做了");
                    echo json_encode($result,JSON_UNESCAPED_UNICODE);
                }else{
                    $num['read_num'] = $data['read_num']+1;
                    $data1 = M('read_nums')->where("students_id = $id and read_type_id = $arr[read_type_id] and read_level_id = $arr[read_level_id]")->save($num);
                    $result = array("status" => '200',"message"=>"提交成功","nums" => $num['read_num'],"time"=>time());
                    echo json_encode($result,JSON_UNESCAPED_UNICODE);
                }
            }else{
                $arr['read_num'] = 1;
                $data2 = M('read_nums')->add($arr);
                $result = array("status" => '200',"message"=>"成功","nums"=>1,"time"=>time());
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }
        }

    }
    /*
     * 回收站单词
     * 需要数据：token,old_word,read_type_id,read_level_id,read_textbook_id
     * 返回数据：status,message
     */
    public function old_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
//        $id= 25;
        $read_type_id = I('post.read_type_id');
        $read_level_id = I('post.read_level_id');
        $read_textbook_id = I('post.read_textbook_id',"0");
        $old_word = I('post.old_word');
        $arr = array(
            'old_word' => $old_word,
            'read_type_id' =>I('post.read_type_id'),
            'read_level_id' => I('post.read_level_id'),
            'read_textbook_id' => I('post.read_textbook_id',""),
            'students_id' => $id,
            'add_time' => time()
        );
        M("yixue_new")->where("students_id = $id and read_type_id = $read_type_id and read_level_id = $read_level_id and read_textbook_id = '$read_textbook_id' and new_word = '$old_word'")->delete();
        $arr = M('yixue_old')->add($arr);
        if($arr){
            $result = array("status" => '200',"message"=>"删除单词成功，可在单词回收站中查看");
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
    /*
     * 获取回收站单词（删除三个月的）
     * 需要数据:token,read_type_id,read_level_id,read_textbook_id
     * 返回数据:data
     */
    public function recycle_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $read_type_id = I('post.read_type_id');
        $read_level_id = I('post.read_level_id');
        $read_textbook_id = I('post.read_textbook_id',"0");
        $arr = M("yixue_old")->field("old_id,old_word,add_time,students_id,read_type_id,read_level_id")->where("students_id = $id and read_type_id = $read_type_id and read_level_id = $read_level_id and read_textbook_id = '$read_textbook_id'")->select();
        $time = time();
//        print_r($arr);die;
        foreach($arr as $v){
            //判断是否过期
            if(($time-$v['add_time'])>60*60*24*90){
                M("yixue_old")->where("add_time = $v[add_time]")->delete();
            }else{
                $old_word[] = $v['old_word'];
            }
        }
        foreach($old_word as $v){
            $data[] = M("danci_two")->field('read_danci,read_jieshi')->where("read_danci = '$v'")->find();
        }
        $result = array("status" => '200',"message"=>"获取回收站单词成功","data"=>$data);
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    /*
    * 删除阅读生词本单词
    * 需要参数：token,new_word,read_type_id,read_level_id,read_textbook_id
    * 返回数据：status,message
    */
    public function delete_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $word = I('post.old_word');
        $read_type_id = I('post.read_type_id');
        $read_level_id = I('post.read_level_id');
        $read_textbook_id = I('post.read_textbook_id',"0");
        $arr = M("yixue_old")->where("students_id = $id and read_type_id = $read_type_id and read_level_id = $read_level_id and read_textbook_id = '$read_textbook_id' and old_word = '$word'")->delete();
        if($arr){
            $result = array("status" => '200',"message"=>"彻底删除单词");
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
            $result = array("status" => '-1',"message"=>"删除单词失败");
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
    /*
     * 提交打印
     * 需要参数：token,read_level_id,read_type_id
     * 返回数据：status,message
     */
    public function read_print()
    {
        $token = I('post.token');
        $id = token_id($token);
        token_no($id, $token);
        $students_name = M("yixue_students")->field("students_name")->where("students_id = '$id'")->find();
        $read_level_id = I('read_level_id');
        $read_type_id = I('read_type_id');
        $read_textbook_id = I('read_textbook_id',"0");
        if($read_textbook_id != 0){
            $read = M("class_dedicated")->field("read_title")->where("read_type_id = '$read_type_id' and read_level_id = '$read_level_id' and read_textbook_id = '$read_textbook_id'")->find();
        }else{
            $read = M("class_read")->field("read_title")->where("read_type_id = '$read_type_id' and read_level_id = '$read_level_id' and read_textbook_id = '0'")->find();
        }
        $key = $id.$read_type_id.$read_level_id.$read_textbook_id;
        $dy = S($key);
        if(empty($dy)){
            $arr['students_name'] = $students_name['students_name'];
            $arr['print_type'] = $read_type_id;
            $arr['print_level'] = $read_level_id;
            $arr['print_textbook'] = $read_textbook_id;
            $arr['read_title'] = $read['read_title'];
            $arr['print_students_id'] = $id;
            $arr['add_time'] = time();
            $data = M('yixue_print')->add($arr);

            if($data){
                S($key,$arr,10);
                $result = array("status" => '200',"message"=>"提交打印成功");
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }
        }else{
            $result = array("status" => '-1',"message"=>"一篇文章一天只能打印一次");
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
    /*
     * 测试报告接口
     * 需要参数：accuracy(正确率),spend_time(花费时间),submit_time(提交时间),read_type_id,read_level_id,all_topic,right_topic
     * 返回数据:data
     */
    public function test_report(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id, $token);
        $read_type_id = I('post.read_type_id');
        $read_level_id = I('post.read_level_id');
        $read_textbook_id = I('post.read_textbook_id','');
        if($read_textbook_id == ""){
            $sql = "select distinct read_level_id,read_type_id,read_title,read_text,add_time,read_difficulty_id,read_time,read_textbook_id from class_read where read_level_id = '$read_level_id' and read_type_id = '$read_type_id'";

            $num = "select count(distinct topic_timu) as all_topic from class_read where read_level_id = '$read_level_id' and read_type_id = '$read_type_id' and read_textbook_id = '0'";
        }else{
            $sql = "select distinct read_level_id,read_type_id,read_title,add_time,read_difficulty_id,read_time,read_textbook_id from class_dedicated,yixue_level,read_textbook 
                where class_dedicated.read_textbook_id = read_textbook.textbook_id and read_textbook.textbook_id = yixue_level.level_textbook_id and read_level_id = '$read_level_id' 
                and read_type_id = '$read_type_id' and read_textbook_id = '$read_textbook_id'";
            $num = "select count(distinct topic_timu) as all_topic from class_dedicated where read_level_id = '$read_level_id' and read_type_id = '$read_type_id' and read_textbook_id = $read_textbook_id";
        }

        $arr = M()->query($sql);
        $num = M()->query($num);
        $data['read_level_id'] = $arr[0]['read_level_id'];//关卡ID
        $data['read_title'] = $arr[0]['read_title'];//文章题目
        $data['accuracy'] = I('post.accuracy');//正确率
        $data['spend_time'] = I('post.spend_time');//花费时间
        $data['submit_time'] = time();//提交时间
        $data['all_topic'] = $num[0]['all_topic'];
        $data['error_topic'] = I('post.error_topic');
        $data['students_id'] = $id;
        $data['read_textbook_id'] = $arr[0]['read_textbook_id'];
        $data['read_type_id'] = $arr[0]['read_type_id'];
        $data['read_difficulty_id'] = $arr[0]['read_difficulty_id'];
        $test = M("read_analyze")->add($data);
        if($test){
            $result = array("status" => '200',"message"=>"答题分析入库成功");
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
            $result = array("status" => '-1',"message"=>"失败");
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
    public function read_feedback(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id, $token);
        $data['students_id'] = $id;
        $data['text'] = I("post.read_feedback");
        $data['time'] = time();
        M("feedback")->add($data);
        $result = array("status" => '200',"message"=>"反馈成功");
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    public function test(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $level = M("yixue_test")->field('test_id')->select();//等级
        for($i=1;$i<=count($level);$i++){//遍历等级的单词
            $arr = M()->query("select `sheet_id`,`danci_name`,`mean_one`,`mean_two`,`mean_three`,`mean_four`,`mean_five`,`word_level_id` from word_mean where word_level_id = $i ORDER BY rand() limit 10");//每个等级的单词
            $num = M()->query("select count(word_level_id) as num from word_mean where word_level_id = $i GROUP BY word_level_id");//每个等级的单词量
            foreach($arr as $v){
                $danci[]=array(
                    "num" => $num[0]['num'],
                    "level"=>$v['word_level_id'],
                    "name"=>$v['danci_name'],
                    "mean"=>array(
                        array(
                            "meandetail"=>$v['mean_one'],
                            "status"=>1
                        ),
                        array(
                            "meandetail"=>$v['mean_two'],
                              "status"=>0
                        ),
                        array(
                            "meandetail"=>$v['mean_three'],
                              "status"=>0
                        ),
                        array(
                            "meandetail"=>$v['mean_four'],
                              "status"=>0
                        ),
                        array(
                            "meandetail"=>$v['mean_five'],
                            "status"=>0
                        ),
                    )
                );
            }
        }
        $result = array(
            "status" => 200,
            "message" => "传输成功",
            "data" =>array(
                "time"=>15,
                "endtime"=>8,
                "weight"=>0.8,
                "arr"=>$danci,
            ),
        );
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    /*
     * 测试开始（开始时间）接口
     * 需要数据：token
     * 返回数据：status,message,time)
     * */
    public function start_time(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $time = time();
        $result = array(
            "status" => 200,
            "message" => "传输成功",
            "time"=>$time,
        );
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    public function asdasdad(){
        $try_study = I("post.try_study");
        $try_accredit = I("post.try_accredit");
        $code = I("post.code");
        //$accredit = isset($_POST['students_accredit']) ? trim($_POST['students_accredit']) : '';
        //时间
        $time = time();
        //连接超时
       if((time()-$time)>30){
           $results = array('status'=>'1001', 'message'=>'请求超时,请检查网络连接');
           exit(json_encode($results, JSON_UNESCAPED_UNICODE));
       }
        //参数为空返回false
        if (empty($try_study)||empty($try_accredit)||empty($code)) {
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
                        S($arr['students_id'],$token,3*24*60*60);
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
    public function try_study(){
        //试用电话
        $try_tel = I("post.try_tel");
        //试用授权码
        $try_accredit = I("post.try_accredit");

        //验证码
        $code = I("post.code");
        //判断验证码
       if($this->CheckSmsYzm($username,$code)){
           $results = array('status' => '1001','message'=>'验证码不正确');
           exit(json_encode($results,JSON_UNESCAPED_UNICODE));
       }


        //判断唯一性
       $names = M('yixue_students')->field('students_tel')->where("students_tel = '$username'")->find();
       if($names){
           $results = array('status' => '-1','message'=>'手机号已注册');
           exit(json_encode($results,JSON_UNESCAPED_UNICODE));
       }
        //判断参数
        if (empty($try_tel)||empty($try_accredit)||empty($code)) {
            $results = array('status' => '-1', 'message' => '缺少必要参数');
            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
        } else {
            //判断是否有该店铺
            $partner_code = M("yixue_partner")->field("partner_account")->where("partner_code = '$try_accredit'")->find();
            if($partner_code){
                $try_token = $try_tel + "try_token";
                $token = base64_encode($try_token.'-'.md5(md5(time()."yixue!")));
                S($try_tel,$token,3*3600);
                $data['try_tel'] = $try_tel;
                $data['try_accredit'] = $try_accredit;
                $data['try_time'] =  time();
                $res = M("try_remark")->add($data);
                $id = M('try_remark')->getLastInsID();
                $arr = array(
                    'try_user' => $id,
                    'token' => $token,
                );
                if ($res) {
                    $results = array('status' => '200', 'message' => '试用成功,试用机构“'.$partner_code['partner_account'].'”，时间为3小时','data'=>$arr);
                } else {
                    $results = array('status' => '-1', 'message' => '试用失败');
                }
                echo json_encode($results,JSON_UNESCAPED_UNICODE);
            }else{
                $results = array('status' => '-10', 'message' => '请输入正确的授权码');
                echo json_encode($results,JSON_UNESCAPED_UNICODE);
            }
        }
    }
    /*
     * 获取用户购买的课程*/
    public function buy_class(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $ids = M("students_class")->field("class_id")->where("students_id = $id")->select();
        foreach($ids as $v){
            $idss[] = $v['class_id'];
        }
        $idsss = implode(",",$idss);
        $where['class_id'] = array("in","$idsss");
        $class_name = M("yixue_class")->field("class_id,class_name")->where($where)->select();
        $result = array("status" => '200',"message"=>"获取用户购买课程成功","data"=>$class_name);
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    public function page(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $class_id = I('post.class_id');
        $will_word = I("post.will_word");
        $wills = explode(",",$will_word);
        $save['type_id'] = 4;
        $where['students_id'] = $id;
        $where['class_id'] = $class_id;
        foreach($wills as $v){
            $where['word'] = $v;
            $status = M("word_logic")->field("type_id")->where("word = '$v'")->find();
            if($status['type_id'] == 6){
                M("word_logic")->where($where)->save($save);
            }
        }
    }
    /*
     * 获取单词：50个一组
     * 需要参数：课程ID,token,page*/
    public function word()
    {
       $token = I('post.token');
       $id = token_id($token);
       token_no($id, $token);
        $id = 5;
        $time = M('word_punch')->field('time')->where("status = 0 and students_id = '$id'")->find();
        if(time()-$time['time'] > 24*3600){
            $save['status'] = 2;
            M("word_punch")->where("students_id = '$id' and status = '0'")->save($save);
        }
        if(!$time){
            $data = array(
                'time'=>time(),
                "status" => 0,//待复习
                "students_id" => $id,
            );
            M("word_punch")->add($data);
        }else{
            $save['time'] = time();
            M("word_punch")->where("students_id = '$id' and status = '0'")->save($save);
        }

        $class_id = I('post.class_id');
        $record = M("class_record")->field('students_id,class_id,study_num,study_status')->where("students_id = $id and class_id = $class_id")->find();
        //判断 1，2，3模块是否大于100
        $learning_where['students_id'] = $id;
        $learning_where['type_id'] = 5;
        $learning_where['class_id'] = $class_id;
        $learning_where['can_num'] = array("in","1,2,3");
        $learning_count = M("word_logic")->field("id")->where($learning_where)->count();
//        print_r($learning_count);die;
        if($learning_count > 100){
            $result = array("status" => "3", "message" => "您暂时没有可识记的单词，只能复习了");
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit;
        }
        //不会的个数
        $nocan_num = M("word_logic")->where("type_id = 6 and class_id = $class_id and students_id = $id")->count();
        //课程学习次数0次的时候并且学习状态为学习中，给表二加单词
        if ($record['study_num'] == 0 && $record['study_status'] == 1) {
            echo "课程学习次数0次的时候并且学习状态为学习中，给表二加单词";
            $word = M("yixue_word")->field("word,mean")->where("class_id = $class_id")->select();
            foreach ($word as $k => $v) {
                $word[$k]['students_id'] = $id;
                $word[$k]['class_id'] = $class_id;
                $word[$k]['type_id'] = 2;
            }
            $save['study_status'] = 2;
            M("word_logic")->addAll($word);
            M("class_record")->where("class_id = $class_id and students_id = $id")->save($save);
//            $where = "type_id = 2 and class_id = $class_id and students_id = $id";
        } else if (1 <= $record['study_num'] && $record['study_num'] < 3 && $record['study_status'] == 1) {//如果课程学习1<=次数<=3 将难词和学会的变为待识记 其他字段清0；
            echo "如果课程学习1<=次数<=3 将难词和学会的变为待识记 其他字段清0；";
            $where['type_id'] = array("in","3,4");
            $where['students_id'] = $id;
            $where['class_id'] = $class_id;
            $save['type_id'] = 2;
            $save['can_num'] = 0;
            $save['nocan_num'] = 0;
            $save['can_time'] = 0;
            M("word_logic")->where($where)->save($save);
        }else if($record['study_num'] == 3||$record['study_num'] == 4){//如果课程学习次数=3或者次数=4 将难词变为待识记 其他字段清0；
            echo "如果课程学习次数=3或者次数=4 将难词变为待识记 其他字段清0";
            $where['type_id'] = 3;
            $where['students_id'] = $id;
            $where['class_id'] = $class_id;
            $save['type_id'] = 2;
            $save['can_num'] = 0;
            $save['nocan_num'] = 0;
            $save['can_time'] = 0;
            M("word_logic")->where($where)->save($save);
        }else if($record['study_num'] == 5){
            $result = array("status" => "-4", "message" => "学习次数已经用完");
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit;
        }
        if ($record['study_num'] == 0) {//第一次学习
            $dai_num = M("word_logic")->where("type_id = 2 and class_id = $class_id and students_id = $id")->count();
            if ($dai_num == 0) {//待识记为0
                if ($nocan_num >= 50) {
                    //不会的词
                    $page = I("post.page", "1");
                    $num = 50;
                    $count = M("word_logic")->where("type_id = 6 and class_id = $class_id and students_id = $id")->count();
                    $pagenum = ceil($count / $num);
                    if ($page == $pagenum || $page == 0) {
                        $stu = false;
                    }else{
                        $stu = true;
                    }
                    $offset = ($page - 1) * $num;
                    $nocan_word = M("word_logic")->field("word,mean")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, $num)->select();
                    $result = array("status" => "200", "message" => "获取单词成功","is_have_page"=>$stu, "data" => $nocan_word);
                    echo json_encode($result, JSON_UNESCAPED_UNICODE);
                } else {
                    //判断会的次数不够的单词的数量 如果大于50去复习，小于50一遍过
                    $where['can_num'] = array("in", "0,1,2,3,4,5,6");
                    $where['class_id'] = $class_id;
                    $where['students_id'] = $id;
                    $nocan_count = M("word_logic")->where($where)->count();
                    if ($nocan_count <= 50) {
                        //学习一轮结束
                        $nocan_word = M("word_logic")->field("word,mean")->where($where)->select();
                        $stu = false;
                        $where['students_id'] = $id;
                        $where['class_id'] = $class_id;
                        $data = M("class_record")->field('study_num,study_status')->where($where)->find();
                        $save['study_num'] = $data['study_num'] + 1;
                        $save['study_status'] = 1;
                        M("class_record")->where($where)->save($save);
                        $result = array("status" => "200", "message" => "获取单词成功","is_last_remember"=>$stu,"data" => $nocan_word);
                        echo json_encode($result, JSON_UNESCAPED_UNICODE);
                    } else {
                        $result = array("status" => "3", "message" => "您暂时没有可识记的单词，只能复习了");
                        echo json_encode($result, JSON_UNESCAPED_UNICODE);
                    }
                }
            } else {//待识记的不为0
                if ($nocan_num >= 50) {//不会的》50
                    $page = I("post.page","1");
                    $num = 25;
                    $nocan_pagenum = ceil($nocan_num / $num);//不会的单词页码3页
                    $pagenum = ceil($dai_num / $num);//待识记的页码1页
                    if ($nocan_num > $dai_num) {//如果不会的大于未识记的 那么不会的页码一定比未识记的多
                        if ($page <= $nocan_pagenum || $page == 0) {//整页的不会的
                            $offset = ($page - 1) * $num;//偏移量 0，25，50
                            if ($page < $pagenum || $page == 0) {//整页的未识记的单词
                                $nocan_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 2 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                //返回数据,  ishavepage=true
                                $stu = true;
                                $words = array_merge($nocan_word, $dai_word);
                                $result = array("status" => "200", "message" => "获取单词成功","is_have_page"=>$stu, "data" => $words);
                                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                            } else if ($page == $pagenum) {//最后一页个数<=25
                                $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 2 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                $lastnum = $dai_num - $offset;//剩余的未识记的单词的个数
                                if ($nocan_num - $offset > 50 - $lastnum) {
                                    //不会的不补齐
                                    $nocan_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                    $stu = true;
                                    //返回数据,ishavepage=true
                                } else {
                                    $nocan_lastnum = $nocan_num - $offset;
                                    $nocan_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, $nocan_lastnum)->select();
                                    // $dai_word $nocan_word返回数据, 最后一页 ishavepage=false
                                    $stu = false;
                                }
                                $words = array_merge($nocan_word, $dai_word);
                                $result = array("status" => "200", "message" => "获取单词成功","is_have_page"=>$stu, "data" => $words);
                                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                            } else {//只剩下不会的
                                $num = 50;
                                $offset = ($pagenum - 1) * 25 + ($page - $pagenum) * 50;
                                if ($offset + $num <= $nocan_num) {
                                    $nocan_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, 50)->select();
                                    $stu = true;
                                    //返回数据,ishavepage=true
                                } else {
                                    $nocan_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, $nocan_num - $offset)->select();
                                    $stu = false;
                                    //$nocan_word返回数据, 最后一页 ishavepage=false
                                }
                                $result = array("status" => "200", "message" => "获取单词成功","is_have_page"=>$stu, "data" => $nocan_word);
                                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                            }
                        }
                    } else {
                        $nocan_pagenum = ceil($nocan_num / $num);//不会的单词页码3页
                        $pagenum = ceil($dai_num / $num);//待识记的页码3页
                        if ($page <= $pagenum || $page == 0) {//整页的未识记
                            $offset = ($page - 1) * $num;//每页50个
                            if ($page < $nocan_pagenum || $page == 0) {//整页的不会的单词
//                                echo 1;die;
                                $nocan_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 2 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                //返回数据,  ishavepage=true
                                $stu = true;
                                $words = array_merge($nocan_word, $dai_word);
                                $result = array("status" => "200", "message" => "获取单词成功","is_have_page" =>$stu, "data" => $words);
                                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                            } else if ($page == $nocan_pagenum) {//最后一页不会个数<=25
//                                echo $offset;die;
                                $nocan_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 2 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                $lastnum = $nocan_num - $offset;//剩余的不会的单词的个数
                                if ($dai_num - $offset > 50 - $lastnum) {//待识记大于不会的个数
                                    //未识记的不补齐
                                    $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                    $stu = false;
                                    //返回数据,ishavepage=true
                                } else {//待识记小于不会的个数
                                    $lastnum = $dai_num - $offset;
                                    $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, $lastnum)->select();
                                    // $dai_word $nocan_word返回数据, 最后一页 ishavepage=false
                                    $stu = false;
                                }
                                $words = array_merge($nocan_word, $dai_word);
                                $result = array("status" => "200", "message" => "获取单词成功","is_have_page" =>$stu, "data" => $words);
                                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                            } else {//只剩下不会的
//                                echo $nocan_pagenum;die;
                                $num = 50;
                                $offset = ($nocan_pagenum - 1) * 25 + ($page - $nocan_pagenum) * 50;
//                                print_r($offset);die;
                                if ($offset + $num <= $nocan_num) {
//                                    echo 1;die;
                                    $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, 50)->select();
                                    $stu = false;
                                    //返回数据,ishavepage=true
                                } else {
                                    $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, $offset - $nocan_num)->select();
                                    $stu = false;
                                    //$nocan_word返回数据, 最后一页 ishavepage=false
                                }
                                $result = array("status" => "200", "message" => "获取单词成功","is_have_page"=>$stu, "data" => $dai_word);
                                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                            }
                        }
                    }
                } else {//不会的<50  待识记的》0
                    //分页返回50个单词
                    $page = I("post.page", "1");
                    $num = 50;
                    $pagenum = ceil($dai_num / $num);
                    if ($page <= $pagenum || $page == 0) {
                        $offset = ($page - 1) * $num;
                        $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 2 and class_id = $class_id and students_id = $id")->limit($offset, 50)->select();
                        if ($page == $pagenum) {
                            $stu = false;
                        } else {
                            $stu = true;
                        }
                        $result = array("status" => "200", "message" => "获取单词成功","is_have_page"=>$stu, "data" => $dai_word);
                        echo json_encode($result, JSON_UNESCAPED_UNICODE);
                    }
                }
            }
        }
    }
    /*
     * 接口名称：一眼会
     * 需要参数：token,class_id,word,
     * 返回数据：data
     * */
    public function word_add(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $class_id = I('post.class_id');
        $yican_word = I("post.yican_word");
        $where['word'] = array("in",$yican_word);
        $save['type_id'] = 1;
        $where['students_id'] = $id;
        $where['class_id'] = $class_id;
        $arr = M("word_logic")->where($where)->save($save);
        $sql = M()->getLastSql();
        $result = array("status" => "200", "message" => "添加一眼会单词成功");
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 选词入库：对错
     * 需要参数：token,class_id,right_word,error_right
     * 返回数据：对错分别入库成功
     * */
    public function will_word(){
       $token = I('post.token');
       $id = token_id($token);
       token_no($id,$token);
        $id = 5;
        $class_id = I('post.class_id');
        //会的单词
        $right_word = I("post.right_word");
        //不会的单词
        $nocan_word = I("post.nocan_word");
        $right_words = explode(",",$right_word);
        $nocan_words = explode(",",$nocan_word);
        $where['students_id'] = $id;
        $where['class_id'] = $class_id;
        foreach($right_words as $v){
            $where['word'] = $v;
            $status = M("word_logic")->field("type_id,can_num")->where($where)->find();
            if($status['type_id'] == 2){
                $save["type_id"] = 5;
                $save['can_num'] = $status['can_num']+1;
                M("word_logic")->where($where)->save($save);
            }else if($status['type_id'] == 5){
                if($status["can_num"] >=1 && $status["can_num"] <3){
                    $save['can_num'] = $status['can_num']+1;
                    M("word_logic")->where($where)->save($save);
                }else if($status["can_num"]>=3 && $status["can_num"]<6){
                    $save["can_time"] = time();
                    $save['can_num'] = $status['can_num']+1;
                    M("word_logic")->where($where)->save($save);
                }else if($status["can_num"] >= 6){
                    $save['type_id'] = 4;
                    $save['can_num'] = $status['can_num']+1;
                    M("word_logic")->where($where)->save($save);
                }
            }
        }
        foreach($nocan_words as $v){
            $where['word'] = $v;
            $statu = M("word_logic")->field("type_id,nocan_num")->where($where)->find();
            if($statu['type_id'] == 6){
                if($statu['nocan_num'] >= 5){
                    $saves['type_id'] = 3;
                    M("word_logic")->where($where)->save($saves);
                }else{
                    $saves['can_num'] = 0;
                    $saves['nocan_num'] = $statu['nocan_num'] + 1;
                    M("word_logic")->where($where)->save($saves);
                }
            }else if($statu['type_id'] == 2){
                $saves['type_id'] = 6;
                $saves['nocan_num'] = $statu['nocan_num']+1;
                $saves['can_num'] = 0;
                M("word_logic")->where($where)->save($saves);
            }else if($statu['type_id'] == 5){
                $saves['type_id'] = 6;
                $saves['nocan_num'] = $statu['nocan_num']+1;
                $saves['can_num'] = 0;
                M("word_logic")->where($where)->save($saves);
            }
        }
        $result = array("status" => "200", "message" => "对错词分类添加成功！");
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 获取复习单词
     * 需要参数：token,class_id
     * 返回数据：获取复习单词成功
     * */
    public function review_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $class_id = I('post.class_id');
        $where['students_id'] = $id;
        $where['class_id'] = $class_id;
        $where['can_num'] = 4;
        $nowtime = time();
        $where["can_num"] = array("in","1,2,3");
        $time["can_num"] = array("in","4,5,6");
        $time['students_id'] = $id;
        $time['class_id'] = $class_id;
        $arr = M("word_logic")->field("word,mean")->where($where)->select();
        $four_day = M("word_logic")->field("word,mean,can_time")->where($time)->select();
        if($arr){
            $time = M("word_punch")->field("time")->where("students_id = '$id' and status = 0")->find();
            $save['status'] = 1;
            M('word_punch')->where("students_id = '$id' and status = 0")->save($save);
        }else{
            echo "无复习单词";
        }
        foreach($four_day as $k=>$v){
            if($nowtime - $v['can_time'] > 10){
                $four[$k]["word"] = $v['word'];
                $four[$k]["mean"] = $v['mean'];
                $words = array_merge($four,$arr);
            }else{
                $words = $arr;
            }
        }
        $result = array("status" => "200", "message" => "获取复习单词成功！","data"=>$words);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 获取复习单词数量
     * 需要参数：token,class_id
     * 返回数据：获取复习单词数量成功
     * */
    public function review_word_count(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $class_id = I('post.class_id');
        $where['students_id'] = $id;
        $where['class_id'] = $class_id;
        $where['can_num'] = 4;
        $nowtime = time();
        $where["can_num"] = array("in","1,2,3");
        $time["can_num"] = array("in","4,5,6");
        $time['students_id'] = $id;
        $time['class_id'] = $class_id;
        $arr = M("word_logic")->field("word,mean")->where($where)->select();
        $four_day = M("word_logic")->field("word,mean,can_time")->where($time)->select();
        foreach($four_day as $k=>$v){
            if($nowtime - $v['can_time'] > 86400){
                $four[$k]["word"] = $v['word'];
                $four[$k]["mean"] = $v['mean'];
                $words = array_merge($four,$arr);
                $count = count($words);
            }else{
                $words = $arr;
                $count = count($words);
            }
        }
        $result = array("status" => "200", "message" => "获取复习单词数量成功！","count"=>$count);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 获取不会单词的个数
     * 需要参数：token,class_id
     * 返回数据：count(个数)
     */
    public function nocan_word_count(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $class_id = I('post.class_id');
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
        $where["type_id"] = 6;
        $nocan_word_count = M("word_logic")->field("id")->where($where)->count();
        $result = array("status" => "200", "message" => "获取不会单词个数成功！","count"=>$nocan_word_count);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
    * 获取不会单词的内容：大于50，随机取50
    * 需要参数：token,class_id
    * 返回数据：count(个数)
    */
    public function nocan_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $class_id = I('post.class_id');
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
        $where["type_id"] = 6;
        $nocan_word = M("word_logic")->field("word,mean")->where($where)->select();
        $nocan_word_count = M("word_logic")->field("id")->where($where)->count();
        if($nocan_word_count > 50){
            $nocan = array_rand($nocan_word,50);
            foreach($nocan as $v){
                $no[] = $nocan_word[$v];
            }
            $result = array("status" => "200", "message" => "获取不会单词成功，大于50！","data"=>$no);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }else{
            $result = array("status" => "200", "message" => "获取不会单词成功！","data"=>$nocan_word);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }
    /*
     * 获取已学习的所有单词
     * 需要参数：token,class_id
     * 返回数据：data(个数)*/
    public function study_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
//        $id = 5;
        $page = I("post.page", "1");
        $class_id = I('post.class_id');
        $num = 50;
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
        $where["type_id"] = array("in","1,3,4,5,6");
        $count = M("word_logic")->where($where)->count();
        $pagenum = ceil($count / $num);
        if ($page == $pagenum || $page == 0) {
            $stu = false;
        }else{
            $stu = true;
        }
        $offset = ($page - 1) * $num;
        $study_word = M("word_logic")->field("word,mean")->where($where)->limit($offset,$num)->select();
        $result = array("status" => "200", "message" => "获取已学习的所有单词成功！","is_have_page"=>$stu,"data"=>$study_word);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 获取剩余的所有单词
     * 需要参数：token,class_id
     * 返回数据：data(个数)*/
    public function study_residue_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $page = I("post.page", "1");
        $class_id = I('post.class_id');
        $num = 50;
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
        $where["type_id"] = 2;
        $count = M("word_logic")->where($where)->count();
        $pagenum = ceil($count / $num);
        if ($page == $pagenum || $page == 0) {
            $stu = false;
        }else{
            $stu = true;
        }
        $offset = ($page - 1) * $num;
        $study_word = M("word_logic")->field("word,mean")->where($where)->limit($offset,$num)->select();
        $result = array("status" => "200", "message" => "获取剩余单词成功！","is_have_page"=>$stu,"data"=>$study_word);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
    * 获取已学习的所有单词的次数和剩余单词的次数
    * 需要参数：token,class_id
    * 返回数据：data(个数)*/
    public function study_word_count(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $class_id = I('post.class_id');
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
        $where["type_id"] = array("in","1,3,4,5,6");
        $no["class_id"] = $class_id;
        $no["students_id"] = $id;
        $no["type_id"] = 2;
        $study_word_yes= M("word_logic")->field("id")->where($where)->count();
        $study_word_no = M("word_logic")->field("id")->where($no)->count();
        $arr = array("yes_study" => $study_word_yes,"no_study"=>$study_word_no);
        $result = array("status" => "200", "message" => "获取已学习的所有单词成功！","data"=>$arr);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 获取每个模块单词的数量
     * 需要参数：token,class_id
     * 返回数据：data(个数)
     * */
    public function each_count_word(){
       $token = I('post.token');
       $id = token_id($token);
       token_no($id,$token);
        $id = 5;
        $class_id = I('post.class_id');
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
        $arr = M("word_logic")->field("count(*) as count,can_num")->group("can_num")->where($where)->select();
        $result = array("status" => "200", "message" => "获取每个模块单词的数量！","data"=>$arr);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 获取某一个模块所有单词、不会的次数
     * 需要参数：token,class_id,type_id
     * */
    public function each_word(){
       $token = I('post.token');
       $id = token_id($token);
       token_no($id,$token);
        $id = 5;
        $class_id = I('post.class_id');
        $type_id = I('post.type_id');
        $can_num = I("post.can_num");
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
        $where['can_num'] = $can_num;
        $page = I("post.page", "1");
        $num = 50;
        $count = M("word_logic")->where($where)->count();
        $pagenum = ceil($count / $num);
        if ($page == $pagenum || $pagenum == 0) {
            $stu = false;
        }else{
            $stu = true;
        }
        $offset = ($page - 1) * $num;
        $each_word = M("word_logic")->field("word,mean")->where($where)->limit($offset,$num)->select();
        $result = array("status" => "200", "message" => "获取每个模块单词的数量！","is_have_page" => $stu,"data"=>$each_word);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 加入难词本
     * 需要参数：token,class_id,word
     * 返回数据：data
     * */
    public function difficulty_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $difficulty_word = I("post.difficulty_word");
        $class_id = I('post.class_id');
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
        $save["type_id"] = 3;
        $where['word'] = $difficulty_word;
        M("word_logic")->where($where)->save($save);
        $result = array("status" => "200", "message" => "加入难词本成功！");
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 打卡
     * 返回数据：data
     * */
    public function punch_card(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $arr = M("word_punch")->where("students_id = '$id'")->select();
        foreach($arr as $v){
            $brr[] = array(
              'date' => date("Y-m-d",$v['time']),
                'word_status'=>$v['status']
            );
        }
        $result = array("status" => "200", "message" => "获取复习记录成功（打卡）！","data"=>$brr);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 打印单词接口
     * 返回数据：data
     * */
    public function print_word(){
       $token = I('post.token');
       $id = token_id($token);
       token_no($id,$token);
        $id = 5;
        $print_word = I('post.word');
        $words = explode(",",$print_word);
        $students = M("yixue_students")->field("students_name")->where("students_id = $id")->find();
        $print_word_list = array(
            'students_id'=>$id,
            'students_name'=>$students['students_name'],
            'time'=>time()
        );
        M("print_word_list")->add($print_word_list);
        foreach($words as $v){
            $ar[] = M("danci_one")->field("read_danci,read_jieshi")->where("read_danci = '$v'")->find();
        }
        foreach($ar as $v){
            $data['students_id'] = $id;
            $data['mean'] = $v['read_jieshi'];
            $data['word'] = $v['read_danci'];
            $data['time'] = time();
            M("print_word")->add($data);
        }
        $result = array("status" => "200", "message" => "单词打印提交成功！");
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    //添加生词本
    public function new_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $print_word = I('post.word');
        $ar = M("danci_one")->field("read_danci,read_jieshi")->where("read_danci = '$print_word'")->find();
        $data['students_id'] = $id;
        $data['new_mean'] = $ar['read_jieshi'];
        $data['new_word'] = $ar['read_danci'];
        $data['add_time'] = date("Y-m-d");
        $data['status'] = 1;
        M("yixue_new")->add($data);
        $result = array("status" => "200", "message" => "添加生词本成功");
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    //获取单词本生词
    public function gain_new_word(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $sql = "select add_time,group_concat(new_word) as word, group_concat(new_mean) as mean  from yixue_new where students_id = $id and status = 1 group by add_time";
        $arr = M()->query($sql);
        foreach($arr as $k=>$v){
            $word = explode(",",$v['word']);
            $mean = explode(",",$v['mean']);
            $a = array(word=>$word);
            $b = array (mean=>$mean);
            $test = array("a"=>word,"b"=>mean);
            $result = array();
            for($i=0;$i<count($a[word]);$i++){
                foreach($test as $key=>$value){
                    $result[$i][$value] = ${$key}[$value][$i];
                }
            }
            $newarray[] = array(
                "time" => $v['add_time'],
                "words" =>$result
            );
        }
        $result = array("status" => "200", "message" => "获取单词本生词成功","data"=>$newarray);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    //获取阅读生词
    public function gain_new_read(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $sql = "select add_time,group_concat(new_word) as word, group_concat(new_mean) as mean  from yixue_new where students_id = $id and status = 2 group by add_time";
        $arr = M()->query($sql);
        foreach($arr as $k=>$v){
            $word = explode(",",$v['word']);
            $mean = explode(",",$v['mean']);
            $a = array(word=>$word);
            $b = array (mean=>$mean);
            $test = array("a"=>word,"b"=>mean);
            $result = array();
            for($i=0;$i<count($a[word]);$i++){
                foreach($test as $key=>$value){
                    $result[$i][$value] = ${$key}[$value][$i];
                }
            }
            $newarray[] = array(
                "time" => $v['add_time'],
                "words" =>$result
            );
        }
        $result = array("status" => "200", "message" => "获取阅读生词本成功","data"=>$newarray);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
     /*
     * 测试单词反馈接口
     * 需要数据：token,all_time,start_time,record_fenshu
     * 返回数据：status,message,data=array('students_name','students_school','eval_text,'garde_name')
     * */
    public function evals(){
        $token = I('post.token');
        $id = token_id($token);
        token_no($id,$token);
        $record_fenshu = I('post.record_fenshu');
        if($record_fenshu==0){
            $record_fenshu = "1";
        }
        $arr['record_fenshu'] = $record_fenshu;
        $arr['start_time'] = I('post.start_time');
        $arr['all_time'] = I('post.all_time');
        if(empty($record_fenshu)||empty($arr['start_time'])||empty($id)||empty($arr['all_time'])){
            $results = array('status'=>'-1', 'message'=>'缺少必要参数');
            exit(json_encode($results, JSON_UNESCAPED_UNICODE));
        }
        $brr = M("yixue_students")->field("students_name,students_garde,students_school")->find();
        $garde = M('yixue_garde')->field('garde_name')->where("garde_id = '$brr[students_garde]'")->find();
        $arr['students_name'] = $brr['students_name'];
        $arr['students_school'] = $brr['students_school'];
        $arr['students_garde'] = $garde['garde_name'];
        M("record_word")->add($arr);
        if(0<$record_fenshu&&$record_fenshu<200){
            $where = "100-200";
        }
        if(201<$record_fenshu&&$record_fenshu<400){
            $where = "201-400";
        }
        if(401<$record_fenshu&&$record_fenshu<600){
            $where = "401-600";
        }
        if(601<$record_fenshu&&$record_fenshu<800){
            $where = "601-800";
        }
        if(801<$record_fenshu&&$record_fenshu<1200){
            $where = "801-1200";
        }
        if(1201<$record_fenshu&&$record_fenshu<1600){
            $where = "1201-1600";
        }
        if(1601<$record_fenshu&&$record_fenshu<2200){
            $where = "1601-2200";
        }
        if(2201<$record_fenshu&&$record_fenshu<2800){
            $where = "2201-2800";
        }
        if(2801<$record_fenshu&&$record_fenshu<3500){
            $where = "2801-3500";
        }
        if(3501<$record_fenshu&&$record_fenshu<4800){
            $where = "3501-4800";
        }
        if(4801<$record_fenshu&&$record_fenshu<5500){
            $where = "4801-5500";
        }
        if(5501<$record_fenshu&&$record_fenshu<8000){
            $where = "5501-8000";
        }
        $a = M("yixue_eval")->field('eval_one,eval_two,eval_three')->where("eval_end_num = '$where'")->find();
        $res = array_merge($brr,$a,$garde);
        unset($res['students_garde']);
        if($a){
            $results = array('status' => '200', 'message' => '成功','data'=>$res);
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