<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
	
<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="top">
<TR>
<TD valign="top" width="65%">
	<div class="posttitle">
	
<?php if($hide=='y'): ?><SPAN style="TEXT-DECORATION:line-through">
<?php endif;echo $title; if($hide=='y'):?>
</SPAN><?php endif; ?>
</div>  <img src="/content/uploadfile/story/<?php echo $img; ?>">
<div class="postcont"><?php echo $content; ?></div>
	<?php if(ROLE =='admin'||ROLE =='writer'): ?>
temp：<div class="postcont"><?php echo $temp; ?></div>
	结果：<div class="postcont"><?php echo $excerpt; ?></div>
	<?php endif;?>
	<div class="postinfo">查看:<?php echo $views; ?> &nbsp;t:<?php echo $tbcount; ?>&nbsp;c:<?php echo $comnum; ?>&nbsp;a:<?php echo $attnum; ?> 
	添加时间: <?php echo gmdate('Y-n-j G:i l', $date); ?>
	</div>
	<br>
	<a href="<?php $a=$gid-1;echo BLOG_URL."m/?sid=".$a; ?>"  >【上一部】</a>--------
	<a href="<?php $b=$gid+1;echo BLOG_URL."m/?sid=".$b; ?>"  >【下一部】</a>
</TD>

<TD >

	<div class="t"></div>
	<div class="c">

	</div>
</TD>
</TR>
</TABLE>	
</div>