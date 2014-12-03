<?php
/**
 * 视频搜索结果显示
 *	<div style="WIDTH: 170px; HEIGHT: 190px; align: center;">
								<br>
								<img src='<?php
									if($value['pic']!=""){
										echo $value['pic'];
									}else{
										echo "/content/images/nopic.jpg";
									} ?>'
									style="WIDTH: 170px; HEIGHT: 190px;" />
							</div>
 * @copyright (c) All Rights Reserved
 * @author Zhang Yulin
 */
if(!defined('EMLOG_ROOT')) {
	exit('error!');
}

if(count($logs)==0 && $_SESSION['logsql']!="" && $_SESSION['page']>0){
	$DB = MySql :: getInstance();
	$sstt= ($_SESSION['page'] -1)*40;
	$sqlt=$_SESSION['logsql'];
	if(!strstr($sqlt,"limit")){
		$sqlt.="limit  $sstt,40 ";
	}
	
	$res = $DB->query($sqlt);
	while ($row = $DB->fetch_array($res)) {
		$logs[] = $row;
	}
}
//imgurl='/seeker.php?re=9&k=prepage';
 //           imgurl='/seeker.php?re=9&k=nextpage';
?>
  

<div align="center">
<?php
	if($_SESSION['lognum']==0) {
		$voice="没有找到结果！";
		echo $voice;
	}
	if($_SESSION['lognum']>0) {
		//设定页面显示信息
		$tempFilmNum = $_SESSION['lognum'];
		$tempPageNum = $_SESSION['page'];
		$tempDisplayInfo = "找到视频".$tempFilmNum."个（第".$tempPageNum."/".ceil($tempFilmNum/40)."页）";
		echo "<font style='font-size: 14;font-family: 楷体;color:olive;'>";
		echo $tempDisplayInfo;
		echo "</font>";

		//设定语音合成内容
		if($_SESSION['page']==1 && $_SESSION['nowid']==0)
			$voice="找到视频".$tempFilmNum."个";
	}
	echo $vmsg;
?>
	<table
			style="width: 700px; height: 400px; align: center; border: 0px dotted #006666; padding: 0; margin: 0;">
			<?php
			$_SESSION['logtitle'] = "";
			$_SESSION['clist'] = "";
			
			foreach($logs as $jn=>$value):
			$pttitle = str_replace(",","",$logs[$jn]['title']);
			
			$_SESSION['logtitle'] .= $pttitle.",";
			$_SESSION['clist'] .= $logs[$jn]['gid'].",";
	
			if($jn%4==0):
			?>
			<tr>
			<?php endif; ?>
				<td>
					<div style="text-align: center; font-family: 楷体; font-size: 12">
						<div class="pic">
						
							<div class="title" style="WIDTH: 170px; HEIGHT: 15px; text-align: center;">
								<a href="<?php echo BLOG_URL."m/?fn=".$value['gid'];?>">
									<?php echo $value['title']; ?>
								</a>
								<?php if($value['rname'])echo "(".$value['rname'].")";?>
							</div>
						</div>
					</div>
				</td>
			<?php if($jn+1%4==0): ?>			
			<tr>
			<?php endif; ?>
			<?php endforeach; ?>		
		</table>
	</div>
</div>

