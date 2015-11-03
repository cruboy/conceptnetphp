<?php if(!defined('EMLOG_ROOT')) {
    exit('error!');
}?>

<div class="comcont">
	<?php 
while ($value = $DB->fetch_array($res)) {
?>
&nbsp;&nbsp;
<a href="<?=$lik?><?php echo $value['id']; ?>"
 style="font-size:<? if($value['f3']>500)echo '24';elseif($value['f3']>100)echo '22';elseif($value['f3']>50)echo '20';elseif($value['f3']>10)echo '18';else echo "16";?>px" title="<?php echo $value['f3']; ?>">
<?php echo $value['text']; ?></a>
<?php } ?>
</div>

<div id='page'>
	<?php echo pagination($nall, 1000, $page, $pageurl); ?>
</div>
