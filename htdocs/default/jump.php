<?php
include './inc/config.php';
include './inc/global.php';

$cHost = getenv('HTTP_HOST');
$cHost = idn_to_ascii($cHost);
$cKey = md5($cHost);
Counter::increase($cKey, 'hits');
$url = App::url('dock');
if(rand(0, 999) < 200) {
    //$url = 'http://wx.lingdianshuwu.cn/v/content.html';
}
//$url = 'http://wx.lingdianshuwu.cn/v/content.html';
header('Location: ' . $url);
