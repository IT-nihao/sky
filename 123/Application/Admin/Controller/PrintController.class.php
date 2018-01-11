<?php
namespace Admin\Controller;
use Think\Controller;
class PrintController extends CommonController {
    public function print_list(){
        $session = session("yixue_user");
        $id = $session['user_id'];
        $students_name = I("get.students_name");
        echo $students_name;
        if($id == 1){
            $where['students_name'] = array('like', "$students_name%");
            $count      = M('yixue_print')->where($where)->count();// 查询满足要求的总记录数
            $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
            $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $arr = M('yixue_print')->field("print_id,print_type,print_level,add_time,print_students_id,print_textbook,read_title,students_name")->where($where)
                ->order("add_time asc")->limit($Page->firstRow.','.$Page->listRows)->select();
        }else{
            $me = M("yixue_partner")->field("partner_code")->where("user_id = $id")->find();
            $students_id = M("yixue_students")->field('students_id')->where("students_accredit = '$me[partner_code]'")->select();
            foreach($students_id as $v){
                $ids[] = $v['students_id'];
            }
            $idss = implode(",",$ids);
            $tiaojian['print_students_id'] = array("in",$idss);
            $where['students_name'] = array('like', "$students_name%");
            $count      = M('yixue_print')->where($where)->count();// 查询满足要求的总记录数
            $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
            $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $arr = M('yixue_print')->field("print_id,print_type,print_level,add_time,print_students_id,print_textbook,read_title,students_name")->where($where)
                ->order("add_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();

//            $where = M('yixue_print')->field('print_id,print_type,print_level,add_time,print_students_id,print_textbook,read_title,students_name')->where($tiaojian)->select();
        }
//        print_r($arr);die;
//        print_r($where);die;
//            print_r($where);die;
            $this->assign('arr',$arr);
            $this->assign("page",$show);
            $this->assign("count",$count);
            $this->display();
    }
    public function print_add(){
        $read_level_id = I('get.read_level_id');
        $read_textbook_id = I('get.read_textbook_id');
        $read_type_id = I('get.read_type_id');
        $students_id = I('get.students_id');
        $students_name = M('yixue_students')->field("students_name")->where("students_id = '$students_id'")->find();
        if($read_textbook_id == 0){
            $arr = M("class_read")->field('read_level_id,read_type_id,read_title,read_text,read_time,add_time,read_difficulty_id')->where("read_level_id = '$read_level_id' and read_type_id = '$read_type_id' and read_textbook_id = '0'")->find();
            $topic_timu = M()->query("select distinct topic_timu,topic_spell from class_read where read_level_id = $read_level_id and read_type_id = $read_type_id ORDER BY  topic_timu asc");
            foreach ($topic_timu as $k => $v) {
                $topic_text = M('class_read')->field('topic_text,yes_no,topic_spell,read_id')->where("topic_timu = '$v[topic_timu]' and read_level_id = '$read_level_id' and read_type_id = '$read_type_id'")->select();
                $topic_timu = $v['topic_timu'];
                foreach ($topic_text as $kk => $vv) {
                    $one = $vv['topic_text'];
                    $two = $vv['yes_no'];
                    $three = $vv['topic_spell'];
                    $four = $vv['read_id'];
                    $bbb[$kk] = array(
                        "topic_text" => $one,
                        "yes_no" => $two,
                        "topic_spell" => $three,
                        "read_id" => $four,
                    );
                }
                $mmm[] = array(
                    "topic_timu" => $topic_timu,
                    "daan" => $bbb,
                );
            }
//            print_r($arr);die;
            $this->assign('arr', $arr);
            $this->assign('crr', $mmm);
            $this->assign('students_name', $students_name);
            if($read_type_id == 2){
                $this->display();
            }else{
                $this->display("print_read");
            }
        }else{
            $arr = M("class_dedicated")->field('read_level_id,read_type_id,read_title,read_text,read_time,add_time,read_difficulty_id')->where("read_level_id = '$read_level_id' and read_type_id = '$read_type_id' and read_textbook_id = '$read_textbook_id'")->find();
            $topic_timu = M()->query("select distinct topic_timu,topic_spell from class_dedicated where read_level_id = $read_level_id and read_type_id = $read_type_id ORDER BY  topic_timu asc");
            foreach ($topic_timu as $k => $v) {
                $topic_text = M('class_dedicated')->field('topic_text,yes_no,topic_spell,read_id')->where("topic_timu = '$v[topic_timu]' and read_level_id = '$read_level_id' and read_type_id = '$read_type_id'")->select();
                $topic_timu = $v['topic_timu'];
                foreach ($topic_text as $kk => $vv) {
                    $one = $vv['topic_text'];
                    $two = $vv['yes_no'];
                    $three = $vv['topic_spell'];
                    $four = $vv['read_id'];
                    $bbb[$kk] = array(
                        "topic_text" => $one,
                        "yes_no" => $two,
                        "topic_spell" => $three,
                        "read_id" => $four,
                    );
                }
                $mmm[] = array(
                    "topic_timu" => $topic_timu,
                    "daan" => $bbb,
                );
            }
            $this->assign('arr', $arr);
            $this->assign('crr', $mmm);
            $this->assign('students_name', $students_name);
            if($read_type_id == 2){
                $this->display();
            }else{
                $this->display("print_read");
            }
        }



//        $htm2 = $arr['read_title']."\n".$arr['read_text']."\n".$dayin;
//        header("Content-type: application/octet-stream");
//        header("Accept-Ranges: bytes");
//        header("Accept-Length: ".strlen($htm2));
//        header("Content-Disposition: attachment; filename=".$students_name['students_name'].".doc");
//        header("Pragma:no-cache");
//        header("Expires:0");
//        echo $htm2;
    }
    public function print_word_list(){
       $arr = M("print_word_list")->field('students_name,students_id,time')->order("time desc")->select();
       $this->assign("arr",$arr);
       $this->display();
    }
    public function print_word(){
        $where['students_id'] = I('get.id');
        $where['time'] = I('get.time');
//        print_r($where);die;
        $word = M("print_word")->field("mean,word")->where($where)->select();
        $word = array_chunk($word,5);
        $this->assign("word",$word);
        $this->display();
    }
}