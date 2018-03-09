<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2017/11/1
 * Time: 10:25
 */
/*
 * 加密token
 */
function token_id($token){
    $token = base64_decode($token);
    $id = explode("-",$token);
    return $id[0];
}
/*
 * 判断token是否失效
 */
function token_no($id,$token_two){
    $id = S($id);
//    print_r($id);die;
    if($token_two != $id){

        $results = array("status"=>"-3","message"=>"token失效，请重新登陆");
        exit(json_encode($results,JSON_UNESCAPED_UNICODE));
    }else if(empty($id)){
        $results = array("status"=>"-3","message"=>"token失效，请重新登陆");
        exit(json_encode($results,JSON_UNESCAPED_UNICODE));
    }else{
        return true;
    }
}