<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>

<div id="m">
	电影分类与查询：<br>
<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="top">
<TR>
<TD valign="top" width="65%">
<?php 
call_user_func(widget_tag,"标签 ");

call_user_func(widget_sort,"分类 ");
?>
	</TD>

<TD >
<?php 
call_user_func(widget_search,"搜索 ");
//call_user_func(widget_calendar,"日历 ");
//call_user_func(widget_archin,"加入日期 ");
call_user_func(widget_archive,"添加时间 ");
call_user_func(widget_random_log,"随机 ");
?>
</TD>
</TR>
</TABLE>
</div>