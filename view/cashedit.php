<?php if(!defined('EMLOG_ROOT')) {
    exit('error!');
}?>

<div id="m">
		<form action="enet.php?action=editnetok" method="post" name="hinet">
			<?php
			if($id<1){
				echo "新建node：";
			}else{
				echo "修改node：";
				echo $tpDa[id];
			}
			?>
			<br>
			<input type="hidden" name="id" value="<?php  echo $tpDa[id]; ?>" /> 
			<input type="text" name="word1" style="width: 500px;" value="<?php  echo $tpDa[text]; ?>" /> <br>
			以: 
			<select	dir="ltr" name="ass" id="datefrom">
				<option value="0" <?php if($ass==0) echo "selected='selected'"; ?>>其他</option>
				<option value="16" <?php if($ass==16) echo "selected='selected'"; ?>>16mdd</option>
				<option value="20" <?php if($ass==20) echo "selected='selected'"; ?>>20add</option>

				<option value="100"
				<?php if($ass==100) echo "selected='selected'"; ?>>100 control</option>
			</select> (<input type="text" name="ass2" style="width: 50px;"
				value="<?php  echo $ass; ?>" /> ) 关系对应到 
				<br>Rule： <input type="text" name="word2" value="<?php  echo $tpDa[rule]; ?>" />
				<br>
				 Rule2:<input type="text" name="word3" value="<?php  echo $tpDa[rule2]; ?>" />
				 <br>
				 处理代码：
				 <textarea name="procs" class="texts"><?php echo $tpDa[procs]; ?></textarea><br />				 
				 
				 
				 注释:<input type="text" name="note" value="<?php  echo $tpDa[note]; ?>" />
				 <br>
				 
				 <input	type="checkbox" name="dhide" value="1" id="checkbox_test"
				<?php if($dhide==1) echo "checked='checked'"; ?> /> <label
				for="checkbox_test">可用</label>
				 <input type="checkbox" name="bat"	value="1" id="checkbox_t" 
				 <?php if($tpDa['cv']==1) echo "checked='checked'"; ?> /> <label
				  for="checkbox_t">word_out_hinets保留</label>
				
				<input	type="submit" value="确定修改" id="buttonGo" />
		</form>
</div>

