<?php
/**
cruboy
 */

require_once 'init.php';

define ('TEMPLATE_PATH', EMLOG_ROOT . '/view/');

$isgzipenable = 'n'; //手机浏览关闭gzip压缩
$index_lognum = 8;

$logid = isset ($_GET['post']) ? intval ($_GET['post']) : '';
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';
$cpid = isset ($_POST['cp']) ? intval ($_POST['cp']) : '';
$fnid = isset ($_GET['fn']) ? intval ($_GET['fn']) : '';
$sid = isset ($_GET['sid']) ? intval ($_GET['sid']) : '';
$akey = isset($_POST['aikey']) ? addslashes($_POST['aikey']) : '';
$seid=session_id();
/////首页
if(($action=='aishow')||($action==''&& empty ($fnid)&& empty ($sid)&& empty ($logid)))
{

		$gip=getIp();
		$uid=UID;
		$ltime = date('Y-m-d H:i:s');
		$DB=MySql::getInstance();
		$cpid=0;
		$pDs=1;
		$concepts=array();
	include "lib/cache.php";
	$vsid=intval($_SESSION['views']);
  
	
	$cpidd=intval($_REQUEST['cp']);
	//$cpp = 
  if(empty($cpidd))
    {  
    $valid=rand(1000,100000);
	$_SESSION['valid']=$valid;
	}
  elseif($cpidd>0 and $_POST['valid']!=$_SESSION['valid'] and ISLOGIN !== true)
	{//print_r($cpp);
		if(strstr($cpp['pub'],','.$cpidd.',')){
			$valid=rand(1000,100000);
	$_SESSION['valid']=$valid;
		}else{
//	header('HTTP/1.1 401 Unauthorized'); 
//	header('status: 401 Unauthorized');echo '请登录后查看！'; exit;
		}
  }else{
	$valid=rand(1000,100000);
	$_SESSION['valid']=$valid;
	}
//	$cpr = $CACHE->readCache('cpr');
	if(ROLE == 'admin' ){
		}else{
			$cc=' and c.visible>=0';
			$ccx=' and visible>-2';
			}
   //搜索或空白随机首页
 if(isset($_POST['aikey'])||empty($_REQUEST['cp'])){
		$akey = addslashes($_POST['aikey']);
		$atitle="查询'".$akey."'的结果：";
   if(empty($akey)){
		$vfdd='mhome';
		//foreach($cpp['home'] as $p)
		//{
		//	$concepts[]=$p;
		//}
	$sql = "SELECT * FROM conceptnet_concept  where 1 $ccx  order by Rand() LIMIT 30";
	}else{
		$vfdd='msearch';
	$sql = "SELECT * FROM conceptnet_concept WHERE text LIKE '%$akey%' $ccx  order by Rand()  LIMIT 100";
	}

	
	$res = $DB->query($sql);
		$o=$akey.'|';
	while ($row = $DB->fetch_array($res)) {
			$o.=$row['id'].$row['text'].' ';
			$concepts[]=$row;
		}
		if($action=='aishow')
		$vfdd.='2';
		$DB->query("INSERT INTO viewlog (method,viewid,concept,uid,seid,vtime,text,loginip) VALUES 
		('$vfdd','$vsid','0','$uid','$seid','$ltime','$o','$gip')");
		$hhtitle=$akey;
  ////内容页
 }else{
			$maxtop=0;
			if($cpidd<0){
				$tabf="cruboy";
				$vfrom="mcruview";
				$cpid=-$cpidd;
			}else{
				$tabf="conceptnet";
				$vfrom="mview";
				$cpid=$cpidd;
				if($cpidd==0)
				$cpid=72;
			}
			
			$DB->query("UPDATE  ".$tabf."_concept SET words=words+1 WHERE id='$cpid'");
			
			$sq1="SELECT * FROM  ".$tabf."_concept WHERE id='$cpid'";
			$pDa=$DB->once_fetch_array($sq1);
           if($tabf=='cruboy')
				$pDa['id']=-$pDa['id'];
			$hhtitle=$pDa['text'];
			if($action=='aishow')
		     $vfrom.='2';
			$DB->query("INSERT INTO viewlog (method,viewid,concept,uid,seid,vtime,text,loginip) VALUES (
				'$vfrom','$vsid','$cpidd','$uid','$seid','$ltime','{$pDa['text']}','$gip')");
			
			$sq2="SELECT a.concept1_id,a.concept2_id,a.id as aid,a.abid,a.seq,
		a.relation_id,a.best_frame_id,a.atop1 as atop,a.aleft1 as aleft,a.itop1 as itop,a.ileft1 as ileft,a.good,a.bad,a.img1 as img,a.imgsize1 as imgsz,a.infos,
		 c.* FROM  ".$tabf."_assertion a LEFT JOIN
		 ".$tabf."_concept c ON a.concept2_id= c.id
		WHERE concept1_id='$cpid' $cc order by a.relation_id,a.best_frame_id LIMIT 4000";
			$res2=$DB->query($sq2);
			while($row=$DB->fetch_array($res2)){
			  if($row['best_frame_id']>0){		
			   $ss=str_replace("1",$pDa['text'],$cpr[$row['best_frame_id']]);
			   $ss=str_replace("2",$row['text'],$ss);
			   $row['frame']=$ss;
			   }else{
			   $row['frame']=$cpr[$row['relation_id']];
			   }
			 $row['fx']='1';
				if($tabf=='cruboy')
					$row['id']=-$row['id'];
				if($row['atop']>$maxtop)
					$maxtop=$row['atop'];	
				$concepts[]=$row;
			}
			
			$sq3="SELECT a.concept1_id,a.concept2_id,a.id as aid,a.abid,a.seq,
		a.relation_id,a.best_frame_id,a.atop2 as atop,a.aleft2 as aleft,a.itop2 as itop,a.ileft2 as ileft,a.good,a.bad,a.img2 as img,a.imgsize2 as imgsz,a.infos,
		 c.* FROM  ".$tabf."_assertion a LEFT JOIN
		 ".$tabf."_concept c ON a.concept1_id= c.id
		WHERE concept2_id='$cpid' $cc order by a.seq,a.relation_id,a.best_frame_id LIMIT 4000";
			$res3=$DB->query($sq3);
			while($row2=$DB->fetch_array($res3)){
				if($row2['best_frame_id']>0){		
			$ss=str_replace("1",$row2['text'],$cpr[$row2['best_frame_id']]);
			$ss=str_replace("2",$pDa['text'],$ss);
			$row2['frame']='!'.$ss;
			}else{
			 $row2['frame']='!'.$cpr[$row2['relation_id']];
			}
			$row2['fx']='2';
				if($tabf=='cruboy')
					$row2['id']=-$row2['id'];
				if($row2['atop']>$maxtop)
					$maxtop=$row2['atop'];
				$concepts[]=$row2;
			}
			
 }	
		    $nohead=1;
			$mm=count($concepts,0)*20+60;
		//	echo $maxtop.' '.$mm;
			if($maxtop<$mm)
			$maxtop=$mm;
			if($maxtop<760)
			$maxtop=760;
			include View::getView('header');
			if($action=='aishow')
			include View::getView('aishow');
			else
			include View::getView('cpshow');
			include View::getView('footer');
			View::output();
			
}

if ($action == 'ailist' && $_SESSION['views']>2) {
	if(isset($_GET['cplist'])){$valid=rand(1000,100000);
	$_SESSION['valid']=$valid;
	}
	elseif($_POST['valid']!=$_SESSION['valid'])
	{
     header('HTTP/1.1 401 Unauthorized'); 
      header('status: 401 Unauthorized'); exit;
    }else{
	$valid=rand(1000,100000);
	$_SESSION['valid']=$valid;
	}
  include "lib/cache.php";
		if(ROLE == 'admin' ){
		}else{
			$cc=' and c.visible>-1';
			$ccx=' and visible>-2';
			}
	$gip=getIp();
	$uid=UID;
	$ltime = date('Y-m-d H:i:s');
	
	if(empty ($akey)){
	  $mnk='mallist';
	  $sql = "SELECT * FROM conceptnet_concept where 1 $ccx  order by Rand()  LIMIT 10";
	 }else{
	  $mnk='malsearch';
	  $atitle="测字‘".$akey."’的结果：";
	  $sql = "SELECT * FROM  conceptnet_concept WHERE text LIKE '%$akey%' $ccx order by Rand() LIMIT 20";
	 }
    $o=$akey.'|';
	 $res = $DB->query($sql);
	       $concepts=array();	
		while ($row = $DB->fetch_array($res)) {
			$o.=$row['text'].' ';
		// $sql2 = "SELECT * FROM conceptnet_assertion WHERE concept1_id='$row[id]' or concept2_id='$row[id]' LIMIT 2";
		$sql2 = "SELECT a.concept1_id,a.concept2_id,
		a.relation_id,a.best_frame_id,c.text FROM conceptnet_assertion a LEFT JOIN
		conceptnet_concept c ON a.concept2_id=c.id
		WHERE concept1_id='{$row['id']}' $cc order by Rand() limit 1";
			$aDa = $DB->once_fetch_array($sql2);
		
		$row['tx1']=$aDa['text'];
		$row['id1']=$aDa['concept2_id'];
	 $row['re1']=$aDa['relation_id'];
	 if($aDa['best_frame_id']>0){		
			$ss=str_replace("1",$row['text'],$cpr[$aDa['best_frame_id']]);
			$ss=str_replace("2",$aDa['text'],$ss);
			$row['fi1']=$ss;
			}else{
			 $row['fi1']=$cpr[$aDa['relation_id']];
			}

		 $sql3 = "SELECT a.concept1_id,a.concept2_id,
		a.relation_id,a.best_frame_id,c.text FROM conceptnet_assertion a LEFT JOIN
		conceptnet_concept c ON a.concept1_id=c.id
		WHERE concept2_id='{$row['id']}' $cc order by Rand() limit 1";
			$aDa3 = $DB->once_fetch_array($sql3);
		
		$row['tx2']=$aDa3['text'];
		$row['id2']=$aDa3['concept1_id'];
	 $row['re2']=$aDa3['relation_id'];
	 if($aDa3['best_frame_id']>0){		
			$ss=str_replace("1",$aDa3['text'],$cpr[$aDa3['best_frame_id']]);
			$ss=str_replace("2",$row['text'],$ss);
			$row['fi2']=$ss;
			}else{
			 $row['fi2']=$cpr[$aDa3['relation_id']];
			}
    $o.='('.$row['tx1'].' '.$row['tx2'].')';
	$concepts[]=$row;
		}
		$hhtitle=$akey;
	$DB->query("INSERT INTO viewlog (method,viewid,concept,uid,seid,vtime,text,loginip) VALUES (
				'$mnk','$vsid','0','$uid','$seid','$ltime','$o','$gip')");
    include View::getView('header');
	include View::getView('ailist');
	include View::getView('footer');
	View::output();
}
// 
if ($action == 'blog') {
    $sqladd="content!='' ";
    if(isset($_GET['s'])){
		$sqladd="and sort=$s ";
		$tjts=$s;
	} 
  
	$sql2="SELECT count(1) as a  FROM conceptnet_concept where  $sqladd ";
	$row2=$DB->once_fetch_array($sql2);
	
	$index_lognum=20;
	$page=isset($_GET['page'])?abs(intval($_GET['page'])):1;
	$start=($page-1)*$index_lognum;
	
	$sql22="SELECT * FROM conceptnet_concept where  $sqladd   limit   $start,$index_lognum";
	$query=$DB->query($sql22);
	$page_url=pagination($row2['a'],$index_lognum,$page,"?action=li&s={$tjts}&page=");
	include View::getView('header');
	include View::getView('log');
	include View::getView('footer');
	View::output();
}


if (!empty ($fnid)) {

$sql = "SELECT *  FROM cruboy_film where gid='$fnid' ";
	$res1 = $DB->query($sql);
	$logData = $DB->fetch_array($res1);
	if($logData[gid]<1){
		echo "<script language=\"JavaScript\">alert(\"Not found!\");history.back();</script>";
		exit();
	}
	$DB->query("UPDATE cruboy_film SET views=views+1 WHERE gid='$id'");
	extract($logData);
	$action="film";
	include View::getView('header');
	include View::getView('filmpage');
	include View::getView('footer');
	View::output();
}
if (!empty ($sid)) {

$sql = "SELECT *  FROM cruboy_story where gid='$sid' ";
	$res1 = $DB->query($sql);
	$logData = $DB->fetch_array($res1);
	if($logData[gid]<1){
		echo "<script language=\"JavaScript\">alert(\"Not found!\");history.back();</script>";
		exit();
	}
	$DB->query("UPDATE cruboy_story SET views=views+1 WHERE gid='$sid'");
	extract($logData);
	$action="story";
	include View::getView('header');
	include View::getView('storypage');
	include View::getView('footer');
	View::output();
}
// 日志
if (!empty ($logid)) {
	$Log_Model = new Log_Model();
	$Comment_Model = new Comment_Model();

	$logData = $Log_Model->getOneLogForHome($logid);
	if ($logData === false) {
		mMsg ('不存在该条目', './');
	}
	extract($logData);
	if (!empty($password)) {
		$postpwd = isset($_POST['logpwd']) ? addslashes(trim ($_POST['logpwd'])) : '';
		$cookiepwd = isset($_COOKIE ['em_logpwd_' . $logid]) ? addslashes(trim($_COOKIE ['em_logpwd_' . $logid])) : '';
		authPassword ($postpwd, $cookiepwd, $password, $logid);
	}
	// comments
	$commentPage = isset($_GET['comment-page']) ? intval($_GET['comment-page']) : 1;
	$verifyCode = ISLOGIN == false && Option::get('comment_code') == 'y' ? "<img src=\"../include/lib/checkcode.php\" /><br /><input name=\"imgcode\" type=\"text\" />" : '';
	$comments = $Comment_Model->getComments(2, $logid, 'n', $commentPage);
	extract($comments);
	$user_cache = $CACHE->readCache('user');
$action="blog";
	$Log_Model->updateViewCount($logid);
	include View::getView('header');
	include View::getView('single');
	include View::getView('footer');
	View::output();
}
if (ISLOGIN === true && $action == 'write') {
	$logid = isset($_GET['id']) ? intval($_GET['id']) : '';
	//$Sort_Model = new Sort_Model();
//	$sorts = $Sort_Model->getSorts();
	if ($logid) {
		$Log_Model = new Log_Model();
		$Tag_Model = new Tag_Model();

	//	$blogData = $Log_Model->getOneLogForAdmin($logid);
		extract($blogData);
		$tags = array();
		foreach ($Tag_Model->getTag($logid) as $val) {
			$tags[] = $val['tagname'];
		}
		$tagStr = implode(',', $tags);
	}else {
		$title = '';
		$sortid = -1;
		$content = '';
		$excerpt = '';
		$tagStr = '';
		$logid = -1;
		$author = UID;
		$date = '';
	}
	include View::getView('header');
	include View::getView('write');
	include View::getView('footer');
	View::output();
}
if (ISLOGIN === true && $action == 'savelog') {
	$Log_Model = new Log_Model();
	$Tag_Model = new Tag_Model();

	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$sort = isset($_POST['sort']) ? intval($_POST['sort']) : '';
	$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
	$excerpt = isset($_POST['excerpt']) ? addslashes(trim($_POST['excerpt'])) : '';
	$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
	$blogid = isset($_POST['gid']) ? intval(trim($_POST['gid'])) : -1;
	$date = isset($_POST['date']) ? addslashes($_POST['date']) : '';
	$author = isset($_POST['author']) ? intval(trim($_POST['author'])) : UID;
	$postTime = $Log_Model->postDate(Option::get('timezone'), $date);	

	$logData = array('title' => $title,
		'content' => $content,
		'excerpt' => $excerpt,
		'author' => $author,
		'sortid' => $sort,
		'date' => $postTime,
		'allow_remark' => 'y',
		'allow_tb' => 'y',
		'hide' => 'n',
		'password' => ''
		);

	if ($blogid > 0) {
		$Log_Model->updateLog($logData, $blogid);
		$Tag_Model->updateTag($tagstring, $blogid);
	}else {
		$blogid = $Log_Model->addlog($logData);
		$Tag_Model->addTag($tagstring, $blogid);
	}
	$CACHE->updateCache();
	emDirect("./");
}
if (ISLOGIN === true && $action == 'dellog') {
	$Log_Model = new Log_Model();
	$id = isset($_GET['gid']) ? intval($_GET['gid']) : -1;
	$Log_Model->deleteLog($id);
	$CACHE->updateCache();
	emDirect("./");
}
// 评论
if (ISLOGIN === true && $action == 'addcom') {
	$Comment_Model = new Comment_Model();

	$content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
    $mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
    $url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
    $imgcode = isset($_POST['imgcode']) ? strtoupper(trim($_POST['imgcode'])) : '';
    $blogId = isset($_GET['gid']) ? intval($_GET['gid']) : - 1;
    $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

        $CACHE = Cache::getInstance();
        $user_cache = $CACHE->readCache('user');
		$name = addslashes($user_cache[UID]['name_orig']);

	if($Comment_Model->isLogCanComment($blogId) === false){
        mMsg('评论失败：该日志已关闭评论','./?post=' . $blogId);
    } elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true){
        mMsg('评论失败：已存在相同内容评论','./?post=' . $blogId);

    } elseif ($mail != '' && !checkMail($mail)) {
        mMsg('评论失败：邮件地址不符合规范', './?post=' . $blogId);
    } elseif (ISLOGIN == false && $Comment_Model->isNameAndMailValid($name, $mail) === false){
        mMsg('评论失败：禁止使用管理员昵称或邮箱评论','./?post=' . $blogId);
    } elseif (strlen($content) == '' || strlen($content) > 2000) {
        mMsg('评论失败：内容不符合规范','./?post=' . $blogId);
    } elseif (ISLOGIN == false && Option::get('comment_code') == 'y' && session_start() && $imgcode != $_SESSION['code']) {
        mMsg('评论失败：验证码错误','./?post=' . $blogId);
    } else {
		$DB = MySql::getInstance();
        $ipaddr = getIp();
		$utctimestamp = time();

		if($pid != 0) {
			$comment = $Comment_Model->getOneComment($pid);
			$content = '@' . addslashes($comment['poster']) . '：' . $content;
		}

		$ischkcomment = Option::get('ischkcomment');
		$hide = ROLE == 'visitor' ? $ischkcomment : 'n';

		$sql = 'INSERT INTO '.DB_PREFIX."comment (date,poster,gid,comment,mail,url,hide,ip,pid)
				VALUES ('$utctimestamp','$name','$blogId','$content','$mail','$url','$hide','$ipaddr','$pid')";
		$ret = $DB->query($sql);
		$cid = $DB->insert_id();
		$CACHE = Cache::getInstance();

		if ($hide == 'n') {
			$DB->query('UPDATE '.DB_PREFIX."blog SET comnum = comnum + 1 WHERE gid='$blogId'");
			$CACHE->updateCache(array('sta', 'comment'));
            doAction('comment_saved', $cid);
            emDirect('./?post=' . $blogId);
		} else {
		    $CACHE->updateCache('sta');
		    doAction('comment_saved', $cid);
		    mMsg('评论发表成功，请等待管理员审核', './?post=' . $blogId);
		}
    }
}
if ($action == 'com') {
	if (ISLOGIN === true) {
		$hide = '';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

		$Comment_Model = new Comment_Model();

		$comment = $Comment_Model->getComments(1, null, $hide, $page);
		$cmnum = $Comment_Model->getCommentNum(null, $hide);
		$pageurl = pagination($cmnum, Option::get('admin_perpage_num'), $page, "./?action=com&page=");
	}else {
		$comment = $CACHE->readCache('comment');
		$pageurl = '';
	}
	include View::getView('header');
	include View::getView('comment');
	include View::getView('footer');
	View::output();
}
if (ISLOGIN === true && $action == 'delcom') {
	$Comment_Model = new Comment_Model();
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Comment_Model->delComment($id);
	$CACHE->updateCache(array('sta','comment'));
	emDirect("./?action=com");
}
if (ISLOGIN === true && $action == 'showcom') {
	$Comment_Model = new Comment_Model();
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Comment_Model->showComment($id);
	$CACHE->updateCache(array('sta','comment'));
	emDirect("./?action=com");
}
if (ISLOGIN === true && $action == 'hidecom') {
	$Comment_Model = new Comment_Model();
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Comment_Model->hideComment($id);
	$CACHE->updateCache(array('sta','comment'));
	emDirect("./?action=com");
}
if (ISLOGIN === true && $action == 'reply') {
	$Comment_Model = new Comment_Model();
	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
	$commentArray = $Comment_Model->getOneComment($cid);
	if(!$commentArray) {
		mMsg('参数错误', './');
	}
	extract($commentArray);
	$verifyCode = ISLOGIN == false && Option::get('comment_code') == 'y' ? "<img src=\"../include/lib/checkcode.php\" /><br /><input name=\"imgcode\" type=\"text\" />" : '';
	include View::getView('header');
	include View::getView('reply');
	include View::getView('footer');
	View::output();
}

