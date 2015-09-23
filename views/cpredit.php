<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="ftt<?=$value['aid']?>" style='display:none;float:right;background:url(views/bg.gif) '>
:<?php echo $value['f1'].'+'.$value['f2'].'='.$value['f3']; ?>
:<?php echo $value['num_assertions']; ?>:
<?php echo $value['relation_id'].".".$value['best_frame_id'].' '.$value['rela'].":".$value['frame']; ?>:V<?php echo $value['visible']; ?>:C<?php echo $value['cruboy']; ?>
 <form id="ft<?=$value['aid']?>" >
 <? if(ROLE=='admin'):?>   <td>r<input style="width:20px;" value="<?php echo $value['relation_id']; ?>"  name="relation_id" /></td>
    <td>b<input style="width:20px;" value="<?php echo $value['best_frame_id']; ?>"  name="best_frame_id" /></td>
 <? endif;?>   <td>atop<input style="width:30px;" id="top<?=$value['aid']?>" value="<?php echo $value['atop']; ?>"  name="atop<?php echo $value['fx']; ?>" /></td>
    <td>aleft<input style="width:30px;" id="left<?=$value['aid']?>" value="<?php echo $value['aleft']; ?>"  name="aleft<?php echo $value['fx']; ?>" /></td>
    <td>seq<input style="width:30px;" value="<?php echo $value['seq']; ?>"  name="seq" /></td>
    <td>abid<input style="width:30px;" value="<?php echo $value['abid']; ?>"  name="abid" /></td><br>
    <td>info<input style="width:90px;" value="<?php echo $value['info']; ?>"  name="info" /></td>
    <td>aurl<input style="width:80px;" value="<?php echo $value['aurl']; ?>"  name="aurl" /></td>
    <td><a onClick="$('#ftt<?=$value['aid']?>').hide();theid=-1;">X</a></td>
    </form>
</div>
<a onClick="$('#ftt'+theid).hide();theid=<?=$value['aid']
?>;$('#ftt<?=$value['aid']?>').show();" 
onDblClick="theid=-1;$.ajax({url:'docp.php?cp=<?=$cpidd?>&aid=<?=$value['aid']?>',type:'POST',
				data:$('#ft<?=$value[aid]?>').serialize(),
				success: function(data){ alert(data);}}); $('#ftt<?=$value['aid']?>').hide();">○</a>