<?php
/**
 * Hinet with tag analysis
 * @copyright Hisense
 * Writer:zhangyulin
 */

require_once 'init.php';

define('TEMPLATE_PATH', EMLOG_ROOT.'/view/');//后台当前模板路径

$blogtitle = 'Hinet Manage-' . Option :: get('blogname');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : "hinets";
if (ISLOGIN !== true || $action == "") {
	echo "Access Denied!";
	exit ();
}
$_SESSION['goiecall']="seeker";
$uid = UID;
$DB = MySql :: getInstance();
include View::getView('header');

//set_time_limit(0);


//3.HiNet Manage
if ($action == "hinets") {
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
		$sql = "SELECT count(*) as a  FROM cruboy_enet where 1 $asql2 ";
		$res1 = $DB->query($sql);
		$row1 = $DB->fetch_array($res1);
		$nall=$row1[a];
	}
$start=($page-1)*200;

	$sql = "SELECT * FROM cruboy_enet where 1 $asql2 order by id desc LIMIT $start,200";
	$res = $DB->query($sql);
	//$ap = $DB->affected_rows();
	$pageurl="enet.php?action=hinets&word=".urlencode($word)."&ass=$ass&rule="
	.urlencode($rule)."&rule2=".urlencode($rule2)."&procs=".urlencode($procs)."&used=$used&nall=$nall&page=";
	
    include View::getView('enetview');


}

//4.HiNet Add

//5.HiNet Edit display
elseif($action =="editnet"){
    
	$id=intval($_GET['id']);
    if($id>0){
	$tpDa = $DB->once_fetch_array("SELECT * FROM cruboy_enet WHERE id='$id' ");
	$ass=$tpDa[dotype];
	$dhide=$tpDa[visible];
    }
	include View::getView('enetedit');
}

//6.HiNet Edit
elseif($action =="editnetok"){

	$id=intval($_POST['id']);
	$att=intval($_POST['ass']);
	$att2=intval($_POST['ass2']);
	$vi=intval($_POST['dhide']);
	$cv=intval($_POST['bat']);
	$word = addslashes(trim($_POST['word1']));
	$word2 = addslashes(trim($_POST['word2']));
	$word3 = addslashes(trim($_POST['word3']));
	$procs = addslashes(trim($_POST['procs']));
	$note = addslashes(trim($_POST['note']));
	if($vi==1 &&($word==""))
	{
		echo "必须填写node!";
		exit;
	}
	if($att==0)$att=$att2;
	//echo $word;
	$word=str_replace("，",",",$word);
	$word2=str_replace("，",",",$word2);
		 
	$uid=UID;
	$ltime=time();
	$gip=getIP();
	if($id>0){
	$tpDa = $DB->once_fetch_array("SELECT * FROM cruboy_enet WHERE id='$id' ");
	$tpDa[procs]=addslashes($tpDa[procs]);
	$DB->query("INSERT INTO cruboy_enetlog (oid,optsort,text,dotype, rule,rule2,procs,
	cv,note,num_assertions,visible,
	editime,creator,noweditime,nowcreator) VALUES
					('$tpDa[id]','$tpDa[optsort]','$tpDa[text]','$tpDa[dotype]','$tpDa[rule]','$tpDa[rule2]','$tpDa[procs]',
					'$tpDa[cv]','$tpDa[note]','$tpDa[num_assertions]', '$tpDa[visible]',
					 '$tpDa[editime]','$tpDa[creator]','$ltime','$uid')" );
	
	$DB->query("UPDATE cruboy_enet  set text='$word',rule='$word2',rule2='$word3',procs='$procs',note='$note',visible='$vi',dotype='$att',
	cv='$cv',editime='$ltime',creator='$uid' WHERE id='$id' ");
	$msf="修改成功！";
	}
	else{
			$DB->query("INSERT INTO cruboy_enet (text,dotype, rule,rule2,procs,cv,note,num_assertions,editime,creator,visible) VALUES
					('$word','$att','$word2','$word3','$procs','$cv','$note','0','$ltime','$uid','$vi')" );
			$id = - $DB->insert_id();
			$msf="添加成功！";
		}
	




	echo "<script language=\"JavaScript\">alert(\"$msf\");history.go(-2);</script>";
	exit;
}
include View::getView('footer');

?>