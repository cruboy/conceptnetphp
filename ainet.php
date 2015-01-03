<?php
/**
 * mynet forzyl@gmail.com
 * @copyright (zhangyulin
*/

require_once '../init.php';

define('TEMPLATE_PATH', EMLOG_ROOT.'/m/views/');

if (ISLOGIN !== true){
//echo "请登录";
$msg='登录后，可以编辑导图等。';
emDirect("/m/?action=login");
exit;
}
$blogtitle = Option::get('twnavi') . ' - ' . Option::get('blogname');
$description = Option::get('bloginfo');
$DB = MySql::getInstance();
$concepts=array();
$aineth=1;
$atitle="";
$gip=getIp();   
$uid=UID;
$vsid=intval($_SESSION['views']);
// 首页

	$cpidd=intval($_GET['cp']);
			if($cpidd<0){
				$tabf="cruboy";
				$vfrom="jcru";
				$cpid=-$cpidd;
			}else{
				$tabf="conceptnet";
				$vfrom="jind";
				$cpid=$cpidd;
				if($cpid==0)$action="keyword";
			}
	if(isset($_GET['jt']))
$tabf="cruboy";		
	$cpr = $CACHE->readCache('cpr');	
if (!empty($cpid) and  empty($_GET['u']))
{
	$ltime = time();

	//$DB->query("UPDATE  ".$tabf."_concept SET words=words+1 WHERE id='$cpid'");

	$sq1 = "SELECT * FROM  ".$tabf."_concept WHERE id='$cpid'";
	$pDa = $DB->once_fetch_array($sq1);

	$hhtitle=$pDa[text];
		$DB->query("INSERT INTO viewlog (method,viewid,concept,uid,sina_uid,date,text,loginip) VALUES (
				'$vfrom','$vsid','$cpidd','$uid','$usersina_id','$ltime','$pDa[text]','$gip')");
	
	$sq2 = "SELECT a.concept1_id,a.concept2_id,a.id as aid,a.abid,a.seq,a.info,a.aurl,
		a.relation_id,a.best_frame_id,a.atop1 as atop,a.aleft1 as aleft,
		 ".$tabf."_concept.* FROM  ".$tabf."_assertion a LEFT JOIN
		 ".$tabf."_concept ON a.concept2_id= ".$tabf."_concept.id
		WHERE concept1_id='$cpid' order by a.relation_id,a.best_frame_id LIMIT 100";
	$res2 = $DB->query($sq2);
	while ($row = $DB->fetch_array($res2)) {
			if($row[best_frame_id]>0){		
			$ss=str_replace("1",$pDa[text],$cpr[$row[best_frame_id]]);
			$ss=str_replace("2",$row[text],$ss);
			$row[frame]=$ss;
			}{
			 $row[rela]=$cpr[$row[relation_id]];
			}
		    $row['fx']='1';
			 if($vfrom=="jcru")
					$row[id]=-$row[id];
				if($row[atop]>$maxtop)
					$maxtop=$row[atop];	
			$concepts[]=$row;
			}

	$sq3 = "SELECT a.concept1_id,a.concept2_id,a.id as aid,a.abid,a.seq,a.info,a.aurl,
		a.relation_id,a.best_frame_id,a.atop2 as atop,a.aleft2 as aleft,
		 ".$tabf."_concept.* FROM  ".$tabf."_assertion a LEFT JOIN
		 ".$tabf."_concept ON a.concept1_id= ".$tabf."_concept.id
		WHERE concept2_id='$cpid' order by a.seq,a.relation_id,a.best_frame_id LIMIT 4000";
		$res3 = $DB->query($sq3);
	while ($row2 = $DB->fetch_array($res3)) {
			if($row2[best_frame_id]>0){		
			$ss=str_replace("1",$row2[text],$cpr[$row2[best_frame_id]]);
			$ss=str_replace("2",$pDa[text],$ss);
			$row2[frame]=$ss;
			}{
			 $row2[rela]=$cpr[$row2[relation_id]];
			}
			$row2['fx']='2';
			 if($vfrom=="jcru")
					$row2[id]=-$row2[id];
			if($row2[atop]>$maxtop)
			$maxtop=$row2[atop];
		$concepts[]=$row2;
		}
		$mm=count($concepts,0)*20+60;
		//	echo $maxtop.' '.$mm;
			if($maxtop<$mm)
			$maxtop=$mm;
			if($maxtop<760)
			$maxtop=760;
	include View::getView('header');
	include View::getView('cpedit');
	include View::getView('footer');
	View::output();
}

else
{
	$akey = addslashes($_GET['k']);
	$atitle="查询'".$akey."'的结果：";
		$ltime = time();
	$DB->query("INSERT INTO viewlog (method,viewid,concept,uid,sina_uid,date,text,loginip) VALUES (
				'keyword','$vsid','0','$uid','$usersina_id','$ltime','$akey','$gip')");
	if(isset($_GET['u']))
	{$sql = "SELECT * FROM ".$tabf."_concept where uid=".intval($_GET['u'])." limit 1000";
	$atitle='我添加的图';
	}elseif(empty ($akey))
	{$sql = "SELECT * FROM ".$tabf."_concept order by Rand()  LIMIT 30";
	$atitle='随机查看图：';
	}else
	$sql = "SELECT * FROM  ".$tabf."_concept WHERE text LIKE '%$akey%' order by f3 desc LIMIT 1000";
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
    include View::getView('header');
	include View::getView('mynet');
	include View::getView('footer');
	View::output();
}

if(isset ($_GET['fre']))
{ $a=0;
	$freid = intval ($_GET['fre']) ;
	$sql2 = "SELECT conceptnet_assertion.concept1_id,conceptnet_assertion.concept2_id,
		conceptnet_assertion.score,conceptnet_assertion.best_frame_id,conceptnet_concept.text FROM conceptnet_assertion LEFT JOIN
		conceptnet_concept ON conceptnet_assertion.concept2_id=conceptnet_concept.id
		WHERE best_frame_id='$freid' order by conceptnet_assertion.score desc";
	$res2 = $DB->query($sql2);
	while ($row = $DB->fetch_array($res2)) {
		$sqqq2="SELECT text FROM conceptnet_concept WHERE id='$row[concept1_id]'";
			 $qDq2 = $DB->once_fetch_array($sqqq2);
			 $row[text1]=$qDq2[text];
		echo $a.$row[text1]."-->".$row[text].$row[score]."<br>";
		$a++;
	}
	exit;
	
}


