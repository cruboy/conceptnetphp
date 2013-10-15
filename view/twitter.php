<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
<?php if(ISLOGIN === true): ?>
<form method="post" action="./index.php?action=t" >
<input name="t" value="" /> <input type="submit" value="发碎语" />
</form>
<?php endif;?>
<?php 
foreach($tws as $value):
$by = $value['author'] != 1 ? 'by:'.$user_cache[$value['author']]['name'] : '';
?>
<div class="twcont"><?php echo $value['content'];?></a></div>
<div class="twinfo"><?php echo $by.' '.$value['date'];?>
<?php if(ISLOGIN === true && $value['author'] == UID || ROLE == 'admin'): ?>
 <a href="./?action=delt&id=<?php echo $value['id'];?>">删除</a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $pageurl;?></div>
</div>