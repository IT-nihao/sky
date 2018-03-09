<?php
class MyThread extends \Thread
{
	//创建线程
	var $num;
	public function __construct()
	{
		$this->num=$num;
	}
	public function run()
	{
		if($data = file_get_contents('https://www.baidu.com/'))
		{
			echo '抓取完毕，线程：'.$this->num."\n";
		}
		
	}
}