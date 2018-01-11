<?php
namespace Home\Controller;
use Think\Controller;
class WordController extends Controller {
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
//        $where['type_id'] = 3;
//        $where['students_id'] = $id;
//        $where['class_id'] = $class_id;
//        $save['type_id'] = 2;
//        $save['can_num'] = 0;
//        $save['nocan_num'] = 0;
//        $save['can_time'] = 0;
//        $save['study_num'] = 0;
//        M("word_logic")->where($where)->save($save);
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
//        $data = M("class_record")->field('study_num,study_status')->where($where)->find();
//        $save['study_num'] = $data['study_num'] + 1;
//        $save['study_status'] = 1;
//        M("class_record")->where($where)->save($save);
    }
    /*
     * 获取单词：50个一组
     * 需要参数：课程ID,token,page*/
    public function word()
    {
//        $token = I('post.token');
//        $id = token_id($token);
//        token_no($id, $token);
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
//        print_r($record);die;
        //获取识记状态（判断在学校还是家）？？？？？
        /****
         *
         */
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
//        print_r($nocan_num);die;
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
//            print_r($nocan_num);die;
            if ($dai_num == 0) {//待识记为0
                if ($nocan_num >= 50) {
                    //不会的词
                    $page = I("post.page", "1");
                    $num = 50;
                    $count = M("word_logic")->where("type_id = 6 and class_id = $class_id and students_id = $id")->count();
                    $pagenum = ceil($count / $num);
                    if ($page == $pagenum || $page == 0) {
                        $stu = false;
//                        $result = array("status" => "-5", "message" => "没有页码了");
//                        echo json_encode($result, JSON_UNESCAPED_UNICODE);
//                        exit;
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
//                    echo $pagenum;die;
                    if ($nocan_num > $dai_num) {//如果不会的大于未识记的 那么不会的页码一定比未识记的多
                        if ($page <= $nocan_pagenum || $page == 0) {//整页的不会的
                            $offset = ($page - 1) * $num;//偏移量 0，25，50
                            if ($page < $pagenum || $page == 0) {//整页的未识记的单词
//                                echo 2;die;
                                $nocan_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 6 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 2 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
                                //返回数据,  ishavepage=true
                                $stu = true;
                                $words = array_merge($nocan_word, $dai_word);
                                $result = array("status" => "200", "message" => "获取单词成功","is_have_page"=>$stu, "data" => $words);
                                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                            } else if ($page == $pagenum) {//最后一页个数<=25
                                $dai_word = M("word_logic")->field("word,mean,type_id")->where("type_id = 2 and class_id = $class_id and students_id = $id")->limit($offset, 25)->select();
//                                print_r($dai_word);die;
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
//                        echo 5;die;
                        $nocan_pagenum = ceil($nocan_num / $num);//不会的单词页码3页
                        $pagenum = ceil($dai_num / $num);//待识记的页码3页
//                        echo $pagenum;die;
                        if ($page <= $pagenum || $page == 0) {//整页的未识记
                            $offset = ($page - 1) * $num;//每页50个
//                            echo $offset;die;
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
//                                print_r($lastnum);die;
//                                echo $dai_num - $offset;
//                                echo "||||";
//                                echo 50 - $lastnum;die;
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
//                                    print_r($nocan_num);die;
//                                    echo 2;die;
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
//                    print_r($dai_num);die;
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
//        echo $sql;die;
        $result = array("status" => "200", "message" => "添加一眼会单词成功");
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 选词入库：对错
     * 需要参数：token,class_id,right_word,error_right
     * 返回数据：对错分别入库成功
     * */
    public function will_word(){
//        $token = I('post.token');
//        $id = token_id($token);
//        token_no($id,$token);
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
//        print_r($right_words);die;
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
//        $id = 5;
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
//            if(time() - $time['time'] > 24*3600){
//                echo "没复习";
//            }else{
//                echo "复习了";
//            }
//            echo date('t');//本月天数
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
//        $id = 5;
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
//        $token = I('post.token');
//        $id = token_id($token);
//        token_no($id,$token);
        $id = 5;
        $class_id = I('post.class_id');
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
//        $where["type_id"] = I("post.type_id");
//        $where['can_num'] = I("post.can_num");
//        $brr = M("word_logic")->field("count(*) as count,type_id as can_num")->where("type_id = 6")->select();
        $arr = M("word_logic")->field("count(*) as count,can_num")->group("can_num")->where($where)->select();
//        $arr = array_merge($brr,$arr);
        $result = array("status" => "200", "message" => "获取每个模块单词的数量！","data"=>$arr);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    /*
     * 获取某一个模块所有单词、不会的次数
     * 需要参数：token,class_id,type_id
     * */
    public function each_word(){
//        $token = I('post.token');
//        $id = token_id($token);
//        token_no($id,$token);
        $id = 5;
        $class_id = I('post.class_id');
        $type_id = I('post.type_id');
        $can_num = I("post.can_num");
        $where["class_id"] = $class_id;
        $where["students_id"] = $id;
//        $where["type_id"] = $type_id;
        $where['can_num'] = $can_num;
        $page = I("post.page", "1");
        $num = 50;
        $count = M("word_logic")->where($where)->count();
//        print_r($count);die;
        $pagenum = ceil($count / $num);
//                print_r($count);die;
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
//        $difficulty_words = explode(",",$difficulty_word);
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
//        $token = I('post.token');
//        $id = token_id($token);
//        token_no($id,$token);
        $id = 5;
        $print_word = I('post.word');
//        echo $print_word;die;
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
}