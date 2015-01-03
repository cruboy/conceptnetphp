<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//echo View::getView('module');<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript">//</ script>
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>图编辑</title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $description; ?>" />

<link href="<?php echo TEMPLATE_URL; ?>main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/content/js/jquery-1.8.2.min.js"></script>
  <script src="/content/js/jquery-ui.js"></script> 
  <script type="text/javascript" src="/content/js/jquery_p.js"></script>
  <style type="text/css" id="internalStyle">

#m{text-align:left;padding:10px;}
.comcont{color:#333; padding:6px 0px;}.reply{color:#FF3300; font-size:12px;}
.texts{width:86%; height:150px;}
</style>
</head>
<body>
<div id="nav">
<ul>
<li class="common"><a href="/">首页</a></li>
<li class="common"><a href="<?php echo BLOG_URL; ?>m/ainet.php" <?php if($action=='')echo 'id="active"'; ?>>图搜索</a> </li>
<li class="common"><a href="<?php echo BLOG_URL; ?>m/ainet.php?u=<?=UID?>" <?php if($action=='')echo 'id="active"'; ?>>我的图</a> </li>
	<?php if(ROLE == 'admin' ): ?>
    <a href="<?php echo BLOG_URL; ?>m/admin.php">统计管理</a>
    <? endif;?>
<?php if(UID) echo $userData['username']; ?>，
<a href="<?php echo BLOG_URL; ?>m/?action=logout" >退出</a> 
</ul>
</div>
