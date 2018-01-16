<?php
include './inc/config.php';
include './inc/global.php';

$cHost = getenv('HTTP_HOST');
file_put_contents('/tmp/hosts', $cHost);
whits($cHost);

//$url = App::url('dock');
//这里设置不随机
$host = wapperHost($cHost,'s.xhtml'); 
//$url = 'http://wx.lingdianshuwu.cn/v/content.html';
header('HTTP/1.1 303 See Other');
header('Location: ' .'http://so.le.com/s3/?to='. $host .'?vid='. (isset($_GET['vid'])?$_GET['vid']:15) );
