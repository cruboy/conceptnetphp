<?php if(!defined('EMLOG_ROOT')) {exit('error!');}

?>

<div>
    <div align="center">
         <form name="keycp" method="get" action="toddler.php">
     <?php   if(0){?>   
     <span><img src="/m/boy.jpg" border="0"></span><br>
<?php } ?>
    <br>
            <input id="searchValue" name="k" type="text" value="<?php echo $akey; ?>" 
                style="font-size:16; width:300px; height:20px;" />       
           <?php   if($tvid>0){?>   
     <input type="hidden" name="devid" value=<?php echo $tvid; ?> />
<?php } ?>
            <input type="submit" id="logserch_logserch" value="输 入" 
               style="width:60px; height:22px; text-align:center; font-size:12;" />
        </form>
 <?php 
 if($akey_remain!="")
	echo "Go on:<a href=\"/seeker.php?re=6&k=".urlencode($akey_remain)."\">$akey_remain </a> ";
  if($ondemo==0): foreach($flog as $value): ?>
	<a href="<?php echo BLOG_URL."/".$goiecall; ?>.php?re=1&k=<?php echo urlencode($value['content']); ?>">
<?php echo $value['content']; ?> <br></a> 
<?php endforeach; ?>
	<div id="page"><?php echo $page_url;?></div>
	<?php endif; ?>
	
	</div>
	