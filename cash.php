<?php
/**
 * @copyright cruboy
 * Writer:zhangyulin
 */

require_once '../init.php';

define('TEMPLATE_PATH', EMLOG_ROOT.'/m/view/');//后台当前模板路径

$action = isset($_GET['action']) ? addslashes($_GET['action']) : "";
if (ISLOGIN !== true ) {
	echo "Access Denied!";
	//exit ();
}

$uid = UID;
$DB = MySql :: getInstance();
include View::getView('header');

//set_time_limit(0);


//3.HiNet Manage
if ($action == "") {
	$opt = $_GET['opt'];
	$ass = intval ($_GET['ass']);
	$att2=intval($_GET['ass2']);
	$word = trim($_GET['word']);
	$rule = trim($_GET['rule']);
	$rule2 = trim($_GET['rule2']);
	$procs = trim($_GET['procs']);
	$used=intval($_GET['used']);

      $asql2 = "";
	if ($word != "")
		$asql2 .= "and text like '%$word%' ";
		
	if ($rule == "!")
		$asql2 .= "and rule != '' ";
	elseif ($rule == "#")
		$asql2 .= "and rule = '' ";	
	elseif ($rule != "")
		$asql2 .= "and rule like '%$rule%' ";	
		
	if ($rule2 == "!")
		$asql2 .= "and rule2 != '' ";
	elseif ($rule2 == "#")
		$asql2 .= "and rule2 = '' ";		
	elseif ($rule2 != "")
		$asql2 .= "and rule2 like '%$rule2%' ";
		
	if ($procs == "!")
		$asql2 .= "and procs != '' ";
	elseif ($procs == "#")
		$asql2 .= "and procs ='' ";	
	elseif ($procs != "")
		$asql2 .= "and procs like '%$procs%' ";

	if($ass==0)
		$ass=$att2;
	if ($ass>0)
		$asql2 .= "and dotype=$ass ";
	elseif($ass==-1)
		$asql2 .= "and dotype=0 ";
	if ($used==1)
		$asql2 .= "and visible=1 ";
	elseif ($used==2)
		$asql2 .= "and visible=0 ";
					
	$page = isset($_GET['page']) ? abs(intval ($_GET['page'])) : 1;
	$nall=intval ($_GET['nall']);
	if($nall<1)
	{
		$sql = "SELECT count(*) as a  FROM cruboy_cash where 1 $asql2 ";
		$res1 = $DB->query($sql);
		$row1 = $DB->fetch_array($res1);
		$nall=$row1[a];
	}
$start=($page-1)*200;

	$sql = "SELECT * FROM cruboy_cash where 1 $asql2 order by id desc LIMIT $start,200";
	$res = $DB->query($sql);
	//$ap = $DB->affected_rows();
	$pageurl="cash.php?word=".urlencode($word)."&ass=$ass&rule="
	.urlencode($rule)."&rule2=".urlencode($rule2)."&procs=".urlencode($procs)."&used=$used&nall=$nall&page=";
	
    include View::getView('cashview');


}


elseif($action =="edit"){
    
	$id=intval($_GET['id']);
    if($id>0){
	$v = $DB->once_fetch_array("SELECT * FROM cruboy_cash WHERE id='$id' ");
    }
	include View::getView('cashedit');
}


elseif($action =="editok"){

	$id=intval($_GET['id']);

$logData=$_POST;
	$uid=UID;
	$ltime=time();
	$gip=getIP();
	$logData[addtime]=$ltime;
		$logData[edittime]=$ltime;
			$logData[creator]=$uid;
		//$logData[end0]=	
	
	$yDate_Y=date('Y',strtotime($logData[start]));
	$md=explode('-',$logData[start]);
	for(;;)
		{
			$yYMD2=$yYMD;
			
			$yDate_Y+=$logData[nian];

$yYMD="$yDate_Y-{$md[1]}-{$md[2]}";
//echo $yYMD;
		if(strtotime($yYMD)>$ltime) break;
		};
		if(empty($yYMD2))
		{$logData[end0]=$yYMD;
		$logData['ends']=$yYMD;
			}
			else{
				$logData[end0]=$yYMD2;
		$logData['ends']=$yYMD;
				}
		//echo $yYMD2;
			print_r($logData);
		//	exit;
			echo getlv($logData['bank'],$logData['nian'],$logData['end0']);
			exit;
	if($id>0){

	  $Item = array();
		foreach ($logData as $key => $data) {
			$Item[] = "$key='".addslashes($data)."'";
		}
		$upStr = implode(',', $Item);
		$DB->query("UPDATE cruboy_cash SET $upStr WHERE id=$id");
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
		$DB->query("INSERT INTO cruboy_cash ($field) VALUES ($values)");
		$logid = $this->db->insert_id();
			$msf="添加成功！".$logid;
		}
	

	echo "<script language=\"JavaScript\">alert(\"$msf\");history.go(-2);</script>";
	exit;
}
include View::getView('footer');


function getlv($bank,$year,$date){
	$DB = MySql :: getInstance();
	if($year==0.5)
	$bb="m6";
	elseif($year==0.25)
	$bb="m3";
	else
	$bb="y".$year;
	$v = $DB->once_fetch_array("SELECT $bb FROM cruboy_lv WHERE bank='$bank' and st<'$date' order by st desc limit 1");
	return $v[$bb];
	}
?>