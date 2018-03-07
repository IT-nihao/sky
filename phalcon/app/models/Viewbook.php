<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;


class Viewbook extends Model
{
    //指定好所有的列（表字段名称）
    public $id;
    public $time;
    public $course_id;
    public $classroom;
    public $node_number;
    public $user_id;
    public function initialize()
    {
        // setSource()方法指定数据库表
        $this->setSource('viewbook');
    }
    public function lists(){
        $robots = Viewbook::find('node_number = 1');
        return $robots;
    }
}