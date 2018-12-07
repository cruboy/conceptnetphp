<?php
/**
 * 基础函数库
 */

/**
 * 去除多余的转义字符
 */
function doStripslashes(){
	if (get_magic_quotes_gpc()){
		$_GET = stripslashesDeep($_GET);
		$_POST = stripslashesDeep($_POST);
		$_COOKIE = stripslashesDeep($_COOKIE);
		$_REQUEST = stripslashesDeep($_REQUEST);
	}
}

/**
 * 递归去除转义字符
 */
function stripslashesDeep($value){
	$value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
	return $value;
}
function getqx(){
    $n=$_SESSION['views'];
	$a=ISLOGIN === true;
	if(isset($_POST['thid']))
		return 8;
	if(ROLE == 'admin')
		return 7;
    if($n>600||($a&&$n>300))return 6;
	if($n>400||($a&&$n>200))return 5;
    if($n>200||($a&&$n>50))return 4;	
	if($n>100||($a&&$n>30))return 3;
	if($n>40||$a)return 2;	
	if($n>6) return 1;
	return 0;
}

function getcptype($i){
	$sub[0]='默认';$sub[1]='概念';
	if(ROLE=='admin'){ $sub[2]='分类';}
	$sub[3]='记事';$sub[4]='人';
	$sub[5]='地方';$sub[6]='时间';
	
	if(isset($i))
	return $sub[$i];
	else
	return $sub;
}
/**
 * 转换HTML代码函数
 *
 * @param unknown_type $content
 * @param unknown_type $wrap 是否换行
 */
function htmlClean($content, $wrap=true){
	$content = htmlspecialchars($content);
	if($wrap){
		$content = str_replace("\n", '<br />', $content);
	}
	$content = str_replace('  ', '&nbsp;&nbsp;', $content);
	$content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
	return $content;
}

function getzi(){
  $k= chr(rand(161,215)).chr(rand(161,249));
 return iconv('GBK', 'UTF-8', $k);
	}
function getzis(){
  $k= chr(mt_rand(161,215)).chr(mt_rand(161,249));
 return iconv('GBK', 'UTF-8', $k);
	}	

/**
 * 获取用户ip地址
 */
function getIp(){
	return $_SERVER['REMOTE_ADDR'];
}

/**
 * 验证email地址格式
 */
function checkMail($email){
	if (preg_match("/^[\w\.\-]+@\w+([\.\-]\w+)*\.\w+$/", $email) && strlen($email) <= 60){
		return true;
	} else {
		return false;
	}
}

/**
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
 */
function subString($strings,$start,$length){
	$str = substr($strings, $start, $length);
	$char = 0;
	for ($i = 0; $i < strlen($str); $i++){
		if (ord($str[$i]) >= 128)
		$char++;
	}
	$str2 = substr($strings, $start, $length+1);
	$str3 = substr($strings, $start, $length+2);
	if ($char % 3 == 1){
		if ($length <= strlen($strings)){
			$str3 = $str3 .= '...';
		}
		return $str3;
	}
	if ($char%3 == 2){
		if ($length <= strlen($strings)){
			$str2 = $str2 .= '...';
		}
		return $str2;
	}
	if ($char%3 == 0){
		if ($length <= strlen($strings)){
			$str = $str .= '...';
		}
		return $str;
	}
}

/**
 * 从可能包含html标记的内容中萃取纯文本摘要
 *
 * @param string $data
 * @param int $len
 */
function extractHtmlData($data, $len) {
	$data = strip_tags(subString($data, 0, $len + 30));
	$search = array ("/([\r\n])[\s]+/",	// 去掉空白字符
		             "/&(quot|#34);/i",	// 替换 HTML 实体
		             "/&(amp|#38);/i",
		             "/&(lt|#60);/i",
		             "/&(gt|#62);/i",
		             "/&(nbsp|#160);/i",
					 "/&(iexcl|#161);/i",
					 "/&(cent|#162);/i",
		             "/&(pound|#163);/i",
		             "/&(copy|#169);/i",
		             "/\"/i",
					);
	$replace = array (" ","\"","&"," "," ","",chr(161),chr(162),chr(163),chr(169), "");
	$data = subString(preg_replace($search, $replace, $data), 0, $len);
	return $data;
}

/**
 * 转换附件大小单位
 *
 * @param string $fileSize 文件大小 kb
 */
function changeFileSize($fileSize){
	if($fileSize >= 1073741824){
		$fileSize = round($fileSize / 1073741824  ,2) . 'GB';
	} elseif($fileSize >= 1048576){
		$fileSize = round($fileSize / 1048576 ,2) . 'MB';
	} elseif($fileSize >= 1024){
		$fileSize = round($fileSize / 1024, 2) . 'KB';
	} else{
		$fileSize = $fileSize . '字节';
	}
	return $fileSize;
}

/**
 * 获取文件后缀
 * @param string $fileName
 */
function getFileSuffix($fileName) { 
	return strtolower(substr(strrchr($fileName, "."),1));
}

/**
 * 分页函数
 *
 * @param int $count 条目总数
 * @param int $perlogs 每页显示条数目
 * @param int $page 当前页码
 * @param string $url 页码的地址
 */
