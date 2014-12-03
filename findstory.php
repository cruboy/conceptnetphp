<?php
/**
 * 音乐搜索
 *
 * @copyright (c) Hisense All Rights Reserved
 */
if(!defined('EMLOG_ROOT')) {
	exit('error!');
}

$DB = MySql::getInstance();

//歌手和歌曲
if($singer!=""){
	$onlymusic=1;
}
$singer=$singer.$scast;
$songtitle .= $stitle . $ause;

$sql="";
if($songtitle!=""){
	$sql="select * from hi_music where MATCH singer AGAINST ('{".$singer.",".$songtitle."}')
	AND MATCH title AGAINST ('{$songtitle}') ";
}elseif($singer!=""){
	$sql="select * from hi_music where MATCH singer AGAINST ('{$singer}') ";
}elseif($onopt=="music"){
	if($findmusicnew==1){
		$sql = "select * from hi_music order by Rand() limit 10 ";
	}elseif($findmusicany==1 || $ause ==""){
		$sql = "select * from hi_music ";
	}
}

if($sql!=""){
	$res = $DB->query($sql);
	$musicnum = $DB->num_rows($res);
}

//歌手名+歌曲名（歌曲名数据库中没有）,显示该歌手的所有歌曲
//没有标注的歌手处理
if($musicnum==0 && $songtitle!="" ){
	$sql="select * from hi_music where MATCH (title,singer) AGAINST ('{".$singer.",".$songtitle."}') ";
	$res = $DB->query($sql);
	$musicnum = $DB->num_rows($res);
}elseif(($scast=="" && $stitle=="")||$ause!=""){
	$onlymusic=1;
}

if($musicnum>0 && $onlymusic==0 && ($scast!="" || $stitle!="")){
	if($movieshow != 2){
		$movieshow=1;
	}
}

$is_music = $segresult; 
$is_music = str_replace("##FN","",$is_music);
$is_music = str_replace("##DA","",$is_music);

if($musicnum>0){
	$ii=0;
	while($row = $DB->fetch_array($res)){
		$song[]=$row;
		$ii++;
		if($ii>9){
			break;
		}
	}
	
	//去除分词中歌手名与歌曲名
	foreach($song as $temp =>$value){
	   $is_music = str_replace($value['singer'],"",$is_music);	   
	   if(strstr($is_music,$value['title'])){
	      $is_music = str_replace($value['title'],"",$is_music);
	      $title_flag = 1;
	   }
	}
}

$residual = explode(",",$is_music);

$residual_num = 0;

//统计分词后词语个数
for($i=0;$i<count($residual);$i++){
  if($residual[$i]!="" && (cnum2num_recu($residual[$i])<=0)){
    $residual_num = $residual_num +1;
  }
}

//除去$nomean/$music_adj
//$nomean 表示的词有{给我,我想,我要,帮我,我}
//$music_adj 表示的词有{好听,流行,优美,动听,美妙,婉转,低沉,忧郁,甜蜜,最新}
$temp = $nomean + $music_adj;
$residual_num = $residual_num - $temp;

//布尔变量$is_music为真表示判断结果为音乐搜索业务
//没有剩余词
$is_music0 = ($residual_num == 0);

//剩余一个词是听、找、歌曲等词
$is_music1 = ($residual_num == 1) && ($action == "find" || $property_act == "listen" ||
			$property == "music" || ($_SESSION['lonopt']=="music" && $again == 1));

//剩余词出现 {搜索+歌曲、听+歌曲、地区+歌曲、语言+歌曲、类型+歌曲、歌手+歌曲}
$is_music2 = ($residual_num <= 4) && (($property == "music" && $action == "find")||
		    ($action == "find" && $title_flag == 1)||
			($property == "music" && $property_act == "listen")||	    
			($music_type !="" && $property == "music")||
			($sarea !="" && $property == "music")||
			($music_language !="" && $property == "music")||
			($property_act == "listen" && $title_flag == 1)||
			($scast != "" && $property == "music"));

//剩余词出现{听+地区、语言+类型+歌曲、搜索+地区、语言+类型+歌曲}
$is_music3 = ($residual_num <= 6) && $property == "music" && ($sarea !="" || $music_language !="")
	&& $music_type !="" && ($action == "find" ||$property_act == "listen");

$is_music4 = ($residual_num <= 2) && $property == "music";

if( True == $is_music0 || True == $is_music1 || True == $is_music2  || True == $is_music3 || True == $is_music4){
  if($musicnum==0 && $onopt=="music"){
  	echo "<div align=\"center\" >没有找到相应的歌曲！</div>";
  }elseif($musicnum>0){
	 $musicshow = 1;
  if($onopt=="")
  	$onopt = "music";
  }
}elseif($onopt != "video"){
	$onopt = "";
}

//会话内容session设置
$_SESSION['musicsql']=$sql;
$_SESSION['musicnum']=$musicnum;
$_SESSION['pagem']=1;
$_SESSION['nowidm']=0;

