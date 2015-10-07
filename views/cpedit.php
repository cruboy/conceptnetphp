<?php if(!defined('EMLOG_ROOT')) {exit('error!');}
if($pDa['backimgid'] ==0)
$backimg="/jt/imgs/bgo.jpg";
else{
	$sq1 = "SELECT * FROM  emlog_attachment WHERE aid=".$pDa['backimgid'];
	$pa = $DB->once_fetch_array($sq1);
	$backimg=$pa['filepath'];
	}
$mtop=70;
$fts=array("方正兰亭超细黑简体", "方正舒体", "方正姚体", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简","汉仪丫丫体简", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简", "黑体", "华文彩云", "华文仿宋", "华文行楷", "华文细黑", "华文新魏", "华文中宋", "经典综艺体简", "楷体", "隶书", "宋体", "微软雅黑", "新宋体", "幼圆", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5(P)", "華康少女文字W6", "華康娃娃體(P)", "華康娃娃體", );
//if($pDa['ctop']<50)$pDa['ctop']=50;
?>
<script type="text/javascript" src="/scan/artDialog/artDialog.js?skin=green"></script>
<script type="text/javascript" src="/scan/artDialog/jquery.artDialog.js"></script>
<script src="/scan/artDialog/plugins/iframeTools.js"></script>
<script type="text/javascript" src="/content/js/jquery-1.8.2.min.js"></script>
<script src="/content/js/jquery-ui.js"></script> 
<script type="text/javascript"> 
var editt=-1;
var theid=0;
var theiid=0;
function ch(){
	editt=-editt;
	//alert(editt);
	if(editt==1)
	document.getElementById('thech').innerText='【位置调整】';
	else
	document.getElementById('thech').innerText='【编辑内容】';
	}
function ax(id){
	if(editt==1){
		if(theid!=id||theiid!=0)
		 savecd();
		theiid=0;
		theid=id;
		//alert(theid);
	}else{
 art.dialog.open("docp.php?m=a&cp=<?=$cpidd?>&editid="+id, { 
 follow: document.getElementById('th'+id),width: 300, height: 250,
 title:document.getElementById('th'+id).innerText+' '+id});	
	}
}
function axx(id){
	if(editt==1){
		if(theiid!=id||theid!=0)
		 savecd();
		theid=0;
		theiid=id;
		//alert(theid);
	}else{
 art.dialog.open("docp.php?m=i&cp=<?=$cpidd?>&editid="+id, { 
 follow: document.getElementById('th'+id),width: 300, height: 250,
 title:document.getElementById('th'+id).innerText+' '+id});	
	}
}
function cnvs_getCoordinates(e)
{ //x=e.clientX;
  //y=e.clientY;
  if(theid!=0){
	y= $('#ftt'+theid).offset().top;
	x= $('#ftt'+theid).offset().left;
document.getElementById('thetop').innerText=(y);
document.getElementById('theleft').innerText=(x);
  }
if(theiid!=0){
	y= $('#ftti'+theiid).offset().top;
	x= $('#ftti'+theiid).offset().left;
document.getElementById('thetop').innerText=(y);
document.getElementById('theleft').innerText=(x);
  }
}
function savecd(){
	$.ajax({url:'docp.php?cp=<?=$cpidd?>',type:'POST',
				data:{x:document.getElementById('theleft').innerText,
				y:document.getElementById('thetop').innerText,
				id:theid,iid:theiid},
				success: function(data){ //alert(data);
				}});
}
</script>
<div id="m"  style="height:<?=$maxtop?>px;width:1000px;background: url('<?=$backimg?>');overflow-x :auto;"
onmousemove="cnvs_getCoordinates(event)"  >
<?php if($pDa['imgid'] >0 ){
$sq1ab = "SELECT * FROM  emlog_attachment WHERE aid=".$pDa['imgid'];
	$paab = $DB->once_fetch_array($sq1ab);
?>
<div class="ui-widget-content" 
style="cursor:pointer;position:absolute;top:<?=$pDa['ctop']?>px;left:<?=$pDa['cleft']?>px;" id='ftti3'>
<img style="border:0px;" src="<?=$paab['filepath']?>" title="<?=$pDa['text']?>" onClick="axx(3)"></div>
<?php } ?>
<div class="ui-widget-content" >
<a onClick="ax(<?=$pDa['id']?>3)">☆</a><span id='th<?=$pDa['id']?>3'><?php echo $pDa['text']; ?></span>&nbsp;
<span title="<?php echo "+".$pDa['f1']."-".$pDa['f2']."~".$pDa['num_assertions']; 
?>">相关数</span><?php echo $pDa['f3']; ?>
 查看<?php echo $pDa['words']; ?> 
 <?php if($pDa['url'] !='' ){ ?>
<a href="<?=$pDa['url']?>">□</a>
<?php }
if($pDa['blogid'] >0 ){?>
<a href="/<?php echo $pDa['blogid']; ?>.html">■</a>
<?php } ?>
<a href="index.php?cp=<?=$cpidd?>">预览 </a>
<span onclick='ch()' id='thech'>【编辑内容】</span>
<span  id='theleft'></span>&nbsp;<span id='thetop'></span>
</div>
<?php echo $pDaa['content']; ?>
<?php 
foreach($concepts as $k=>$value){
?>
<?php if($value['imgid'] >0 ){
$sq1a = "SELECT * FROM  emlog_attachment WHERE aid=".$value['imgid'];
	$paa = $DB->once_fetch_array($sq1a);
 ?>
<div class="ui-widget-content" style="cursor:pointer;position:absolute;top:<?=
$value['itop']?>px;left:<?=$value['ileft']?>px;" id='ftti<?=$value['aid'].$value['fx']?>'>
<img onClick="axx(<?=$value['aid'].$value['fx']?>)" style="border:0px;" src="<?=$paa['filepath']?>" title='<?=$value['text']?>'></div>
<?php }
} ?>
<?php 
foreach($concepts as $value){
$value['atop']=$value['atop']==0?$mtop+=20:$value['atop'];
//$value['aleft']=$value['aleft']==0?rand(1,920):$value['aleft'];
if($value['seq']<8)$value['seq']=14;
?>
<div class="ui-widget-content" style="cursor:pointer;position:absolute;top:<?=$value['atop']
?>px;left:<?=$value['aleft']?>px;font-size:<?=$value['seq']?>px;" id='ftt<?=$value['aid'].$value['fx']?>'>
<a onClick="ax(<?=$value['aid'].$value['fx']?>)">○</a><span id='th<?=$value['aid'].$value['fx']?>'><a href="/m/ainet.php?cp=<?php
 echo $value['id']; ?>" title="<?=$value['frame']?><?php echo '+'.$value['f1'].'-'.$value['f2'].'~'.$value['num_assertions']; 
?>"><?php echo $value['text']; ?></a>
<?php if($value['url'] !='' ){ ?>
<a href="<?=$value['url']?>">□</a>
<?php }
if($value['blogid'] >0 ){?>
<a href="/<?php echo $value['blogid']; ?>.html">■</a>
<?php } ?></span></div>
<?php } ?>
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