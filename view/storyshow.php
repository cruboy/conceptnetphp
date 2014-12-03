<?php
if(!defined('EMLOG_ROOT'))
	exit('error!');

//链接打开用$mcid
//搜索页按名纠错打开用$mc_nnum
//搜索页按个用$mc_fnum
//翻页用$_SESSION['nowidm']
if($mcid==0){
	$clist =  ($_SESSION['musicids']);
	$clists = explode(",",$clist);

	if($mc_nnum>0){
		$aa=$_SESSION['pagem']==ceil($_SESSION['musicnum']/10)? $_SESSION['musicnum']%10:10;
		$start=($_SESSION['pagem']-1)*10+ $aa-$mc_nnum;
	}elseif($mc_fnum>0)
	$start=($_SESSION['pagem']-1)*10+$mc_fnum-1;
	else
		$start=$_SESSION['nowidm'];
	$_SESSION['nowidm']=$start;

	$start=$start%10;
	$mcid=$clists[$start];
}

if($mcid>0){
	$sql = "SELECT * FROM hi_music WHERE gid='$mcid' ";
	$stmDa = $DB->once_fetch_array($sql);
	echo " <div align=\"center\"";
	
	if(!isset($_SESSION['musiccontent'])||$_SESSION['musiccontent']==0)
		echo " style='display:none;'";
	
	echo "><iframe id=\"mainFrame2\"  width=\"830\" height=\"640\"
	src=\"".$stmDa['url']."\" frameborder=\"0\"></iframe></div>";
}
else
	echo "错误！";

if(!isset($_SESSION['musiccontent'])||$_SESSION['musiccontent']==0):
?>
<font style="font-size: 14; font-family: 楷体; color: olive;"><?php echo "播放 《".$stmDa['title']."》"; ?>
</font>
<br />
<br />
<div width='700px' height='510px'>
	<img src="./content/images/musicplayer.jpg" />
</div>
<?php endif;?>