<?php
require_once '../init.php';
$aid=$_GET['id'];
$row = $DB->once_fetch_array("SELECT content FROM ".DB_PREFIX."images where aid=$aid");

Header("Content-type:image/jpg");
echo $row['content'];

?>