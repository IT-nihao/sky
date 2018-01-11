<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;


class Users extends Model
{
    //指定好所有的列（表字段名称）
    public $id;
    public $name;
    public $email;
    public $tel;
    public $time;
    public $sex;
    public $birthday;
    public $address;

    public function initialize()
    {
        // setSource()方法指定数据库表
        $this->setSource('users');
    }
    /**
     * [findfirstAction 完善信息]
     * @param  [type] $name [昵称]
     * @param  [type] $pwd  [密码]
     * @return [type]       [description]
     */
    public function findfirstAction($name, $pwd)
    {
        $Users = Users::findFirst("name = '$name' and pwd = '$pwd'");
        $this->session->set("user_id", $Users->id);
        if ($Users) {
            if(empty($Users->address)||empty($Users->time)||empty($Users->sex)||empty($Users->tel)||empty($Users->img)){
                $this->response->redirect("Index/add");
            }else{
                $this->response->redirect("Index/list");
            }
        } else {
            $this->response->redirect("Signup/fourzerofour");
        }
        
    }
    /**
     * [lists 查询数据]
     * @return [type] [description]
     */
    public function lists($search,$currentPage){
        if($search){
            $robots = $this->modelsManager->createBuilder()
                ->from("users")->where("users.name = '$search'")->getQuery()->execute();
        }else{
            $robots = $this->modelsManager->createBuilder()
                ->from("users")->getQuery()->execute();
    }


        return $robots;
    }
    /**
     * [update 修改数据]
     * @param  [int] $id [用户ID]
     * @return [type]     [description]
     */
     public function updates($id){
         $Users = Users::findFirst($id);
         return $Users;
     }
    /**
     * [deleteSecord 删除数据]
     * @param  [int] $id [用户ID]
     * @return [type]    [description]
     */
    public function deleteSecord($id){
        $userTest = $this->findFirst($id);
//        print_r($userTest);die;
        return $userTest->delete();
    }

    public function beforeCreate()
    {
        $this->time = date('Y-m-d:h-i-s');
        // $this->pwd = md5($pwd);
    }
    /**
     * [iupdate 更新]
     * @param  array|null $data      [更新数据]
     * @param  [type]     $whiteList [description]
     * @return [type]                [description]
     */
    public function iupdate(array $data=null, $whiteList=null){
        if(count($data) > 0){
            $attributes = $this -> getModelsMetaData() -> getAttributes($this);
            $this -> skipAttributesOnUpdate(array_diff($attributes, array_keys($data)));
        }
        return parent::update($data, $whiteList);
    }
}