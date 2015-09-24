<?php if(!defined('EMLOG_ROOT')) {exit('error!');}
if($pDa['backimgid'] ==0)
$backimg="/jt/imgs/bgg.jpg";
else{
	$sq1 = "SELECT * FROM  emlog_attachment WHERE aid=".$pDa['backimgid'];
	$pa = $DB->once_fetch_array($sq1);
	$backimg=$pa['filepath'];
	}
$mtop=60;
$fts=array("方正兰亭超细黑简体", "方正舒体", "方正姚体", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简","汉仪丫丫体简", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简", "黑体", "华文彩云", "华文仿宋", "华文行楷", "华文细黑", "华文新魏", "华文中宋", "经典综艺体简", "楷体", "隶书", "宋体", "微软雅黑", "新宋体", "幼圆", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5(P)", "華康少女文字W6", "華康娃娃體(P)", "華康娃娃體", );

?>
<script type="text/javascript" src="/content/js/jquery-1.8.2.min.js"></script>
<script src="/content/js/jquery-ui.js"></script> 
<div id="m"  style="height:<?=$maxtop?>px;width:1000px;background: url('<?=$backimg?>');overflow-x :auto; ">
<?php if($pDa['imgid'] >0 ){
$sq1ab = "SELECT * FROM  emlog_attachment WHERE aid=".$pDa['imgid'];
	$paab = $DB->once_fetch_array($sq1ab);
 ?>
<div class="ui-widget-content" 
style="cursor:pointer;position:absolute;top:<?=$pDa['ctop']?>px;left:<?=$pDa['cleft']?>px;">
<img style="border:0px;" src="<?=$paab['filepath']?>" title="<?=$pDa['text']?>"></div>
<?php } ?>
<div class="ui-widget-content" >
☆<span ><?php echo $pDa['text']; ?></span>&nbsp;
<span title="<?php echo "+".$pDa['f1']."-".$pDa['f2']."~".$pDa['num_assertions']; 
?>">相关数</span><?php echo $pDa['f3']; ?>
 查看<?php echo $pDa['words']; ?> 
 <?php if($pDa['url'] !='' ){ ?>
<a href="<?=$pDa['url']?>">□</a>
<?php }
if($pDa['blogid'] >0 ){?>
<a href="/<?php echo $pDa['blogid']; ?>.html">■</a>
<?php } ?>
 <?php if(ISLOGIN === true):?><a href="/m/ainet.php?cp=<?=$pDa['id']?>">编辑</a><? endif;?>
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
$value['itop']?>px;left:<?=$value['ileft']?>px;" >
<img style="border:0px;" src="<?=$paa['filepath']?>" title='<?=$value['text']?>'></div>
<?php }
} ?>
<?php 
foreach($concepts as $k=>$value){
$value['atop']=$value['atop']==0?$mtop+=20:$value['atop'];
$value['aleft']=$value['aleft']==0?rand(1,920):$value['aleft'];
?>
<div class="ui-widget-content" style="cursor:pointer;position:absolute;top:<?=
$value['atop']?>px;left:<?=$value['aleft']?>px;" >○<span onclick="dotovv(<?php 
echo $value['id']; ?>)" title="<?=$value['frame']?><?php echo '+'.$value['f1'].'-'.$value['f2'].'~'.$value['num_assertions']; 
?>" style="font-family:<?=$fts[rand(0,36)]?>;"><?=$value['text']?></span>
<?php if($value['url'] !='' ){ ?>
<a href="<?=$value['url']?>">□</a>
<?php }
if($value['blogid'] >0 ){?>
<a href="/<?php echo $value['blogid']; ?>.html">■</a>
<?php } ?></div>
<?php } ?>
</div>
<script>
  function dotovv(id){
	  var temp = document.createElement("form");         
   temp.action = '/m/index.php';         
   temp.method = "post";         
   temp.style.display = "none"; 
   var opt = document.createElement("input");         
      opt.name = 'cp';         
        opt.value = id;         
       temp.appendChild(opt);  
	   opt = document.createElement("input"); 
	      opt.name = 'valid';         
        opt.value = <?php echo $valid;?>;         
       temp.appendChild(opt); 
   document.body.appendChild(temp);         
   temp.submit();         
   return temp;
 }

	 $(function() {    $( ".ui-widget-content" ).draggable();  });  </script>