<?php
include './inc/config.php';
include './inc/global.php';
include('./inner/script2img.php');

$simg = script2img('no_wechat.js') ;

$page = App::fetchPage();

$page['search'] = isset($_GET['vid'])?$_GET['vid']:15;
foreach($page as $key => $val){
    if(preg_match('/titles\d*/', $key)&&!is_array($val)){
        $page[$key] = explode("\n",$val);
    }
}
$pageConfig = array(
    'vid'   => $page['video'],
    'delay' => intval($page['delay_time']),
    'status'=> $cfg['switch_share'] == 'off' ? 'continue' : 'pending',
    'back'  => $page["ad_back"]
);

$shares = Cache::get('share');
$share = $shares['1'];
if(empty($share) || $share['type'] != 'jump') {
    $url = App::url();
    $url = App::wrapper($url);
    $pageConfig['title'] = $page['title'];
    $pageConfig['link'] = $url;
    $pageConfig['imgUrl'] = $page['image'];
    $pageConfig['desc'] = '<city>本地刚发生的>>>';
} else {
    $pageConfig['title'] = $share['title'];
    $pageConfig['link'] = App::wrapper($share['link']);
    $pageConfig['imgUrl'] = $share['image'];
    $pageConfig['desc'] = $share['desc'];
}

$cHost = getenv('HTTP_HOST');
$cHost = idn_to_ascii($cHost);
$cKey = md5($cHost);
Counter::increase($cKey, 'views');

include './tpl/page_view.php';

