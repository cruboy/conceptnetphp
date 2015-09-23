<?php if(!defined('EMLOG_ROOT')) {exit('error!');}
if($pDa['backimg'] =='' )
$pDa['backimg']="/jt/imgs/bgg.jpg";
$mtop=60;
$fts=array("方正兰亭超细黑简体", "方正舒体", "方正姚体", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简","汉仪丫丫体简", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简", "黑体", "华文彩云", "华文仿宋", "华文行楷", "华文细黑", "华文新魏", "华文中宋", "经典综艺体简", "楷体", "隶书", "宋体", "微软雅黑", "新宋体", "幼圆", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5(P)", "華康少女文字W6", "華康娃娃體(P)", "華康娃娃體", );
//if($pDa['ctop']<50)$pDa['ctop']=50;
?>
<script type="text/javascript" src="/scan/artDialog/artDialog.js?skin=green"></script>
<script type="text/javascript" src="/scan/artDialog/jquery.artDialog.js"></script>
<script src="/scan/artDialog/plugins/iframeTools.js"></script>
<script>
	function ax(id){
art.dialog.open("filingview.php?srid=<?=$srid?>&id="+id, { 
follow: document.getElementById('th'+id),width: 740, height: 350,title:document.getElementById('th'+id).innerText+' '+id});	
	}
</script>
<script type="text/javascript" src="/content/js/jquery-1.8.2.min.js"></script>
  <script src="/content/js/jquery-ui.js"></script> 
  <script type="text/javascript"> 
var theid=-1;
function cnvs_getCoordinates(e)
{//x=e.clientX;
//y=e.clientY;
if(theid>=0)
{
y= $('#ftt'+theid).offset().top-18;
x= $('#ftt'+theid).offset().left;
$('#top'+theid).val(y);
$('#left'+theid).val(x);
}
}
</script>
<style type="text/css" id="internalStyle">

#m{text-align:left;padding:10px;}
.comcont{color:#333; padding:6px 0px;}.reply{color:#FF3300; font-size:12px;}
.texts{width:86%; height:150px;}
</style>
<div id="m" style="height:<?=$maxtop?>px;width:1000px;background: url('<?=$pDa['backimg']?>') ;" 
onmousemove="cnvs_getCoordinates(event)" >
<div class="ui-widget-content" 
style="cursor:pointer;position:absolute;top:<?=$pDa['ctop']?>px;left:<?=$pDa['cleft']?>px;" >
<div style="width:<? echo strlen($pDa['text'])*9+140;?>px;"><a onClick="ax(1)">☆</a><span id='th1'><?php echo $pDa['text']; ?></span>&nbsp;
<span title="<?php echo "+".$pDa['f1']." -".$pDa['f2']." ".$pDa['num_assertions']; 
?>">关链</span><?php echo $pDa['f3']; ?>
 查看<?php echo $pDa['words']; ?><a href="index.php?cp=<?=$cpidd?>">预览 </a></div>


</div> 
<?php 
foreach($concepts as $value):
//print_r($value);
$value['atop']=$value['atop']==0?$mtop+=20:$value['atop'];
$value['aleft']=$value['aleft']==0?rand(1,920):$value['aleft'];?>
<div class="ui-widget-content" style="cursor:pointer;position:absolute;top:<?=$value['atop']
?>px;left:<?=$value['aleft']?>px;">
<div style="width:<? echo strlen($value['text'])*9+28;?>px;">
<a onClick="">○</a><a href="<?php echo BLOG_URL;
				 ?>m/ainet.php?cp=<?php echo $value['id']; ?>" title="<?=$value['aid']?>"><?php echo $value['text']; ?></a><?php if($value['aurl'] !='' ): ?>
<a href="<?php echo $value['aurl']; ?>">□</a>
<?php endif;if($value['url'] !='' ): ?>
<a href="<?php echo $value['url']; ?>">■</a>
<?php endif;?></div><?php if($value['img'] !='' ): ?>
<img style="border:0px;" src="<?=$value['img']?>">
<?php endif;?>

</div>
<?php endforeach; ?>
</div>
=======坐标=====<a onClick="$('.zuobiao').show();">显示</a>=====<a onClick="$('.zuobiao').hide();">隐藏</a>====
<? for($t=100;$t<$maxtop;$t+=100){?>
<div class="zuobiao" style="position:absolute;top:<?=$t?>px;left:5px;"><?=$t?></div>

<? if($t%500==0){?>
<? for($tt=100;$tt<1100;$tt+=100){?>
<div class="zuobiao" style="position:absolute;top:<?=$t+50?>px;left:<?=$tt?>px;"><?=$tt?></div>
<?  }}?>
<?  }?>
<div style="text-align:left;">
提示：点击并移动‘○’进行编辑，双击'○'进行保存。
	<form id="addcp<?php echo $valid;?>" >
    添加
    <input id="sch" type="radio" value="0" name="dirs" checked />
    <label for="sch" >前向(1="<?php echo $pDa['text']; ?>")</label> 
	<input id="sch1" type="radio" value="1" name="dirs" />
	<label for="sch1" >反向(2="<?php echo $pDa['text']; ?>")</label> 
	的关联概念：<br>
	关系：
    <select dir="ltr" name="addrel" id="darom" >
	<option value="83" style="color:grey" selected='selected'>{1}包括{2}</option><option value="33" >{1}会让你想要{2}</option>
	<option value="34" style="background-color:#FFFFFF; color:blue">{1}会让你{2}</option><option value="35" style="background-color:#FFFFFF; color:blue">{1}之后可能会发生的事情是{2}</option><option value="36" style="color:blue">因为{1}所以{2}</option><option value="37" style="background-color:#FFFFFF; color:blue">{1}可能会带来{2}</option><option value="38" style="background-color:#FFFFFF; color:blue">{1}可能会引起{2}</option>
	<option value="40">{1}的时候，首先要{2}</option><option value="45">{1}是{2}的一部分</option>
	<option value="46" >{1}可以用{2}制成</option><option value="47" >{1}由{2}组成</option><option value="50">{1}是一种{2}</option><option value="51" style="color:grey">{1}在{2}里</option><option value="55" style="color:grey">{1}在{2}外</option><option value="57" style="color:grey">你可以在{2}找到{1}</option><option value="58" style="color:grey">{2}有{1}</option>
	<option value="60">{2}的时候可能会用到{1}</option><option value="63">{1}能做的事情有{2}</option><option value="64">{1}会{2}</option>
	<option value="65" style="background-color:#FFFFFF; color:green">你会{1}因为你{2}</option>	<option value="66" style="color:green">{1}是为了{2}</option><option value="67" style="color:green">想要有{2}应该要{1}</option><option value="68" style="color:green">当你想要{2}的时候你可能会{1}</option><option value="69" style="color:green">{2}的时候会想要{1}</option>
	<option value="70" style="background-color:#FFFFFF; color:red">{1}喜欢{2}</font></option><option value="71" style="background-color:#FFFFFF; color:red">{1}想要{2}</option><option value="72" style="background-color:#FFFFFF; color:red">{1}不想要{2}</option><option value="73" style="background-color:#FFFFFF; color:red">{1}害怕{2}</option><option value="75" style="background-color:#FFFFFF; color:red">{1}痛恨{2}</option>
	<option value="79">{1}是{2}的</option><option value="84">{2}可能代表{1}</option><option value="89">{1}代表{2}</option><option value="92">{1}的时候，你会{2}</option><option value="95">在{1}，你会{2}</option>   
</option>
	</select> 
	<? if(ROLE=='admin'):?><br>名称：<textarea name="addname"  class="texts"/></textarea><? else:?>
    名称：<input name="addname"  type="text" value="" style="width:120px;"/>
    <? endif;?>
    <input type="hidden" name="cp0s" value="<?php echo $pDa['text']; ?>" />
    <input type="hidden" name="cid" value="<?php echo $cpidd; ?>" />
        <input type="hidden" name="valid" value="<?php echo $valid;?>" />
	<a onClick=" $.ajax({
				url:'<?php echo BLOG_URL; ?>m/doadd.php?action=addcp',
				type:'POST',
				data:$('#addcp<?php echo $valid;?>').serialize(),
				success: function(data){
                     alert(data);
					}
		});">添加</a>
	</form>
</div>
<script> 
	 $(function() {    $( ".ui-widget-content" ).draggable();  });  </script>