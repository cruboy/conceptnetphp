<?php if(!defined('EMLOG_ROOT')) {
    exit('error!');
}?>


<div align="center">
<table width="402" border="1">
  <tr>
    <td width="64">&nbsp;</td>
    <td width="116">conceptnet</td>
    <td width="98">cruboy</td>
    <td width="96">&nbsp;</td>
  </tr>
  <tr>
    <td>concept</td>
    <td><?=$nc['a']?>[<?=$nc2['a']?>]</td>
    <td><?=$cc['a']?>[<?=$cc2['a']?>]</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>assertion</td>
    <td><?=$na['a']?>[<?=$na2['a']?>]</td>
    <td><?=$ca['a']?>[<?=$ca2['a']?>]</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

	<form action="" method="get" name="hinetslist">
	<input type="hidden" name="action" value="hinets" />
	查询： <input type="text" name="word" value="<?php  echo $word; ?>" /> 关系: 
		(<input type="text" name="ass2" style="width: 50px;" value="<?php  echo $ass; ?>" /> ) 
		cp <input type="text"	name="rule" style="width: 120px;" value="<?php  echo $rule; ?>" />
		cp2 <input type="text"	name="rule2" style="width: 120px;" value="<?php  echo $rule2; ?>" />
		uid<input type="text"	name="procs" style="width: 120px;" value="<?php  echo $procs; ?>" />	 
	 
			 <select dir="ltr" name="used" id="darom" >
			<option value="0" <?php if($used==0) echo "selected='selected'"; ?>>所有</option>
			<option value="1" <?php if($used==1) echo "selected='selected'"; ?>>可用</option>
			<option value="2" <?php if($used==2) echo "selected='selected'"; ?>>不可用</option>
			</select> 
			 <input type="submit" value="查询" id="buttonGo" />（!不为空#为空）
	</form>

	<table width="98%" cellspacing=2 cellpadding=2
		style="border-collapse: collapse; border: 1px dotted #cc0000">
		<tr style="border-collapse: collapse; border: 1px dotted #cc0000">
			<td colspan="7"><?php echo "管理--查询结果有 $nall 个，第 $page 页: <br>";?>
			</td>
		</tr>
		<tr style="background-color: #CCFFFF;">
			<td width="7%">id</td>
			<td width="7%">view</td>
			<td width="5%">关系</td>
			<td width="18%">cp</td>
			<td width="18%">cp2</td>
			<td width="30%">date</td>
			<td width="5%">uid</td>
			<td width="7%">ip</td>

		</tr>
		<?php
		$i=0;
		while ($row = $DB->fetch_array($res)) {
		    if ($i % 2== 0) {
		        echo "<tr>";
		    } else {
	        echo "<tr style=\"background-color: #DDDDDD;\">";
		    }
		    
		    ?>
			<td><a href=''><?php echo $row[id]; ?>
			</a></td>
			<td><?php echo $row[viewid]; ?></td>
			<td><?php echo $row[rid]; ?></td>
			<td><a href="index.php?cp=<?php echo $row[cp0id]; ?>"><?php echo $row[cp0]; ?></a>
			</td>
			<td><a href="index.php?cp=<?php if($row[cp0id]<0)echo '-';echo abs($row[cpaddid]); ?>"><?php if($row[cpaddid]>0) echo '+';echo $row[cpadd]; ?></a>
			</td>
			<td><?php echo ($row[dates]); ?>
			</td>
			<td><?php echo $row[uid]; ?></td>
			<td><?php echo $row[loginip]; ?></td>

		     <tr>
			<?php
			$i++;
		}
		?>
			
		<tr>

	</table>
</div>

<div id='page'>
	<?php echo pagination($nall, 200, $page, $pageurl); ?>
</div>
