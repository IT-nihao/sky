<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller {
    /*
     * 测试单词接口
     * 需要数据：token
     * 返回数据：status,message,data=array('time','end_time','weight',array('num','level','name','mean'))
     * */
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

}