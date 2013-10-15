<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo '<?xml version="1.0" encoding="UTF-8"?>';
require_once View::getView('module');
?>
<head>
<title><?php echo $hhtitle.'-'.Option::get('blogname'); ?></title>
<style type="text/css" id="internalStyle">
body{background:url(bg.gif) 8px 3px repeat; font-size:14px; margin: 0; padding:0;font-family: Helvetica, Arial, sans-serif;-webkit-text-size-adjust: none;}
a:link,a:visited,a:hover,a:active {text-decoration: none;color:#333;}
#top{background-color:rgb(128,0,64); padding:10px 8px;}#footer{background-color:#EFEFEF; color:#666666; padding:5px;text-align:center;font-weight:bold;}
#page{text-align:center;font-size:26px; color: #CCCCCC}#page a:link,a:active,a:visited,a:hover{padding:0px 6px;}#m{padding:10px;}
#blogname{font-weight:bold; color:#FFFFFF; font-size:14px;}
#navi{background:#EFEFEF; padding:3px 0px;}#active{font-weight:bold; font-size:16px;}
.title{font-weight:bold; margin:10px 0px 5px 0px;}.title a:link, a:active,a:visited,a:hover{color:#333360; text-decoration:none}
.info{font-size:12px;color:#999999;}.info2{font-size:12px; border-bottom:#CCCCCC dotted 1px; text-align:right; color:#666666; margin:5px 0px; padding:5px;}
.posttitle{font-size:16px; color:#333; font-weight:bold;}.postinfo{font-size:13px; color: #999999;}.postinfo2{font-size:14px; color: #99aa99;}
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

<?php if(UID) echo $userData['username']; 
elseif(!empty($_SESSION['u_name']))echo $_SESSION['u_name'];
else echo "?请<a href=\"m/?action=login\">登录</a>?"; ?>，您好！
<a href="<?php echo BLOG_URL; ?>" <?php if($action=='')echo 'id="active"'; ?>>应用首页</a> 

<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=48" <?php if($cpid==48)echo 'id="active"'; ?>>志愿者</a>
<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=72" <?php if($cpid==72)echo 'id="active"'; ?>>本应用成员</a>
<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=468" <?php if($cpid==468)echo 'id="active"'; ?>>爱心</a>
<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=405" <?php if($cpid==405)echo 'id="active"'; ?>>善良</a>
<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=136" <?php if($cpid==136)echo 'id="active"'; ?>>知识</a>
<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=182" <?php if($cpid==182)echo 'id="active"'; ?>>爱</a>
<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=27310"<?php if($cpid==27310)echo 'id="active"'; ?> >儿童</a> 
<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=798" <?php if($cpid==798)echo 'id="active"'; ?>>孩子</a> 
<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=54" <?php if($cpid==54)echo 'id="active"'; ?>>学习</a>
<a href="<?php echo BLOG_URL; ?>/cruboy.php?id=653" <?php if($cpid==653)echo 'id="active"'; ?>>上学</a> ||
<?php if(empty($_SESSION['u_name'])): ?>
<a href="<?php echo BLOG_URL; ?>" >返回首页</a>
<?php endif; ?> 
</div>
