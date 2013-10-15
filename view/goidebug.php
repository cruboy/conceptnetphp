<?php if(!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>

<div id="m">
	<h3>
		<span>$views:<?php echo $views; ?>
	</h3>
	<table width="98%" cellspacing=2 cellpadding=2
		style="border-collapse: collapse; border: 1px dotted #cc0000">
		<td width="50%" style="border-collapse: collapse; border: 1px dotted #cc0000">
    状态：source:<?php echo $source." test: ".$test." ondemo:".$ondemo; ?><br>
    $akey:<?php echo $akey; ?><br>
	$segresult:<?php echo $segresult; ?><br>
    $word_to_hinets:<?php echo $word_to_hinets; ?><br>
    $word_out_hinets:<?php echo $word_out_hinets; ?><br>
    $oword:<?php echo $oword; ?><br>
    $method:<?php echo $method; ?><br>
    $debuginf:<?php echo $debuginf; ?><br>
	$ause:<?php echo $ause; ?><br>
	$atitle:<?php echo $atitle; ?><br>
	<br>
	$onlogic:<?php echo $onlogic; ?><br>
	$onopt:<?php echo $onopt; ?><br>
	$controltype:<?php echo $controltype; ?><br>
	$goi:<?php echo $goi; ?><br>
	lonopt: <?php echo $_SESSION['lonopt']; ?><br>
	llonopt: <?php echo $_SESSION['llonopt']; ?><br>
	$goiresult： <?php echo $goiresult; ?><br>
	$voice:<?php echo $voice; ?><br>

	<td width="50%">$logs： <?php foreach($logs as $jn=>$value): if($jn>19)break;?>
	
				<a href="<?php echo BLOG_URL.$pagepre.$value['gid'];?>"> <?php echo $value['title']; ?>
				</a> &nbsp;(
				<?php echo $value['gid'];?>
				) <font color=#999999><?php echo $value['aka'];?> </font>
		<?php echo $value['show'].' '; ?> <?php echo $value['tags']; ?>
         	(<?php echo $value['id'];?>)
				<?php echo gmdate('Y-n-j', $value['date']); ?>
		
			<br>
			 <?php endforeach; ?>
		</td>

</table>
</div>