<?php
//function SendMail($address, $user, $title, $message){
////    new PHPMailer()
    require './ThinkPHP/Library/Vendor/PHPMailer/class.phpmailer.php';
//    $mail = new PHPMailer();
//    //设置使用SMTP服务器发送邮件
//    $mail->IsSMTP();
//    //设置邮件的字符编码,若不指定,默认为UTF-8
//    $mail->CharSet = 'UTF-8';
//    //设置是否需要登录验证
//    $mail->SMTPAuth = true;
//    //设置SMTP服务器
//    $mail->Host = C('MAIL_SMTP');
//    //设置发送邮件者需要登录的用户名和密码
//    $mail->Username = C('MAIL_USER');
//    $mail->Password = C('MAIL_PASS');
//    //设置发件人的地址
//    $mail->From = C('MAIL_FROM_ADDRESS');
//    //设置邮件发件人
//    $mail->FromName = C('MAIL_FROM_USER');
//    //添加收件人地址
//    $mail->AddAddress($address, $user);
//    //设置邮件正文
//    $mail->Body = $message;
//    //设置邮件标题
//    $mail->Subject = $title;
//    $mail -> isHTML();
//    //发送邮件
//    return $mail->Send();
//}
//
function send($title,$content,$user,$address){
    $mail= new PHPMailer();
    /*服务器相关信息*/
    $mail->IsSMTP();//设置使用SMTP服务器发送
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->SMTPAuth  = true;               //开启SMTP认证
    $mail->Host     = 'smtp.163.com';   	    //设置 SMTP 服务器,自己注册邮箱服务器地址
    $mail->Username   = '13611369402';  //发信人的邮箱名称
    $mail->Password   = 'yt258963';    //发信人的邮箱密码
    /*内容信息*/
    $mail->IsHTML(true); 			  //指定邮件格式为：html 不加true默认为以text的方式进行解析
    $mail->CharSet    ="UTF-8";			     //编码
    $mail->From       = '13611369402@163.com';	 		 //发件人完整的邮箱名称
    $mail->FromName   = $user;			 //发信人署名
    $mail->Subject    = $title;  			 //信的标题
    $mail->MsgHTML($content);  				 //发信主体内容
    //$mail->AddAttachment("15.jpg");	     //附件
    /*发送邮件*/
    $mail->AddAddress($address);  			 //收件人地址
    //使用send函数进行发送
    $mail->Send();
//        return true;
//    } else {
//        self::$error=$mail->ErrorInfo;
//        return   false;
//    }
}
//function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
//
//    $config = C('THINK_EMAIL');
//
//    vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
//    vendor('SMTP');
//    $mail = new PHPMailer(); //PHPMailer对象
//
//    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
//
//    $mail->IsSMTP(); // 设定使用SMTP服务
//
//    $mail->SMTPDebug = 0; // 关闭SMTP调试功能
//
//// 1 = errors and messages
//
//// 2 = messages only
//
//    $mail->SMTPAuth = true; // 启用 SMTP 验证功能
//
//    $mail->SMTPSecure = 'ssl'; // 使用安全协议
//
//    $mail->Host = $config['SMTP_HOST']; // SMTP 服务器
//
//    $mail->Port = $config['SMTP_PORT']; // SMTP服务器的端口号
//
//    $mail->Username = $config['SMTP_USER']; // SMTP服务器用户名
//
//    $mail->Password = $config['SMTP_PASS']; // SMTP服务器密码
//
//    $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
//
//    $replyEmail = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
//
//    $replyName = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
//
//    $mail->AddReplyTo($replyEmail, $replyName);
//
//    $mail->Subject = $subject;
//
//    $mail->AltBody = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";
//
//    $mail->MsgHTML($body);
//
//    $mail->AddAddress($to, $name);
//
//    if(is_array($attachment)){ // 添加附件
//
//        foreach ($attachment as $file){
//
//            is_file($file) && $mail->AddAttachment($file);
//
//        }
//
//    }
//
//    return $mail->Send() ? true : $mail->ErrorInfo;
//
//}
//递归
function getNode($data,$pid=0,$level=0){
    static $tmp=array();
    foreach($data as $key=>$val){
        if($val['power_pid']==$pid){
            $val['level']=$level;
            $tmp[]=$val;
            getNode($data,$val['power_id'],$level+1);
        }
    }
    return $tmp;
}
function getStudentsClass($data,$pid=0){
    $tmp=array();
    foreach($data as $key=>$val){
        if($val['class_pid']==$pid){
            $child=getStudentsClass($data,$val['class_id']);
            if($child){
                $val['child']=$child;
            }
            $tmp[]=$val;
        }
    }
    return $tmp;
}
//父子
function getChild($data,$pid=0){
    $tmp=array();
    foreach($data as $key=>$val){
        if($val['power_pid']==$pid){
            $child=getChild($data,$val['power_id']);
            if($child){
                $val['child']=$child;
            }
            $tmp[]=$val;
        }
    }
    return $tmp;
}
//table表名   search_name 搜索的表字段名称   search 搜索内容，field 搜索字段 order 排序
function page($table,$search_name,$search,$field,$order){
    $User = M($table); // 实例化User对象
    $where[$search_name] = array('like', "$search%");
    $count      = $User->where($where)->count();// 查询满足要求的总记录数
    $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    $arr = $User->field($field)->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
    $a = array("arr"=>$arr,"count"=>$count,"page"=>$show);
    return $a;
}
//管理员特权
function admin($table,$search_name,$search_tel,$students_accredit,$field,$order){
    $where['students_accredit'] = array('like', "$students_accredit%");
    $User = M($table); // 实例化User对象
    $where["students_name"] = array('like', "$search_name%");
    $where["students_tel"] = array('like', "$search_tel%");
//    $where["students_home"] = array('like', "$search_home%");
    $count      = $User->where($where)->count();// 查询满足要求的总记录数
    $Page       = new \Think\Page($count,1);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    $arr = $User->field($field)->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
    $a = array("arr"=>$arr,"count"=>$count,"page"=>$show);
    return $a;
}
//学生分类
function students($table,$search_name,$search_tel,$codes,$code,$field,$order){
    if($code != ""){
        $where['students_accredit'] = $code;
    }else{
        $where['students_accredit'] = array("in","$codes");
    }
    $User = M($table); // 实例化User对象
    $where["students_name"] = array('like', "$search_name%");
    $where["students_tel"] = array('like', "$search_tel%");
//    $where["students_home"] = array('like', "$search_home%");
    $count      = $User->where($where)->count();// 查询满足要求的总记录数
    $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    $arr = $User->field($field)->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
    $a = array("arr"=>$arr,"count"=>$count,"page"=>$show);
    return $a;
}
function partner($table,$search_user,$search_home,$search_code,$partner_tel,$field,$order,$id){
    $User = M($table); // 实例化User对象
    $where['partner_tel'] = array("like","$partner_tel%");
    $where['partner_code'] = array("like","$search_code%");
    $where["partner_account"] = array('like', "$search_user%");
    $where["partner_home"] = array('like', "$search_home%");
    $where["user_id"] = array("in",$id);
//    $where["user_id"] = array("in",$user_id);
    $count      = $User->where($where)->count();// 查询满足要求的总记录数
    $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    $arr = $User->field($field)->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
    $a = array("arr"=>$arr,"count"=>$count,"page"=>$show);
    return $a;
}
function store($table,$search_user,$search_home,$search_code,$store_tel,$field,$order){
    $User = M($table); // 实例化User对象
    $where['store_tel'] = array("like","$store_tel%");
    $where['code'] = array("like","$search_code%");
    $where["store_user"] = array('like', "$search_user%");
    $where["store_home"] = array('like', "$search_home%");
//    $where["user_id"] = array("in",$user_id);
    $count      = $User->where($where)->count();// 查询满足要求的总记录数
    $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    $arr = $User->field($field)->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
    $a = array("arr"=>$arr,"count"=>$count,"page"=>$show);
    return $a;
}

