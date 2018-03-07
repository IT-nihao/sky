<?php

use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
class DemoController extends Controller
{
    public function indexAction(){
        $var = new Viewbook();
        $brr = $var->lists()->toArray();
//        $brr = array();
//        foreach ($arr as $key=>$value) {
////            print_r($value);die;
//            $brr[$value['time']][] = $value;
//        }
        $arr=array('','','','','');
        foreach ($brr as $k=>$v)
        {
            $key=$v['time'];
            $arr[$key-1]=$v;
        }
        print_r($arr);
    }

//        $arr=array('','','','','');
//        foreach ($viewbook2 as $k=>$v)
//        {
//            $key=$v->time;
//            $arr[$key-1]=$v->toarray();
//        }

}