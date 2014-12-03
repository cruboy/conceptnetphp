<?php
/**
 * 视频信息展示页面（播放）
 * 张钰林
 */
if(!defined('EMLOG_ROOT')) {
	exit('error!');
}

//链接打开用$mvid
//搜索页按名纠错打开用$mv_nnum
//搜索页按个用$mv_fnum
//翻页用$_SESSION['nowid']
if($mvid==0){
	$clist =  ($_SESSION['clist']);
	$clists = explode(",",$clist);
	if($mv_nnum>0) {
		$aa=$_SESSION['page']==ceil($_SESSION['lognum']/8)? $_SESSION['lognum']%8:8;
		$start=($_SESSION['page']-1)*8+$aa -$mv_nnum;
	}elseif($mv_fnum>0)
		$start=($_SESSION['page']-1)*8+$mv_fnum-1;
	else
		$start=$_SESSION['nowid'];
	
	$_SESSION['nowid']=$start;
	$start=$start%8;
	$mvid=$clists[$start];
}

if($mvid>0){
	$sql = "SELECT * FROM hi_blog WHERE gid='$mvid' ";
	$stDa = $DB->once_fetch_array($sql);
	if($stDa[content]==""){
		if($stDa[sid]>0)
		{
			$sql = "SELECT content FROM hi_cntvfilms WHERE sid='$stDa[sid]' ";
			$stDa2 = $DB->once_fetch_array($sql);
			$stDa[content]=$stDa2[content];
		}
		elseif($stDa[aid]>0)
		{
			$sql = "SELECT content FROM hi_huashu WHERE aid='$stDa[aid]' ";
			$stDa2 = $DB->once_fetch_array($sql);
			$stDa[content]=$stDa2[content];
		}
	}
}
?>
<div align="center">
	<div id="m1">
		<TABLE
			style="width: 98%; border: 0; cellspacing: 0; cellpadding: 0; align: top;">
			<TR>
				<TD valign="top" width="65%">
					<div class="posttitle">
						<?php if($stDa[hide]=='y'): ?>
						<SPAN style="TEXT-DECORATION: line-through"> <?php endif;echo $stDa[title]; if($stDa[hide]=='y'):?>
						</SPAN>
						<?php endif; ?>
						<font color=red><?php if($stDa[aka]!=''||$stDa[rname]!=''){ 
							echo "（".$stDa[aka]."  ";echo $stDa[rname]."）";
						} ?>
						</font>
					</div>
					<div class="postinfo">
						年代:
						<?php echo $stDa[year]; ?>
						地区:
						<?php echo $stDa[area]; ?>
						语言:
						<?php echo $stDa[lang]; ?>
					</div>
					<div class="postinfo2" style="display: none;">
						创建时间:
						<?php echo $stDa[createdate]; ?>
						sid:
						<?php echo $stDa[sid]; ?>
						pid:
						<?php echo $stDa[aid]; ?>
					</div>
					<div class="postcont1">
						类型:
						<?php echo $stDa[mtype]; ?>
						<br>导演：
						<?php echo $stDa[direct]; ?>
						<br>演员：
						<?php echo $stDa[cast]; ?>
					</div>
					<div class="postcont1">
						内容简介： <br>
						<?php echo $stDa[content]; ?>
					</div>
					<div class="postinfo1">
						版权:
						<?php echo $stDa[copyRight]; ?>
						查看:
						<?php echo $stDa[views]; ?>
						添加时间:
						<?php echo gmdate('Y-n-j G:i l', $stDa[date]); ?>
					</div> <br>
				</TD>
				<TD>
					<div class="c">
						<img
							src='<?php if($stDa['pic']!="")echo $stDa['pic']; else echo "/content/images/nopic.jpg" ?>'
							style="width: 240px; height: 370px;" />
					</div>
				</TD>
			</TR>
		</TABLE>
	</div>
</div>