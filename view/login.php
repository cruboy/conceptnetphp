<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
<?php if($action=='login'): ?>
欢迎登录访问！您将看到更多内容。<br>
<font color="red"><?php echo $errorInfo; ?></font><br><br>
<form method="post" action="./?action=auth">
		用户名<br />
	    <input type="text" name="user" /><br />
	    密码<br />
	    <input type="password" name="pw" /><br />
	    <?php echo $ckcode; ?>
	    <br /><input type="submit" value=" 登 录" />
	    <a href="./?action=reg">注册</a>
	</form>
	
<?php endif;?>
<?php if($action=='reg'): ?>
欢迎 注册！
<form method="post" action="./?action=new">
		用户名<br />
	    <input type="text" name="user" /><br />
	    密码<br />
	    <input type="password" name="pw" /><br />
	     重复密码<br />
	    <input type="password" name="pw2" /><br />
	     注册码（请加入qq群180406860获得）<br />
	    <input type="password" name="pw3" /><br />
	    <?php echo $ckcode; ?>
	    <br /><input type="submit" value=" 注册" />
	    <a href="<?php echo BLOG_URL; ?>m/?action=login">登录</a>
	</form>
	
<?php endif;?>
</div>