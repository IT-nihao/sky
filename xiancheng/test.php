<?php
	require_once(__DIR__.'/Threads.php');
	$ThreadList = Array();
	for($i=1;$i<=100;$i++)
	{
		$ThreadList[] = new Threads($i);	
	}
	//创建一个线程池
	$pool = new \Pool(10);
	foreach ($ThreadList as $v)
	{
		$pool->submit($v);
	}
	$pool->shutdown();

	