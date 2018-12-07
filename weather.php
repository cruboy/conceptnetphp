<?php
/**
 * 天气信息查询
 *
 * @copyright (c) All Rights Reserved
 * @author Sun Zhaomei
 */
if(!defined('EMLOG_ROOT')) {
	exit('error!');
}

//公共变量定义
$code=array();
$DB = MySql::getInstance();

//确定目的城市名称
$weatherCityName = str_replace(',', '', $ause);
if($weatherCityName !=""){

	$sql = "SELECT * FROM ".DB_PREFIX."cityinfo WHERE MATCH (districtname) AGAINST ('{$weatherCityName}') OR
	districtname LIKE '%$weatherCityName%' ORDER BY id DESC";
	$res = $DB->query($sql);
	while ($row = $DB->fetch_array($res)) {
		array_push($code, $row[citycode]);
	}

	if(count($code)==0){
		$sql = "SELECT * FROM ".DB_PREFIX."cityinfo WHERE MATCH (cityname) AGAINST ('{$weatherCityName}') OR
		cityname LIKE '%$weatherCityName%' ORDER BY id";
		$res = $DB->query($sql);
		while ($row = $DB->fetch_array($res)) {
			array_push($code, $row[citycode]);
		}
	}
}

if(count($code)==0 && $onopt=="weather"){
	if($_SESSION['lonopt']=="weather"||$_SESSION['llonopt']=="weather"){
		$code[0]=isset($_SESSION['citycode'])?$_SESSION['citycode']:101120201;
	}else{
		$code[0]=101120201;
	}
}

//更新session城市信息
$_SESSION['citycode']=$code[0];

if(count($code)>0){
	$onopt="weather";

	//天气信息请求链接
	$uri1 = 'http://m.weather.com.cn/data/'.$code[0].'.html';
	$uri2 = 'http://www.weather.com.cn/data/sk/'.$code[0].'.html';

	$ch1 = curl_init();
	$ch2 = curl_init();
	$timeout = 5;
	curl_setopt($ch1, CURLOPT_URL, $uri1);
	curl_setopt($ch2, CURLOPT_URL, $uri2);
	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 2);
	curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch2, CURLOPT_CONNECTTIMEOUT, $timeout);
	
	//获取天气信息
	$file_contents1 = curl_exec($ch1);
	$file_contents2 = curl_exec($ch2);
	
	//关闭请求
	curl_close($ch1);
	curl_close($ch2);
	
	$J = json_decode($file_contents1);
	$J1 = json_decode($file_contents2);
	
	//星期数组
	$weeks = array (
			"Mon" => "周一",
			"Tue" => "周二",
			"Wed" => "周三",
			"Thu" => "周四",
			"Fri" => "周五",
			"Sat" => "周六",
			"Sun" => "周日"
	);
	
	if($weatherTime==""){
		$weatherTime="今天";
	}
	$voice=$J->weatherinfo->city.$weatherTime;
	
	if($weatherDateTime=="明天"){
		$temp1=str_replace("~","",$J->weatherinfo->temp2);
		$temp1=explode("℃",$temp1);
		if($temp1[0]>$temp1[1]){
			$max=$temp1[0];
			$min=$temp1[1];
		}else{
			$max=$temp1[1];
			$min=$temp1[0];
		}
		$voice=$voice.$J->weatherinfo->weather2."，最高气温".$max."℃"."，最低气温".$min."℃";
	}elseif($weatherDateTime=="后天"){
		$temp1=str_replace("~","",$J->weatherinfo->temp3);
		$temp1=explode("℃",$temp1);
		if($temp1[0]>$temp1[1])
		{
			$max=$temp1[0];
			$min=$temp1[1];
		}
		else
		{
			$max=$temp1[1];
			$min=$temp1[0];
		}

		$voice=$voice.$J->weatherinfo->weather3."，最高气温".$max."℃"."，最低气温".$min."℃";
	}elseif($weatherDateTime=="大后天"){
		$temp1=str_replace("~","",$J->weatherinfo->temp4);
		$temp1=explode("℃",$temp1);
		if($temp1[0]>$temp1[1]){
			$max=$temp1[0];
			$min=$temp1[1];
		}else{
			$max=$temp1[1];
			$min=$temp1[0];
		}

		$voice=$voice.$J->weatherinfo->weather4."，最高气温".$max."℃"."，最低气温".$min."℃";
	}elseif($weatherDateTime=="明天后天" || $weatherDateTime=="明天后天大后天"){
		$temp1=str_replace("~","",$J->weatherinfo->temp2);
		$temp1=explode("℃",$temp1);
		if($temp1[0]>$temp1[1]){
			$max=$temp1[0];
			$min=$temp1[1];
		}else{
			$max=$temp1[1];
			$min=$temp1[0];
		}

		$voice=$J->weatherinfo->city."明天".$J->weatherinfo->weather2."，最高气温".$max."℃"."，最低气温".$min."℃";

		$temp1=str_replace("~","",$J->weatherinfo->temp3);
		$temp1=explode("℃",$temp1);
		if($temp1[0]>$temp1[1]){
			$max=$temp1[0];
			$min=$temp1[1];
		}else{
			$max=$temp1[1];
			$min=$temp1[0];
		}

		$voice=$voice."，后天".$J->weatherinfo->weather3."，最高气温".$max."℃"."，最低气温".$min."℃";
	}elseif($weatherDateTime=="未来"){
		$temp1=str_replace("~","",$J->weatherinfo->temp5);
		$temp1=explode("℃",$temp1);
		if($temp1[0]>$temp1[1]){
			$max=$temp1[0];
			$min=$temp1[1];
		}else{
			$max=$temp1[1];
			$min=$temp1[0];
		}

		$voice=$voice.$J->weatherinfo->weather5."，最高气温".$max."℃"."，最低气温".$min."℃";
	}else{
		$temp1=str_replace("~","",$J->weatherinfo->temp1);
		$temp1=explode("℃",$temp1);
		if($temp1[0]>$temp1[1]){
			$max=$temp1[0];
			$min=$temp1[1];
		}else{
			$max=$temp1[1];
			$min=$temp1[0];
		}
		$voice=$voice.$J->weatherinfo->weather1."，最高气温".$max."℃"."，最低气温".$min."℃";
	}
	
	include './view/weather.php';
}
?>
