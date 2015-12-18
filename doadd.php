<?php
/**
 * mynet forzyl@gmail.com
 * @copyright (zhangyulin
*/

require_once '../init.php';

define('TEMPLATE_PATH', TPLS_PATH.Option::get('nonce_templet').'/');//前台模板路径

$blogtitle = '操作-' . Option::get('blogname');

if (ISLOGIN !== true&&(
empty($_POST[valid])||$_POST[valid]!=$_SESSION['valid'])){
echo "非法访问！请先登录！";
exit;
}
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';
$gip=getIp();   
$uid=intval(UID);
$usersina_id= intval($_SESSION['oauth2']["user_id"]);
	$DB = MySql::getInstance();


if($action == 'addcp')
{
$acidd =intval($_POST['cid']);
$cruboy =intval($_POST['cruboy']);
if($acidd>0) {
	$tabf="conceptnet";
		$vfrom="ladd";
		$acid=$acidd;
}
elseif($acidd<0){
	$tabf="cruboy";
		$vfrom="lcru";
		$acid=-$acidd;
}else
   mMsg('错误', '-1');
   $sort =intval($_POST['sort']);
$ltime = time();
if($_POST['addrel']=="#"){
$arlo =intval($_POST['addname']);
if($arlo==0)mMsg('关联log号不能为空', '-1');
$DB->query("INSERT INTO viewlog (method,viewid,concept,uid,sina_uid,date,text,loginip) VALUES (
				'$vfrom','$vsid','$acidd','$uid','$usersina_id','$ltime','$arlo','$gip')");
	$DB->query("UPDATE ".$tabf."_concept SET logid='$arlo' WHERE id='$acid'");
mMsg('log操作成功！', '-1');	
}else
$ar =intval($_POST['addrel']);
if($ar==0)
mMsg('关系号不能为空', '-1');
if($ar<-100||$ar>100)
mMsg('关系号超出范围', '-1');
if(intval($_POST['dirs'])==1)
$ar=-$ar;
$arrr=$ar;
$ro=str_replace('，',',',trim($_POST['addname']));
$ro=str_replace(' ',',',$ro);
$addnamess =addslashes($ro) ;
$addnames=explode(',',$addnamess);
$n=0;
foreach($addnames as $addname)
{
if(empty($addname))continue;	
$n++;
$msg.=$addname;
if(strlen($addname)==0 || strlen($addname)>200)
{$msg.='概念错误';continue;}

$cp0s=addslashes(trim($_POST['cp0s'])) ;
$sq1 = "SELECT * FROM ".$tabf."_concept WHERE text LIKE '$addname'";
$pDa = $DB->once_fetch_array($sq1);
$hid=$pDa['id'];
if($hid>0)
{
if($hid==$acid) {$msg.="重复".$hid;continue;}
if($sort>0)
$svv='sort='.$sort.',';
if($cruboy==-2)
$svv.='cruboy=-1,';
if(!empty($svv)){
$DB->query("UPDATE ".$tabf."_concept SET ".substr($svv,0,-1)." WHERE id='$hid'");
$msg.="U";
}
$cpaddid=-$hid;
}
else{    $cbn=0;if($cruboy==-2)$cbn=-2;
	    $DB->query("INSERT INTO ".$tabf."_concept (text,edittime,uid,visible,sort,cruboy) VALUES ('$addname',$ltime,$uid,'1',$sort,$cbn)");
		$hid = $DB->insert_id();
		$cpaddid=$hid;
		$msg.="+";
//mMsg('ok add'.$hid, '-1');
}
if($ar>0)
{
	$DB->query("UPDATE ".$tabf."_concept SET f1=f1+1,f3=f3+1 WHERE id='$acid'");
$DB->query("UPDATE ".$tabf."_concept SET f2=f2+1,f3=f3+1 WHERE id='$hid'");
$sq2 = "WHERE concept1_id='$acid' AND concept2_id='$hid' ";
$sq3 = "INSERT INTO ".$tabf."_assertion (concept1_id,concept2_id,edittime,uid,relation_id";
}
else
{
$DB->query("UPDATE ".$tabf."_concept SET f2=f2+1,f3=f3+1 WHERE id='$acid'");
$DB->query("UPDATE ".$tabf."_concept SET f1=f1+1,f3=f3+1 WHERE id='$hid'");
$ar=-$ar;
$sq2 = "WHERE concept2_id='$acid' AND concept1_id='$hid' ";
$sq3 = "INSERT INTO ".$tabf."_assertion (concept2_id,concept1_id,edittime,uid,relation_id";
}
$pDr = $DB->once_fetch_array("SELECT * FROM ".$tabf."_assertion ".$sq2);
$rid=$pDr[id];

if($ar<32)
{
$sq3=$sq3.") VALUES ('$acid','$hid',$ltime,$uid,'$ar')";
$sq4="relation_id='$ar' ";
}
else
{
$sqqq1="SELECT relation_id FROM conceptnet_frame WHERE id='$ar'";
        $qDq = $DB->once_fetch_array($sqqq1);
$sq3=$sq3.",best_frame_id) VALUES ('$acid','$hid',$ltime,$uid,'$qDq[relation_id]','$ar')";
$sq4="relation_id='$qDq[relation_id]',best_frame_id='$ar' ";
}

if($rid>0)
{
//
$DB->query("UPDATE ".$tabf."_assertion SET edittime=$ltime,".$sq4.$sq2 );
//mMsg("关系已改".$rid, '-1');
$msg.="V ";
}
else{
$DB->query($sq3);
$rid = $DB->insert_id();
$msg.="# ";
}

$sst=date('Y-m-d H:i:s', $ltime);
	$vsid=intval($_SESSION['views']);
$DB->query("INSERT INTO vaddlog (viewid,cp0,cp0id,rid,cpadd,cpaddid,relation,
     uid,sina_uid,date,dates,loginip) VALUES (
		'$vsid','$cp0s','$acidd','$arrr','$addname','$cpaddid','$rid',
		'$uid','$usersina_id','$ltime','$sst','$gip')");
}
mMsg('添加了'.$n.'个：'.$msg."C".$cpaddid."R".$rid,'');

}


function mMsg($msg, $url) {
	if(isset($_POST[valid]))
echo $msg;
else
	echo "<script language=\"JavaScript\">alert(\"$msg\");history.back();</script>";
	exit;
}

?>