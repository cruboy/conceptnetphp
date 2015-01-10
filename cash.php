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
	exit ();
}

$uid = UID;
$DB = MySql :: getInstance();
include View::getView('header');

//set_time_limit(0);


//3.HiNet Manage
if ($action == "") {
	$opt = $_GET['opt'];
	if(empty($opt)) $opt='id';
	
	$word = trim($_GET['bank']);
	$rule = trim($_GET['name']);
    $used=intval($_GET['used']);

      $asql2 = "";
	if ($word != "")
		$asql2 .= "and bank like '$word' ";
		
     if ($rule != "")
		$asql2 .= "and name like '$rule' ";	
		
	if ($used==0)
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

	$sql = "SELECT * FROM cruboy_cash where 1 $asql2 order by $opt ";
	$res = $DB->query($sql);
	//$ap = $DB->affected_rows();
$pageurl="/m/cash.php?bank=$word&name=$rule&used=$used&opt=";
	
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
	$xil="";
	$yYMD=$logData['start'];

	for(;;)
		{
			$yYMD2=$yYMD;
			$xit2=$xit;
			
		$lv= getlv($logData['bank'],$logData['nian'],$yYMD);
	$xitt=$logData['money']*0.01*$logData['nian']*$lv;
	$xit+=$xitt;
	$xil.=$yYMD.'*'.$lv.' '.$xit.' ';	
			$yDate_Y+=$logData[nian];

$yYMD="$yDate_Y-{$md[1]}-{$md[2]}";
//echo $yYMD;
$xit3=$xitt;
		if(strtotime($yYMD)>$ltime) break;
		};
		

		$logData[end0]=$yYMD2;
		$logData['ends']=$yYMD;
		$logData['lilv']=$lv;
$logData['lixi0']=$xit2;
$logData['lixi']=$xit3;
$logData['notexi']=$xil;
			print_r($logData);
			//exit;
		//	echo getlv($logData['bank'],$logData['nian'],$logData['end0']);
			//exit;
	if($id>0){
       if(empty($logData['visible'])){
	   $upStr="visible=0";
	   }
	   else{
	  $Item = array();
		foreach ($logData as $key => $data) {
			$Item[] = "$key='".addslashes($data)."'";
		}
		$upStr = implode(',', $Item);
	   }
		$DB->query("UPDATE cruboy_cash SET $upStr WHERE id=$id");
	$msf="修改成功！";
	}
	else{
		 if(empty($logData['visible'])){
	     $logData['visible']=0;
	   }
		$kItem = array();
		$dItem = array();
		foreach ($logData as $key => $data) {
			$kItem[] = $key;
			$dItem[] = addslashes($data);
		}
		$field = implode(',', $kItem);
		$values = "'" . implode("','", $dItem) . "'";
		$DB->query("INSERT INTO cruboy_cash ($field) VALUES ($values)");
		$logid = $DB->insert_id();
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