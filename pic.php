<?php
require_once 'init.php';
$aid=intval($_GET['id']);
if(empty($aid))$aid=intval($_GET['img']);
$row = $DB->once_fetch_array("SELECT content FROM ".DB_PREFIX."images where aid=$aid");

Header("Content-type:image/jpg");
echo $row['content'];

?>