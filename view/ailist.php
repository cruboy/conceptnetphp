<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
    <li>
	<h3><span>概念</span></h3>
	<ul id="logserch">
	<form name="keycp" method="post" action="<?php echo BLOG_URL; ?>?action=ailist">
	<input name="aikey"  type="text" value="<?php echo $akey; ?>" style="width:120px;"/>
    <input name="valid"  type="hidden" value="<?=$valid?>" />
	<input type="submit" id="logserch_logserch" value="搜索" />
	</form>
	</ul>
<?php echo $atitle;?>    

	<?php 
	if(ISLOGIN === true)
foreach($concepts as $value){
?>

<div class="comcont" >
&nbsp;&nbsp;
<a style="cursor:pointer;<?php if($value['visible'] == -2 ): ?>TEXT-DECORATION: line-through <?php 
endif;?>" href="?action=aishow&cp=<?php echo $value['id']; ?>" title='<?php echo $value['f3']; ?>'>
<?php echo $value['text']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;

<a style="cursor:pointer;" title='<?php echo $value['fi1']; ?>' href="?action=aishow&cp=<?php echo $value['id1']; ?>" >
<?php echo $value['tx1']; ?></a>&nbsp;&nbsp;
&nbsp;&nbsp;
<a style="cursor:pointer;" title='<?php echo $value['fi2']; ?>' href="?action=aishow&cp=<?php echo $value['id2']; ?>" >
<?php echo $value['tx2']; ?></a>

<?php }else 
foreach($concepts as $value){
?>
<div class="comcont" >
&nbsp;&nbsp;
<SPAN style="cursor:pointer;<?php if($value['visible'] == -2 ): ?>TEXT-DECORATION: line-through <?php 
endif;?>" onclick='dotu(<?php echo $value['id']; ?>);' title='<?php echo $value['f3']; ?>'>
<?php echo $value['text']; ?></SPAN>&nbsp;&nbsp;&nbsp;&nbsp;

<SPAN style="cursor:pointer;" title='<?php echo $value['fi1']; ?>' onclick='dotu(<?php echo $value['id1']; ?>);' >
<?php echo $value['tx1']; ?></SPAN>&nbsp;&nbsp;
&nbsp;&nbsp;
<SPAN style="cursor:pointer;" title='<?php echo $value['fi2']; ?>' onclick='dotu(<?php echo $value['id2']; ?>);' >
<?php echo $value['tx2']; ?></SPAN>

<?php } ?>
</div>
<div id="page"><?php echo $pageurl;?></div>
</div>
<SCRIPT stype=text/javascript>
 function dotu(id){
	  var temp = document.createElement("form");         
   temp.action = '/index.php?action=aishow';         
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