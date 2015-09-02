<?php 
/*
* 首页
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

<div id="content">
<table width="100%" cellspacing=0 cellpadding=0 style="border:1px solid #cc0000; font-size:12px">

    <tr>
        <th style="text-align:left;">
        
             <h2><a href="?post=<?php echo $valuz['gid']; ?>"><?php echo $valuz['title']; ?></a></h2>
	<p class="date">作者：<?php blog_author($valuz['author']); ?> 发布于：<?php echo gmdate('Y-n-j G:i l', $valuz['date']); ?> 
	</p>
	<?php echo $valuz['content']; ?>
	<p class="count">
	评论(<?php echo $valuz['comnum']; ?>)
	引用(<?php echo $valuz['tbcount']; ?>)
	<a href="?post=<?php echo $valuz['gid']; ?>">浏览(<?php echo $valuz['views']; ?>)</a>
	</p>
        
        </th>
        <th style="text-align:left;">

<?php echo $cpidd; ?>&nbsp;&nbsp;
<?php echo $pDa['text']; ?>&nbsp;<br>
关系数<?php echo $pDa['f3']; ?>
（前向<?php echo $pDa['f1']; ?>
后向<?php echo $pDa['f2']; ?>）
 受记c:<?php echo $pDa['num_assertions']; ?>
 cruboy<?php echo $pDa['cruboy']; ?>
 查看<?php echo $pDa['words']; ?>
 标记<?php echo $pDa['language_id']; ?> ======================================================================================<br>
<?php 
foreach($concepts as $value):
?>
&nbsp;&nbsp;
<a href="?cp=<?php echo $value['id']; ?>">
<?php echo $value['text']; ?></a>&nbsp;
<?php echo $value['f3']; ?>
:<?php echo $value['num_assertions']; ?>
<?php echo " +".$value['relation_id'].".".$value['best_frame_id'].' '.$value['rela'].":".$value['frame']; ?>
<br>
<?php endforeach; ?>
=========反向关系============<br>
<?php 
foreach($concepts2 as $value):
?>
&nbsp;&nbsp;
<a href="?cp=<?php echo $value['id']; ?>">
<?php echo $value['text']; ?></a>&nbsp;
<?php echo $value['f3']; ?>
:<?php echo $value['num_assertions']; ?>
<?php echo " -".$value['relation_id'].".".$value['best_frame_id'].' '.$value['rela'].":".$value['frame']; ?>
<br>
<?php endforeach; ?>
<br>

<form name="addcp" method="post" action="<?php echo BLOG_URL; ?>m/doadd.php?action=addcp">
    添加
    <input id="sch" type="radio" value="0" name="dirs" checked />
    <label for="sch" >前向(1=“<?php echo $pDa['text']; ?>”)</label> 
	<input id="sch1" type="radio" value="1" name="dirs" />
	<label for="sch1" >反向(2=“<?php echo $pDa['text']; ?>”)</label> 
	的关联概念：<br>
	关系：
    <select dir="ltr" name="addrel" id="darom" >
	<option value="0">请选择...</option>
	<option value="33" >{1}会让你想要{2}</option>
	<option value="34" style="background-color:#FFFFFF; color:blue">{1}会让你{2}</option><option value="35" style="background-color:#FFFFFF; color:blue">{1}之后可能会发生的事情是{2}</option><option value="36" style="background-color:#FF77FF; color:blue">因为{1}所以{2}</option><option value="37" style="background-color:#FFFFFF; color:blue">{1}可能会带来{2}</option><option value="38" style="background-color:#FFFFFF; color:blue">{1}可能会引起{2}</option>
	<option value="40">{1}的时候，首先要{2}</option><option value="45">{1}是{2}的一部分</option>
	<option value="46" style="background-color:#FFFFFF; color:yellow">{1}可以用{2}制成</option><option value="47" style="background-color:#FFFFFF; color:yellow">{1}由{2}组成</option><option value="50">{1}是一种{2}</option><option value="51" style="color:grey">{1}在{2}里</option><option value="55" style="color:grey">{1}在{2}外</option><option value="57" style="color:grey">你可以在{2}找到{1}</option><option value="58" style="color:grey">{2}有{1}</option>
	<option value="60">{2}的时候可能会用到{1}</option><option value="63">{1}能做的事情有{2}</option><option value="64">{1}会{2}</option>
	<option value="65" style="background-color:#FFFFFF; color:green">你会{1}因为你{2}</option>	<option value="66" style="color:green">{1}是为了{2}</option><option value="67" style="color:green">想要有{2}应该要{1}</option><option value="68" style="color:green">当你想要{2}的时候你可能会{1}</option><option value="69" style="color:green">{2}的时候会想要{1}</option>
	<option value="70" style="background-color:#FFFFFF; color:red">{1}喜欢{2}</font></option><option value="71" style="background-color:#FFFFFF; color:red">{1}想要{2}</option><option value="72" style="background-color:#FFFFFF; color:red">{1}不想要{2}</option><option value="73" style="background-color:#FFFFFF; color:red">{1}害怕{2}</option><option value="75" style="background-color:#FFFFFF; color:red">{1}痛恨{2}</option>
	<option value="79">{1}是{2}的</option><option value="84">{2}可能代表{1}</option><option value="89">{1}代表{2}</option><option value="92">{1}的时候，你会{2}</option><option value="95">在{1}，你会{2}</option>   
</option>
	</select> 
	名称：<input name="addname"  type="text" value="" style="width:120px;"/>
    <input type="hidden" name="cp0s" value="<?php echo $pDa['text']; ?>" />
    <input type="hidden" name="cid" value="<?php echo $cpidd; ?>" />
	<input type="submit" id="addcpsubmit" value="添加" />
	</form>

</th>
  </tr>
  </table>
