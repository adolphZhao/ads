<?php
include './inc/config.php';
include './inc/global.php';

$cHost = getenv('HTTP_HOST');
$cHost = idn_to_ascii($cHost);
$cKey = md5($cHost);
Counter::increase($cKey, 'hits');
//$url = App::url('dock');
$hosts = [
	'http://cdn.greenlowcarbon.com.cn/s.xhtml',
	'http://img.lowcarbonlife.com.cn/s.xhtml',
	'http://img.microtiny.com.cn/s.xhtml'
	];
if(rand(0, 999) < 200) {
    //$url = 'http://wx.lingdianshuwu.cn/v/content.html';
}

$r = rand(0,2);
//$url = 'http://wx.lingdianshuwu.cn/v/content.html';
header('HTTP 1.1 303 OK');
header('Location: ' .'http://so.le.com/s3/?to='. $hosts[$r] .'?vid='. (isset($_GET['vid'])?$_GET['vid']:15) );
