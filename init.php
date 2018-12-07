<?php
/**
 * 全局项加载
 * @copyright cruboy
 */

//error_reporting(1);
ob_start();
session_start();
header('Content-Type: text/html; charset=UTF-8');

define('EMLOG_ROOT', dirname(__FILE__));


date_default_timezone_set('PRC'); 

require_once EMLOG_ROOT.'/config.php';
require_once EMLOG_ROOT.'/lib/function.base.php';
require_once EMLOG_ROOT.'/lib/mysql.php';
require_once EMLOG_ROOT.'/lib/view.php';
//print_r($_SERVER);

$seid=session_id();
$DB = MySql::getInstance();
if(!isset($_SESSION['views']))  
{   $ltime = date('Y-m-d H:i:s');
	$_SESSION['views']=1;
	$DB->query("INSERT INTO vaccelog (method,tou,lastu,expler,vdate,aip,times,seid) VALUES (
		'".$_SERVER[REQUEST_METHOD]."','".addslashes($_SERVER[REQUEST_URI])."','".
addslashes($_SERVER[HTTP_REFERER])."','".addslashes($_SERVER[HTTP_USER_AGENT])."','$ltime','".$_SERVER['REMOTE_ADDR']."','".$_SESSION['views']."','$seid')");
}
   else 
	$_SESSION['views']++;
if($_SESSION['views']%5==2){
	 $ltime = date('Y-m-d H:i:s');
	$DB->query("INSERT INTO vaccelog (method,tou,lastu,vdate,aip,times,seid) VALUES (
	'".$_SERVER[REQUEST_METHOD]."','".addslashes($_SERVER[REQUEST_URI])."','".
addslashes($_SERVER[HTTP_REFERER])."','$ltime','".$_SERVER['REMOTE_ADDR']."','".$_SESSION['views']."','$seid')");

}
//echo $_SESSION['views'];
require_once EMLOG_ROOT.'/lib/function.login.php';

doStripslashes();
$userData = array();

define('ISLOGIN',	isLogin());
//用户组: admin管理员, writer联合撰写人,user visitor访客
define('ROLE', ISLOGIN === true ? $userData['role'] : '');
//用户ID
define('UID', ISLOGIN === true ? $userData['uid'] : 0);
define('UNM', ISLOGIN === true ? $userData['username'] : 0);

define('BLOG_URL', "/");

$blogname='安道笔记';
