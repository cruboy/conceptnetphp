<?php if(!defined('EMLOG_ROOT')) {exit('error!');}
if($pDa['imgsize'] !=-1)
$backimg="/images/bgo.jpg";
else{
	$sq1 = "SELECT * FROM  emlog_attachment WHERE aid=".$pDa['imgid'];
	$pa = $DB->once_fetch_array($sq1);
	$backimg=$pa['filepath'];
	}
$mtop=70;
$fts=array("方正兰亭超细黑简体", "方正舒体", "方正姚体", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简","汉仪丫丫体简", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简", "黑体", "华文彩云", "华文仿宋", "华文行楷", "华文细黑", "华文新魏", "华文中宋", "经典综艺体简", "楷体", "隶书", "宋体", "微软雅黑", "新宋体", "幼圆", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5(P)", "華康少女文字W6", "華康娃娃體(P)", "華康娃娃體", );
//if($pDa['ctop']<50)$pDa['ctop']=50;
?>
<script type="text/javascript" src="/views/artDialog/artDialog.js?skin=green"></script>
<script type="text/javascript" src="/views/artDialog/jquery.artDialog.js"></script>
<script src="/views/artDialog/plugins/iframeTools.js"></script>
<script type="text/javascript" src="/views/jss/jquery.min.js"></script>
<script src="/views/jss/jquery-ui.js"></script> 
<script type="text/javascript"> 
var editt=-1;
var theid=0;
var theiid=0;
function ch(){
	editt=-editt;
	//alert(editt);
	if(editt==1){
	document.getElementById('thech').innerText='【位置调整】';
	 $( ".ui-widget-content" ).draggable('enable'); 
	}else{
	document.getElementById('thech').innerText='【编辑内容】';
	 $( ".ui-widget-content" ).draggable('disable'); 
	}}
function ax(id){
	if(editt==1){
		if(theid!=id||theiid!=0)
		 savecd();
		theiid=0;
		theid=id;
		//alert(theid);
	}else{
 art.dialog.open("docp.php?m=a&cp=<?=$cpidd?>&editid="+id, { 
 follow: document.getElementById('th'+id),width: 350, height: 300,
 title:"<?=$pDa['text']; ?>--"+document.getElementById('th'+id).innerText+' '+id});	
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
 follow: document.getElementById('th'+id),width: 350, height: 300,
 title:"<?=$pDa['text']; ?>--"+document.getElementById('th'+id).innerText+' '+id});	
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
<?php if($pDa['imgid'] >0 &&$pDa['imgsize'] !=-1 ){
$sq1ab = "SELECT * FROM  emlog_attachment WHERE aid=".$pDa['imgid'];
	$paab = $DB->once_fetch_array($sq1ab);
?>
<div class="ui-widget-content" 
style="cursor:pointer;position:absolute;top:<?=$pDa['ctop']?>px;left:<?=$pDa['cleft']?>px;" id='ftti3'>
<img style="border:0px;" src="<?=$paab['filepath']?>" title="<?=$pDa['text']?>" onClick="axx(3)"></div>
<?php } ?>
<div class="ui-widget-content" >
<a onClick="ax(<?=$pDa['id']?>3)">☆</a><span id='th<?=$pDa['id']?>3'><?php echo $pDa['text']; ?></span>&nbsp;
 <img src="/images/os2.gif" title="总关联数(<?=$pDa['num_assertions']?>)"><?php echo $pDa['f3']; ?>
（<img src="/images/qian.gif" title="前向关联数"><?php echo $pDa['f1']; ?>
<img src="/images/hou.gif" title="后向关联数"><?php echo $pDa['f2']; ?>）[<?php echo getcptype($pDa['sort']); ?>]
 <img src="/images/fav.gif" title="查看次数"><?php echo $pDa['words']; ?> 
 
 <?php if($pDa['url'] !='' ){ ?>
<a href="<?=$pDa['url']?>">□</a>
<?php }
if($pDa['blogid'] >0 ){?>
<a href="/<?php echo $pDa['blogid']; ?>.html">■</a>
<?php } ?>
<a href="/?cp=<?=$cpidd?>">预览 </a>
<a href="/?action=aishow&cp=<?=$cpidd?>">列表</a>
<span onclick='ch()' id='thech' style='cursor:pointer;' title='点击切换'>【编辑内容】</span>
<span  id='theleft'></span>&nbsp;<span id='thetop'></span>
</div>
<?php echo $pDa['info']; ?>
<?php 
foreach($concepts as $k=>$value){
?>
<?php if($value['img'] >0 ){
$sq1a = "SELECT * FROM  emlog_attachment WHERE aid=".$value['img'];
	$paa = $DB->once_fetch_array($sq1a);
 ?>
<div class="ui-widget-content" style="cursor:pointer;position:absolute;top:<?=
$value['itop']?>px;left:<?=$value['ileft']?>px;" id='ftti<?=$value['aid'].$value['fx']?>'>
<img onClick="axx(<?=$value['aid'].$value['fx']?>)" style="border:0px;<? if($value['imgsz']>0)echo "width:".$value['imgsz']."px;"?>" src="<?=$paa['filepath']?>" title='<?=$value['text'].' '.$value['infos']?>'></div>
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
<a onClick="ax(<?=$value['aid'].$value['fx']?>)">○</a><span id='th<?=$value['aid'].$value['fx']?>'><a href="/ainet.php?cp=<?php
 echo $value['id']; ?>" title="<?=$value['frame']?><?php echo '+'.$value['f1'].'-'.$value['f2'].'~'.$value['num_assertions'].' '.$value['infos']; 
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
提示：点击或移动‘○’进行编辑内容或调整位置，点击文字会跳转。<a onClick="ax(<?=$pDa['id']?>3)">编辑概念</a>
	<form id="addcp<?php echo $valid;?>" >
    添加
    <input id="sch" type="radio" value="0" name="dirs" checked />
    <label for="sch" >前向(1="<?php echo $pDa['text']; ?>")</label> 
	<input id="sch1" type="radio" value="1" name="dirs" />
	<label for="sch1" >反向(2="<?php echo $pDa['text']; ?>")</label> 
	的关联概念：<br>
	关系：
    <select dir="ltr" name="addrel" id="darom" >
           <?
		   if(ROLE!='admin') $dadda="where n1>0";
      $sql2p="select * from conceptnet_frame $dadda order by relation_id asc,n1 desc";
	  $res=$DB->query($sql2p);
         while($arr=$DB->fetch_array($res))
                {
            ?>
   <option value="<?=$arr['id']?>" <? if($arr['id']==83) echo "selected";?>>
         【<?=$arr['relation_id']?>】<?=$arr['text']?>(<?=$arr['n1']?>)
        </option>
        <?  }	?>
	</select> 分类<select name="sort" >
	 <?php 
	
foreach (getcptype() as $k=>$v) {	
?><option value="<?=$k?>" <? if($k==$pDa['sort']) echo 'selected="selected"';?> ><?=$v?></option>	
<?php } ?></select>
	<? if(ROLE=='admin'):?><br>名称：<textarea name="addname" style="height:90px;width:350px" class="texts"/></textarea><? else:?>
    名称：<input name="addname"  type="text" value="" style="width:120px;" />
    <? endif;?>
    <input type="hidden" name="cp0s" value="<?php echo $pDa['text']; ?>" />
      <input type="hidden" name="cruboy" value="<?php echo $pDa['cruboy']; ?>" />
    <input type="hidden" name="cid" value="<?php echo $cpidd; ?>" />
        <input type="hidden" name="valid" value="<?php echo $valid;?>" /><br>
	<div style="width:500px;text-align:center;"><a onClick=" $.ajax({
				url:'<?php echo BLOG_URL; ?>m/doadd.php?action=addcp',
				type:'POST',
				data:$('#addcp<?php echo $valid;?>').serialize(),
				success: function(data){
                     alert(data);
					}
		});" title="添加"><img src="/images/tijiao.gif"></a></div>
	</form>
</div>
<script> 
	 $(function() {    $( ".ui-widget-content" ).draggable();  
	 $( ".ui-widget-content" ).draggable('disable');  });  </script>