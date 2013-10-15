<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
	
<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="top">
<TR>
<TD valign="top" width="65%">
	<div class="posttitle"><?php echo $rname; ?></div>&nbsp;<?php echo $title; ?><font color=red> <?php echo $aka; ?></font>
	<div class="postinfo">年代: <?php echo $year; ?>&nbsp;地区: <?php echo $area; ?>&nbsp;语言: <?php echo $lang; ?>
	</div>
	 <div class="postinfo2">类型: <?php echo $mtype; ?>&nbsp;<?php blog_sort($gid); ?>&nbsp;</div>
	
	<div class="postcont"><?php blog_tag($gid); ?> <br>导演：<?php echo $direct; ?><br>演员：<?php echo $cast; ?></div>
	
	内容简介：<div class="postcont"><?php echo $content; ?></div>
	分词1：<div class="postcont"><?php echo $content1; ?></div>
	分词2：<div class="postcont"><?php echo $content2; ?></div>

	结果：<div class="postcont"><?php echo $excerpt; ?></div>
	
	<div class="postinfo">查看:<?php echo $views; ?> &nbsp;t:<?php echo $tbcount; ?>&nbsp;c:<?php echo $comnum; ?>&nbsp;a:<?php echo $attnum; ?> 
	添加时间: <?php echo gmdate('Y-n-j G:i l', $date); ?>
	</div>
	
	
</TD>

<TD >
	<div class="t">评论：</div>
	<div class="c">
		<?php foreach($commentStacks as $cid):
			$comment = $comments[$cid];
			$comment['poster'] =  '<a href="?post='.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' ;
		?>
		<div class="l">
	
			<div class="comcont"><?php echo $comment['content']; ?>	
		</div><div class="info"><?php echo $comment['date']; ?>
		<b><?php echo $comment['poster']; ?></b>
		 <a href="./?action=reply&cid=<?php echo $comment['cid'];?>">回复</a></div>
	</div>
		<?php endforeach; ?>
		<div id="page"><?php echo $commentPageUrl;?></div>
	</div>
	<div class="t">发表评论：</div>
	<div class="c">
		<form method="post" action="./index.php?action=addcom&gid=<?php echo $gid; ?>">
		<textarea name="comment" rows="10"></textarea><br />
		<input type="submit" value="发表评论" />
		</form>
	</div>
</TD>
</TR>
</TABLE>	
</div>