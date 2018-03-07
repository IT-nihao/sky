<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
    	$this->view->disable();
    	echo "hello word!";
    }
    public function hiAction(){
    	echo __FILE__,"<br/>",__METHOD__,'<br/>',__LINE__,'<br/>';
    }

}

