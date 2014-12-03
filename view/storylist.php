<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
<?php echo $tinf; 
?> <br>
<table width="98%" cellspacing=2 cellpadding=2 style="border-collapse: collapse; border:1px dotted #cc0000">
<?php foreach($logs as $jn=>$value): ?>
<?php if($jn%4==0): ?>
<tr style="background-color:#DDDDDD;">
<?php elseif($jn%2==0):?>
<tr>
<?php endif;?>
<td width="50%" style="border-collapse: collapse; border:1px dotted #cc0000">

<div class="title"><a href="<?php echo BLOG_URL; ?>m/?sid=<?php echo $value['gid'];?>">
<img src="/content/uploadfile/story/<?php echo $value['img']; ?>">
</a> 
<a href="<?php echo BLOG_URL; ?>m/?sid=<?php echo $value['gid'];?>">
<?php echo $value['title']; ?></a> 
</div>
<?php echo subString($value['content'],0,210); ?>
<div class="info"><?php echo gmdate('Y-n-j', $value['date']); ?>&nbsp;
查看:<?php echo $value['views']; ?>  
<?php if(ROLE == 'admin' || $value['author'] == UID): ?>
 <a href="<?php echo $value['api'] ?>">api</a>
<?php endif;?>
</div>
</td>
<?php if(($jn+1)%2==0): ?>
</tr>
<?php endif;?>
<?php endforeach; ?>
</div>
</table>
<div id="page"><?php echo $page_url;?></div>

