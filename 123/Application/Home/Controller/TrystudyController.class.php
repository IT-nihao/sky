<?php
namespace Home\Controller;
use Think\Controller;
class TrystudyController extends Controller {
    public function asdasdad(){
        $try_study = I("post.try_study");
        $try_accredit = I("post.try_accredit");
        $code = I("post.code");
        //$accredit = isset($_POST['students_accredit']) ? trim($_POST['students_accredit']) : '';
        //时间
        $time = time();
        //连接超时
//        if((time()-$time)>30){
//            $results = array('status'=>'1001', 'message'=>'请求超时,请检查网络连接');
//            exit(json_encode($results, JSON_UNESCAPED_UNICODE));
//        }
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
//        if($this->CheckSmsYzm($username,$code)){
//            $results = array('status' => '1001','message'=>'验证码不正确');
//            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
//        }


        //判断唯一性
//        $names = M('yixue_students')->field('students_tel')->where("students_tel = '$username'")->find();
//        if($names){
//            $results = array('status' => '-1','message'=>'手机号已注册');
//            exit(json_encode($results,JSON_UNESCAPED_UNICODE));
//        }
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
}