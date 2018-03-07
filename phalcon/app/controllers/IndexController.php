<?php

use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
class IndexController extends Controller
{
	public function indexAction()
    {
//        echo 1;die;
    }
    public function addAction(){
        $user = new Users();
//        print_r($user);die;
        $user_id = $this->session->get("user_id");

        $arr = $this->request->getPost();
       
        if($this->request->isPost()){
           $arr['img'] = $this -> upload();
           $user->id = $user_id;
           $arr['time'] = date("Y-m-d H:i:s",time());
           // print_r(strlen($arr['tel']));die;
           $user -> iupdate($arr);
           $this->response->redirect("Index/list");
        }
    }
    public function listAction(){
        $currentPage = $_GET["page"]?$_GET['page']:1;
//         if($this->request->isPost()){
//             echo 1;die;
//         }else{
            $search = $this->request->get("search");
            $user = new Users();
            $arr = $user->lists($search,$currentPage);
            $paginator = new PaginatorModel(
                array(
                    'data'=>$arr,
                    'limit' =>5,
                    'page' =>$currentPage
                )
            );
            $page = $paginator->getPaginate();
//            print_r($page->items);die;
            $this->assets->addJs('js/jquery-3.2.1.min.js');
            $this->view->setVar('page',$page);
            $this->view->setVar('search',$search);
//            $this->view->setVar('page', $arr);
            // $this->view
//         }
    }

    public function delAction(){
        $user = new Users();
        $id = $this->request->get('id');
        $user->deleteSecord($id);
        $this->response->redirect("Index/list");
    }
    public function updateAction(){
        $User = new Users();
        if($this->request->isPost()){
//            echo 1;die;
            $img = $this -> upload();
            $brr = $this->request->getPost();
            $arr= $User->updates($brr['id']);
            $arr->name = $brr['name'];
            $arr->tel = $brr['tel'];
            $arr->time = date("Y-m-d H:i:s",time());
            $arr->img = $img;
            $arr->name = $brr['name'];
            $arr->address = $brr['address'];
            $arr->sex = $brr['sex'];
            $arr->birthday = $brr['birthday'];
            $arr ->save();
////            print_r($arr);die;
////            $arr['id'] = $arr['id'];
//
//            $arr['time'] = date("Y-m-d H:i:s",time());
////            print_r($arr);die;
//            $User -> iupdate($arr);
            $this->response->redirect("Index/list");
        }else{
            $id = $this->request->get("id");
            $arr = $User->updates($id);
            $this->assets->addJs('js/jquery-3.2.1.min.js');
            $this->view->setVar('arr', $arr);
//            print_r($arr->toArray());die;
            $this->view->setVar('arr',$arr);
        }
    }

    public function upload(){
        // 检查是否有文件上传
//        $arr = $this->request->hasFiles();
//        print_r($arr);die;
        if ($this->request->hasFiles() == true) {
//             print_r($this->request->getUploadedFiles());die;
            // 打印文件信息
            foreach ($this->request->getUploadedFiles() as $file) {
//                print_r($file->getError());die;
                if($file->getError() == 0){
                    // 移动到指定目录
                    $file->moveTo("files/".$file->getName());
                    return "files/".$file->getName();
                }else{
                    $img = $this->request->get("img");
                    return $img;
                }
            }
        }
    }
    //$User -> iupdate($arr);
//$User->tel = $arr['tel'];
//$User->time = $arr['time'];
//$User->img = $arr['img'];
//$User->name = $arr['name'];
//$User->address = $arr['address'];
//$User->sex = $arr['sex'];
//$User->birthday = $arr['birthday'];

}