if ($action == 'login' ||$action == 'reg' ) {

	include View::getView('header');
	include View::getView('login');
	include View::getView('footer');
	View::output();
}
if ($action == 'auth') {
	 $username = addslashes(trim($_POST['user']));
	$password = addslashes(trim($_POST['pw'])); 
	$gip=getIp();
		$uid=UID;
		$ltime = date('Y-m-d H:i:s');
		$vsid=intval($_SESSION['views']);
		$ddid=intval($_POST['lv']);
		$o=serialize($_POST);
		$DB->query("INSERT INTO vialog (method,uname,viewid,cid,uid,vtime,text,loginip) VALUES (
				'login','$username','$vsid','$ddid','$uid','$ltime','$o','$gip')");
	session_start();
	

	$ispersis = true;
	if (checkUser($username, $password, $img_code) === true) {
		setAuthCookie($username, $ispersis);
		if($ddid==1)
		emDirect('/love.php');
		if($ddid>1)
		emDirect('/');
		else
		emDirect('?tem=' . time());
	}else {
		emDirect("?action=login");
	}
}
if ($action== 'new') {
	    $gip=getIp();
		$uid=UID;
		$ltime = date('Y-m-d H:i:s');
		$vsid=intval($_SESSION['views']);
		$o=serialize($_POST);
		$DB->query("INSERT INTO vialog (method,viewid,cid,uid,vtime,text,loginip) VALUES (
				'reg','$vsid','0','$uid','$ltime','$o','$gip')");
		$isd = $DB->insert_id();
		$login = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
		$password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
		$password2 = isset($_POST['pw2']) ? addslashes(trim($_POST['pw2'])) : '';
		$password3 = isset($_POST['pw3']) ? addslashes(trim($_POST['pw3'])) : '';
		if (strlen($login) < 3) {
			mMsg('用户名过短！', './?action=reg');
		}
		if (strlen($password) < 3) {
			mMsg('密码过短！', './');
		}
		if ($password != $password2) {
			mMsg('两次密码不一致！', './?action=reg');
		}
		if ($password3 != 'cruboy') 
			{
				if($vsid<4)
				mMsg('注册码不正确！请再试一次', './?action=reg');
				else
				mMsg('注册码不正确！请填写“cruboy”', './?action=reg');
			}
		$User_Model = new User_Model();
		if ($User_Model->isUserExist($login)) {
			mMsg('用户名已存在！', './?action=reg');
		}


		$PHPASS = new PasswordHash(8, true);
		$password = $PHPASS->HashPassword($password);

		$User_Model->addUser($login, $password, $role);
		$CACHE->updateCache(array('sta','user'));
			$DB->query("update vialog set rt=1 where id='$isd'"); 
			mMsg('注册成功！', './?action=login');
	
}

