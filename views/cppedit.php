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
  <tr><td>名称<input style="width:60px;" value="<?php echo $pDa['text']; ?>"  name="text" /></td>
  </tr>
  <? endif;?> 
   <tr>
    <td>图片imgid<input style="width:60px;" value="<?php echo $pDa['imgid']; ?>"  name="imgid" /></td>
    <td>backimgid<input style="width:60px;" value="<?php echo $pDa['backimgid']; ?>"  name="backimgid" /></td>
    </tr>
    <tr><td>图片位置ctop<input style="width:30px;" id="top0" value="<?php echo $pDa['ctop']; ?>"  name="ctop" /></td>
    <td>cleft<input style="width:30px;" id="left0" value="<?php echo $pDa['cleft']; ?>"  name="cleft" /></td>
  </tr><tr>
    <td>概念链接url<input style="width:80px;" value="<?php echo $pDa['url']; ?>"  name="url" /></td>
     <td>关联文章blog<input style="width:30px;" value="<?php echo $pDa['blogid']; ?>"  name="blogid" /></td>
     </tr><tr>
     <!--tr>
    <td colspan="2"><textarea name="info"  class="texts"/><?php echo $pDa['info']; ?></textarea></td>
     </tr--><tr>
     <td>样式<input style="width:20px;" value="<?php echo $pDa['style']; ?>"  name="style" /> 
    <? if(ROLE=='admin'):?>     可见V<input style="width:20px;" value="<?php echo $pDa['visible']; ?>"  name="visible" /> </td>
     <td>推荐C<input style="width:20px;" value="<?php echo $pDa['cruboy']; ?>"  name="cruboy" /></td>
      <? endif;?> 
  </tr>
  <tr><td><input  type='submit' value='提交'/></td></tr>
  </table>
    </form>
</body>