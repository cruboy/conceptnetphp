<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="ftt0" style='display:none;background:url(views/bg.gif)'>
<?php echo $pDa['id']; ?>
<?php echo $pDa['text'];//print_r($pDa); ?>&nbsp;
关系数<?php echo $pDa['f3']; ?>（前向<?php echo $pDa['f1']; ?>后向<?php echo $pDa['f2']; ?>）
<?php echo $pDa['num_assertions']; ?> 查看<?php echo $pDa['words']; ?>
  <form id="fttz" >
 <? if(ROLE=='admin'):?>     <td>t<input style="width:60px;" value="<?php echo $pDa['text']; ?>"  name="text" /></td><? endif;?> 
    <td>img<input style="width:60px;" value="<?php echo $pDa['img']; ?>"  name="img" /></td>
    <td>backimg<input style="width:60px;" value="<?php echo $pDa['backimg']; ?>"  name="backimg" /></td>
    <td>ctop<input style="width:30px;" id="top0" value="<?php echo $pDa['ctop']; ?>"  name="ctop" /></td>
    <td>cleft<input style="width:30px;" id="left0" value="<?php echo $pDa['cleft']; ?>"  name="cleft" /></td>
   <br>
    <td>url<input style="width:80px;" value="<?php echo $pDa['url']; ?>"  name="url" /></td>
     <td>blog<input style="width:30px;" value="<?php echo $pDa['blogid']; ?>"  name="blogid" /></td>
     <td>V<input style="width:20px;" value="<?php echo $pDa['visible']; ?>"  name="visible" />
     <td>C<input style="width:20px;" value="<?php echo $pDa['cruboy']; ?>"  name="cruboy" /></td>
    <td><a onClick="$('#ftt0').hide();theid=0;">X</a>	</td>
    </form>
</div>  
<a onClick="$('#ftt'+theid).hide();theid=0;$('#ftt0').show();" 
onDblClick="theid=-1;   $.ajax({	url:'docp.php?cp=<?=$cpidd?>&ecdid=<?=$pDa['id']?>',
				type:'POST',
				data:$('#fttz').serialize(),
				success: function(data){
                   alert(data);					}
		}); $('#ftt0').hide();">☆</a>