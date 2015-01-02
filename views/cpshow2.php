<?php if(!defined('EMLOG_ROOT')) {exit('error!');}
if($pDa['backimg'] =='' )
$pDa['backimg']="jt/imgs/bgg.jpg";
$mtop=60;
$fts=array("方正兰亭超细黑简体", "方正舒体", "方正姚体", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简","汉仪丫丫体简", "仿宋", "汉仪家书简", "汉仪楷体简", "汉仪太极体简", "汉仪娃娃篆简", "汉仪丫丫体简", "黑体", "华文彩云", "华文仿宋", "华文行楷", "华文细黑", "华文新魏", "华文中宋", "经典综艺体简", "楷体", "隶书", "宋体", "微软雅黑", "新宋体", "幼圆", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5", "华康娃娃体W5(P)", "華康少女文字W6", "華康娃娃體(P)", "華康娃娃體", );

?>
<script type="text/javascript" src="/content/js/jquery-1.8.2.min.js"></script>
<script src="/content/js/jquery-ui.js"></script> 
<div id="m"  style="height:<?=$maxtop?>px;width:1000px;background: url('<?=$pDa['backimg']?>');overflow-x :auto; ">
<div <?php if($pDa['ctop']>0||$pDa['cleft']>0):?>
style="position:absolute;top:<?=$pDa['ctop']?>px;left:<?=$pDa['cleft']?>px;" <?php endif;?>>
<span ><?php echo $pDa['text']; ?></span>&nbsp;
关系数<?php echo $pDa['f3']; ?>
（前向<?php echo $pDa['f1']; ?>
后向<?php echo $pDa['f2']; ?>）
<?php echo $pDa['num_assertions']; ?>
 查看<?php echo $pDa['words']; ?>
</div>  
<?php echo $pDaa['content']; ?>
<?php 
foreach($concepts as $k=>$value):
$value['atop']=$value['atop']==0?$mtop+=20:$value['atop'];
$value['aleft']=$value['aleft']==0?rand(1,920):$value['aleft'];
?>
<div class="ui-widget-content" style="cursor:pointer;position:absolute;<? 
echo "top:".$value['atop']."px;"
?>left:<?=$value['aleft']?>px;" ><?php if($value['img'] !='' ): ?>
<img style="border:0px;" src="<?=$value['img']?>"><?php endif;?>
<div style="width:100px;">○<span onclick="dotovv(<?php echo $value['id']; ?>)" title="<?php echo $value['f3']; ?>个<?php echo $value['num_assertions']; 
?>链<?php echo $value['frame']; ?>" style="font-family:<?=$fts[rand(0,36)]?>;"><?php echo $value['text']; ?></span></div></div>
<?php endforeach; ?>
</div>
<script>
  function dotovv(id){
	  var temp = document.createElement("form");         
   temp.action = '/index.php';         
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