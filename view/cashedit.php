<?php if(!defined('EMLOG_ROOT')) {
    exit('error!');
}?>

<div id="m">
		<form action="cash.php?action=editok" method="post" name="hinet">
			<?php
			if($id<1){
				echo "添加cash：";
			}else{
				echo "修改cash：";
				echo $v[id];
			}
			?>
			<br>
			<input type="hidden" name="id" value="<?php  echo $v[id]; ?>" /> 
			银行: <?php  echo $v[bank]; ?>
			<select	 name="bank" >
            <option value="" <?php if($v[bank]=='') echo "selected='selected'"; ?>>---</option>
				<option value="威商" <?php if($v[bank]=='威商') echo "selected='selected'"; ?>>威商</option>
				<option value="农合" <?php if($v[bank]=='农合') echo "selected='selected'"; ?>>农合</option>
				<option value="ICBC" <?php if($v[bank]=='ICBC') echo "selected='selected'"; ?>>ICBC</option>
				<option value="BC"	<?php if($v[bank]=='BC') echo "selected='selected'"; ?>>BC</option>
			</select> (<?php  echo $v[fenhang]; ?>
            <select	 name="fenhang" ><?php  echo $v[fenhang]; ?>
				<option value="" <?php if($v[fenhang]=='') echo "selected='selected'"; ?>>---</option>
                <option value="河西" <?php if($v[fenhang]=='河西') echo "selected='selected'"; ?>>河西</option>
				<option value="长峰" <?php if($v[fenhang]=='长峰') echo "selected='selected'"; ?>>长峰</option>
				<option value="青岛" <?php if($v[fenhang]=='青岛') echo "selected='selected'"; ?>>青岛</option>
				<option value="威海"	<?php if($v[fenhang]=='威海') echo "selected='selected'"; ?>>威海</option>
			</select>
             ) 
				<br>账号： <input type="text" name="zhanghao" value="<?php  echo $v[zhanghao]; ?>" />
				 名 <select	 name="name" ><?php  echo $v[name]; ?>
				<option value="ma" <?php if($v[name]=='ma') echo "selected='selected'"; ?>>ma</option>
				<option value="lin" <?php if($v[name]=='lin') echo "selected='selected'"; ?>>lin</option>
                </select>
				 <br>
     开始<input type="text" name="start" value="<?php  echo $v[start]; ?>" />
				 <br>
		存期 <select	 name="nian" ><?php  echo $v[nian]; ?>
				<option value="0" <?php if($v[nian]=='') echo "selected='selected'"; ?>>---</option>
                <option value="0.5" <?php if($v[nian]==0.5) echo "selected='selected'"; ?>>0.5</option>
				<option value="1" <?php if($v[nian]==1) echo "selected='selected'"; ?>>1</option>
				<option value="2" <?php if($v[nian]==2) echo "selected='selected'"; ?>>2</option>
				<option value="3"	<?php if($v[nian]==3) echo "selected='selected'"; ?>>3</option>
			</select>
				<input	type="checkbox" name="auto" value="1" id="checkbox_auto"
				<?php if($v[auto]==1) echo "checked='checked'"; ?> /> <label
				for="checkbox_auto">梓旭</label>
                 利率<input type="text" name="lilv" value="<?php  echo $v[lilv]; ?>" />
				 <br>
        金额： <input type="text" name="money" value="<?php  echo $v[money]; ?>" /><br>			 
				 注释:<input type="text" name="note" value="<?php  echo $v[note]; ?>" />
				 <br>
				 
				 <input	type="checkbox" name="visible" value="1" id="checkbox_test"
				<?php if($v[visible]==1) echo "checked='checked'"; ?> /> <label
				for="checkbox_test">可用</label>
						
				<input	type="submit" value="确定修改" id="buttonGo" />
		</form>
</div>

