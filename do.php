<?php
/**
 * mynet forzyl@gmail.com
 * @copyright (zhangyulin
*/

require_once 'init.php';


$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';
$gip=getIp();   
$uid=UID;
$usersina_id=0;
	$DB = MySql::getInstance();
if (ISLOGIN !== true){
echo "请登录";
exit;
}
if ($action == 'delok') { //删除标记不可见的
	 $sql = "SELECT * FROM conceptnet_concept WHERE visible=0 limit 10000";
	 //limit 0,10000
		$res = $DB->query($sql);
		while ($row = $DB->fetch_array($res)) {
		
		$sql2 = "DELETE FROM conceptnet_assertion WHERE concept1_id=".$row['id'];
		$sql3 = "DELETE FROM conceptnet_assertion WHERE concept2_id=".$row['id'];
		$res2 = $res2+ $DB->query($sql2);
		$res3 = $res3 + $DB->query($sql3);
		
		}
		echo $sql.' ';
		echo  $row['text'].$res2."-".$res3;
}
if ($action == 'dot') { //重整ass编号
	set_time_limit(0);
	 $sql = "SELECT * FROM conceptnet_assertion where id> ";
	 //limit 0,10000
		$res = $DB->query($sql);
     $i=1;
		while ($row = $DB->fetch_array($res)) {

		$DB->query("UPDATE conceptnet_assertion SET fid=".$i." WHERE id=".$row['id']);
	//	$DB->query("UPDATE conceptnet_assertion set concept1_id='$i' WHERE concept1_id=".$row['id']);
	//	$DB->query("UPDATE conceptnet_assertion set concept2_id='$i' WHERE concept2_id=".$row['id']);
		$i++;
		}
echo 'ok';
}
if ($action == 'dodd-') {  //比对
	set_time_limit(0);
	 $sql = "SELECT * FROM conceptnet_concept where hn=0 ";
	 //limit 0,10000
		$res = $DB->query($sql);
     $i=1;
		while ($row = $DB->fetch_array($res)) {

		$DB->query("UPDATE hinet_concept SET fid=".$row['id']." where fid=0 and text like '".$row['text']."'");

		}
echo 'ok';
}
//update a set a.c2=c.fid from `hinet_assertion` a, hinet_concept c where a.concept2_id=c.id and a.c2=0 and a.c1>0
//update `hinet_assertion` a, hinet_concept c set a.c2=c.fid  where a.concept2_id=c.id and a.c2=0 and a.c1>0
//update `hinet_assertion` a, hinet_concept c set a.c1=c.fid  where a.concept1_id=c.id and a.c1=0 and a.c2>0
if ($action == 'dodd2-') {  //ass重编cp号
	set_time_limit(0);
	 $sql = "SELECT * FROM hinet_concept where fid>12866 ";
	 //limit 0,10000
		$res = $DB->query($sql);
     $i=1;
		while ($row = $DB->fetch_array($res)) {
		$DB->query("UPDATE hinet_assertion SET c1=".$row['fid']." where concept1_id=".$row['id']);
          $DB->query("UPDATE hinet_assertion SET c2=".$row['fid']." where concept2_id=".$row['id']);
		}
echo 'ok';
}
if ($action == 'dor') {  //hownet比对
	set_time_limit(0);
	 $sql = "SELECT * FROM hi_hown et ";
	 //limit 0,10000
		$res = $DB->query($sql);
 		while ($row = $DB->fetch_array($res)) {
		   $DB->query("UPDATE hinet_concept SET hn=1 WHERE text like '".$row['word']."'");
		}
		echo 'ok';
}
if ($action == 'dor2-') { //重提取原hinet中hownet的词
	set_time_limit(0);
	 $sql = "SELECT * FROM hinet_concept where hn=1";
	 //limit 0,10000
		$res = $DB->query($sql);
 		while ($row = $DB->fetch_array($res)) {
			$nm=$row['text'];
		   $sql2 = "SELECT * FROM conceptnet_concept WHERE text like '{$nm}'";
		$r2 = $DB->once_fetch_array($sql2);
		$roid=$row['id'];
       if($r2['id']>0){
		   $tid=$r2['id'];
		 //  $DB->query("UPDATE conceptnet_concept SET cruboy=-1 WHERE id=".$tid);
		  echo $tid.' ';
		   }
		   else
		   {	
		   unset($row['id']);
		    unset($row['fid']);
			unset($row['creator']);
		   $row['hn']=1;
		   $kItem = array();
		$dItem = array();
		foreach ($row as $key => $data) {
			$kItem[] = $key;
			$dItem[] = addslashes($data);
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$DB->query("INSERT INTO conceptnet_concept  ($field) VALUES ($values)");
		$tid = $DB->insert_id();
		echo '+'.$tid.' ';
		   }
		$DB->query("UPDATE hinet_concept SET fid=".$tid." WHERE id=".$roid);
		}
		echo 'ok';
}
if ($action == 'dott-') { //一个net融入总的net
	set_time_limit(0);
	 $sql = "SELECT * FROM cruboy_concept ";
	 //limit 0,10000
		$res = $DB->query($sql);
 		while ($row = $DB->fetch_array($res)) {
			$nm=$row['text'];
        $sql2 = "SELECT * FROM conceptnet_concept WHERE text like '{$nm}'";
		$r2 = $DB->once_fetch_array($sql2);
		$roid=$row['id'];
       if($r2['id']>0){
		   $tid=$r2['id'];
		   $DB->query("UPDATE conceptnet_concept SET cruboy=-1 WHERE id=".$tid);
		  echo $tid.' ';
		   }
		   else
		   {	
		   unset($row['id']);
		    unset($row['fid']);
		   $row['cruboy']=-2;
		   $kItem = array();
		$dItem = array();
		foreach ($row as $key => $data) {
			$kItem[] = $key;
			$dItem[] = addslashes($data);
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$DB->query("INSERT INTO conceptnet_concept  ($field) VALUES ($values)");
		$tid = $DB->insert_id();
		echo '+'.$tid.' ';
		   }
		    $DB->query("UPDATE cruboy_concept SET fid=".$tid." WHERE id=".$roid);
	//	$DB->query("UPDATE cruboy_assertion SET fid=".$i." WHERE id=".$row['id']);
	//	$DB->query("UPDATE conceptnet_assertion set concept1_id='$i' WHERE concept1_id=".$row['id']);
	//	$DB->query("UPDATE conceptnet_assertion set concept2_id='$i' WHERE concept2_id=".$row['id']);
		$i++;
		}
echo 'ok';
}
if ($action == 'dott2-') { //一个net的关系融入总的net
	set_time_limit(0);
	$sql = "SELECT * FROM cruboy_concept ";
	 //limit 0,10000
		$res = $DB->query($sql);
 		while ($row = $DB->fetch_array($res)) {
		$d[$row['id']]=$row['fid'];
		}
	 $sql = "SELECT * FROM cruboy_assertion ";
	 //limit 0,10000
		$res = $DB->query($sql);
 		while ($row = $DB->fetch_array($res)) {
			$c1=$d[$row['concept1_id']];
			$c2=$d[$row['concept2_id']];
        $sql2 = "SELECT * FROM conceptnet_assertion WHERE concept1_id={$c1} and concept2_id={$c2}  ";
		$r2 = $DB->once_fetch_array($sql2);
		$roid=$row['id'];
       if($r2['id']>0){
		   $tid=$r2['id'];
		   $DB->query("UPDATE conceptnet_assertion SET cruboy=-1 WHERE id=".$tid);
		  echo $tid.' ';
		   }
		   else
		   {	
		   unset($row['id']);
		   $row['concept1_id']=$d[$row['concept1_id']];
		   $row['concept2_id']=$d[$row['concept2_id']];
		  //  unset($row['fid']);
		   $row['cruboy']=-2;
		   $kItem = array();
		$dItem = array();
		foreach ($row as $key => $data) {
			$kItem[] = $key;
			$dItem[] = addslashes($data);
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$DB->query("INSERT INTO conceptnet_assertion  ($field) VALUES ($values)");
		$tid = $DB->insert_id();
		echo '+'.$tid.' ';
		   }
	//	    $DB->query("UPDATE cruboy_concept SET fid=".$tid." WHERE id=".$roid);
	//	$DB->query("UPDATE cruboy_assertion SET fid=".$i." WHERE id=".$row['id']);
	//	$DB->query("UPDATE conceptnet_assertion set concept1_id='$i' WHERE concept1_id=".$row['id']);
	//	$DB->query("UPDATE conceptnet_assertion set concept2_id='$i' WHERE concept2_id=".$row['id']);
		$i++;
		}
echo 'ok';
}
if ($action == 'doe') {  //取回hownet中有词的关系
	set_time_limit(0);

	 $sql = "SELECT * FROM hinet_assertion where c1>0 and c2>0 ";
	 //limit 0,10000
		$res = $DB->query($sql);
 		while ($row = $DB->fetch_array($res)) {


		$DB->query("INSERT INTO conceptnet_assertion  (relation_id,concept1_id,concept2_id,score,best_frame_id) VALUES (
		'{$row['relation_id']}','{$row['c1']}','{$row['c2']}','{$row['score']}','{$row['best_frame_id']}')");
		$tid = $DB->insert_id();
		echo '+'.$tid.' ';

		}
echo 'ok';
}
if ($action == 'updnum') {
	 $sql = "SELECT * FROM conceptnet_concept limit 15000,10000";
	 //limit 0,10000
		$res = $DB->query($sql);
		while ($row = $DB->fetch_array($res)) {
		
		$sql2 = "SELECT count(*) FROM conceptnet_assertion WHERE concept1_id=".$row['id'];
		$res2 = $DB->once_fetch_array($sql2);
		$comNum1 = $res2['count(*)'];
		$sql3 = "SELECT count(*) FROM conceptnet_assertion WHERE concept2_id=".$row['id'];
		$res3 = $DB->once_fetch_array($sql3);
		$comNum2 = $res3['count(*)'];
		$comNum=$comNum1+$comNum2;
		$DB->query("UPDATE conceptnet_concept SET f1=".$comNum1.",f2=".$comNum2.",f3=".$comNum.
		" WHERE id=".$row['id']);
		
		}
		echo $sql.' ';
		echo  $row['text'].$res2."-".$res3;
}
// 按frame统计.
if ($action == 'frame') {
		$a=0;
    $sql = "SELECT * FROM conceptnet_frame order by relation_id";
		$res = $DB->query($sql);
		while ($row = $DB->fetch_array($res)) {
			$wd=$row['text']; 
			$a++;
			$dd=$row['id'];
		$sql2 = "SELECT count(*) FROM conceptnet_assertion WHERE best_frame_id=".$dd;
		$res2 = $DB->once_fetch_array($sql2);
		$comNum = $res2['count(*)'];
		$sql3 = "SELECT count(*) FROM conceptnet_assertion WHERE score>2 AND best_frame_id=".$dd;
		$res3 = $DB->once_fetch_array($sql3);
		$comNum3 = $res3['count(*)'];
		echo " ".$row['relation_id'].":".$dd." ".$wd.":".$comNum."--".$comNum3."<br>";
		
		}
}
// .按relation统计
if ($action == 'relation') {
	set_time_limit(0);
    $sql = "SELECT * FROM conceptnet_relation order by id";
		$res = $DB->query($sql);
		while ($row = $DB->fetch_array($res)) {
			$wd=$row['name']; 
			$dd=$row['id'];
		$sql2 = "SELECT count(*) FROM conceptnet_assertion WHERE relation_id=".$dd;
		$res2 = $DB->once_fetch_array($sql2);
		$comNum = $res2['count(*)'];
		$sql3 = "SELECT count(*) FROM conceptnet_assertion WHERE score>2 AND relation_id=".$dd;
		$res3 = $DB->once_fetch_array($sql3);
		$comNum3 = $res3['count(*)'];
		echo $dd." ".$wd.":".$comNum."--".$comNum3."<br>";
		}
}

// concept.
if ($action == '') {
$ltime = time();
if(isset($_POST['del']) )
{
$hhtitle="删除概念";
$eid =intval($_POST['del']);
$DB->query("INSERT INTO oplog (opid,concept,gid,sina_uid,date,loginip) VALUES (
				'4','$eid','$uid','$usersina_id','$ltime','$gip')");
$DB->query("UPDATE conceptnet_concept SET edittime=$ltime,visible=0 WHERE id=".$eid);
}

else if(isset($_POST['res']) )
{
$hhtitle="恢复概念";
$eid =intval($_POST['res']);
$DB->query("INSERT INTO oplog (opid,concept,gid,sina_uid,date,loginip) VALUES (
				'5','$eid','$uid','$usersina_id','$ltime','$gip')");
$DB->query("UPDATE conceptnet_concept SET edittime=$ltime,visible=1 WHERE id=".$eid);
}


else
$hhtitle="错误";

mMsg($hhtitle.'操作成功！', $turl."?cp=".$eid);
}

function mMsg($msg, $url) {
	echo $msg;
	exit;
}
