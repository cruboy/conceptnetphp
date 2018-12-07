<?php
/**
 * @copyright cruboy
 * Writer:zhangyulin
 */

require_once 'init.php';

define('TEMPLATE_PATH', EMLOG_ROOT.'/views/');//后台当前模板路径

$act = isset($_GET['action']) ? addslashes($_GET['action']) : "";


$uid = UID;
$DB = MySql :: getInstance();
if(ROLE != 'admin'){
	echo '没有权限';
	exit;
	} 
if($act=='ch')
{
$eid =intval($_POST['id']);
$ltime = time();
$row = $DB->once_fetch_array("select visible from conceptnet_concept WHERE id=".$eid);
//echo $row['visible'];
$r=intval(!intval($row['visible']));
$DB->query("UPDATE conceptnet_concept SET edittime=$ltime,visible={$r} WHERE id=".$eid);
echo $r;
exit;
}
$action='admin';
include './view/header.php';

//set_time_limit(0);


if ($act == "") {
	$opt = $_GET['opt'];
	if(empty($opt)) $opt='id desc';
	
	$word = trim($_GET['bank']);
	$rule = trim($_GET['name']);
    $used=intval($_GET['used']);

      $asql2 = "";
	if ($word != "")
		$asql2 .= "and bank like '$word' ";
		
     if ($rule != "")
		$asql2 .= "and name like '$rule' ";	
		
	if ($used==1)
		$asql2 .= "and visible=1 ";
	elseif ($used==2)
		$asql2 .= "and visible=0 ";
	if(ROLE != 'admin' )
		$asql2 .= "and uid=".UID;
	$page = isset($_GET['page']) ? abs(intval ($_GET['page'])) : 1;
	$nall=intval ($_GET['nall']);
	if($nall<1)
	{
		$sql = "SELECT count(*) as a  FROM vaddlog where 1 $asql2 ";
		$res1 = $DB->query($sql);
		$row1 = $DB->fetch_array($res1);
		$nall=$row1[a];
	}
$start=($page-1)*100;				

	$sql = "SELECT * FROM vaddlog where 1 $asql2 order by $opt  LIMIT $start,100";
	$res = $DB->query($sql);
	//$ap = $DB->affected_rows();
$pageurl="/admin.php?nall=$nall&page=";
	
    include View::getView('admin');


}
elseif($act=='zl'){
		$page = isset($_GET['page']) ? abs(intval ($_GET['page'])) : 1;
	$nall=intval ($_GET['nall']);
	if($nall<1)
	{
		$sql = "SELECT count(*) as a  FROM conceptnet_concept where 1 $asql2 ";
		$res1 = $DB->query($sql);
		$row1 = $DB->fetch_array($res1);
		$nall=$row1['a'];
	}
    $start=($page-1)*1000;				
	$sql = "SELECT * FROM conceptnet_concept where 1 $asql2 order by id  LIMIT $start,1000";
	$res = $DB->query($sql);
	//$ap = $DB->affected_rows();
$pageurl="/admin.php?action=zl&nall=$nall&page=";
	
    include View::getView('zl');


}
elseif($act=='zll'){

 		
	$sql = "SELECT * FROM conceptnet_concept where 1 $asql2 order by text ";
	$res = $DB->query($sql);
	
    include View::getView('zll');


}
elseif($act =='tongji'){
   	$cc = $DB->once_fetch_array("SELECT count(*) as a  FROM cruboy_concept ");
	$ca = $DB->once_fetch_array("SELECT count(*) as a  FROM cruboy_assertion ");
	$nc = $DB->once_fetch_array("SELECT count(*) as a  FROM conceptnet_concept ");
	$na = $DB->once_fetch_array("SELECT count(*) as a  FROM conceptnet_assertion ");
	
	$cc2 = $DB->once_fetch_array("SELECT max(id) as a  FROM cruboy_concept ");
	$ca2 = $DB->once_fetch_array("SELECT max(id) as a  FROM cruboy_assertion ");
	$nc2 = $DB->once_fetch_array("SELECT max(id) as a  FROM conceptnet_concept ");
	$na2 = $DB->once_fetch_array("SELECT max(id) as a  FROM conceptnet_assertion ");
?>
<table width="402" border="1">
  <tr>
    <td width="64">&nbsp;</td>
    <td width="116">conceptnet</td>
    <td width="98">cruboy</td>
    <td width="96">&nbsp;</td>
  </tr>
  <tr>
    <td>concept</td>
    <td><?=$nc['a']?>[<?=$nc2['a']?>]</td>
    <td><?=$cc['a']?>[<?=$cc2['a']?>]</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>assertion</td>
    <td><?=$na['a']?>[<?=$na2['a']?>]</td>
    <td><?=$ca['a']?>[<?=$ca2['a']?>]</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?
}
elseif($act =="edit"){
    
	$id=intval($_GET['id']);
    if($id>0){
	$v = $DB->once_fetch_array("SELECT * FROM cruboy_lilv WHERE id='$id' ");
    }
	include View::getView('vhedit');
}


elseif($act =="editok"){

	$id=intval($_GET['id']);

$logData=$_POST;
	$uid=UID;
	$ltime=time();
	$gip=getIP();
	$logData[addtime]=$ltime;
		$logData[edittime]=$ltime;
			$logData[creator]=$uid;
		//$logData[end0]=	

			print_r($logData);
		//	exit;
		//	echo getlv($logData['bank'],$logData['nian'],$logData['end0']);
			//exit;
	if($id>0){

	  $Item = array();
		foreach ($logData as $key => $data) {
			$Item[] = "$key='".addslashes($data)."'";
		}
		$upStr = implode(',', $Item);
		$DB->query("UPDATE cruboy_  SET $upStr WHERE id=$id");
	$msf="修改成功！";
	}
	else{
		$kItem = array();
		$dItem = array();
		foreach ($logData as $key => $data) {
			$kItem[] = $key;
			$dItem[] = addslashes($data);
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$DB->query("INSERT INTO cruboy_  ($field) VALUES ($values)");
		$logid = $DB->insert_id();
			$msf="添加成功！".$logid;
		}
	

	echo "<script language=\"JavaScript\">alert(\"$msf\");history.go(-2);</script>";
	exit;
}
include View::getView('footer');
?>