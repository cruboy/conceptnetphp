<?php if(!defined('EMLOG_ROOT')) {exit('error!');}
if($pDa['backimg'] =='' )
$pDa['backimg']="/jt/imgs/bgg.jpg";
$mtop=60;
$fts=array("方正兰亭超细黑简体", "方正舒体", "方正姚体", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简","汉仪丫丫体简", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简", "黑体", "华文彩云", "华文仿宋", "华文行楷", "华文细黑", "华文新魏", "华文中宋", "经典综艺体简", "楷体", "隶书", "宋体", "微软雅黑", "新宋体", "幼圆", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5(P)", "華康少女文字W6", "華康娃娃體(P)", "華康娃娃體", );

?>
<script type="text/javascript"> 
var theid=0;
function cnvs_getCoordinates(e)
{
	
x=e.clientX;
y=e.clientY;
//document.getElementById("xycoordinates").innerHTML="Coordinates: (" + x + "," + y + ")";
$('#top'+theid).val(y);
$('#left'+theid).val(x);
}
 

</script>

<div id="m" style="height:<?=$maxtop?>px;width:1000px;background: url('<?=$pDa['backimg']?>') ;" 
onmousemove="cnvs_getCoordinates(event)" >
<div class="ui-widget-content" <?php if($pDa['ctop']>0||$pDa['cleft']>0):?>
style="position:absolute;top:<?=$pDa['ctop']?>px;left:<?=$pDa['cleft']?>px;" <?php endif;?>>
☆<span ><?php echo $pDa['text']; ?></span>&nbsp;
<span title="<?php echo "+".$pDa['f1']." -".$pDa['f2']." ".$pDa['num_assertions']; 
?>">关链数</span>
 查看<?php echo $pDa['words']; ?><a href="/?cp=<?=$cpidd?>">预览 </a>
</div> 
<?php 
foreach($concepts as $value):
//print_r($value);
$value['atop']=$value['atop']==0?$mtop+=20:$value['atop'];
$value['aleft']=$value['aleft']==0?rand(1,920):$value['aleft'];?>
<div class="ui-widget-content" style="cursor:pointer;position:absolute;top:<?=$value['atop']
?>px;left:<?=$value['aleft']?>px;"><a onClick="$('#ftt'+theid).hide();theid=<?=$value['aid']
?>;$('#ftt<?=$value['aid']?>').show();" 
onDblClick="theid=0;">○</a>
<?php if($value['img'] !='' ): ?>
<img style="border:0px;" src="<?=$value['img']?>">
<?php endif;?>
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=<?php echo $value['id']; ?>" title="<?=$value['aid']?>">
<?php echo $value['text']; ?></a><?php if($value['aurl'] !='' ): ?>
<a href="<?php echo $value['aurl']; ?>">□</a>
<?php endif;if($value['url'] !='' ): ?>
<a href="<?php echo $value['url']; ?>">■</a>
<?php endif;?>
<div id="ftt<?=$value['aid']?>" style='display:none;float:right;'>
:<a  onClick="
    $.ajax({url:'docp.php?cp=<?=$cpidd?>&aid=<?=$value['aid']?>',type:'POST',
				data:$('#ft<?=$value[aid]?>').serialize(),
				success: function(data){ alert(data);}}); " >修改</a><?php echo $value['f1'].'+'.$value['f2'].'='.$value['f3']; ?>
:<?php echo $value['num_assertions']; ?>:
<?php echo $value['relation_id'].".".$value['best_frame_id'].' '.$value['rela'].":".$value['frame']; ?>:V<?php echo $value['visible']; ?>:C<?php echo $value['cruboy']; ?>
 <form id="ft<?=$value['aid']?>" >
    <td>r<input style="width:20px;" value="<?php echo $value['relation_id']; ?>"  name="relation_id" /></td>
    <td>b<input style="width:20px;" value="<?php echo $value['best_frame_id']; ?>"  name="best_frame_id" /></td>
    <td>atop<input style="width:30px;" id="top<?=$value['aid']?>" value="<?php echo $value['atop']; ?>"  name="atop<?php echo $value['fx']; ?>" /></td>
    <td>aleft<input style="width:30px;" id="left<?=$value['aid']?>" value="<?php echo $value['aleft']; ?>"  name="aleft<?php echo $value['fx']; ?>" /></td>
    <td>seq<input style="width:30px;" value="<?php echo $value['seq']; ?>"  name="seq" /></td>
    <td>abid<input style="width:30px;" value="<?php echo $value['abid']; ?>"  name="abid" /></td><br>
    <td>info<input style="width:90px;" value="<?php echo $value['info']; ?>"  name="info" /></td>
    <td>aurl<input style="width:80px;" value="<?php echo $value['aurl']; ?>"  name="aurl" /></td>
    <td><a onClick="$('#ftt<?=$value['aid']?>').hide();theid=0;">X</a></td>
    </form>
</div>
</div>
<?php endforeach; ?>
</div>
==========================================
<div >
<?php echo $pDa['id']; ?>
<?php echo $pDa['text'];//print_r($pDa); ?>&nbsp;
关系数<?php echo $pDa['f3']; ?>（前向<?php echo $pDa['f1']; ?>后向<?php echo $pDa['f2']; ?>）
<?php echo $pDa['num_assertions']; ?> 查看<?php echo $pDa['words']; ?>
  <form id="fttz" >
    <td>t<input style="width:60px;" value="<?php echo $pDa['text']; ?>"  name="text" /></td>
    <td>img<input style="width:60px;" value="<?php echo $pDa['img']; ?>"  name="img" /></td>
    <td>backimg<input style="width:60px;" value="<?php echo $pDa['backimg']; ?>"  name="backimg" /></td>
    <td>backh<input style="width:30px;" value="<?php echo $pDa['backheight']; ?>"  name="backheight" /></td>
    <td>ctop<input style="width:30px;" id="top0" value="<?php echo $pDa['ctop']; ?>"  name="ctop" /></td>
    <td>cleft<input style="width:30px;" id="left0" value="<?php echo $pDa['cleft']; ?>"  name="cleft" /></td>
    <td>blog<input style="width:30px;" value="<?php echo $pDa['blogid']; ?>"  name="blogid" /></td><br>
    <td>url<input style="width:80px;" value="<?php echo $pDa['url']; ?>"  name="url" /></td>
    <td>V<input style="width:20px;" value="<?php echo $pDa['visible']; ?>"  name="visible" />
     <td>C<input style="width:20px;" value="<?php echo $pDa['cruboy']; ?>"  name="cruboy" /></td>
    <td> <a   onClick="
    $.ajax({	url:'docp.php?cp=<?=$cpidd?>&ecdid=<?=$pDa['id']?>',
				type:'POST',
				data:$('#fttz').serialize(),
				success: function(data){
                   alert(data);					}
		});
   " >修改</a>	</td>
    </form>
</div>  
	<form name="keycp" method="post" action="<?php echo BLOG_URL; ?>jt/index.php?action=keyword<? if($cpidd<0)echo"&jt"?>">

	<input name="k"  type="text" value="<?=$akey?>" style="width:120px;"/>
	<input type="submit" id="logserch_logserch" value="搜索" />
	</form>
<br>
	<form name="addcp" method="post" action="<?php echo BLOG_URL; ?>m/doadd.php?action=addcp&r=jt">
    添加“<?php echo $pDa['text']; ?>”的关联概念：<br>
    <input type="hidden" name="cp0s" value="<?php echo $pDa['text']; ?>" />
    <input type="hidden" name="cid" value="<?php echo $cpidd; ?>" />
    关系号：<input name="addrel"  type="text" value="" style="width:80px;"/>
	名称：<input name="addname"  type="text" value="" style="width:120px;"/>
	<input type="submit" id="addcpsubmit" value="添加" />
    33：{1}会让你想要{2}。 34：{1}会让你{2}。 35：{1}之后可能会发生的事情是{2}。 36：因为{1}所以{2}。 37：{1}可能会带来{2}。 38：{1}可能会引起{2}。 40：{1}的时候，首先要{2}。 45：{1}是{2}的一部分。 46：{1}可以用{2}制成。 47：{1}由{2}组成。 50：{1}是一种{2}。 51：{1}在{2}里。 55：{1}在{2}外。 57：你可以在{2}找到{1}。 58：{2}有{1}。 60：{2}的时候可能会用到{1}。 63：{1}能做的事情有{2}。 64：{1}会{2}。 65：你会{1}因为你{2}。 66：{1}是为了{2}。 67：想要有{2}应该要{1}。 68：当你想要{2}的时候你可能会{1}。 69：{2}的时候会想要{1}。 70：{1}喜欢{2}。 71：{1}想要{2}。 72：{1}不想要{2}。 73：{1}害怕{2}。 75：{1}痛恨{2}。 79：{1}是{2}的。84：{2}可能代表{1}。 89：{1}代表{2}。 92：{1}的时候，你会{2}。 95：在{1}，你会{2}。   
</form>

<script> 
	 $(function() {    $( ".ui-widget-content" ).draggable();  });  </script>