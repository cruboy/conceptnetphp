<?php
/**
 * 词库管理显示
 *
 * @copyright Hisense All Rights Reserved
 */
if(!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>

<form action="/m/dict.php" method="get" name="dictManage">
	<input id="sch" type="radio" value="sch" name="opt" <?php if($opt == "sch")echo "checked";?> />
	<label for="sch" title="词库查询">前向匹配查询</label>
	<input id="sch1" type="radio" value="sch1" name="opt" <?php if($opt == "sch1")echo "checked";?> />
	<label for="sch1" title="词库查询">后向匹配查询</label>
	<input id="sch2" type="radio" value="sch2" name="opt" <?php if($opt == "sch2")echo "checked";?> />
	<label for="sch2" title="词库查询">任意匹配查询</label>
	<input id="sch3" type="radio" value="sch3" name="opt" <?php if($opt == "sch3")echo "checked";?> />
	<label for="sch3" title="词库查询">精确匹配查询</label>
	<input id="upd" type="radio" value="upd" name="opt" <?php if($opt == "upd")echo "checked";?> />
	<label for="upd" title="词库更新（包含添加、删除）">更新</label>
	词:
	<input type="text" name="word" value="" />
	作为:
	<select name="wordFlg">
		<option value="">普通词</option>
		<option value="FILMNAME" <?php if($wordFlg=="FILMNAME") echo "selected='selected'"; ?>>影视名称</option>
		<option value="STOPWORD" <?php if($wordFlg=="STOPWORD") echo "selected='selected'"; ?>>停止词</option>
		<option value="QUANTIFIER" <?php if($wordFlg=="QUANTIFIER") echo "selected='selected'"; ?>>数量词</option>
		<option value="DELFLG" <?php if($wordFlg=="DELFLG") echo "selected='selected'"; ?>>删除词</option>
		<option value="FILMTYPE" <?php if($wordFlg=="FILMTYPE") echo "selected='selected'"; ?>>影视类型</option>
		<option value="ACTORANDDIRECTOR" <?php if($wordFlg=="ACTORANDDIRECTOR") echo "selected='selected'"; ?>>演员导演</option>
	</select>
	曾为
	<select name="wold">
		<option value="" <?php if($wold=="") echo "selected='selected'"; ?>>---</option>
		<option value="temp" <?php if($wold=="temp") echo "selected='selected'"; ?>>待处理</option>
		<option value="step" <?php if($wold=="step") echo "selected='selected'"; ?>>step</option>
		<option value="FILMNAME" <?php if($wold=="FILMNAME") echo "selected='selected'"; ?>>影视名称</option>
		<option value="STOPWORD" <?php if($wold=="STOPWORD") echo "selected='selected'"; ?>>停止词</option>
		<option value="QUANTIFIER" <?php if($wold=="QUANTIFIER") echo "selected='selected'"; ?>>数量词</option>
		<option value="FILMTYPE" <?php if($wold=="FILMTYPE") echo "selected='selected'"; ?>>影视类型</option>
		<option value="ACTORANDDIRECTOR" <?php if($wold=="ACTORANDDIRECTOR") echo "selected='selected'"; ?>>演员导演</option>
	</select>
	<input type="submit" value="确定执行" />
	<a href='/m/dict.php?action=runs'>分词服务查看</a>
</form>
<div align="center">
	<form action="dict.php?opt=updid" method="post">
		<table width="98%" cellspacing=2 cellpadding=2 style="border: 1px dotted #cc0000">
			<tr style="border: 1px dotted #cc0000">
				<td colspan="16">
				<?php
				if($wordFlg==""){
					echo "词库管理--查询：标记为[普通词] 的 '$word' 有 $nall 个！<br>";
				}else{
					echo "词库管理--查询：标记为[$wordFlg] 的 '$word' 有 $nall 个！<br>";
				}
				?>
				</td>
			</tr>
			<tr style="background-color: #CCFFFF;">
				<td width="6%">id</td>
				<td width="20%">WORD</td>
				<td width="3%">量词</td>
				<td width="4%">停用</td>
				<td width="4%">类型</td>
				<td width="4%">影名</td>
				<td width="4%">演员</td>
				<td width="4%">删除</td>
				<td width="6%">id</td>
				<td width="20%">WORD</td>
				<td width="3%">量词</td>
				<td width="4%">停用</td>
				<td width="4%">类型</td>
				<td width="4%">影名</td>
				<td width="4%">演员</td>
				<td width="4%">删除</td>
			</tr>
			<?php
			$i = 0;
			while ($row = $DB->fetch_array($res)) {
				if ($i % 4 == 0) {
			?>
			<tr>
			<?php 
				} else if ($i % 2 == 0) {
			?>
			<tr style="background-color:#DDDDDD;">
			<?php } ?>
			<td><?php echo $row[ID];?></td>
			<td><?php echo $row[WORD];?>
				<input type="checkbox" name="wids[<?php echo $row['ID']; ?>]" value="1" />
			</td>
			<td><?php echo $row[QUANTIFIER];?></td>
			<td><?php echo $row[STOPWORD];?></td>
			<td><?php echo $row[FILMTYPE];?></td>
			<td>
				<?php
				if($row[FILMNAME]==1){
					echo $row[FILMNAME]."<a href='dict.php?opt=upd&wid=$row[ID]&wordFlg='>去</a>";
				}else{
					echo $row[FILMNAME]."<a href='dict.php?opt=upd&wid=$row[ID]&wordFlg=FILMNAME'>名</a>";
				}
				?>
			</td>
			<td><?php echo $row[ACTORANDDIRECTOR];?></td>
			<td>
				<?php
				if($row[DELFLG]==1){
					echo $row[DELFLG]."<a href='dict.php?opt=upd&wid=$row[ID]&wordFlg='>还</a>";
				}else{
					echo $row[DELFLG]."<a href='dict.php?opt=upd&wid=$row[ID]&wordFlg=DELFLG'>删</a>";
				}
				?>
			</td>
			<?php
				$i++;
			}
			$pageurl="dict.php?opt=$opt&word=$word&wordFlg=$wordFlg&wold=$wold&nall=$nall&page=";
			?>
		</table>
		<br>
		将所选择的词修改为：
		<select name="wordF">
			<option value="">普通词</option>
			<option value="FILMNAME" <?php if($wordF=="FILMNAME") echo "selected='selected'"; ?>>影视名称</option>
			<option value="STOPWORD" <?php if($wordF=="STOPWORD") echo "selected='selected'"; ?>>停止词</option>
			<option value="QUANTIFIER" <?php if($wordF=="QUANTIFIER") echo "selected='selected'"; ?>>数量词</option>
			<option value="DELFLG" <?php if($wordF=="DELFLG") echo "selected='selected'"; ?>>删除词</option>
			<option value="FILMTYPE" <?php if($wordF=="FILMTYPE") echo "selected='selected'"; ?>>影视类型</option>
			<option value="ACTORANDDIRECTOR" <?php if($wordF=="ACTORANDDIRECTOR") echo "selected='selected'"; ?>>演员导演</option>
		</select>
		<input type="submit" value="确定" class="submit" />
	</form>
</div>
<?php
	echo "<div id='page'>".pagination($nall, 100, $page, $pageurl)."</div>";
?>