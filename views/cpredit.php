<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

关联数+<?php echo $value['f1'].'-'.$value['f2'].'共'.$value['f3']; ?>
~<?php echo $value['num_assertions']; ?>:
<?php echo $value['relation_id'].".".$value['best_frame_id'].' '.$value['rela'].":".$value['frame']; ?>:V<?php echo $value['visible']; ?>:C<?php echo $value['cruboy']; ?>
 <form method='post' action='docp.php?cp=<?=$cpidd?>&aid=<?=$value['aid']?>' >
 <table>
 <? if(ROLE=='admin'):?>  
 <tr> <td>r<input style="width:20px;" value="<?php echo $value['relation_id']; ?>"  name="relation_id" /></td>
    <td>b<input style="width:20px;" value="<?php echo $value['best_frame_id']; ?>"  name="best_frame_id" /></td>
 </tr>
 <? endif;?>  
  <tr>
  <td>位置top<input style="width:50px;"  value="<?php echo $value[$m.'top'.$fx]; ?>"  name="<?php echo $m.'top'.$fx; ?>" /></td>
    <td>left<input style="width:50px;"  value="<?php echo $value[$m.'left'.$fx]; ?>"  name="<?php echo $m.'left'.$fx; ?>" /></td>
    </tr>
    <tr><td>seq<input style="width:30px;" value="<?php echo $value['seq']; ?>"  name="seq" /></td>
    <td>abid<input style="width:30px;" value="<?php echo $value['abid']; ?>"  name="abid" /></td><br>
    </tr>
    <tr><td>info<input style="width:90px;" value="<?php echo $value['info']; ?>"  name="info" /></td>
    <td>aurl<input style="width:80px;" value="<?php echo $value['aurl']; ?>"  name="aurl" /></td>
    </tr> <tr><td><input  type='submit' value='提交'/></td></tr>
  </table>
    </form>