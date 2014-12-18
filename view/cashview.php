<?php if(!defined('EMLOG_ROOT')) {
    exit('error!');
}?>


<div align="center">
	<form action="./enet.php" method="get" name="hinetslist">
	<input type="hidden" name="action" value="hinets" />
	查询： <input type="text" name="word" value="<?php  echo $word; ?>" /> 关系: 
		<select dir="ltr" name="ass" id="datefrom" >
			<option value="0" <?php if($ass==0) echo "selected='selected'"; ?>>其他</option>
				
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

		</select> 
		(<input type="text" name="ass2" style="width: 50px;" value="<?php  echo $ass; ?>" /> ) 
		对应 <input type="text"	name="rule" style="width: 120px;" value="<?php  echo $rule; ?>" />
		 
			 
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
			<td colspan="7"><?php echo "支票--查询结果有 $nall 个，第 $page 页: <br>";?>
			</td>
		</tr>
		<tr style="background-color: #CCFFFF;">
			<td width="6%">id</td>
			<td width="10%">银行</td>
			<td width="14%">号</td>
			<td width="10%">开始</td>
			<td width="10%">结束</td>
			<td width="5%">存期</td>
            <td width="10%">结束2</td>
			<td width="10%">金额</td>
            <td width="10%">息</td>
			<td width="10%">总</td>
            <td width="10%">钱</td>
			<td width="2%">cv</td>
		</tr>
		<tr>
			<td clospan="7"><a href='cash.php?action=edit&id='>新增</a></td>
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
			<td><a href='cash.php?action=edit&id=<?php echo $row[id]; ?>'>
			<?php echo $row[id]; ?>	</a></td>
			<td><?php echo $row[bank]; ?><?php echo $row[fenhang]; ?></td>
			<td><?php echo $row[name]; ?><?php echo $row[zhanghao]; ?>	</td>
			<td><?php echo $row[start]; ?>	</td>
		<td><?php echo $row[end0]; ?>	</td>
			<td><?php echo $row[nian]; if($row[auto])echo "Y"?></td>
           <td> <?php echo $row[ends]; ?></td>
			<td><?php echo $row[money]; ?></td>
            <td><?php echo $row[lilv]; ?>@<?php echo $row[lixi]; ?></td>
            <td><?php echo $row[account]; ?></td>
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
