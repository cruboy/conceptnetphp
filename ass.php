<?php
/**
 * notenet cruboy.com
 * @copyright (zhangyulin
*/

require_once '../init.php';

define('TEMPLATE_PATH', EMLOG_ROOT.'/m/view/');

$DB = MySql::getInstance();
$concepts=array();
$atitle="";
$gip=getIp();   
$uid=UID;
$vsid=intval($_SESSION['views']);
// 首页

	$cpidd=intval($_GET['cp']);
			if($cpidd<0){
				$tabf='cruboy';
				$vfrom="acru";
				$cpid=-$cpidd;
			}else{
				$tabf="conceptnet";
				$vfrom="aind";
				$cpid=$cpidd;
			}
	
	$cpr = $CACHE->readCache('cpr');	
  $cpr[0]="{1}--{2}";
	$ltime = date('Y-m-d H:i:s');

	//$DB->query("UPDATE  ".$tabf."_concept SET words=words+1 WHERE id='$cpid'");

		//$DB->query("INSERT INTO viewlog (method,viewid,concept,uid,sina_uid,date,text,loginip) VALUES (
			//	'$vfrom','$vsid','$cpidd','$uid','$usersina_id','$ltime','$pDa[text]','$gip')");
	
//print_r($cpr);
    $sqlad='';
	$freid = intval ($_GET['fre']);
	if($freid==0) $freid = intval ($_POST['fre']);
	if($freid){$sqlad=" and a.best_frame_id='$freid' ";
	}
	if(isset($_POST['fre'])){
		$sqlad.=" order by rand() limit 30";
		}else{
	$w=date('W');$y=date('Y');
		$sql2="SELECT * FROM weekcache where year=$y and week=$w and oid=$freid and name='asss'";
	$row2=$DB->once_fetch_array($sql2);
	if($row2['id']){
     $wwcps=$row2['content'];
		}else{ $ltime = date('Y-m-d H:i:s');
		$res = $DB->query("SELECT id FROM conceptnet_assertion  a where visible>=0 $sqlad order by Rand() LIMIT 30");
   $o='';
	while ($row = $DB->fetch_array($res)) {
			$o.=$row['id'].','; 
		}	
		$wwcps=substr($o,0,-1);
	$DB->query("INSERT INTO weekcache (year,week,name,oid,ctime,content) VALUES (
				'$y','$w','asss','$freid','$ltime','".$wwcps."')");
		}
		$sqlad=" and a.id in( $wwcps )";
		}
	$sql2 = "SELECT a.id as aid,a.concept1_id,a.concept2_id,
		a.score,a.relation_id,a.best_frame_id,a.good,a.bad,c.text as cp1,d.text as cp2 FROM 
		conceptnet_assertion a LEFT JOIN conceptnet_concept c ON a.concept1_id=c.id 
		 LEFT JOIN conceptnet_concept d ON a.concept2_id=d.id
		WHERE 1  $sqlad ";
	$res2 = $DB->query($sql2);
   include View::getView('header');
   include View::getView('ass');
	include View::getView('footer');
	

if(isset ($_GET['list']))
{
   $action='list';
	$sql = "SELECT uid,count(1) as a FROM  ".$tabf."_concept WHERE uid>0 group by uid order by a desc";
			$res = $DB->query($sql);
		
			global $CACHE;
	$user_cache = $CACHE->readCache('user');
	
  include './view/header.php';
 echo ' <table width="400" border="1">
  <tr>
    <th scope="col">会员</th>
    <th scope="col">图数量</th>
    <th scope="col">&nbsp;</th>
  </tr>';
	while ($row = $DB->fetch_array($res)) {
			//print_r($row);
			echo '<tr>
    <td>'.$user_cache[$row['uid']]['name'].'</td>
    <td>'.$row['a'].'</td>
    <td><a href="?u='.$row['uid'].'">查看</a></td>
  </tr>';
			}  
echo '</table>';


	include View::getView('footer');
	View::output();
}
else if(0)
{
	$akey = addslashes($_GET['k']);
	
	$ltime = date('Y-m-d H:i:s');
	
	if(isset($_GET['u'])){
		$uid=intval($_GET['u']);
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$author = $user_cache[$uid]['name'];
	$sql = "SELECT * FROM ".$tabf."_concept where uid={$uid} order by edittime desc limit 1000";
	$atitle=$author.'添加的图';$action='list';
	$kword='maimy';
	}elseif(empty ($akey)){
	$sql = "SELECT * FROM ".$tabf."_concept where uid=0 order by Rand()  LIMIT 30";
	$atitle='点击编辑图：';
	$aineth=1;
	$kword='maihome';
	}else{
	$sql = "SELECT * FROM  ".$tabf."_concept WHERE text LIKE '%$akey%' order by f3 desc LIMIT 1000";
	$atitle="查询'".$akey."'进行编辑：";$aineth=1;
	$kword='maisearch';
	}
	$DB->query("INSERT INTO viewlog (method,viewid,concept,uid,sina_uid,vtime,text,loginip) VALUES (
				'$kword','$vsid','0','$uid','$usersina_id','$ltime','$akey','$gip')");	
			$res = $DB->query($sql);
		
			while ($row = $DB->fetch_array($res)) {
			if(isset($_GET['jt']))$row[id]=-$row[id];
		// $sql2 = "SELECT * FROM  ".$tabf."_assertion WHERE concept1_id='$row[id]' or concept2_id='$row[id]' LIMIT 2";
		$sql2 = "SELECT a.concept1_id,a.concept2_id,
		a.relation_id,a.best_frame_id, ".$tabf."_concept.text FROM  ".$tabf."_assertion a LEFT JOIN
		 ".$tabf."_concept ON a.concept2_id= ".$tabf."_concept.id
		WHERE concept1_id='$row[id]'";
			$aDa = $DB->once_fetch_array($sql2);
		
		$row[tx1]=$aDa[text];
	 $row[re1]=$aDa[relation_id];
	 $row[fi1]=$aDa[best_frame_id];
		 $sql3 = "SELECT a.concept1_id,a.concept2_id,
		a.relation_id,a.best_frame_id, ".$tabf."_concept.text FROM  ".$tabf."_assertion a LEFT JOIN
		 ".$tabf."_concept ON a.concept1_id= ".$tabf."_concept.id
		WHERE concept2_id='$row[id]'";
			$aDa3 = $DB->once_fetch_array($sql3);
		
		$row[tx2]=$aDa3[text];
	 $row[re2]=$aDa3[relation_id];
	 $row[fi2]=$aDa3[best_frame_id];
	$concepts[]=$row;
		}
		$hhtitle=$akey;
		$atitle.="（共".count($concepts,0)."个）";
  include './view/header.php';
	include View::getView('mynet');
	include View::getView('footer');
	View::output();
}




