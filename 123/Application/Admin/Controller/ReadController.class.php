<?php
namespace Admin\Controller;
use Think\Controller;
class ReadController extends CommonController {
    //阅读关卡
    public function read_level(){
        $textbook_id = I('post.textbook_id');
        $arr = M("yixue_level")->field("level_id,level_name")->where("level_textbook_id = $textbook_id")->select();
        echo json_encode($arr);
    }
    //阅读教材
    public function read_textbook(){
        $type_id = I('post.type_id');
        $arr = M("read_textbook")->field("textbook_id,textbook_name")->where("textbook_type_id = $type_id")->select();
        echo json_encode($arr);
    }
    //阅读添加
    public function read_add(){
//        $students_id = I("get.students_id");
        if(IS_GET){
            $students_id = I("get.students_id");
            $this->assign("students_id",$students_id);
            $this->display();
        }
        if(IS_POST){
            $data = I('post.');
            $data['read_text'] = preg_replace('/_+/','###',$data['read_text']);
//            preg_match_all($patterns,$data['read_text'],$arr);
            $have = M("class_read")->field("read_text")->where("read_type_id = '$data[read_type_id]' and read_level_id ='$data[read_level_id]'")->find();
            if($have){
                $this->error("已经有该类型的等级的文章了，请修改文章或者重新选择添加");
            }
            if(!preg_match('/^\d*$/', $data['read_time'])){
                $this->error("建议答题时间只能是数字哦！");
            }
            if(preg_match('/[\x7f-\xff]/', $data['read_title'])){
                $this->error("文章标题不能是中文哦！");
            }
            foreach($data as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }
            foreach($data['topic_text'] as $v){
                if(preg_match('/[\x7f-\xff]/', $v)){
                    $this->error("题答案不能是中文哦！");
                }
            }
            $topic = array_chunk($data['topic_text'],4);
            $topic_timu = $data['topic_timu'];
            foreach($topic_timu as $v) {
                if(preg_match('/[\x7f-\xff]/', $v)){
                    $this->error("题目不能有中文哦！");
                }
            }
            $yes = $data['yes_no'];
            foreach($yes as $v){
                if(preg_match('/[\x7f-\xff]/', $v)){
                    $this->error("正确答案不能是中文哦！");
                }
            }
            $topic_spell = $data['topic_spell'];
            foreach($topic as $kk => $vv){
                foreach($vv as $k => $s){
                    $qq = "";
                    if($s==$yes[$kk]){
                        $qq = 1;
                    }else{
                        $qq = 0;
                    }
                    $res[] = array(
                        'type'=>2,
                        'read_text' => $data['read_text'],
                        'read_title' => $data['read_title'],
                        'read_time' => $data['read_time'],
                        'read_type_id' => $data['read_type_id'],
                        'read_level_id' => $data['read_level_id'],
                        'students_id' => $data['students_id'],
                        'read_textbook_id' => 0,
                        'read_difficulty_id' => $data['read_difficulty_id'],
                        'topic_timu' => $topic_timu[$kk],
                        'topic_text' => $s,
                        'yes_no' => $qq,
                        'topic_spell' => $topic_spell[$kk],
                        'add_time' => time()
                    );
                }
            }
            $arr = M('class_read')->addAll($res);
            if($arr){
                $this->success("添加成功");
            }else{
                $this->error("添加失败");
            }
        }
    }
    public function read_list(){
        $students_id = I("get.students_id");
        $read_title = I("get.read_title");
        $where['read_title'] = array('like', "$read_title%");
        $sql = "SELECT count(DISTINCT read_type_id,read_level_id) as count FROM class_read where read_title like '$read_title%'";
        $num      = M()->query($sql);// 查询满足要求的总记录数
        $count = $num[0]['count'];
        $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $arr = M("class_read")->distinct(true)->field('students_id,read_level_id,read_type_id,read_title,read_text,add_time,read_time,type_name,level_name')->join("read_type on class_read.read_type_id = read_type.type_id")->join("level_type_id on class_read.read_level_id = level_type_id.level_id")->
        where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
//        print_r($arr);die;
        $this->assign("count",$count);
        $this->assign('page',$show);
        $this->assign('arr',$arr);
        $this->assign('students_id',$students_id);
        $this->display();
    }
    public function read_delete(){
        $read_level_id = I('get.read_level_id');
        $read_type_id = I('get.read_type_id');
        $arr = M('class_read')->where("read_level_id = '$read_level_id' and read_type_id = '$read_type_id'")->delete();
        if($arr){
            $this->success("删除成功",U('read_list'));
        }
    }
    public function read_update()
    {
        if (IS_GET) {
            $read_level_id = I('get.read_level_id');
            $read_type_id = I('get.read_type_id');
            $arr = M("class_read")->field('read_level_id,read_type_id,read_title,read_text,read_time,add_time')->where("read_level_id = '$read_level_id' and read_type_id = '$read_type_id'")->find();
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
//            print_r($mmm);die;
            $this->assign('arr', $arr);
            $this->assign('crr', $mmm);
            $this->display();
        }
        if (IS_POST) {
            $read_id = I('post.read_id');
            $data = I('post.');
            $data['read_text'] = preg_replace('/_+/','###',$data['read_text']);
            $topic = $data['topic_text'];
            $have = M("class_read")->field("read_text")->where("read_type_id = '$data[read_type_id]' and read_level_id ='$data[read_level_id]'")->find();
            if($have){
                $this->error("已经有该类型的等级的文章了，请修改文章或者重新选择添加");
            }
            if(!preg_match('/^\d*$/', $data['read_time'])){
                $this->error("建议答题时间只能是数字哦！");
            }
            if(preg_match('/[\x7f-\xff]/', $data['read_title'])){
                $this->error("文章标题不能是中文哦！");
            }
            foreach($data as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }
            foreach($data['topic_text'] as $v){
                if(preg_match('/[\x7f-\xff]/', $v)){
                    $this->error("题答案不能是中文哦！");
                }
            }
            foreach($read_id as $k=>$v){
                $b[] = array($v,$topic[$k]);
            }
            $topic = array_chunk($b,4);
            $topic_timu = $data['topic_timu'];
            $yes = $data['yes_no'];
            foreach($yes as $v){
                if(preg_match('/[\x7f-\xff]/', $v)){
                    $this->error("正确答案不能是中文哦！");
                }
            }
            $topic_spell = $data['topic_spell'];
            foreach ($topic as $kk => $vv) {
                foreach ($vv as $k => $s) {
                    $qq = "";
                    if ($s[1] == $yes[$kk]) {
                        $qq = 1;
                    } else {
                        $qq = 0;
                    }
                    $res[] = array(
                        'read_text' => $data['read_text'],
                        'read_title' => $data['read_title'],
                        'read_time' => $data['read_time'],
                        'read_type_id' => $data['read_type_id'],
                        'read_level_id' => $data['read_level_id'],
//                        'read_textbook_id' => $data['read_textbook_id'],
                        'read_difficulty_id' => $data['read_difficulty_id'],
                        'topic_timu' => $topic_timu[$kk],
                        'topic_text' => $s[1],
                        'read_id' => $s[0],
                        'yes_no' => $qq,
                        'topic_spell' => $topic_spell[$kk],
                        'add_time' => time()
                    );
                }
            }
            foreach ($res as $v) {
                $r = array('read_title'=>$v['read_title'],'read_level_id'=>$v['read_level_id'],'read_difficulty_id'=>$v['read_difficulty_id'],'read_text'=>$v['read_text'],'topic_text'=>$v['topic_text'],'read_time'=>$v['read_time'],'topic_timu'=>$v['topic_timu'],'yes_no'=>$v['yes_no'],'add_time'=>$v['add_time'],'topic_spell'=>$v['topic_spell']);
                $arr = M('class_read')->where("read_id = '$v[read_id]'")->save($r);
            }
            if($arr){
                $this->success("修改成功",U('read_list'));
            }else{
                $this->error("修改失败");
            }
        }
    }
    public function read_look(){
        $read_level_id = I('get.read_level_id');
        $read_type_id = I('get.read_type_id');
        $arr = M("class_read")->field('read_level_id,read_type_id,read_title,read_text,read_time,add_time')->where("read_level_id = '$read_level_id' and read_type_id = '$read_type_id'")->find();
        $topic_timu = M()->query("select distinct topic_timu,topic_spell from class_read where read_level_id = $read_level_id and read_type_id = $read_type_id ORDER BY  topic_timu asc");
//        print_r($topic_timu);die;
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
//            print_r($mmm);die;
        $this->assign('arr', $arr);
        $this->assign('crr', $mmm);
        $this->display();
    }

