<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
    <li>
	<h3><span>认知网格</span></h3>
	<ul id="logserch">
	<form name="keycp" method="post" action="<?php echo BLOG_URL; ?>m/index.php">
	<input name="aikey"  type="text" value="<?php echo $akey; ?>" style="width:120px;"/>
    <input name="valid"  type="hidden" value="<?=$valid?>" />
	<input type="submit" id="logserch_logserch" value="搜索" />
	</form>
	</ul>
<?php echo $atitle;?>    

	<?php 
foreach($concepts as $value):
?>

<div class="comcont">
&nbsp;&nbsp;



<SPAN <?php if($value['visible'] == false ): ?>style="TEXT-DECORATION: line-through" <?php endif;?>onclick='dotu(<?php echo $value['id']; ?>);' title='<?php echo $value['f3']; ?>'>
<?php echo $value['text']; ?></SPAN>&nbsp;&nbsp;&nbsp;&nbsp;

<SPAN title='<?php echo $value['fi1']; ?>' onclick='dotu(<?php echo $value['id1']; ?>);' >
<?php echo $value['tx1']; ?></SPAN>&nbsp;&nbsp;
&nbsp;&nbsp;
<SPAN title='<?php echo $value['fi2']; ?>' onclick='dotu(<?php echo $value['id2']; ?>);' >
<?php echo $value['tx2']; ?></SPAN>

<?php endforeach; ?>
</div>
<div id="page"><?php echo $pageurl;?></div>
</div>
<SCRIPT stype=text/javascript>
 function dotu(id){
	  var temp = document.createElement("form");         
   temp.action = '/m/index.php';         
   temp.method = "post";         
   temp.style.display = "none"; 
   var opt = document.createElement("input");         
      opt.name = 'cp';         
        opt.value = id;         
       temp.appendChild(opt);  
	   opt = document.createElement("input"); 
	      opt.name = 'valid';         
        opt.value = <?php echo $valid;?>;         
       temp.appendChild(opt); 
   document.body.appendChild(temp);         
   temp.submit();         
   return temp;
 }
</script>