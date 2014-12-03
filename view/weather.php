<?php
/**
 * 天气信息查询结果显示页面
 *
 *
 */
if(!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<div align="center">
	<br> <br>
	<table width="760px" height="300px" cellpadding="5" cellspacing="0"	style="background: url(./content/images/weather.jpg)">
		<tr>
			<td colspan="4" align="center">
				<font style="font-size: 64; color: #00E3E3; font-family: 楷体;"><?php  echo $J->weatherinfo->city; ?></font>
				<font size="4" color="#FF9900"><?php  echo $J->weatherinfo->temp1."<br/>"; ?></font>
				<font size="7" color="#FFB90F"><?php  echo $J1->weatherinfo->temp."℃"."<br/>"; ?></font>
			</td>
			<td width="350" colspan="4" align="left">
				<font size="5" color="#FF9900"><?php  $t = mktime(0, 0, 0, date("m"), date("d"), date("Y")); $w = date("D", $t); echo date("m/d")." ".$weeks["$w"]."<br/>"; ?></font>
				<font size="2" color="#FF9900"><?php echo "<br/>".$J->weatherinfo->index_d; ?></font>
			</td>
		</tr>
		<tr height="60">
			<td colspan="2" align="center">
				<font style="font-size: 24; color: orange; font-family: 楷体;"><?php echo $J->weatherinfo->weather1; ?></font>
			</td>
			<td colspan="2" align="center">
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img1 ?>.gif" />
				<?php if($J->weatherinfo->img2!=99){ ?>
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img2 ?>.gif" />
				<?php } ?>
			</td>
			<td colspan="5" align="left">
				<font size="3" color="#FF9900">
				<?php
				echo "空气湿度：".$J1->weatherinfo->SD."<br/>";
				echo "风向风速：".$J1->weatherinfo->WD.$J1->weatherinfo->WS."<br/>";
				echo "紫外强度：".$J->weatherinfo->index_uv."<br/>";
				echo "穿衣指数：".$J->weatherinfo->index."<br/>";
				echo "舒适指数：".$J->weatherinfo->index_co."<br/>";
				echo "晨练指数：".$J->weatherinfo->index_cl;
				?>
				</font>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<?php if(strstr($weatherDateTime,"明天")) {  ?>
				<font color="red">
				<?php }else{ ?>
				<font color="#FF9900">
				<?php }
				$t = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
				$w = date("D", $t);
				$d=date("m/d", $t);
				echo $d." ".$weeks["$w"];
				?>
				</font>			
			</td>
			<td colspan="2" align="center">
				<?php if(strstr($weatherDateTime,"后天") && $weatherDateTime !="大后天") { ?>
				<font color="red">
				<?php }else{ ?>
				<font color="#FF9900">
				<?php }
				$t = mktime(0, 0, 0, date("m"), date("d") + 2, date("Y"));
				$w = date("D", $t);
				$d=date("m/d", $t);
				echo $d." ".$weeks["$w"];
				?>
				</font>			
			</td>
			<td colspan="2" align="center">
				<?php if(strstr($weatherDateTime,"大后天")) { ?>
				<font color="red">
				<?php }else{ ?>
				<font color="#FF9900">
				<?php }
				$t = mktime(0, 0, 0, date("m"), date("d") + 3, date("Y"));
				$w = date("D", $t);
				$d=date("m/d", $t);
				echo $d." ".$weeks["$w"];
				?>
				</font>			
			</td>
			<td colspan="2" align="center">
				<?php if($weatherDateTime=="未来") { ?>
				<font color="red">
				<?php }else{ ?>
				<font color="#FF9900">
				<?php }
				$t = mktime(0, 0, 0, date("m"), date("d") + 4, date("Y"));
				$w = date("D", $t);
				$d=date("m/d", $t);
				echo $d." ".$weeks["$w"];
				?>
				</font>			
			</td>
		</tr>
		<tr>
			<td align="center">
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img3 ?>.gif" />
				<?php if($J->weatherinfo->img4!=99){ ?>
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img4 ?>.gif" />
				<?php } ?>
			</td>
			<td style="border-right: 1px solid #008B8B;" align="center">
				<?php  if(strstr($weatherDateTime,"明天")) { ?>
				<font size="2" color="red">
				<?php }else{ ?>
				<font size="2" color="#FF9900">
				<?php }
					echo $J->weatherinfo->weather2."<br/>";
					echo $J->weatherinfo->temp2;
				?>
				</font>
			</td>
			<td align="center">
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img5 ?>.gif" />
				<?php if($J->weatherinfo->img6!=99){ ?>
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img6 ?>.gif" />
				<?php } ?>
			</td>
			<td style="border-right: 1px solid #008B8B;" align="center">
				<?php  if(strstr($weatherDateTime,"后天") && $weatherDateTime !="大后天") { ?>
				<font size="2" color="red">
				<?php }else{ ?>
				<font size="2" color="#FF9900">
				<?php }
					echo $J->weatherinfo->weather3."<br/>";
					echo $J->weatherinfo->temp3;
				?>
				</font>			
			</td>
			<td align="center">
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img7 ?>.gif" />
				<?php if($J->weatherinfo->img8!=99){ ?>
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img8 ?>.gif" />
				<?php } ?>
			</td>
			<td style="border-right: 1px solid #008B8B;" align="center">
				<?php if(strstr($weatherDateTime,"大后天")) { ?>
				<font size="2" color="red">
				<?php }else{ ?>
				<font size="2" color="#FF9900"> <?php }
					echo $J->weatherinfo->weather4."<br/>";
					echo $J->weatherinfo->temp4;
				?>
				</font>			
			</td>
			<td align="center">
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img9 ?>.gif" />
				<?php if($J->weatherinfo->img10!=99){ ?>
				<img src="http://m.weather.com.cn/img/b<?php echo $J->weatherinfo->img10 ?>.gif" />
				<?php } ?>
			</td>
			<td align="center">
				<?php  if($weatherDateTime=="未来") { ?>
				<font size="2" color="red">
				<?php }else{ ?>
				<font size="2" color="#FF9900">
				<?php }
					echo $J->weatherinfo->weather5."<br/>";
					echo $J->weatherinfo->temp5;
				?>
				</font>			
			</td>
		</tr>
		<tr>
			<td colspan="9" height="10"></td>
		</tr>
	</table>
</div>
