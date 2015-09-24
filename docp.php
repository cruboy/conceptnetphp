<?php
/**
 * jitongr
*/

require_once '../init.php';

if (ISLOGIN !== true){
//empty($_SESSION['oauth2']["user_id"])||empty($_SESSION['u_name']))){
echo "请先登录或授权！";
exit;
}

$gip=getIp();   
$uid=UID;

	$DB = MySql::getInstance();
$cpidd=intval($_GET['cp']);
			if($cpidd<0){
				$tabf="cruboy";
				$vfrom="jcru";
				$cpid=-$cpidd;
			}elseif($cpidd>0){
				$tabf="conceptnet";
				$vfrom="jind";
				$cpid=$cpidd;
			}
			else{
				echo "错误";exit;
				}
			
if(isset($_GET['ecdid'])){

	$id=intval($_GET[ecdid]);

	$uid=UID;
	$ltime=time();
	$gip=getIP();
	$_POST['edittime']=$ltime;
	  $Item = array();
		foreach ($_POST as $key => $data) {
			$Item[] = "$key='".addslashes($data)."'";
		}
		$upStr = implode(',', $Item);
		$DB->query("UPDATE ".$tabf."_concept SET $upStr WHERE id=$id");
	   $msf="修改成功！".$id;
		 
	echo $msf;
	exit;
}
elseif(isset($_GET['aid'])){

		$id=intval($_GET['aid']);

	$uid=UID;
	$ltime=time();
	$gip=getIP();
	$_POST['edittime']=$ltime;
	  $Item = array();
		foreach ($_POST as $key => $data) {
			$Item[] = "$key='".addslashes($data)."'";
		}
		$upStr = implode(',', $Item);
		$DB->query("UPDATE ".$tabf."_assertion SET $upStr WHERE id=$id");
	   $msf="修改成功！".$id;
		 
	echo $msf;
}
elseif(isset($_POST['iid'])){
   $x=intval($_POST['x']);
   $y=intval($_POST['y']);
	if($_POST['iid']==3){
		$DB->query("UPDATE ".$tabf."_concept SET ctop=$y,cleft=$x WHERE id=$cpid");
	}
	else if(!empty($_POST['iid'])){
		$fx=substr($_POST['iid'],-1,1);
		$rid=substr($_POST['iid'],0,-1);
		$DB->query("UPDATE ".$tabf."_assertion SET itop{$fx}=$y,ileft{$fx}=$x WHERE id=$rid");
	}
	else if(!empty($_POST['id'])){
		$fx=substr($_POST['id'],-1,1);
		$rid=substr($_POST['id'],0,-1);
		$DB->query("UPDATE ".$tabf."_assertion SET atop{$fx}=$y,aleft{$fx}=$x WHERE id=$rid");
		}
	print_r($_POST);
	}
function mMsg($msg, $url) {
	echo "<script language=\"JavaScript\">alert(\"$msg\");history.back();</script>";
	exit;
}

?>