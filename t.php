<?php
/**
 * 碎语
 * @copyright (c) Emlog All Rights Reserved
 * $Id: index.php 2014 2011-08-25 16:24:12Z emloog $
*/

require_once '../init.php';

define ('TEMPLATE_PATH', EMLOG_ROOT . '/m/view/');

$blogtitle = Option::get('twnavi') . ' - ' . Option::get('blogname');
$description = Option::get('bloginfo');
  $vid=intval($_SESSION['views']);
$action = isset($_GET['action']) ? addslashes($_GET['action']) : 'tw';

if ($action == 'mark') {
	$tid = intval(trim($_GET['tid']));
	$r=addslashes(trim($_GET['opt']));
      $rdata = array(
            'tid' => $tid,
            'content' => $r,
            'name' => '',
            'hide' => 'y',
			'method'=>$r,
             'uid' => UID,
			 'seid'=>session_id(),
			 'lastu'=>addslashes($_SERVER[HTTP_REFERER]),
			 'vdate' => date('Y-m-d H:i:s'),
			 'ip'=>getIP(),
			 'viewid'=>$vid
    );

    $Reply_Model = new Reply_Model();

    $rid = $Reply_Model->addReply($rdata);
	$DB->query('update emlog_twitter set '.$r.'='.$r.'+1 where id='.$tid);
	echo $r;
}
if ($action == 'getans') {
	$tid = intval(trim($_GET['tid']));
	$aid = intval(trim($_GET['aid']));
	$r=addslashes(trim($_GET['opt']));
	if($r=='q1'){
		$andd=array('','家庭','金钱','事业','朋友','性','','');
		$rr=$andd[$aid];
		$rd=$tid.':'.$aid.$rr;
		}
	if($r=='q2'){
     $a[1]='你对于目前的恋爱感到傍徨不安，好象缺了点安全感，"既期待又怕被伤害"，不知道该通敢去爱，还是悄悄的走开。虽然你的他条件并不差，你总是没办法把心交给他，要得到你完全的信任，似乎还要再加把劲儿。';
	 $a[2]='你的恋爱哲学是：只要是我喜欢，有什么不可以。你不排斥条件比你差的情人或异国恋情，反正只要卯上，你的爱情就像麻辣火锅一样热烈，大胆而奔放。';
	 $a[3]='虽然你的内心饥渴难耐，但是却极力保持冷酷的外表。你再"闷骚"下去，当心"内伤"！对付你这种假道学的人，只能化被动为主动，才能让你卸下面具。';
	 $a[4]='你的爱情不及格，只有托儿所程度，时常表错情而不自知，又左思右想的裹足不前，丘比特碰到你也伤脑筋！';
	 $rr=$a[$aid];
	 $rd=$aid.substr($rr,0,24);
	}
      $rdata = array(
            'tid' => $tid,
            'content' => $rd,
            'name' => '',
            'hide' => 'y',
			'method'=>$r,
             'uid' => UID,
			 'seid'=>session_id(),
			 'lastu'=>addslashes($_SERVER[HTTP_REFERER]),
			 'vdate' => date('Y-m-d H:i:s'),
			 'ip'=>getIP(),
			 'viewid'=>$vid
    );

    $Reply_Model = new Reply_Model();

    $rid = $Reply_Model->addReply($rdata);

	echo $rr;
}
if ($action == 'mr') {
	$tid = intval(trim($_GET['tid']));

      $rdata = array(
            'tid' => $tid,
            'content' => '',
            'name' => '',
            'hide' => 'y',
			'method'=>'torep',
             'uid' => UID,
			  'seid'=>session_id(),
			 'lastu'=>addslashes($_SERVER[HTTP_REFERER]),
			 'vdate' => date('Y-m-d H:i:s'),
			 'ip'=>getIP(),
			 'viewid'=>$vid
    );
    $Reply_Model = new Reply_Model();
    $rid = $Reply_Model->addReply($rdata);
?>
<form action='/m/t.php?action=mo' method='post'>
	<textarea name='ct' style='width:160px;height:60px'></textarea><br>
    <input type='hidden' name='id' value='<?=$tid?>'>
     昵称：<input type="text" name='nc' style='width:60px'/>
     <input type='submit' value='提交'>
     </form>
<?
}
if ($vid<5) {
    emMsg('抱歉，碎语未开启前台访问！再试一次看看能否开启。', BLOG_URL);
}
if ($action == 'mo') {
		$tid = intval(trim($_POST['id']));
  $ct=addslashes(trim($_POST['ct']));
  $nc=addslashes(trim($_POST['nc']));
      $rdata = array(
            'tid' => $tid,
            'content' => $ct,
            'name' => $nc.$userData['username'],
            'hide' => 'y',
			'method'=>'lvrep',
             'uid' => UID,
			  'seid'=>session_id(),
			 'lastu'=>addslashes($_SERVER[HTTP_REFERER]),
			 'vdate' => date('Y-m-d H:i:s'),
			 'ip'=>getIP(),
			 'viewid'=>$vid
    );
    $Reply_Model = new Reply_Model();
    $rid = $Reply_Model->addReply($rdata);
	echo '谢谢！';
}
if ($action == 'tw') {
	$user_cache = $CACHE->readCache('user');
    $options_cache = $CACHE->readCache('options');
    extract($options_cache);
    
    $navibar = unserialize($navibar);

    $Twitter_Model = new Twitter_Model();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $tws = $Twitter_Model->getTwitters($page);
    $twnum = $Twitter_Model->getTwitterNum();
    $pageurl =  pagination($twnum, Option::get('index_twnum'), $page, '/m/t.php/?page=');
    $avatar = empty($user_cache[UID]['avatar']) ? '../admin/views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];
    $rcode = Option::get('reply_code') == 'y' ? "<img src=\"".DYNAMIC_BLOGURL."?action=ckcode&mode=t\" />" : '';

    $curpage = CURPAGE_TW;
    include View::getView('header');
    require_once View::getView('t');
    View::output();
}
// 获取回复.
if ($action == 'getr') {
    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;

    $Reply_Model = new Reply_Model();
    $replys = $Reply_Model->getReplys($tid, 'n');

    $response = '';
    foreach($replys as $val){
         $response .= "
         <li>
         <span class=\"name\">{$val['name']}</span> {$val['content']}<span class=\"time\">{$val['vdate']}</span>
         <em><a href=\"javascript:re({$tid}, '@".addslashes($val['name'])."：');\">回复</a></em>
         </li>";
    }
    echo $response;
}
// 回复碎语.
if ($action == 'reply') {
    $r = isset($_POST['r']) ? addslashes(trim($_POST['r'])) : '';
    $rname = isset($_POST['rname']) ? addslashes(trim($_POST['rname'])) : '';
    $rcode = isset($_POST['rcode']) ? strtoupper(addslashes(trim($_POST['rcode']))) : '';
  $tid = intval(trim($_POST['tid']));
    
    $user_cache = $CACHE->readCache('user');

  if( $vid<5)
  exit('err3');
    if (!$r || strlen($r) > 420){
        exit('err1');
    } elseif (ROLE == '' && empty($rname) ) {
        exit('err2');
    }elseif (ROLE == '' && Option::get('reply_code') == 'y' && session_start() && $rcode != $_SESSION['code']){
        exit('err3');
    }

    foreach($user_cache as $val){
        if(isset($val['name']) && $val['name'] == $rname){
            exit('err4');
        }
    }

    $date = time();
    $name =   $rname .$user_cache[UID]['name'];

    $rdata = array(
            'tid' => $tid,
            'content' => $r,
            'name' => $name,

            'hide' => ROLE == '' ? 'y' : 'n',
			'method'=>'rem',
             'uid' => UID,
			  'seid'=>session_id(),
			 'lastu'=>addslashes($_SERVER[HTTP_REFERER]),
			 'vdate' => date('Y-m-d H:i:s'),
			 'ip'=>getIP(),
			 'viewid'=>$vid
    );

    $Twitter_Model = new Twitter_Model();
    $Reply_Model = new Reply_Model();

    $rid = $Reply_Model->addReply($rdata);
    if ($rid === false){
        exit('err5');
    }

    doAction('reply_twitter', $r, $name, $date, $tid);

    if (Option::get('ischkreply') == 'n' || ROLE != ''){
        $Twitter_Model->updateReplyNum($tid, '+1');
    }else{
        exit('succ1');
    }

    $CACHE->updateCache('sta');

    $date = smartDate($date);
    $r = htmlClean(stripslashes($r));
    $response = "
         <li>
         <span class=\"name\">".stripslashes(htmlspecialchars($name))."</span> {$r}<span class=\"time\">{$vdate}</span>
         <em><a href=\"javascript:re({$tid}, '@{$name}：');\">回复</a></em>
         </li>";
    echo $response;
}
// 回复验证码.
if ($action == 'ckcode') {
    require_once EMLOG_ROOT.'/include/lib/checkcode.php';
}
if ($action == 'postnew') {
    $t = isset($_POST['t']) ? addslashes(trim($_POST['t'])) : '';

    if (!$t){
        echo 'error';exit;
    }
$Twitter_Model = new Twitter_Model();
    $tdata = array('content' => $Twitter_Model->formatTwitter($t),
            'author' => UID,
            'vdate' => date('Y-m-d H:i:s'),
    );

    $Twitter_Model->addTwitter($tdata);
    $CACHE->updateCache(array('sta','newtw'));
	emDirect("/m/t.php");
}