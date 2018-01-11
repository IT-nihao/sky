<?php
namespace Admin\Controller;
use Think\Controller;
class StudentsController extends CommonController {
    //学生列表
    public function students_list(){
        $session = session("yixue_user");
        $id = $session['user_id'];
        $me = M("yixue_partner")->field("partner_code")->where("user_id = $id")->select();//自己的店
        $ids = M("yixue_partner")->field("user_id")->where("user_pid = $id")->select();//大客户名下所有校区
        //根据用户找校区
        foreach($ids as $v){
            $campus_ids[] = $v['user_id'];
        }
        $idss = implode(",",$campus_ids);
//        print_r($ids);die;
        //拼接当前用户ID和所管理的ID
        $idsss = $idss.",".$id;
        $whe['user_id'] = array("in",$idsss);/*1，2，3，4用户ID（包括自己的）*/
//        $whe['user_id'] = $id;
        //根据店铺找学生
        if($id != 1){
            $code = M("yixue_partner")->field("partner_code,partner_account")->where($whe)->select();
//            $m = M()->getLastSql();
//            echo $m;die;
        }else{
            $code = M("yixue_partner")->field("partner_code,partner_account")->select();
        }
        foreach($code as $v){
            $codes[] = $v['partner_code'];
        }

        $where = implode(',',$codes);/*12222，11111，11114授权码*/
        $search_name = I("get.students_name");
        $search_tel = I("get.students_tel");
//        $search_home = I("get.students_home");
        $students_accredit = I("get.students_accredit");
        if($id == 1){
//            echo 1;die;
            $arr = admin("yixue_students",$search_name,$search_tel,$students_accredit,"students_id,students_name,students_tel,students_sex,students_school,students_garde,students_course
        ,students_patriarch,patriarch_tel,students_home,students_accredit,students_location","students_id");
        }else if($students_accredit == ""){
//            echo 2;die;
            $arr = students("yixue_students",$search_name,$search_tel,$where,"","students_id,students_name,students_tel,students_sex,students_school,students_garde,students_course
        ,students_patriarch,patriarch_tel,students_home,students_accredit","students_id");
        }else{
//            echo 3;die;
            $arr = students("yixue_students",$search_name,$search_tel,"","$students_accredit","students_id,students_name,students_tel,students_sex,students_school,students_garde,students_course
        ,students_patriarch,patriarch_tel,students_home,students_accredit","students_id");
        }
//        print_r($arr);die;
        foreach($me as $v) {
            $stud_accredit[] = $v['partner_code'];
        }
        foreach($arr['arr'] as $vv){
            $is_have = false;
            foreach($stud_accredit as $v){
                if($v == $vv['students_accredit']){
                    $st[] = 1;
                    $is_have = true;
                    break;
                }
            }
            if($is_have == false){
                $st[] = 2;
            }
        }
        foreach($arr['arr'] as $k => $v){
            foreach($st as $kk=>$vv){
                $arr['arr'][$kk]['is_me_students'] = $vv;
            }
        }
//        $sql = M()->getLastSql();
//        print_r($arr);die;
        $open_pwd = M("yixue_partner")->field('open_pwd')->where("user_id = '$id'")->find();
        $this->assign("count",$arr['count']);
        $this->assign("open_pwd",$open_pwd);
        $this->assign('page',$arr['page']);// 赋值分页输出
        $this->assign('arr',$arr['arr']);
        $this->assign('partner_code',$code);
        $this->assign('id',$id);
        $this->display();
    }
    //学生添加
    public function students_add(){
        if(IS_GET){
            $session = session("yixue_user");
            $id = $session['user_id'];
            if($id != 1){
                $code = M('yixue_partner')->field('partner_code,partner_account')->where("user_id = $id")->select();
            }else{
                $code = M('yixue_partner')->field('partner_code,partner_account')->select();
            }
//            print_r($code);die;
            $garde = M('yixue_garde')->field('garde_id,garde_name')->select();
            $partner = M('yixue_partner')->field('user_id,partner_government')->select();
            $this->assign("partner",$partner);
            $this->assign("code",$code);
            $this->assign('garde',$garde);
            $this->display();
        }
        if(IS_POST) {
            $data = I('post.');
            if(!preg_match("/^[\x7f-\xff]+$/", $data['students_name'])){
                $this->error("学生姓名不能是除中文以外的字符！");
            }
            if(!preg_match("/^1[34578]\d{9}$/", $data['students_tel'])){
                $this->error("请输入正确的学生电话，如果无，输入家长电话！");
            }
            if(!preg_match("/^[\x7f-\xff]+$/", $data['students_patriarch'])){
                $this->error("家长姓名不能是除中文以外的字符！");
            }
            if(!preg_match("/^1[34578]\d{9}$/", $data['patriarch_tel'])){
                $this->error("请输入正确的家长电话");
            }
            foreach ($data as $v) {
                if (empty($v)) {
                    $this->error("每个选项都需要填哦！");
                }
            }
            $arr = M('yixue_students')->add($data);
            if ($arr) {
                $this->success('添加成功', U('students_list'));
            } else {
                $this->error('添加失败');
            }
        }

    }

    //学生删除
    public function students_delete(){
        $students_id = I('get.students_id');
        $arr = M('yixue_students')->where("students_id = '$students_id'")->delete();
        if($arr){
            $this->success("删除成功",U('students_list'));
        }else{
            $this->error("删除失败");
        }
    }
    //修改学生信息
    public function students_update(){
        if(IS_GET){
            $students_id = I("get.students_id");
            $session = session("yixue_user");
            $id = $session['user_id'];
            $code = M('yixue_partner')->field('partner_code,partner_account')->where("user_id = $id")->select();
            $garde = M('yixue_garde')->field('garde_id,garde_name')->select();
            $arr = M('yixue_students')->field('students_id,students_name,students_tel,students_sex,students_school,students_garde,students_course
            ,students_patriarch,patriarch_tel,students_home')->where("students_id = '$students_id'")->find();
            $this->assign('arr',$arr);
            $this->assign('code',$code);
            $this->assign('garde',$garde);
            $this->display();
        }
        if(IS_POST) {
//            'students_course'=>I('post.students_course')//已经购买课程未添加
//            'students_birthday'=>I('post.students_birthday'),生日未添加
            $id = I('post.students_id');
//            print_r($id);die;
            $data = array(
                'students_name' => I('post.students_name'),
                'patriarch_tel' => I('post.patriarch_tel'),
                'students_tel' => I('post.students_tel'),
                'students_sex' => I('post.students_sex'),
                'students_school' => I('post.students_school'),
                'students_garde' => I('post.students_garde'),
                'students_patriarch' => I('post.students_patriarch'),
                'students_home' => I('post.students_home'),
            );
            if (!preg_match("/^[\x7f-\xff]+$/", $data['students_name'])) {
                $this->error("学生姓名不能是除中文以外的字符！");
            }
            if (!preg_match("/^1[34578]\d{9}$/", $data['students_tel'])) {
                $this->error("请输入正确的学生电话，如果无，输入家长电话！");
            }
            if (!preg_match("/^[\x7f-\xff]+$/", $data['students_patriarch'])) {
                $this->error("家长姓名不能是除中文以外的字符！");
            }
            if (!preg_match("/^1[34578]\d{9}$/", $data['patriarch_tel'])) {
                $this->error("请输入正确的家长电话");
            }
            foreach ($data as $v) {
                if (empty($v)) {
                    $this->error("每个选项都需要填哦！");
                }
            }
            $arr = M('yixue_students')->where("students_id = '$id'")->save($data);
            if ($arr) {
                $this->success("修改成功", U('students_list'));
            } else {
                $this->error("修改失败");
            }
        }
    }
    //查看学生状态

    public function students_look(){
        $students_id = I('get.students_id');
//        echo $students_id;die;
//        $arr = M()->query("select students_id,students_name,students_tel,students_sex,students_school,students_garde,garde_name,students_course,students_patriarch,patriarch_tel,students_home from yixue_students,yixue_garde where yixue_students.students_garde = yixue_garde.garde_id  and students_id = '$students_id'");
        $arr = M("yixue_students")->join('yixue_garde ON yixue_garde.garde_id = yixue_students.students_garde')->where("students_id = '$students_id'")->find();
        $this->assign('arr',$arr);
        $this->display();
    }
    public function students_location(){
        $students_id = I("post.students_id");
        $students_location = I("post.students_location");
        if($students_location == 1){
            $data = array("students_location"=>2);
            M("yixue_students")->where("students_id = $students_id")->save($data);
            echo 1;
        }
        if($students_location == 2){
            $data = array("students_location"=>1);
            M("yixue_students")->where("students_id = $students_id")->save($data);
            echo 2;
        }
    }
    //课程界面
    public function students_class(){
        $students_id = I("get.students_id");
//        $partner_operator = I("get.pay_operator");
//        echo $partner_operator;die;
        $students_name = M("yixue_students")->field("students_name,students_id,students_course")->where("students_id = $students_id")->find();
        $students_class = M("students_class")->field("class_id")->where("students_id = $students_id")->select();
        foreach($students_class as $v){
            $students_course[] = $v['class_id'];
        }
        $arr = M("yixue_class")->field("class_name,class_id,class_pid,class_money")->select();
            foreach($arr as $vv){
                $is_have = false;
                foreach($students_course as $v){
                    if($v == $vv['class_id']){
                        $st[] = 1;
                        $is_have = true;
                        break;
                    }
                }
                if($is_have == false){
                    $st[] = 2;
                }
            }
            foreach($arr as $k => $v){
                foreach($st as $kk=>$vv){
                    $arr[$kk]['pay_class'] = $vv;
                }
            }
        $this->assign("class",$arr);
        $this->assign("students_id",$students_name);
        $this->assign("students_course",$students_course);
        $this->display();
    }
    //开课消费
    public function class_open(){
        $session = session("yixue_user");
        $id = $session['user_id'];#当前用户ID
        $class['class_id'] = I("post.class_id");#当前课程ID
        $class_name = I("post.class_name");#当前课程名称
        $students_name = I("post.students_name");#当前学生姓名
        $class['students_id'] = I("post.students_id");#当前学生ID
        $class_money = I("post.class_money");#课程价格
        $pay_operator = I("post.pay_operator");
        $partner_money = M("yixue_partner")->field("partner_balance,partner_rebate")->where("user_id = $id")->find();#用户余额
        $save_yue['partner_balance'] = $partner_money["partner_balance"] - $class_money;//修改后的余额
        $save_fan['partner_rebate'] = $partner_money["partner_rebate"] - $class_money;//修改后的返点余额
        $user_pay = M("yixue_partner")->field("partner_code,user_id,partner_account,user_account,partner_rebate,partner_balance")->where("user_id = '$id'")->find();
        if($partner_money["partner_balance"] - $class_money>=0){#余额-课程价格
            $data = array(
                "pay_id" => $id,
                "pay_campus"=>$user_pay['partner_account'],
                "pay_time"=>time(),
                "pay_user"=>$user_pay['partner_code'],
                "pay_money"=>$class_money,
                "pay_rebates"=>0,
                "pay_operator"=>$pay_operator,
                "pay_fanyue"=>$partner_money['partner_rebate'],
                "pay_balance"=>$save_yue['partner_balance'],
                "pay_type"=>1,
                "pay_spend"=>2,
                "pay_describe"=>"使用余额给".$students_name."开通".$class_name."课程，消费".$class_money."元"
            );
            M("yixue_partner")->where("user_id = $id")->save($save_yue);
            $arr = M("students_class")->add($class);
            $arr = M("yixue_pay")->add($data);
            if($arr){
                echo 1;
            }else{
                echo 0;
            }
        }else if($partner_money["partner_rebate"] - $class_money>=0){
            $data = array(
                "pay_id" => $id,
                "pay_campus"=>$user_pay['partner_account'],
                "pay_time"=>time(),
                "pay_user"=>$user_pay['partner_code'],
                "pay_money"=>$class_money,
                "pay_rebates"=>0,
                "pay_operator"=>$pay_operator,
                "pay_fanyue"=>$save_fan['partner_rebate'],
                "pay_balance"=>$partner_money['partner_balance'],
                "pay_type"=>1,
                "pay_spend"=>2,
                "pay_describe"=>"使用返点余额给".$students_name."开通".$class_name."课程，消费".$class_money."元"
            );
            M("yixue_partner")->where("user_id = $id")->save($save_fan);
            $arr = M("students_class")->add($class);
            $arr = M("yixue_pay")->add($data);
            if($arr){
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 2;//钱不够了，快去充值吧！
        }
    }
    public function class_close(){
        $class_id = I("post.class_id");
        $students_id = I("post.students_id");
        $arr = M("students_class")->where("class_id = $class_id and students_id = $students_id")->delete();
        if($arr){
            echo 1;
        }else{
            echo 0;
        }
    }
}