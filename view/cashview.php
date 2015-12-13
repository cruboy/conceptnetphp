<?php if(!defined('EMLOG_ROOT')) {
    exit('error!');
}?>


<div align="center">
	<form action="/m/cash.php" method="get" name="hinetslist">
	查询：<select	 name="bank" >
     <option value="" <?php if($v[bank]=='') echo "selected='selected'"; ?>>---</option>
				<option value="威商" <?php if($v[bank]=='威商') echo "selected='selected'"; ?>>威商</option>
				<option value="农合" <?php if($v[bank]=='农合') echo "selected='selected'"; ?>>农合</option>
				<option value="ICBC" <?php if($v[bank]=='ICBC') echo "selected='selected'"; ?>>ICBC</option>
				<option value="BC"	<?php if($v[bank]=='BC') echo "selected='selected'"; ?>>BC</option>
			</select> 
            名 <select	 name="name" ><?php  echo $v[name]; ?>
            <option value="" <?php if($rule=='') echo "selected='selected'"; ?>>--</option>
				<option value="ma" <?php if($rule=='ma') echo "selected='selected'"; ?>>ma</option>
				<option value="lin" <?php if($rule=='lin') echo "selected='selected'"; ?>>lin</option>
                </select>
			 <select dir="ltr" name="used" id="darom" >
			<option value="0" <?php if($used==0) echo "selected='selected'"; ?>>所有</option>
			<option value="1" <?php if($used==1) echo "selected='selected'"; ?>>可用</option>
			<option value="2" <?php if($used==2) echo "selected='selected'"; ?>>不可用</option>
			</select> 
			 <input type="submit" value="查询" id="buttonGo" />
	</form>

	<table width="98%" cellspacing=2 cellpadding=2
		style="border-collapse: collapse; border: 1px dotted #cc0000">
		<tr style="border-collapse: collapse; border: 1px dotted #cc0000">
			<td colspan="12"><?php echo "支票--查询结果有 $nall 个，第 $page 页: <br>";?>
			</td>
		</tr>
		<tr style="background-color: #CCFFFF;">
			<td width="6%"><a href='<?=$pageurl?>id'>id</a></td>
			<td width="10%"><a href='<?=$pageurl?>bank'>银行</a></td>
			<td width="4%">号</td>
			<td width="10%"><a href='<?=$pageurl?>start'>开始</a></td>
			
			<td width="5%"><a href='<?=$pageurl?>nian'>存期</a></td>
            <td width="10%"><a href='<?=$pageurl?>end0'>转至</a></td>
            <td width="10%"><a href='<?=$pageurl?>lixi0'>中息</a></td>
            <td width="10%"><a href='<?=$pageurl?>ends'>结束2</a></td>
			<td width="10%"><a href='<?=$pageurl?>money'>金额</a></td>
             <td width="6%">率</td>
            <td width="6%"><a href='<?=$pageurl?>lixi'>息</a></td>
			<td width="10%"><a href='<?=$pageurl?>'>总</a></td>
            <td width="10%"><a href='<?=$pageurl?>'>活</a></td>
             <td width="10%"><a href='<?=$pageurl?>'>至天</a></td>
              <td width="10%"><a href='<?=$pageurl?>'>损</a></td>
			<td width="2%">cv</td>
		</tr>
		<tr>
			<td clospan="7"><a href='cash.php?action=edit&id='>新增</a></td>
		</tr>
		<?php
		$i=0;
		while ($row = $DB->fetch_array($res)) {
			$zt=intval((time()-strtotime($row[end0]))/3600/24);
			$rhuo=0.35*$row[money]*$zt/365;
			$rhuo=intval($rhuo)/100;
		    if ($i % 2== 0) {
		        echo "<tr>";
		    } else {
	        echo "<tr style=\"background-color: #DDDDDD;\">";
		    }
		    
		    ?>
			<td><a href='cash.php?action=edit&id=<?php echo $row[id]; ?>'>
			<?php echo $row[id]; ?>	</a></td>
			<td><?php echo $row[bank]; ?><?php echo $row[fenhang]; ?></td>
			<td title="<?php echo $row[zhanghao]; ?>	"><?php echo $row[name]; ?><?php echo substr($row[zhanghao],-2,2); ?>	</td>
			<td><?php echo $row[start]; ?>	</td>
		
			<td><?php echo $row[nian]; if($row[auto])echo "z"?></td>
            <td><?php echo $row[end0]; ?>	</td>
            <td title="<?php echo $row[notexi]; ?>"><?php echo $row[lixi0]; ?>	</td>
           <td> <?php echo $row[ends]; ?></td>
			<td><?php echo $row[money]; ?></td>
            <td><?php echo $row[lilv]; ?></td>
            <td ><?php echo $row[lixi]; ?></td>
            <td><?php echo $row[money]+$row[lixi0]+$row[lixi]; ?></td>
               <td><?php echo $rhuo; ?></td>
                  <td><?php echo $zt; ?></td>
                   <td><?php echo $row[lixi]-$rhuo; ?></td>   
			<td><?php echo $row['visible']; ?></td>
		     <tr>
			<?php
			$myy+=$row[money];
			$x+=$row[lixi0];
			$xx+=$row[lixi];
			$i++;
		}
		?>
			
		<tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><?=$x?></td><td></td><td><?=$myy?></td>
<td><?=$xx?></td></tr>
	</table>
</div>

<div id='page'>
	<?php echo pagination($nall, 200, $page, $pageurl); ?>
</div>
