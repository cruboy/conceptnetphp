<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//echo View::getView('module');<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript">//</ script>
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $blogtitle; ?></title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $description; ?>" />

<link href="<?php echo TEMPLATE_URL; ?>main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/content/js/jquery-1.8.2.min.js"></script>
  <script src="/content/js/jquery-ui.js"></script> 
  <script type="text/javascript" src="/content/js/jquery_p.js"></script>
</head>
<body>
<div id="navi">

<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=48" <?php if($cpid==48)echo 'id="active"'; ?>>志愿者</a>
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=72" <?php if($cpid==72)echo 'id="active"'; ?>>home</a>
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=468" <?php if($cpid==468)echo 'id="active"'; ?>>爱心</a>
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=405" <?php if($cpid==405)echo 'id="active"'; ?>>善良</a>
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=136" <?php if($cpid==136)echo 'id="active"'; ?>>知识</a>
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=182" <?php if($cpid==182)echo 'id="active"'; ?>>爱</a>
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=27310"<?php if($cpid==27310)echo 'id="active"'; ?> >儿童</a> 
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=798" <?php if($cpid==798)echo 'id="active"'; ?>>孩子</a> 
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=54" <?php if($cpid==54)echo 'id="active"'; ?>>学习</a>
<a href="<?php echo BLOG_URL; ?>m/ainet.php?cp=653" <?php if($cpid==653)echo 'id="active"'; ?>>上学</a> 
<a href="/" ><?php if(UID) echo $userData['username']; else echo "游客"; ?></a>，您好！
<a href="/">首页</a>
<a href="<?php echo BLOG_URL; ?>m/ainet.php" <?php if($action=='')echo 'id="active"'; ?>>本首页</a> 
<?php if(ISLOGIN === true): ?>
<a href="<?php echo BLOG_URL; ?>m/do.php" <?php if($action=='admin')echo 'id="active"'; ?> >管理</a> 
<a href="<?php echo BLOG_URL; ?>m/?action=logout" >退出</a> 
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login" <?php if($action=='about')echo 'id="active"'; ?> >登录</a>
<?php endif;?>
</div>
