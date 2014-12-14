<?php if(!defined('EMLOG_ROOT')) {
    exit('error!');
}?>


<div align="center">
	<form action="./enet.php" method="get" name="hinetslist">
	<input type="hidden" name="action" value="hinets" />
	查询Node： <input type="text" name="word" value="<?php  echo $word; ?>" /> 关系: 
		<select dir="ltr" name="ass" id="datefrom" >
			<option value="0" <?php if($ass==0) echo "selected='selected'"; ?>>其他</option>
				<option value="16" <?php if($ass==16) echo "selected='selected'"; ?>>16方法</option>
				<option value="20" <?php if($ass==20) echo "selected='selected'"; ?>>20补充</option>
			<option value="1" <?php if($ass==1) echo "selected='selected'"; ?>>1
				sortid</option>
			<option value="2" <?php if($ass==2) echo "selected='selected'"; ?>>2
				title</option>
			<option value="3" <?php if($ass==3) echo "selected='selected'"; ?>>3
				aka</option>
			<option value="4" <?php if($ass==4) echo "selected='selected'"; ?>>4
				direct</option>
			<option value="5" <?php if($ass==5) echo "selected='selected'"; ?>>5
				cast</option>
			<option value="6" <?php if($ass==6) echo "selected='selected'"; ?>>6
				area</option>
			<option value="7" <?php if($ass==7) echo "selected='selected'"; ?>>7
				mtype</option>
			<option value="8" <?php if($ass==8) echo "selected='selected'"; ?>>8
				lang</option>
			<option value="9" <?php if($ass==9) echo "selected='selected'"; ?>>9
				year</option>
			<option value="10" <?php if($ass==10) echo "selected='selected'"; ?>>10
				tags</option>
			<option value="11" <?php if($ass==11) echo "selected='selected'"; ?>>11
				content</option>
			<option value="12" <?php if($ass==12) echo "selected='selected'"; ?>>12
				电视台</option>	
		</select> 
		(<input type="text" name="ass2" style="width: 50px;" value="<?php  echo $ass; ?>" /> ) 
		对应 <input type="text"	name="rule" style="width: 120px;" value="<?php  echo $rule; ?>" />
		对应2 <input type="text"	name="rule2" style="width: 120px;" value="<?php  echo $rule2; ?>" />
		处理代码<input type="text"	name="procs" style="width: 120px;" value="<?php  echo $procs; ?>" />	 
			 
			 <select dir="ltr" name="used" id="darom" >
			<option value="0" <?php if($used==0) echo "selected='selected'"; ?>>所有</option>
			<option value="1" <?php if($used==1) echo "selected='selected'"; ?>>可用</option>
			<option value="2" <?php if($used==2) echo "selected='selected'"; ?>>不可用</option>
			</select> 
			 <input type="submit" value="查询" id="buttonGo" />（!不为空#为空）
			 <a href='?post=20'>规则</a>
	</form>

	<table width="98%" cellspacing=2 cellpadding=2
		style="border-collapse: collapse; border: 1px dotted #cc0000">
		<tr style="border-collapse: collapse; border: 1px dotted #cc0000">
			<td colspan="7"><?php echo "Hinet+ 管理--查询结果有 $nall 个，第 $page 页: <br>";?>
			</td>
		</tr>
		<tr style="background-color: #CCFFFF;">
			<td width="10%">id</td>
			<td width="10%">text</td>
			<td width="8%">关系</td>
			<td width="10%">对应</td>
			<td width="10%">对应2</td>
			<td width="40%">PROCS</td>
			<td width="3%">n</td>
			<td width="3%">H</td>
			<td width="2%">cv</td>
		</tr>
		<tr>
			<td clospan="7"><a href='enet.php?action=editnet&id='>新增</a></td>
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
			<td><a href='enet.php?action=editnet&id=<?php echo $row[id]; ?>'><?php echo $row[id]; ?>
			</a></td>
			<td><?php echo $row[text]; ?></td>
			<td><?php echo $row[dotype]; ?></td>
			<td><?php echo $row[rule]; ?>
			</td>
			<td><?php echo $row[rule2]; ?>
			</td>
			<td><?php echo strip_tags($row[procs]); ?>
			</td>
			<td><?php echo $row[num_assertions]; ?></td>
			<td><?php echo $row[visible]; ?></td>
			<td><?php echo $row['cv']; ?></td>
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
