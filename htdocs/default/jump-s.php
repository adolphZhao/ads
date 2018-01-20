<?php
include './inc/config.php';
include './inc/global.php';

$cHost = getenv('HTTP_HOST');

$cKey = getHostKey($cHost);

$jump = $cHost;

$guide = Cache::get('domain_guide_' . $cKey);

if ($guide) {
    $rand = rand(1, 1000);

    foreach ($guide as $host => $per) {
        $rand -= $per;
        if ($rand <= 0) {
            $jump = $host;
            break;
        }else{
            $jump = $cHost;
            break;
        }
    }
}

//这里因为导流要开启随机
$host = wapperHost($jump, 's.dhtml');

header('HTTP/1.1 303 See Other');
header('Location: ' . 'http://so.le.com/s3/?to=' . $host . '?vid=' . (isset($_GET['vid']) ? $_GET['vid'] : 15));
