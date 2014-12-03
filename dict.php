<?php
/**
 * 词库管理
 *
 * @copyright Hisense All Rights Reserved
 */
require_once '../init.php';
define('TEMPLATE_PATH', EMLOG_ROOT.'/m/view/');//后台当前模板路径

$blogtitle = 'Hinet Analysis-' . Option :: get('blogname');
if (ISLOGIN !== true ) {
	echo "Access Denied!";
	exit ();
}

//标题样式处理用
$action="dict";
include View::getView('header');

$DB = MySql2 :: getInstance();
$uid = UID;
$ltime = time();
$updIp = getIP();

//词库管理
//取得POST值
$opt = $_GET['opt']; //操作类型
$word = trim($_GET['word']); //操作词
$wid=intval($_GET['wid']);
$wordFlg = trim($_GET['wordFlg']); //词语标记
$wordold = trim($_GET['wold']);
$useas=$wordFlg;

//更新值判断
//操作类型
if ($opt == "") {
	$opt = "sch";
}

//操作词
if ($opt == "upd" && $word == "" && $wid==0) {
	echo "请输入要操作的词语或ID！";
	exit ();
}
if(isset($_GET['action'])){
	$act=$_GET['action'];
	if($act=="restart"||$act=="stop"||$act=="start"||$act=="runs"){
		echo $act." segment server...<br>";
		$killer= isset($_GET['kill'])&& intval($_GET['kill'])>0 ? intval($_GET['kill']):
		exec("ps aux | grep java | grep JavaBridge | grep :8000 |sed -n 1p | awk '{print $2}'",$out,$st);
		echo "to kill $killer<br>";
		if($act=="restart"||$act=="stop"){
			exec("ps aux | grep java | grep JavaBridge",$out,$st);
			echo "now these runs:<br>";
			foreach($out as $aww) echo $aww."<br>";
			exec("kill ".$killer,$out,$st);
			echo "result: $st <br>";
			if($st!=0) {
				$addinfo.="kill error ".$st;
				echo "Kill wordseg error!<br>";
			}
		}
		
		if($act=="restart"||$act=="start"){
			//exec("java -jar -Xms256m -Xmx512m  /srv/JavaBridge.jar SERVLET_LOCAL:8000 &>/dev/null &");
			$fp = @popen("java -jar -Xms256m -Xmx512m  /srv/JavaBridge.jar SERVLET_LOCAL:8000 &>/dev/null &","r");
			@pclose($fp);
			echo "Restarted!<br>";
		}

		exec("ps aux | grep java | grep JavaBridge",$outb,$st);
		echo "now runs:<br>";
		foreach($outb as $awwb) {
			echo $awwb."<br>";
			$addinfo.=$awwb."<br>";
		}
		echo "<a href='/m/dict.php?action=stop&kill='>停止</a><br>";
		echo "<a href='/m/dict.php?action=start'>启动</a><br>";
		echo "<a href='/m/dict.php?action=restart'>重启</a><br>";
		echo "<a href='".BLOG_URL."/'>返回</a><br>";

		$ltime = time();
		$gip = getIP();
		$uid = UID;
		$sst=date('Y-m-d H:i:s', $ltime);
		$DB->query("INSERT INTO " . DB_PREFIX2 ."oplog (date,cycle,dtime,action,tab,colum,
				linestart,lineend,addinfo,att,ip,opter) VALUES (
				'$ltime','$cycle','$sst','$act','$datafor','','$first','$lsid','$addinfo','$att','$gip','$uid')");
	}
	elseif($act=="log"){
		$acll=isset($_GET['ac'])?$_GET['ac'] : "wordseg";
		echo "wordseg log $acll :<br>";
		$sql = "SELECT * FROM " . DB_PREFIX2 . "oplog where action='$acll' order by id ";
		$res = $DB->query($sql);
		while ($row = $DB->fetch_array($res)) {
			echo $row['id']." ".$row['dtime']." ".$row['cycle']." ".$row[action]."
			<font color=red>".$row['tab']." ".$row['colum']." ".$row['linestart']."-".$row['lineend']." "."</font> ".$row['addinfo']."<br>";
		}
	}
	exit;
}
//词语标记
if ($wordFlg != "") {
	$whereSql = " AND $wordFlg = '1' ";
	$whers = " $wordFlg = '1', ";
} else {
	$whereSql = "";
	$whers="";
}

//查询词为空时
if ($word == "") {
	$wordSql = " ";
} elseif($opt == "sch"){
	$wordSql = " AND WORD LIKE '$word%' ORDER BY WORD ";
}
elseif($opt == "sch1"){
	$wordSql = " AND WORD LIKE '%$word' ";
}
elseif($opt == "sch2"){
	$wordSql = " AND WORD LIKE '%$word%' ";
}
elseif($opt == "sch3"){
	$wordSql = " AND WORD = '$word' ";
}

//wordold
if($wordold=="temp"){
	$whereSql = "and FILMNAME=2  AND DELFLG=0 ";
}
elseif($wordold=="step"){
	$whereSql .= " AND step>0 ";
}
elseif($wordold!=""){
	$whereSql .= " AND $wordold = '2' ";
}
$wold=$wordold;

//操作类型：查询
if ($opt == "sch"||$opt == "sch1"||$opt == "sch2"||$opt == "sch3") {
	$page = isset($_GET['page']) ? abs(intval ($_GET['page'])) : 1;
	$nall=intval ($_GET['nall']);
	if($nall<1){
		$sql = "SELECT count(*) as a  FROM " . DB_PREFIX2 . "maindict WHERE 1=1 $whereSql $wordSql ";
		$res1 = $DB->query($sql);
		$row1 = $DB->fetch_array($res1);
		$nall=$row1[a];
	}
	$start=($page-1)*100;
	
	//词库管理
	$selectSql = "SELECT * FROM " . DB_PREFIX2 . "maindict WHERE 1=1 $whereSql $wordSql  LIMIT $start,100";
	$res = $DB->query($selectSql);
	include View::getView('dictview');
	include View::getView('footer');
	exit;
}

