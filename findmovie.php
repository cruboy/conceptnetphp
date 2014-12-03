<?php
/**
 * 视频搜索
 *
 * @copyright (c)cruboy All Rights Reserved
 * @author Zhang Yulin
 */
if(!defined('EMLOG_ROOT')) {
	exit('error!');
}

$ids = "";//搜索出的影视结果blog表gid
$clist="";//分页 影视gid集
$lognum = 0;
$result = "";

		$sourced = " 1 ";
		$table = "film";
		$pagepre = "/?fn=";


//大分类（电影、电视剧、综艺）
if ($ssortid != "") {
	$biggoal = " and sortid in ({$ssortid}) ";
} else {
	$biggoal = "";
}
//影视名称
if ($stitle != "" ) {
	$sqlSegment .= " and MATCH (title) AGAINST ('{$stitle}') ";
}
//演员导演
if ($scast != "") {
	$sqlSegment .= "and MATCH (direct,cast) AGAINST ('{$scast}') ";
}
//地区
if ($sarea != "") {
	$sqlSegment .= "and MATCH (area) AGAINST ('{$sarea}') ";
}
//影视类型
if ($smtype != "") {
	$sqlSegment .= "and MATCH (mtype) AGAINST ('{$smtype}') ";
}
//语言
if ($slang != "") {
	$sqlSegment .= "and MATCH (lang) AGAINST ('{$slang}') ";
}
//年代
if ($syear != "" && $startTime > 0 && $endTime > 0) {
	$sqlSegment .= " and (year in ('{$syear}') or releaseDate BETWEEN $startTime AND $endTime ) ";
}
elseif ($syear != "") {
	$sqlSegment .= " and year in ('{$syear}') ";
}
elseif ($startTime > 0 && $endTime > 0) {
	$sqlSegment .= " and releaseDate BETWEEN $startTime AND $endTime ";
}
//否定逻辑
if ($logicno != "") {
	$ause = str_replace(",", " ", $ause);
	$sqlSegment .= "and MATCH (excerpt) AGAINST ('{".$ause." ".$logicno."}' in boolean mode)";
}
//剩余词权重排序
if ($ause != "" ||$oword!="" && $logicno=="" ) {
	$ssqd=",MATCH (excerpt) AGAINST ('".$ause.",".$oword."') as score ";
	if($cond=="")$cond2="order by score desc";
	else $cond2=",score desc";
}

if ($sqlSegment != "" || $biggoal != "" ) {
	$searched = 1;
	$sql = "SELECT * $ssqd FROM cruboy_" . $table . " WHERE $sourced $biggoal $sqlSegment $cond $cond2 $cond3";
	if(!strstr($sql,"order")){
		$sql.="order by year desc ";
	}
	$res = $DB->query($sql);
	$lognum = $DB->num_rows($res);
	$atitle .= "影视精确搜索：";
	if (ROLE == 'admin' || ROLE == 'writer') {
		$atitle = $atitle . " " . $sql;
	}
}
elseif ($ause == "") {
	$lognum = -1;
	$searched = 0;
} else {
	$searched = 0;
}

if ($searched == 0) {
	$usess = 1;
	if ($logicno == "") {
		if($ause!=""){
			$sqlSegment = "and MATCH (excerpt) AGAINST ('{$ause}')";
		}
	} else {
		$ause = str_replace(",", " ", $ause);
		$sqlSegment = "and MATCH (excerpt) AGAINST ('{".$ause." ".$logicno."}' in boolean mode)";
	}
	$sql = "SELECT * FROM cruboy_" .  $table . " WHERE $sourced $biggoal $sqlSegment $cond $cond3";
	if(!strstr($sql,"order")){
		$sql.="order by year desc ";
	}
	$res = $DB->query($sql);
	$lognum = $DB->num_rows($res);
	$atitle .= "影视模糊搜索：";
	if (ROLE == 'admin' || ROLE == 'writer') {
		$atitle = $atitle . " " . $sql;
	}
}

if ($lognum > 0) {
	$ii = 0;
	while ($row = $DB->fetch_array($res)) {
		$logs[] = $row;
		$result = $result . $row[title]. " ";
		$ii++;
		if($ii>39)break;
	}
} else {
	$atitle = $atitle . "没找到";
}


$_SESSION['logsql']=$sql;
$_SESSION['lognum']=$lognum;
if($lognum>0){
	$_SESSION['page']=1;
	$_SESSION['nowid']=0;
}
