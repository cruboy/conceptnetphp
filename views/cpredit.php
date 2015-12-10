<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

关联<?php echo $value['concept1_id'].'与'.$value['concept2_id'].'评分'.$value['score']; ?>
<br><?php echo $value['num_assertions']; ?>:
<?php echo $value['relation_id'].".".$value['best_frame_id'].' '.$value['rela'].":".$value['frame']; ?>:好<?php echo $value['good']; ?>:坏<?php echo $value['bad']; ?>
<br>创建<?=$value['creator']?>，<?=$value['uid']?>时<?=date('Y-m-d H:i:s',$value['edittime'])?>
  <br>a1t <?=$value['atop1']?>,<?=$value['aleft1']?> a2 <?=$value['atop2']?>,<?=$value['aleft2']?> i1 <?=$value['itop1']?>,<?=$value['ileft1']?> i2 <?=$value['itop2']?>,<?=$value['ileft2']?>
  <form method='post' action='docp.php?cp=<?=$cpidd?>&aid=<?=$rid?>' >
 <table>
 <? if(ROLE=='admin'):?>  
 <tr> <td>r_id<input style="width:40px;" value="<?php echo $value['relation_id']; ?>"  name="relation_id" /></td>
     <td>b_f_id<input style="width:40px;" value="<?php echo $value['best_frame_id']; ?>"  name="best_frame_id" /></td>
 </tr>
 <tr> <td>可用V<input style="width:30px;" value="<?php echo $value['visible']; ?>"  name="visible" /> </td>
     <td>abid<input style="width:40px;" value="<?php echo $value['abid']; ?>"  name="abid" />
    seq<input style="width:40px;" value="<?php echo $value['abid']; ?>"  name="seq" /></td>
 </tr>
 <? endif;?>  
  <tr>
  <td>位置top<input style="width:50px;"  value="<?php echo $value[$m.'top'.$fx]; ?>"  name="<?php echo $m.'top'.$fx; ?>" /></td>
    <td>left<input style="width:50px;"  value="<?php echo $value[$m.'left'.$fx]; ?>"  name="<?php echo $m.'left'.$fx; ?>" /></td>
    </tr>
    <tr><td>字体大小<input style="width:30px;" value="<?php echo $value['seq']; ?>"  name="seq" /></td>
    <td>显示C <select name="cruboy" >
<?php if(ROLE=='admin'){ $subs[2]='推荐';$subs[-2]='祭童';$subs[-1]='涉祭';}
	$subs[0]='正常';$subs[1]='隐藏';
foreach ($subs as $k=>$v) {	
?><option value="<?=$k?>" <? if($k==$pDa['cruboy']) echo 'selected="selected"';?> ><?=$v?></option>	
<?php } ?>	
	  </select></td>
    </tr>
    
  <tr><td><input  type='submit' value='提交'/></td></tr>
  </table>
    </form>