function pagination($count,$perlogs,$page,$url,$anchor=''){
	$pnums = @ceil($count / $perlogs);
	$re = '';
	$urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|","",$url);
	for ($i = $page-5;$i <= $page+5 && $i <= $pnums; $i++){
		if ($i > 0){
			if ($i == $page){
				$re .= " <span>$i</span> ";
		//	} elseif($i == 1) {
		//		$re .= " <a href=\"$urlHome$anchor\">$i</a> ";
			} else {
				$re .= " <a href=\"$url$i$anchor\">$i</a> ";
			}
		}
	}
	if ($page > 6) $re = "<a href=\"{$urlHome}$anchor\" title=\"首页\">&laquo;</a><em>...</em>$re";
	if ($page + 5 < $pnums) $re .= "<em>...</em> <a href=\"$url$pnums$anchor\" title=\"尾页\">&raquo;</a>";
	if ($pnums <= 1) $re = '';
	return $re;
}


/**
 * 日志分割
 *
 * @param string $content 日志内容
 * @param int $lid 日志id
 */
function breakLog($content,$lid){
	$a = explode('[break]',$content,2);
	if(!empty($a[1]))
	$a[0].='<p class="readmore"><a href="'.Url::log($lid).'">阅读全文&gt;&gt;</a></p>';
	return $a[0];
}


/**
 * 生成一个随机的字符串
 *
 * @param int $length
 * @param boolean $special_chars
 * @return string
 */
function getRandStr($length = 12, $special_chars = true){
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ( $special_chars ){
		$chars .= '!@#$%^&*()';
	}
	$randStr = '';
	for ( $i = 0; $i < $length; $i++ ){
		$randStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $randStr;
}


/**
 * 文件上传
 *
 * @param string $fileName 文件名
 * @param string $errorNum 错误码：$_FILES['error']
 * @param string $tmpFile 上传后的临时文件
 * @param string $fileSize 文件大小 KB
 * @param array $type 允许上传的文件类型
 * @param boolean $isIcon 是否为上传头像
 * @param boolean $is_thumbnail 是否生成缩略图
 * @return string 文件路径
 */
function uploadFile($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon=false, $is_thumbnail=Option::IS_THUMBNAIL){
	require_once EMLOG_ROOT.'/include/lib/pinyin.php';
	if ($errorNum == 1){
		emMsg('文件大小超过系统'.ini_get('upload_max_filesize').'限制');
	}elseif ($errorNum > 1){
		emMsg('上传文件失败,错误码：'.$errorNum);
	}
	$extension  = getFileSuffix($fileName);
	if (!in_array($extension, $type)){
		emMsg('错误的文件类型');
	}
	if ($fileSize > Option::UPLOADFILE_MAXSIZE){
		$ret = changeFileSize(Option::UPLOADFILE_MAXSIZE);
		emMsg("文件大小超出{$ret}的限制");
	}
	$uppath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
	$fname =  Pinyin(str_replace(strrchr($fileName, "."),"",$fileName))
	.Rand(10000000,99999999).'.'.$extension;
	$attachpath = $uppath . $fname;
	if (!is_dir(Option::UPLOADFILE_PATH)){
		umask(0);
		$ret = @mkdir(Option::UPLOADFILE_PATH, 0777);
		if ($ret === false){
			emMsg('创建文件上传目录失败');
		}
	}
	if (!is_dir($uppath)){
		umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false){
			emMsg('上传失败。文件上传目录(content/uploadfile)不可写');
		}
	}
	doAction('attach_upload', $tmpFile);

	//resizeImage
	$thum = $uppath . substr($fname,0,-8).'.'.$extension;
	$attach = $attachpath;
	if ($is_thumbnail) {
	    if ($isIcon && resizeImage($tmpFile, $thum, Option::ICON_MAX_W, Option::ICON_MAX_H)) {
	        $attach = $uppath .$fname;
	        resizeImage($tmpFile, $uppath.'thum52-'. $fname, 52, 52);
	    } elseif (resizeImage($tmpFile, $thum, Option::IMG_MAX_W, Option::IMG_MAX_H)){
	        $attach = "#".$uppath .$fname;
	    }
	}

	if (@is_uploaded_file($tmpFile)){
		if (@!move_uploaded_file($tmpFile ,$attachpath)){
			@unlink($tmpFile);
			emMsg('上传失败。文件上传目录(content/uploadfile)不可写');
		}
		chmod($attachpath, 0777);
	}
	return 	$attach;
}


/**
 * 页面跳转
 */
function emDirect($directUrl) {
	header("Location: $directUrl");
	exit;
}

/**
 * 显示系统信息
 *
 * @param string $msg 信息
 * @param string $url 返回地址
 * @param boolean $isAutoGo 是否自动返回 true false
 */
function emMsg($msg, $url='javascript:history.back(-1);', $isAutoGo=false){
	if ($msg == '404') {
		header("HTTP/1.1 404 Not Found");
		$msg = '抱歉，你所请求的页面不存在！';
	}
	echo "<HTML><head>";
	if($isAutoGo){
		echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
	}
	echo <<<EOT
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Error message</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	font-size: 12px;
	color: #666666;
	width:750px;
	margin:100px auto;
	border-radius: 10px;
	padding:30px 10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.main p {
	line-height: 18px;
	margin: 5px 20px;
}
-->
</style>
</head>
<body>
<div class="main">
<p>$msg</p>
<p><a href="$url">&laquo;点击返回</a></p>
</div>
</body>
</html>
EOT;
	exit;
}
