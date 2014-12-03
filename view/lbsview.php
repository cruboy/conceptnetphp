<?php
/**
 * 地图搜索功能
 *   var lng=120.384428;                         // 青岛坐标
    var lat=36.105215;
  //  var map = new BMap.Map("l-map");            // 创建Map实例
   map.centerAndZoom(new BMap.Point(lng, lat), 14);
 */
if(!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<SCRIPT type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></SCRIPT>
<DIV align="center">
	<DIV id="l-map"></DIV>
	<DIV id="r-result"></DIV>
</DIV>

<SCRIPT type="text/javascript">
  var map = new BMap.Map("l-map");            // 创建Map实例


    var local = new BMap.LocalSearch("全国", {
      renderOptions: {
        map: map,
        panel : "r-result",
        autoViewport: true,
        selectFirstResult: false
      }
    });
    local.search("<?php echo $mapkeyword;?>");
</SCRIPT>
<BR>