if ($action == 'logout') {
	setcookie(AUTH_COOKIE_NAME, ' ', time () - 31536000, '/');
	emDirect('?tem=' . time());
}
if($action == 'film'){
		$page = isset($_GET['page']) ? abs(intval ($_GET['page'])) : 1;
		$DB = MySql::getInstance();
		$start=($page-1)*$index_lognum;
		$nall=intval ($_GET['n']);
		if($nall<1){
			$sql = "SELECT count(*) as a  FROM cruboy_film where hide='n' ";
			$res1 = $DB->query($sql);
			$row1 = $DB->fetch_array($res1);
			$nall=$row1[a];
		}
		$tinf="所有电影列表（".$nall."部）：";
		$pageurl = "?action=film&n=".$nall."&page=";
		$sql = "SELECT * FROM cruboy_film where hide='n' limit $start,$index_lognum";
		$res = $DB->query($sql);
		while ($row = $DB->fetch_array($res)) {
			$logs[]=$row;
		}
		$page_url = pagination($nall, $index_lognum, $page, $pageurl);
//print_r($logs);
		include View::getView('header');
		include View::getView('filmlist');
		include View::getView('footer');
		View::output();
	}
	if($action == 'story'){
		$page = isset($_GET['page']) ? abs(intval ($_GET['page'])) : 1;
		$DB = MySql::getInstance();
		$start=($page-1)*$index_lognum;
		$nall=intval ($_GET['n']);
		if($nall<1){
			$sql = "SELECT count(*) as a  FROM cruboy_story where hide='n' ";
			$res1 = $DB->query($sql);
			$row1 = $DB->fetch_array($res1);
			$nall=$row1[a];
		}
		$tinf="所有童话故事列表（".$nall."部）：";
		$pageurl = "?action=story&n=".$nall."&page=";
		$sql = "SELECT * FROM cruboy_story where hide='n' limit $start,$index_lognum";
		$res = $DB->query($sql);
		while ($row = $DB->fetch_array($res)) {
			$logs[]=$row;
		}
		$page_url = pagination($nall, $index_lognum, $page, $pageurl);
//print_r($logs);
		include View::getView('header');
		include View::getView('storylist');
		include View::getView('footer');
		View::output();
	}
function mMsg($msg, $url) {
	include View::getView('header');
	include View::getView('msg');
	include View::getView('footer');
	View::output();
}
function authPassword($postPwd, $cookiePwd, $logPwd, $logid) {
	$pwd = $cookiePwd ? $cookiePwd : $postPwd;
	if ($pwd !== addslashes($logPwd)) {
		include View::getView('header');
		include View::getView('logauth');
		include View::getView('footer');
		if ($cookiePwd) {
			setcookie('em_logpwd_' . $logid, ' ', time() - 31536000);
		}
		View::output();
	}else {
		setcookie('em_logpwd_' . $logid, $logPwd);
	}
}
