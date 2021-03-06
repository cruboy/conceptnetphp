<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
	<div class="posttitle"><?php echo $title; ?></div>
	<div class="postinfo">作者:<?php echo $user_cache[$author]['name'];?> 
	添加：<?=$addtime?> 修改：<?=$edittime?>评论:<?php echo $comnum; ?> 阅读:<?php echo $views; ?> 分类<?=$sortid?>
	<?php if(ROLE == 'admin' || $author == UID): ?>
	<a href="./?action=dellog&gid=<?php echo $gid;?>">删除</a>
	<?php endif;?>
	</div>
	<div class="postcont"><?php echo $content; ?></div>
	<div class="t">评论：</div>
	<div class="c">
		<?php foreach($commentStacks as $cid):
			$comment = $comments[$cid];
			$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
		?>
		<div class="l">
		<div ><b><?php echo $comment['poster']; ?></b>
		<?php echo $comment['date']; ?> 
<?php if(ISLOGIN == true):?>
	<a href="./?action=reply&cid=<?php echo $comment['cid'];?>">回复</a>
	<?php endif; ?>
		</div>
		<div class="comcont"><?php echo $comment['content']; ?></div>
		</div>
		<?php endforeach; ?>
		<div id="page"><?php echo $commentPageUrl;?></div>
	</div>
	<div class="t">登录后发表评论：</div>
	<?php if(ISLOGIN == true):?>
	<div class="c">
		<form method="post" action="./index.php?action=addcom&gid=<?php echo $logid; ?>">
	
		当前已登录为：<b><?php echo $user_cache[UID]['name']; ?></b><br />
		邮件地址 (选填)<br /><input type="text" name="commail" value="<?php echo $user_cache[UID]['mail']; ?>" /><br />
		个人主页 (选填)<br /><input type="text" name="comurl" value="" /><br />

		内容<br /><textarea name="comment" rows="10"></textarea><br />
		<?php echo $verifyCode; ?><br /><input type="submit" value="发表评论" />
		</form>
	</div>		<?php endif; ?>
</div>