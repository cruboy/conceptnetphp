<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<style type="text/css" id="internalStyle">
body{background-color:#FFFFFF; font-size:14px; margin: 0; padding:0;}
</style>
<body>
<?php echo $pDa['id']; ?>
☆<?php echo $pDa['text'];//print_r($pDa); ?>&nbsp;
概念数<?php echo $pDa['f3']; ?>（前向<?php echo $pDa['f1']; ?>后向<?php echo $pDa['f2']; ?>）
关系数<?php echo $pDa['num_assertions']; ?> 查看<?php echo $pDa['words']; ?>
  <form id="fttz" method='post' action='docp.php?cp=<?=$cpidd?>&ecdid=<?=$pDa['id']?>'>
  <table style=" font-size:14px;">
 <? if(ROLE=='admin'):?>    
  <tr><td>名称<input style="width:60px;" value="<?php echo $pDa['text']; ?>"  name="text" /></td><td>可用V<input style="width:30px;" value="<?php echo $pDa['visible']; ?>"  name="visible" /> </td>
  </tr>
  <? endif;?> 
   <tr>
    <td>图片ID<input style="width:60px;" value="<?php if($pDa['imgid'])echo $pDa['imgid']; ?>"  name="imgid" /></td>
    <td>背景图ID<input style="width:60px;" value="<?php if($pDa['backimgid'])echo $pDa['backimgid']; ?>"  name="backimgid" /></td>
    </tr>
    <tr><td>图片位置ctop<input style="width:30px;" id="top0" value="<?php echo $pDa['ctop']; ?>"  name="ctop" /></td>
    <td>cleft<input style="width:30px;" id="left0" value="<?php echo $pDa['cleft']; ?>"  name="cleft" /></td>
  </tr><tr>
    <td>链接<input style="width:80px;" value="<?php echo $pDa['url']; ?>"  name="url" /></td>
     <td>关联文章ID<input style="width:40px;" value="<?php echo $pDa['blogid']; ?>"  name="blogid" /></td>
     </tr>
     <tr><td>分类<select name="sort" >
	 <?php 
	$sub[0]='默认';$sub[1]='概念';if(ROLE=='admin'){ $sub[2]='分类';}$sub[3]='记事';$sub[4]='人';$sub[5]='地方';$sub[6]='时间';
foreach ($sub as $k=>$v) {	
?><option value="<?=$k?>" <? if($k==$pDa['sort']) echo 'selected="selected"';?> ><?=$v?></option>	
<?php } ?></select></td>
     <td>显示C <select name="cruboy" >
<?php if(ROLE=='admin'){ $subs[2]='推荐';$subs[-2]='祭童';$subs[-1]='涉祭';}
	$subs[0]='正常';$subs[1]='隐藏';
foreach ($subs as $k=>$v) {	
?><option value="<?=$k?>" <? if($k==$pDa['cruboy']) echo 'selected="selected"';?> ><?=$v?></option>	
<?php } ?>	
	  </select></td>
      </tr>
      <?php if(ROLE=='admin'): ?><tr>
    <td colspan="2"><textarea name="info"  class="texts"/><?php echo $pDa['info']; ?></textarea></td>
      <? endif;?> 
  </tr>
  <tr><td><input  type='submit' value='提交'/></td></tr>
  </table>
    </form>
</body>