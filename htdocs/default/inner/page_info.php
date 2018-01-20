<?php

$page = App::fetchPage();

// $hosts = [
//     'http://cdn.greenlowcarbon.com.cn/s.xhtml',
//     'http://img.lowcarbonlife.com.cn/s.xhtml',
//     'http://img.microtiny.com.cn/s.xhtml'
//     ];
$hosts = [];

$interface = Cache::get("page_interface");

foreach($interface as $config){
    $bindUrl = array_column($config['bind_url'],'host');
    $hosts = array_merge($hosts,$bindUrl);
}
$tmpHosts = [];
while (count($hosts)) {
    $domain = array_shift($hosts);

    $health = rhealth($domain);

    if($health['health']<2){
        $tmpHosts[] = wapperHost($domain,'vod.dhtml');
    }
}
$hosts = $tmpHosts;

foreach($page as $key => $val){
    if(preg_match('/titles(?<id>\d*)/', $key,$matches)&&!is_array($val)){
        $page[$key] = explode("\n",$val);
        $page['title'.$matches['id']] = App::fetchOneOfColl($page[$key], 6);
        unset($page[$key]);
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
    //$url = App::url();
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

unset($page['ad_backs']);
unset($page['titles']);
unset($page['ad_authors']);
unset($page['ad_bottoms']);
unset($page['ad_originals']);
unset($page['ad_tops']);
unset($page['docks']);
unset($page['entries']);
unset($page['images']);
unset($page['link_rems']);
unset($page['path_dock']);
unset($page['path_entry']);
unset($page['platform_appid']);
unset($page['platform_secret']);
unset($page['wrappers']);

return [
	'page'=>$page,
	'hosts' => $hosts,
	'page-config'=>$pageConfig,
	'share' =>$share
];
