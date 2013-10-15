<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
<?php echo $tinf; ?> <br>
<table border="4" width="98%">
<?php foreach($logs as $jn=>$value): ?>
<?php if($jn%2==0): ?>
<tr>
<?php endif;?>
<td width="50%">
<div class="title"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>">
<?php echo $value['rname']; ?></a> &nbsp;<a href="<?php echo $value['api'] ?>">
<font color=#999999><?php echo $value['log_title'];?></font></a> </div>
<?php echo $value['show'].' '; ?><?php echo $value['tags']; ?>
<?php echo blog_sort2($value['logid']); ?>
<?php echo $value['lovemsg']; ?>

<div class="info"><?php echo gmdate('Y-n-j', $value['date']); ?>&nbsp;
c:<?php echo $value['comnum']; ?> 查看:<?php echo $value['views']; ?> 
<?php if(ROLE == 'admin' || $value['author'] == UID): ?>
<a href="<?php echo BLOG_URL; ?>?action=write&id=<?php echo $value['logid'];?>">修改</a>
<?php endif;?>
</div>
</td>
<?php endforeach; ?>

</div>

</table>
<div id="page"><?php echo $page_url;?></div>
<?php
//blog：分类
function blog_sort2($blogid){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');?>
	<?php if(!empty($log_cache_sort[$blogid])): ?>
	[<a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a>]
	<?php endif;?>
<?php }?>