//词库管理--批量处理词
elseif ($opt == "updid") {
	$wids = isset($_POST['wids']) ? $_POST['wids'] : '';
	if(!$wids){
		echo "你没有选择任何词！";
		exit;
	}
	
	$updNum = 0;
	$updNum1 = 0;
	$updNum2 = 0;
	$i = 0;
	
	$useas= $_POST['wordF'];
	if($useas!=""){
		$whers = " $useas = '1', ";
	}else{
		$whers = "";
	}
	
	foreach($wids as $wdid=>$value){
		$i++;

		//词存在检查语句
		$tpDa = $DB->once_fetch_array("SELECT * FROM " . DB_PREFIX2 . "maindict WHERE ID = $wdid");
		$tag=$tpDa[WORD];
		$addchg="";
		
		if($tpDa[QUANTIFIER]==1 && $useas!="QUANTIFIER")
			$addchg.=",QUANTIFIER=2";
		if($tpDa[STOPWORD]==1 && $useas!="STOPWORD")
			$addchg.=",STOPWORD=2";
		if($tpDa[FILMTYPE]==1 && $useas!="FILMTYPE")
			$addchg.=",FILMTYPE=2";
		if($tpDa[FILMNAME]==1 && $useas!="FILMNAME")
			$addchg.=",FILMNAME=2";
		if($tpDa[ACTORANDDIRECTOR]==1 && $useas!="ACTORANDDIRECTOR")
			$addchg.=",ACTORANDDIRECTOR=2";
		if($tpDa[DELFLG]==1 && $useas!="DELFLG")
			$addchg.=",DELFLG=0";

		$DB->query("UPDATE " . DB_PREFIX2 . "maindict SET $whers opter='$uid',lastuptime='$ltime' $addchg  WHERE ID ='$wdid' ");
		echo $tag . " ";
		$lsid =$tpDa[ID];
		$updNum1++;
		
		$typeb=str_replace("=2", "", $addchg);

		$DB->query("INSERT INTO " . DB_PREFIX2 . "maindict_log (cid,WORD, typebefore,typeupto,opter,UPDIP, UPDTIME) VALUES
				('$lsid','$tag','$typeb','$useas', '$uid','$updIp', '$ltime')" );
		$updNum++;
	}
	echo "<br>处理 $updNum 个属性为 $useas 的词，更新 $updNum1 个 ";
}

//更新
elseif ($opt == "upd") {
	$word = str_replace("，", ",", $word);
	$words= explode(",", $word);
	$ltime = time();
	$updIp = getIP();
	$updNum = 0;
	$updNum1 = 0;
	$updNum2 = 0;
	$i = 0;

	while ($words[$i]!="" || $wid>0) {
		$tag = $words[$i];

		$i++;

		//词存在检查语句
		if($wid>0){
			$tpDa = $DB->once_fetch_array("SELECT * FROM " . DB_PREFIX2 . "maindict WHERE ID= $wid ");
			$tag = $tpDa[WORD];
		}else{
			$tpDa = $DB->once_fetch_array("SELECT * FROM " . DB_PREFIX2 . "maindict WHERE WORD like '$tag'");
		}

		$wid=0;
		if($tpDa[ID]>0){
			$addchg="";
			if($tpDa[QUANTIFIER]==1&& $useas!="QUANTIFIER"){
				$addchg.=",QUANTIFIER=2";
			}
			if($tpDa[STOPWORD]==1&& $useas!="STOPWORD"){
				$addchg.=",STOPWORD=2";
			}
			if($tpDa[FILMTYPE]==1&& $useas!="FILMTYPE"){
				$addchg.=",FILMTYPE=2";
			}
			if($tpDa[FILMNAME]==1&& $useas!="FILMNAME"){
				$addchg.=",FILMNAME=2";
			}
			if($tpDa[ACTORANDDIRECTOR]==1&& $useas!="ACTORANDDIRECTOR"){
				$addchg.=",ACTORANDDIRECTOR=2";
			}
			if($tpDa[DELFLG]==1 && $useas!="DELFLG"){
				$addchg.=",DELFLG=0";
			}

			$DB->query("UPDATE " . DB_PREFIX2 . "maindict SET $whers opter='$uid',lastuptime='$ltime' $addchg  WHERE ID ='$tpDa[ID]' ");
			echo $tag . " ";
			$lsid =$tpDa[ID];
			$updNum1++;
			$typeb=str_replace("=2", "", $addchg);
		}else{
			if($useas!=""){
				$insertSql = "INSERT INTO " . DB_PREFIX2 . "maindict ( WORD, $useas, opter, lastuptime) VALUES( '$tag', 1, '$uid', '$ltime')";
			}else{
				$insertSql = "INSERT INTO " . DB_PREFIX2 . "maindict ( WORD, opter, lastuptime) VALUES( '$tag', '$uid', '$ltime')";
			}

			$DB->query($insertSql);
			$lsid = - $DB->insert_id();
			echo "+".$tag . " ";
			$updNum2++;
		}

		$DB->query("INSERT INTO " . DB_PREFIX2 . "maindict_log (cid,WORD, typebefore,typeupto,opter,UPDIP, UPDTIME) VALUES
				('$lsid','$tag','$typeb','$useas', '$uid','$updIp', '$ltime')" );
		$updNum++;
	}
	echo "<br>处理 $updNum 个属性为 $useas 的词，更新 $updNum1 个，新增 $updNum2 个 ";
}