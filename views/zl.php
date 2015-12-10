<?php if(!defined('EMLOG_ROOT')) {
    exit('error!');
}?>
<script type="text/javascript" src="/content/js/jquery-1.8.2.min.js"></script>

<script>
function ch(id,t){
	$.ajax({url:'admin.php?action=ch',type:'POST',
				data:{id:id},
				success: function(data){ 
				//alert(data);
				if(data=='0')
			$(t).css("text-decoration","line-through");
			//$(t).css("background-color","yellow");
				else
			$(t).css("text-decoration","none");

				}});

}
</script>
<div class="comcont">
	<?php 
while ($value = $DB->fetch_array($res)) {
?>
&nbsp;&nbsp;
<span onclick='ch(<?php echo $value['id']; ?>,this)' 
 style=" <? if($value['hn']) echo 'background-color:#a4a;';
 if(!$value['visible']) echo 'text-decoration:line-through;'; ?>font-size:<? 
 if($value['f3']>500)echo '24';elseif($value['f3']>100)
 echo '22';elseif($value['f3']>50)echo '20';elseif($value['f3']>10)echo '18';else echo "16";
 ?>px" title="<?php echo $value['id'].' '.$value['f3']; ?>">
<?php echo $value['text']; ?></span>
<?php } ?>
</div>

<div id='page'>
	<?php echo pagination($nall, 1000, $page, $pageurl); ?>
</div>
