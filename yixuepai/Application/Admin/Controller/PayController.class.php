<?php
namespace Admin\Controller;
use Think\Controller;
class PayController extends CommonController {
    //学生列表
    public function pay_campus(){
        $this->display("pay_login");
    }
    public function pay_partner(){
        $this->display("pay_login");
    }
    public function pay_login(){
        $login['user_account'] = I("post.user_account");
        $login['finance_pwd'] = I("post.finance_pwd","","md5");
        $arr = M("yixue_partner")->field("user_id")->where($login)->find();
        if($arr){
                $this->success("登陆成功",U('pay_campus_list'));
        }else{
            $this->error("账号密码错误");
        }
    }
    public function pay_campus_list(){
        $session = session('yixue_user');
        $id = $session["user_id"];
        if($id == 1){
            $where['yixue_role_id'] = array("in","1,2");
            $dakehu = M("yixue_user_role")->field("yixue_user_id")->where($where)->select();
            foreach($dakehu as $v){
                $ap[] = $v['yixue_user_id'];
            }
            $dakehu_ids = implode(",",$ap);
            $wh['user_id'] = array("in",$dakehu_ids);
            $dakehu=M('yixue_partner')->field("user_id,partner_account,partner_code")->where($wh)->select();
        }else{
            $dakehu = M("yixue_partner")->field("user_id,partner_account,partner_code")->where("user_pid = $id")->select();
        }
        foreach($dakehu as $v){
            $ap[] = $v['user_id'];
        }
        $dakehu_ids = implode(",",$ap);
        $search_account = I("get.partner_account");
        $search_home = I("get.partner_home");
        $search_code = I("get.partner_code");
        $partner_tel = I("get.partner_tel");
        $data = partner("yixue_partner","$search_account",$search_home,$search_code,$partner_tel,"user_id,user_account,user_pwd,finance_pwd,partner_account,partner_idcard,partner_sex,partner_rebate,partner_balance,partner_tel,partner_time,partner_government,partner_code,detailed_address","user_id",$dakehu_ids);
        $this->assign("count",$data['count']);
        $this->assign("page",$data['page']);
        $this->assign("arr",$data['arr']);
        $this->assign("code",$dakehu);
        $this->display();
    }
    public function pay_add(){
        if(IS_GET){
            $user_id  = I("get.user_id");
            $user = M("yixue_partner")->field("user_account,user_id")->where("user_id = '$user_id'")->find();
            $this->assign("user",$user);
            $this->display();
        }
        if(IS_POST) {
            $session = session("yixue_user");
            $id = $session['user_id'];#当前用户的ID
            //修改校区金额
            $user_id = I("post.user_id");#充值用户用户ID
            $partner_rebate = I("post.partner_rebate");
            //充值金额
            $partner_money = I("post.partner_money");
            $pay_operator = I("post.pay_operator");
            $pay['partner_money'] = $partner_money;#充值金额
            $pay['partner_rebate'] = $partner_rebate;#充值返点金额
            //根据USER_ID查到校区信息
            $pay = M("yixue_partner")->field("user_id,partner_account,user_account,partner_rebate,partner_balance")->where("user_id = '$id'")->find();
            if($pay['partner_balance'] - $partner_money<0){
                $this->error("余额不足，请联系上一级管理员");
            }else{
                $pay_save['partner_balance'] = $pay['partner_balance'] - $partner_money;#修改当前用户的余额
                $pay_save['partner_rebate'] = $pay['partner_rebate'] - $partner_rebate;#修改当前用户的返点金额
                M("yixue_partner")->where("user_id = '$id'")->save($pay_save);#修改当前用户钱
                $user_pay = M("yixue_partner")->field("partner_code,user_id,partner_account,user_account,partner_rebate,partner_balance")->where("user_id = '$user_id'")->find();

                $save['partner_balance'] = $user_pay['partner_balance'] + $partner_money;#修改下一级的余额 原来的余额+充值的余额
                $save['partner_rebate'] = $user_pay['partner_rebate'] + $partner_rebate;#修改下一级的返点 原来的返点+充值的返点
                M("yixue_partner")->where("user_id = '$user_id'")->save($save);
                $add = array(
                    "pay_id" => $user_id,
                    "pay_campus"=>$user_pay['partner_account'],
                    "pay_time"=>time(),
                    "pay_user"=>$user_pay['partner_code'],
                    "pay_money"=>$partner_money,
                    "pay_rebates"=>$partner_rebate,
                    "pay_operator"=>$pay_operator,
                    "pay_fanyue"=>$save['partner_rebate'],
                    "pay_balance"=>$save['partner_balance'],
                    "pay_type"=>2,
                    "pay_spend"=>1,
                    "pay_describe"=>"使用余额给".$user_pay['partner_account']."充值".$partner_money."元，返点".$partner_rebate."元"
                );
                $arr = M("yixue_pay")->add($add);
                if($arr){
                    $this->success("充值成功",U("pay_campus_list"));
                }else{
                    $this->error("充值失败");
                }
            }
            //添加充值记录
        }
    }
    public function pay_my(){
        $session =session("yixue_user");
        $id = $session['user_id'];
        $pay_type =  I("get.pay_type",'1,2,3');
        if($id == 1){
            $where['pay_type'] = array("in","$pay_type");
            $count      = M('yixue_pay')->where($where)->count();// 查询满足要求的总记录数
            $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
            $show       = $Page->show();// 分页显示输出
//// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $arr = M('yixue_pay')->field("pay_campus,pay_time,pay_user,pay_money,pay_rebates,pay_balance,pay_fanyue,pay_type,pay_spend,pay_describe,pay_operator")
                ->where($where)
                ->order("pay_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();
        }else{
            $dakehu = M("yixue_partner")->field("user_id,partner_account,partner_code")->where("user_pid = $id")->select();
            foreach($dakehu as $v){
                $ap[] = $v['user_id'];
            }
            $dakehu_ids = implode(",",$ap);
            $ids = $dakehu_ids.",".$id;
            $where['pay_id'] = array("in","$ids");
            $where['pay_type'] = array("in","$pay_type");
            $count  = M('yixue_pay')->where($where)->count();// 查询满足要求的总记录数
            $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
            $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $arr = M('yixue_pay')->field("pay_campus,pay_time,pay_user,pay_money,pay_rebates,pay_balance,pay_fanyue,pay_type,pay_spend,pay_describe,pay_operator")
                ->where($where)
                ->order("pay_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();
        }
        $sql = M()->getLastSql();
        $partner_balance = M("yixue_partner")->field("partner_balance,partner_rebate")->where("user_id = '$id'")->find();
        $this->assign("arr",$arr);
        $this->assign("count",$count);
        $this->assign("page",$show);
        $this->assign("partner_balance",$partner_balance);
        $this->display();
    }
}
