<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo Option::get('blogname'); ?></title>
<style type="text/css" id="internalStyle">
body{background-color:#FFFFFF; font-size:14px; margin: 0; padding:0;}
a:link,a:visited,a:hover,a:active {text-decoration: none;color:#333;}
#top{background-color:#32598B; padding:10px 8px;}#footer{background-color:#EFEFEF; color:#666666; padding:5px;text-align:center;font-weight:bold;}
#page{text-align:center;font-size:26px; color: #CCCCCC}#page a:link,a:active,a:visited,a:hover{padding:0px 6px;}#m{padding:10px;}
#blogname{font-weight:bold; color:#FFFFFF; font-size:14px;}
#navi{background:#EFEFEF; padding:3px 0px; text-align:right;}#active{font-weight:bold; font-size:16px;}
.title{font-weight:bold; margin:10px 0px 5px 0px;}.title a:link, a:active,a:visited,a:hover{color:#333360; text-decoration:none}
.info{font-size:12px;color:#999999;}.info2{font-size:12px; border-bottom:#CCCCCC dotted 1px; text-align:right; color:#666666; margin:5px 0px; padding:5px;}
.posttitle{font-size:16px; color:#333; font-weight:bold;}.postinfo{font-size:12px; color: #999999;}
.postcont{border-bottom:1px solid #DDDDDD; padding:12px 0px; margin-bottom:10px;}
.t{font-size:16px; font-weight:bold;}.c{padding:10px;}.l{border-bottom:1px solid #DDDDDD; padding:10px 0px;}.twcont{color:#333; padding-top:12px;}
.twinfo{text-align:right; color:#999999; border-bottom:1px solid #DDDDDD; padding:8px 0px; font-size:12px;}
.comcont{color:#333; padding:6px 0px;}.reply{color:#FF3300; font-size:12px;}
.cominfo{text-align:right; color:#999999; border-bottom:1px solid #DDDDDD; padding:8px 0px;font-size:12px;}
.texts{width:92%; height:200px;}.excerpt{width:92%; height:100px;}
</style>
</head>
<body>
<div id="top">
<div id="blogname"><?php echo Option::get('blogname'); ?></div>
</div>
<div id="navi">
<?php if(UID) echo $userData['username']; else echo "游客"; ?></a>，您好！
<a href="/m" <?php if($action=='')echo 'id="active"'; ?>>首页</a> 
<a href="/m/?action=ailist&cplist" <?php if($action=='ailist')echo 'id="active"'; ?>>认知网格</a>
<a href="/m/?action=blog" <?php if($action=='blog')echo 'id="active"'; ?>>文章资料</a>
<a href="/m/ainet.php" <?php if($aineth)echo 'id="active"'; ?>>图编辑</a>
<a href="/m/?action=film" <?php if($action=='film')echo 'id="active"'; ?>>影视</a> 
<a href="/m/?action=story" <?php if($action=='story')echo 'id="active"'; ?>>童话故事</a> 
<a href="/jt/?m" <?php if($action=='zz')echo 'id="active"'; ?>>节点图</a> 
<a href="/m/?action=tw" <?php if($action=='tw')echo 'id="active"'; ?>>动态</a> 
<a href="/m/?action=com" <?php if($action=='com')echo 'id="active"'; ?>>评论</a> 
	<?php if(ROLE == 'admin' ): ?>
    <a href="<?php echo BLOG_URL; ?>m/cash.php">支票</a>
<a href="<?php echo BLOG_URL; ?>m/enet.php">enet管理</a>
<a href="<?php echo BLOG_URL; ?>m/dict.php">词典</a>
 <a href="<?php echo BLOG_URL; ?>m/lilv.php">利率</a>
<a href="/m/?action=write" <?php if($action=='write')echo 'id="active"'; ?>>写日志</a> 
<?php endif;?>
<?php if(ISLOGIN === true): ?>
<a href="/m/?action=logout">退出</a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login" <?php if($action=='login')echo 'id="active"'; ?>>登录</a>
<a href="<?php echo BLOG_URL; ?>m/?action=reg" <?php if($action=='reg')echo 'id="active"'; ?>>注册</a>
<?php endif;?>
</div>