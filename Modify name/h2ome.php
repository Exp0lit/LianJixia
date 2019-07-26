<meta charset="utf-8">
<?php
error_reporting(E_ALL ^ E_NOTICE);// 显示除去 E_NOTICE 之外的所有错误信息
$index = $_GET['index'];


if ($index != "") {
	$file_contents = curl_get_https('http://api.lianjixia.com/user_api/?&do=load_game_briefs&index='. $index."&limit=18&order=&session_id=&sign=75381b6111964679a22e16cf10132667&type=&version=0.3.32");
    $arr = json_decode($file_contents,true);
    //print_r($arr['game_briefs'][0]);
    $number = substr_count($file_contents, 'caption');
    // echo $number;
	# code...
	for ($i=0; $i <$number ; $i++) { 
    	getserver($i,$arr);
    	sleep(1.5);
		# code...
	}
}

function getserver($a,$arr){
	$a = (int)$a;
	$server_list = $arr['game_briefs'][$a];
	//print_r($server_list);
	echo "服务器名称：".$server_list['caption']."<br>";
	echo "服务器公告：".$server_list['desc']."<br>";
	if ($server_list['is_online']=='1') {
		echo "在线状态：Yes"."<br>";
	}else{
		echo "在线状态：No"."<br>";
	}
	if ($server_list['is_opened']=='1') {
		echo "开启状态：Yes"."<br>";
	}else{
		echo "开启状态：No"."<br>";
	}
	echo "在线玩家/最大在线数：".$server_list['player_current']."/".$server_list['player_capacity']."<br>";
	echo "类型：".$server_list['type']."<br>";
	if ($server_list['user_vip_level']=="") {
		echo "服务器等级：非VIP".'<br>';
	}else{
		echo "服务器等级：VIP".$server_list['user_vip_level'].'<br>';
	}
	echo "<br><br>";
}

function curl_get_https($url){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    $tmpInfo = curl_exec($curl); // 返回api的json对象
    curl_close($curl);
    return $tmpInfo; // 返回json对象
}

?>p