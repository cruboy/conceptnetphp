<?php if(!defined('EMLOG_ROOT')) {
    exit('error!');
}?>


<div align="center">
	<form action="/lilv.php" method="get" name="hinetslist">
	查询：<select	 name="bank" >
     <option value="" <?php if($v[bank]=='') echo "selected='selected'"; ?>>---</option>
				<option value="威商" <?php if($v[bank]=='威商') echo "selected='selected'"; ?>>威商</option>
				<option value="农合" <?php if($v[bank]=='农合') echo "selected='selected'"; ?>>农合</option>
				<option value="ICBC" <?php if($v[bank]=='ICBC') echo "selected='selected'"; ?>>ICBC</option>
				<option value="BC"	<?php if($v[bank]=='BC') echo "selected='selected'"; ?>>BC</option>
			</select> 
          
			 <select dir="ltr" name="used" id="darom" >
			<option value="0" <?php if($used==0) echo "selected='selected'"; ?>>所有</option>
			<option value="1" <?php if($used==1) echo "selected='selected'"; ?>>最新</option>
			<option value="2" <?php if($used==2) echo "selected='selected'"; ?>>旧的</option>
			</select> 
			 <input type="submit" value="查询" id="buttonGo" />
	</form>

	<table width="98%" cellspacing=2 cellpadding=2
		style="border-collapse: collapse; border: 1px dotted #cc0000">
		<tr style="border-collapse: collapse; border: 1px dotted #cc0000">
			<td colspan="12"><?php echo "利率--查询结果有 $nall 个，第 $page 页: <br>";?>
			</td>
		</tr>
		<tr style="background-color: #CCFFFF;">
			<td >id</td>
<td >bank</td><td >st</td><td >活</td><td >3月</td><td >6月</td><td >1年</td><td >2年</td><td >3年</td><td >5年</td>
<td >z1</td><td >z3</td><td >z5</td>
<td >xd</td><td >t1</td>
			<td >t7</td>
		</tr>
		<tr>
			<td clospan="7"><a href='lilv.php?action=edit&id='></a></td>
		</tr>
		<?php
		$i=0;
		while ($row = $DB->fetch_array($res)) {
		    if ($i % 2== 0) {
		        echo "<tr>";
		    } else {
	        echo "<tr style=\"background-color: #DDDDDD;\">";
		    }
		    for($j=0;$j<17;$j++){
		    ?>
  
			<td><?php $s=(each($row));if($j==8)echo "<font color=red>";echo $s[value]; 
			if($j==8)echo "</font>";?></td>
            <?  } ?>
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
