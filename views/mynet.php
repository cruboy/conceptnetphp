<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
	<li>
	<h3>图编辑</h3>
	<ul id="logserch">
	<form name="keycp" method="get" action="<?php echo BLOG_URL; ?>ainet.php">
	<input name="k"  type="text" value="<?php echo $akey; ?>" style="width:120px;"/>
	<input type="submit" id="logserch_logserch" value="搜索" />
	</form>
	</ul>
	</li>
<?=$atitle?>
	<?php 
foreach($concepts as $value):
?>

<div class="comcont">
&nbsp;&nbsp;
<?php if($value['visible'] >-2 ): ?>
<a href="<?php echo BLOG_URL; ?>ainet.php?cp=<?php echo $value['id']; ?>">
<?php echo $value['text']; ?></a>&nbsp;
<?php else:?>

<SPAN style="TEXT-DECORATION: line-through"><a href="<?php echo BLOG_URL; ?>ainet.php?cp=<?php echo $value['id']; ?>">
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
