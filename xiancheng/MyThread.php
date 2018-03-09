<?php
class MyThread extends \Thread
{
	//创建线程
	public function __construct($num)
	{
		set_time_limit(0);
		$this->num=$num;
	}

	public function getcurl($num)
	{
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, 'http://www.zujuan.com/question/list?knowledges=&question_channel_type=&difficult_index=&exam_type=&kid_num=&grade_id%5B%5D=0&grade_id%5B%5D=10&grade_id%5B%5D=11&grade_id%5B%5D=12&grade_id%5B%5D=13&sortField=time&page='.$num.'&_=1517213282114' );
			$header = array ();
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
			curl_setopt ( $ch, CURLOPT_COOKIE, '_ga=GA1.2.1868883631.1516782550; PHPSESSID=en2rikf62fpd4ogchbcmdot8f2; _csrf=8e4f14a2d0208d1a68956ac95df9b96ac5368de9822e4b6e2e97eefe3151404fa%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22kIjN25vmIWdY4ewhUZ0KVUX3BYOi2Qd1%22%3B%7D; _gid=GA1.2.2138505869.1517189203; Hm_lvt_6de0a5b2c05e49d1c850edca0c13051f=1516842132,1516928878,1517016357,1517189203; xd=e409e1df3e15356a9137ce7680720f7dcbdcd6c6ebeb77ff59f645d6ffb02d15a%3A2%3A%7Bi%3A0%3Bs%3A2%3A%22xd%22%3Bi%3A1%3Bs%3A1%3A%223%22%3B%7D; chid=753411127a26c0bf4f88c5bb0c64e771512616316bae9de43cb9a9038d6b13ffa%3A2%3A%7Bi%3A0%3Bs%3A4%3A%22chid%22%3Bi%3A1%3Bs%3A1%3A%223%22%3B%7D; Hm_lpvt_6de0a5b2c05e49d1c850edca0c13051f=1517213282' );
			$content = curl_exec ( $ch );
			return $content;
	}
	public function run()
	{
		$mysqli = new \mysqli("192.168.52.130", "root", "123456","english"); 
		
		$ids=array();
			$ch = curl_init ();
			echo "开始抓取第".$this->num."页\n";
			$a = $this->num;
			$content = $this->getcurl($a);
			
			$arr = json_decode ( $content, true );
			foreach ( $arr ['ids'] as $v ) {
				if(!in_array($v,$ids)) $ids[]=$v;
			}
			$index = 0;
			foreach ( $ids as $val )
			{
				$ch = curl_init();
				curl_setopt ( $ch, CURLOPT_URL, 'http://www.zujuan.com/question/detail-'.$val.'.shtml' );
				$header = array ();
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
				try
				{
					$data = curl_exec ( $ch );
					curl_close($ch);
				}
				catch(Exception $e)
				{
					echo "第".$val."页面出现异常！";exit;
				}
				if($data) 
				{
					preg_match_all ( "/\[{.*?\}] /is", $data, $matches );
					$info[]  = json_decode ( $matches [0] [0],true );
					if(!$data) echo "ids为".$val."数据抓取错误\n";
				}else
				{

						$ch = curl_init();
						curl_setopt ( $ch, CURLOPT_URL, 'http://www.zujuan.com/question/detail-'.$val.'.shtml ' );
						$header = array ();
						curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
						curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
						$dataErr = curl_exec ( $ch );
						curl_close($ch);
						if($dataErr)
						{
							preg_match_all ( "/\[{.*?\}] /is", $dataErr, $matches );
							$info [] = json_decode ( $matches [0] [0] );
						}else
						{
							$nu[] = $val;
							echo '本条数据抓取错误,id为'.$val.'\n';
						}
				}
				
			}
			echo "开始处理第".$this->num."页的数据\n";

		// 处理语言表达类型
		$lists=array();
		$op = array();
		$question_text=array();
		$options=array();
		$mm=0;
		foreach ( $info as $v ) 
		{
			foreach ( $v as $val )
			{
				$json = json_encode ( $val['questions'], true );
				$rel = json_decode ( $json, true );
				foreach ( $rel as $key=>$value )
				{
					if(isset($value['list']))
					{
						foreach ($value['list'] as $kk=>$list)
						{
							if($list['options'])
							{
								if(is_array($list['options']))
								{
									foreach ($list['options'] as $k=>$option)
									{
										$op[]=$k.'、'.$option.'<br>';
									}
									$lists[]='('.$kk.')'.'、'.$list['question_text'].'<br>'.implode(',',$op);
								}
							}else
							{
								$lists[]='('.$kk.')'.'、'.$list['question_text'].'<br>';
							}
						}
						$listInfo=implode(',',$lists);
						$question_text=$value['question_text'].'<br>'.$listInfo;
						$value['question_text']=$question_text;
					}
					$resoult=$value;
					if(isset($value['options']))
					{
						$options = json_encode($value['options'],true);
						$aa = str_replace("'",'"',$options);
						$resoult['options'] = $aa;
					}else
					{
						$resoult['options'] ='';
					}
					$title = $resoult['title'];
					$newtitle = str_replace("'","/",$title);
					$resoult['title'] = $newtitle;
					$question_text = $resoult['title'];
					$newquestion_text = str_replace("'","/",$question_text);
					$resoult['question_text'] = $newquestion_text;
					$mm ++;
					error_reporting(E_ALL ^ E_NOTICE);
					$sql = "insert into shuxue (`question_id`,`question_type`,`question_channel_type`,`question_status`,`question_tags`,`chid`,`xd`,`is_objective`,`difficult_index`,`master_level`,`exam_type`,`region_ids`,`grade_id`,`question_source`,`mode`,`title`,`kid_num`,`question_text`,`answer`,`pic_answer`,`pic_explanation`,`knowledge`,`score`,`sort2`,`options`)values('$resoult[question_id]','$resoult[question_type]','$resoult[question_channel_type]','$resoult[question_status]','$resoult[question_tags]','$resoult[chid]','$resoult[xd]','$resoult[is_objective]','$resoult[difficult_index]','$resoult[master_level]','$resoult[exam_type]','$resoult[region_ids]','$resoult[grade_id]','$resoult[question_source]','$resoult[mode]','$resoult[title]','$resoult[kid_num]','$resoult[question_text]','$resoult[answer]','$resoult[pic_answer]','$resoult[pic_explanation]','$resoult[knowledge]','$resoult[score]','$resoult[sort2]','$resoult[options]')";
					$result = $mysqli-> query($sql);
					if($result != true)
					{
						$str = $resoult['question_id'].",";
						$file = __FILE__."shuxueerror.txt";
						file_put_contents($file, $str, FILE_APPEND);
						echo "!!抓取失败数据id为".$resoult['question_id'];

						echo '!!抓取失败，页面：'.$this->num."第".$mm."条\n";
						
					}else
					{
						echo "抓取数据id为".$resoult['question_id']."\n";
						$str = $resoult['question_id'].",";
						// var_dump($resoult['question_id']);exit;
						// $content[] = $resoult['question_id'];
						// $str = implode(",",$content);
						$file = __FILE__."shuxuesuccess.txt";
						file_put_contents($file, $str, FILE_APPEND);
						echo '抓取成功，页面：'.$this->num."第".$mm."条\n";
					}
				}
			}
		}
		
	}
}