<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./">首页</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com" id="active">评论</a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=write">写日志</a> 
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
	<div class="comcont">回复<b><?php echo $poster; ?></b>：<?php echo $comment; ?></div>
	<form method="post" action="./index.php?action=addcom&gid=<?php echo $gid; ?>&pid=<?php echo $cid; ?>">

	<input type="hidden" name="comname" value="<?php echo $user_cache[UID]['name']; ?>" />
	<input type="hidden" name="commail" value="<?php echo $user_cache[UID]['mail']; ?>" />
	<input type="hidden" name="comurl" value="<?php echo BLOG_URL; ?>" />

	内容<br /><textarea name="comment" rows="10"></textarea><br />
	<?php echo $verifyCode; ?><br /><input type="submit" value="发表评论" />
	</form>
</div>