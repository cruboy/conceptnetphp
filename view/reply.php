<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
	<div class="comcont">回复<b><?php echo $poster; ?></b>：<?php echo $comment; ?></div>
	<form method="post" action="./index.php?action=addcom&gid=<?php echo $gid; ?>&pid=<?php echo $cid; ?>">
	<?php
		if(ISLOGIN == true):
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
	?>
	当前已登录为<b><?php echo $user_cache[UID]['name']; ?></b><br />
	<input type="hidden" name="comname" value="<?php echo $user_cache[UID]['name']; ?>" />
	<input type="hidden" name="commail" value="<?php echo $user_cache[UID]['mail']; ?>" />
	<input type="hidden" name="comurl" value="<?php echo BLOG_URL; ?>" />
	<?php else: ?>
	昵称<br /><input type="text" name="comname" value="" /><br />
	邮件地址 (选填)<br /><input type="text" name="commail" value="" /><br />
	个人主页 (选填)<br /><input type="text" name="comurl" value="" /><br />
	<?php endif; ?>
	内容<br /><textarea name="comment" rows="10"></textarea><br />
	<?php echo $verifyCode; ?><br /><input type="submit" value="发表评论" />
	</form>
</div>