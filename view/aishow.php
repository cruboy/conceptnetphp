<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
 <script type="text/javascript" src="/views/artDialog/artDialog.js?skin=green"></script>
<script type="text/javascript" src="/views/artDialog/jquery.artDialog.js"></script>
<script src="/views/artDialog/plugins/iframeTools.js"></script>
<script type="text/javascript" src="/views/jss/jquery.min.js"></script>

<div id="m">
   	<li>
	<h3><span>概念查看</span></h3>
	<ul id="logserch">
	<form name="keycp" method="post" action="<?php echo BLOG_URL; ?>index.php?action=ailist">
	<input name="aikey"  type="text" value="<?php echo $akey; ?>" style="width:120px;"/>
    <input name="valid"  type="hidden" value="<?=$valid?>" />
	<input type="submit" id="logserch_logserch" value="搜索" />
	</form>
	</ul>
	</li>
    
<div class="comcont">
&nbsp;&nbsp;
<SPAN title='<?=$pDa['id']?>' <?php if($pDa['visible'] == -2 ): ?>style="TEXT-DECORATION: line-through"<?php endif;?>  onclick="dotu(<?php echo $pDa['id']; ?>)">
<?php echo $pDa['text']; ?></SPAN>&nbsp;<img src="/images/os2.gif" title="总关联数"><?php echo $pDa['f3']; ?>
（<img src="/images/qian.gif" title="前向关联数"><?php echo $pDa['f1']; ?>
<img src="/images/hou.gif" title="后向关联数"><?php echo $pDa['f2']; ?>）[<?php echo getcptype($pDa['sort']); ?>]
 <img src="/images/fav.gif" title="查看次数"><?php echo $pDa['words']; ?>
<?php 
	if(ISLOGIN === true){?>
    <a href="/?action=aishow&cp=<?=$cpidd?>">刷新</a>
    <a href="/?cp=<?=$cpidd?>">导图 </a>
    <a href="/ainet.php?cp=<?=$cpidd?>">导图编辑</a>
    <?php } ?>
</div>   
===========================<br>
	<?php 
	if(ISLOGIN === true)
foreach($concepts as $value):
?>
<div class="comcont" ><?php if($value['fx']==2)echo '-'; ?>
&nbsp;&nbsp;<a style="cursor:pointer;<?php if($value['visible'] == -2 ): ?>TEXT-DECORATION: line-through<?php endif;?>"  href="?action=aishow&cp=<?php echo $value['id'];?>" id="th<?=$value['aid'].$value['fx']?>">
<?php echo $value['text']; ?></a>
&nbsp;&nbsp;
<SPAN  title='<?php echo $value['best_frame_id']; ?>'>
<?php echo $value['frame']; ?>
</SPAN>

<span onclick="mark(this,<?=$value['aid']?>,'goodr')">
<img src="/images/thread_rate.gif"><?php echo $value['good']; ?></span>
    <span onclick="mark(this,<?=$value['aid']?>,'badr')">
    <img src="/images/disagree.gif"><?php echo $value['bad']; ?></span>
<span onclick="ed(this,<?=$value['aid'].$value['fx']?>)"><img src='/images/edt.gif'></span>
<?php endforeach; else foreach($concepts as $value):
?>
<div class="comcont" ><?php if($value['fx']==2)echo '-'; ?>
&nbsp;&nbsp;<SPAN style="cursor:pointer;<?php if($value['visible'] == -2 ): ?>TEXT-DECORATION: line-through<?php endif;?>"  onclick="dotu(<?php echo $value['id'];?>);" id="th<?=$value['aid'].$value['fx']?>">
<?php echo $value['text']; ?></SPAN>
<span onclick="mark(this,<?=$value['aid']?>,'goodr')">
<img src="/images/thread_rate.gif"><?php echo $value['good']; ?></span>
    <span onclick="mark(this,<?=$value['aid']?>,'badr')">
    <img src="/images/disagree.gif"><?php echo $value['bad']; ?></span>
<span onclick="ed(this,<?=$value['aid'].$value['fx']?>)"><img src='/images/edt.gif'></span>
<?php endforeach; ?>
</div>
==========================<br>

<br>
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
	</select> 
	</select> 分类<select name="sort" >
	 <?php 
 foreach (getcptype() as $k=>$v) {	
?><option value="<?=$k?>" <? if($k==$pDa['sort']) echo 'selected="selected"';?> ><?=$v?></option>	
<?php } ?></select>
	<? if(ROLE=='admin'):?><br>名称：<textarea name="addname" rows="4" /></textarea><? else:?>
    名称：<input name="addname"  type="text" value="" style="width:120px;"/>
    <? endif;?>
     <input type="hidden" name="cruboy" value="<?php echo $pDa['cruboy']; ?>" />
    <input type="hidden" name="cp0s" value="<?php echo $pDa['text']; ?>" />
    <input type="hidden" name="cid" value="<?php echo $pDa['id']; ?>" />
        <input type="hidden" name="valid" value="<?php echo $valid;?>" />
	<a onClick=" $.ajax({
				url:'<?php echo BLOG_URL; ?>m/doadd.php?action=addcp',
				type:'POST',
				data:$('#addcp<?php echo $valid;?>').serialize(),
				success: function(data){
                     alert(data);
					}
		});" title="添加"><img src="/images/tijiao.gif"></a>
	</form>
</div>
<SCRIPT type=text/javascript>
 function dotu(id){
	  var temp = document.createElement("form");         
   temp.action = '/index.php?action=aishow';         
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

	function mark(t,id,opt){
    var ord = {}; ord[opt] =id;
	$.ajax({
				url:'/docp.php',
				type:'POST',
				data:ord,
				success: function(data){ 
				if(opt=="goodr")
					 t.innerText="已赞";	else	
					 t.innerText="已踩";				
				}
		});	
	}
	function ed(t,id){
art.dialog.open("docp.php?m=a&cp=<?=$cpidd?>&editid="+id, { 
follow: t,width: 300, height: 260,title:'<?php echo $pDa['text']; ?>--'+document.getElementById('th'+id).innerText+' '+id} );	
	}
</script>