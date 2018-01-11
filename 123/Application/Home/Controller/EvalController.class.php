<?php
namespace Home\Controller;
use Think\Controller;
class EvalController extends Controller {
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
//        $record_fenshu = ceil($record_fenshu);
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
//        print_r($where);die;
        $a = M("yixue_eval")->field('eval_one,eval_two,eval_three')->where("eval_end_num = '$where'")->find();
//        print_r($a);die;
        $res = array_merge($brr,$a,$garde);
//        print_r($res);die;
        unset($res['students_garde']);
        if($a){
            $results = array('status' => '200', 'message' => '成功','data'=>$res);
            echo json_encode($results,JSON_UNESCAPED_UNICODE);
        }
    }
}