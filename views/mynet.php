<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
	    	<li>
	<h3><span>ainet search</h3>
	<ul id="logserch">
	<form name="keycp" method="get" action="<?php echo BLOG_URL; ?>m/ainet.php">
	<input name="keyword"  type="text" value="" style="width:120px;"/>
	<input type="submit" id="logserch_logserch" value="搜索" />
	</form>
	</ul>
	</li>
<?php echo $atitle;?>    
	<?php 
foreach($logs1 as $value1):
?>
<div class="title"><a href="<?php echo BLOG_URL; ?>m/?post=<?php echo $value1['gid'];?>"><?php echo $value1['title']; ?></a></div>
<?php echo gmdate('Y-n-j', $value['date']); ?>&nbsp;查看:<?php echo $value1['views']; ?> <br>
<?php echo $value1['content']; ?> 
<?php endforeach; ?>

	<?php 
foreach($concepts as $value):
?>

<div class="comcont">
&nbsp;&nbsp;
<?php if($value['visible'] == true ): ?>
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=<?php echo $value['id']; ?>">
<?php echo $value['text']; ?></a>&nbsp;
<?php else:?>

<SPAN style="TEXT-DECORATION: line-through"><a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=<?php echo $value['id']; ?>">
<?php echo $value['text']; ?></a></SPAN>&nbsp;
<?php endif;?>

：<?php echo $value['f3']; ?>
：c:<?php echo $value['num_assertions']; ?>
<?php echo "-->".$value['re1'].".".$value['fi1'].$value['tx1']; ?>||
<?php echo "<--".$value['re2'].".".$value['fi2'].$value['tx2']; ?>
</div>


<?php endforeach; ?>
</div>
<div id="page"><?php echo $pageurl;?></div>
</div>