    public function dedicated_add()
    {
        if (IS_GET) {
            $this->display();
        }
        if (IS_POST) {
            $data = I('post.');
            $patterns = "/\d+/";
            $data['read_text'] = preg_replace('/_+/','###',$data['read_text']);
            $have = M("class_dedicated")->field("read_text")->where("read_type_id = '$data[read_type_id]' and read_level_id ='$data[read_level_id]'")->find();
            if ($have) {
                $this->error("已经有该类型的等级的文章了，请修改文章或者重新选择添加");
            }
            if (!preg_match('/^\d*$/', $data['read_time'])) {
                $this->error("建议答题时间只能是数字哦！");
            }
            if (preg_match('/[\x7f-\xff]/', $data['read_title'])) {
                $this->error("文章标题不能是中文哦！");
            }
            foreach ($data as $v) {
                if (empty($v)) {
                    $this->error("每个选项都要填哦！");
                }
            }
            foreach ($data['topic_text'] as $v) {
                if (preg_match('/[\x7f-\xff]/', $v)) {
                    $this->error("题答案不能是中文哦！");
                }
            }
            $topic = array_chunk($data['topic_text'], 4);
            $topic_timu = $data['topic_timu'];
            foreach ($topic_timu as $v) {
                if (preg_match('/[\x7f-\xff]/', $v)) {
                    $this->error("题目不能有中文哦！");
                }
            }
            $yes = $data['yes_no'];
            foreach ($yes as $v) {
                if (preg_match('/[\x7f-\xff]/', $v)) {
                    $this->error("正确答案不能是中文哦！");
                }
            }
            $topic_spell = $data['topic_spell'];
            foreach ($topic as $kk => $vv) {
                foreach ($vv as $k => $s) {
                    $qq = "";
                    if ($s == $yes[$kk]) {
                        $qq = 1;
                    } else {
                        $qq = 0;
                    }
                    $res[] = array(
                        'type'=>1,
                        'read_text' => $data['read_text'],
                        'read_title' => $data['read_title'],
                        'read_time' => $data['read_time'],
                        'read_type_id' => $data['read_type_id'],
                        'read_level_id' => $data['read_level_id'],
//                        'read_textbook_id' => $data['read_textbook_id'],
                        'read_difficulty_id' => $data['read_difficulty_id'],
                        'topic_timu' => $topic_timu[$kk],
                        'topic_text' => $s,
                        'yes_no' => $qq,
                        'topic_spell' => $topic_spell[$kk],
                        'add_time' => time()
                    );
                }
            }
            $arr = M('class_dedicated')->addAll($res);
            if ($arr) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }
        }
    }
    public function read_dedicated(){
        $read_title = I("get.read_title");
        $where['read_title'] = array('like', "$read_title%");
        $sql = "SELECT count(DISTINCT read_type_id,read_level_id) as count FROM class_dedicated where read_title like '$read_title%'";
        $num      = M()->query($sql);// 查询满足要求的总记录数
        $count = $num[0]['count'];
        $Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $arr = M("class_dedicated")->distinct(true)->field('read_level_id,read_type_id,read_title,read_text,add_time,read_time,type_name,level_name')->join("read_type on class_dedicated.read_type_id = read_type.type_id")->join("yixue_level on class_dedicated.read_level_id = yixue_level.level_id")->
        where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign("count",$count);
        $this->assign('page',$show);
        $this->assign('arr',$arr);
        $this->display();
    }
    public function dedicated_delete(){
        $read_level_id = I('get.read_level_id');
        $read_type_id = I('get.read_type_id');
        $arr = M('class_dedicated')->where("read_level_id = '$read_level_id' and read_type_id = '$read_type_id'")->delete();
        if($arr){
            $this->success("删除成功",U('read_list'));
        }
    }
    public function dedicated_update()
    {
        if (IS_GET) {
            $read_level_id = I('get.read_level_id');
            $read_type_id = I('get.read_type_id');
            $arr = M("class_dedicated")->field('read_level_id,read_type_id,read_title,read_text,read_time,add_time')->where("read_level_id = '$read_level_id' and read_type_id = '$read_type_id'")->find();
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
            $this->display();
        }
        if (IS_POST) {
            $read_id = I('post.read_id');
            $data = I('post.');
            $data['read_text'] = preg_replace('/_+/','###',$data['read_text']);
            $topic = $data['topic_text'];
            $have = M("class_dedicated")->field("read_text")->where("read_type_id = '$data[read_type_id]' and read_level_id ='$data[read_level_id]'")->find();
            if($have){
                $this->error("已经有该类型的等级的文章了，请修改文章或者重新选择添加");
            }
            if(!preg_match('/^\d*$/', $data['read_time'])){
                $this->error("建议答题时间只能是数字哦！");
            }
            if(preg_match('/[\x7f-\xff]/', $data['read_title'])){
                $this->error("文章标题不能是中文哦！");
            }
            foreach($data as $v){
                if(empty($v)){
                    $this->error("每个选项都要填哦！");
                }
            }
            foreach($data['topic_text'] as $v){
                if(preg_match('/[\x7f-\xff]/', $v)){
                    $this->error("题答案不能是中文哦！");
                }
            }
            foreach($read_id as $k=>$v){
                $b[] = array($v,$topic[$k]);
            }
            $topic = array_chunk($b,4);
            $topic_timu = $data['topic_timu'];
            $yes = $data['yes_no'];
            foreach($yes as $v){
                if(preg_match('/[\x7f-\xff]/', $v)){
                    $this->error("正确答案不能是中文哦！");
                }
            }
            $topic_spell = $data['topic_spell'];
            foreach ($topic as $kk => $vv) {
                foreach ($vv as $k => $s) {
                    $qq = "";
                    if ($s[1] == $yes[$kk]) {
                        $qq = 1;
                    } else {
                        $qq = 0;
                    }
                    $res[] = array(
                        'read_text' => $data['read_text'],
                        'read_title' => $data['read_title'],
                        'read_time' => $data['read_time'],
                        'read_type_id' => $data['read_type_id'],
                        'read_level_id' => $data['read_level_id'],
                        'read_textbook_id' => $data['read_textbook_id'],
                        'read_difficulty_id' => $data['read_difficulty_id'],
                        'topic_timu' => $topic_timu[$kk],
                        'topic_text' => $s[1],
                        'read_id' => $s[0],
                        'yes_no' => $qq,
                        'topic_spell' => $topic_spell[$kk],
                        'add_time' => time()
                    );
                }
            }
            foreach ($res as $v) {
                $r = array('read_title'=>$v['read_title'],'read_textbook_id' => $v['read_textbook_id'],'read_level_id'=>$v['read_level_id'],'read_difficulty_id'=>$v['read_difficulty_id'],'read_text'=>$v['read_text'],'topic_text'=>$v['topic_text'],'read_time'=>$v['read_time'],'topic_timu'=>$v['topic_timu'],'yes_no'=>$v['yes_no'],'add_time'=>$v['add_time'],'topic_spell'=>$v['topic_spell']);
                $arr = M('class_dedicated')->where("read_id = '$v[read_id]'")->save($r);
            }
            if($arr){
                $this->success("修改成功",U('read_list'));
            }else{
                $this->error("修改失败");
            }
        }
    }
    public function dedicated_look(){
        $read_level_id = I('get.read_level_id');
        $read_type_id = I('get.read_type_id');
        $arr = M("class_dedicated")->field('read_level_id,read_type_id,read_title,read_text,read_time,add_time')->where("read_level_id = '$read_level_id' and read_type_id = '$read_type_id'")->find();
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
//            print_r($mmm);die;
        $this->assign('arr', $arr);
        $this->assign('crr', $mmm);
        $this->display();
    }
}