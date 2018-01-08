<?php
session_start();
include '../inc/config.php';
include '../inc/global.php';
//page_global       - 页面信息及广告
//count             - 数据统计
//count_global      - 公共统计
//share             - 分享配置
//dns_{hosts]       - DNS缓存
//platform_open_xxx - 开放平台相关参数

$actions = array('summary', 'share', 'config', 'global', 'check', 'qr', 'refresh');
$act = in_array($_GET['act'], $actions) ? $_GET['act'] : 'summary';
if(empty($_SESSION['login'])) {
    $act = 'login';
}

if($act == 'summary') {
    include '../tpl/summary.php';
}

if($act == 'config') {
    if($_POST['method'] == 'clean_count') {
        $count = array();
        Cache::set('count', $count);
        exit;
    }
}

if($act == 'share') {
    $index = $_POST['index'];
    $shares = Cache::get('share');
    if(empty($shares)) {
        $shares = array();
    }
    if($_POST['method'] == 'save') {
        $share = array(
            'type'      => $_POST['type'],
            'title'     => $_POST['title'],
            'image'     => $_POST['image'],
            'link'      => $_POST['link'],
            'desc'      => $_POST['desc'],
        );
        $shares[$index] = $share;
        Cache::set('share', $shares);
        exit;
    }
    $share = $shares[$index];
    if(empty($share)) {
        $share = array(
            'type'      => 'close',
            'title'     => '',
            'image'     => '',
            'link'      => '',
            'desc'      => '',
        );
    }
    header('Content-Type: application/json');
    echo json_encode($share);
    exit;
}

if($act == 'refresh') {
    $count = Cache::get('count');
    
    $row = Cache::get("page_global");
    $ds = array();
    $ds['entries'] = array();
    $ds['docks'] = array();
    foreach($row['entries'] as $entry) {
        $countEntry = $count[md5(idn_to_ascii($entry))];
        $ds['entries'][] = array(
            'domain'    => $entry,
            'domain_e'  => idn_to_ascii($entry),
            'ip'        => fetchDns($entry),
            'url'       => App::url('entry', $entry),
            'hits'      => $countEntry['hits'],
            'status'    => $countEntry['status'],
            'last'      => date('m.d H:i:s', $countEntry['last']),
        );
    }
    foreach($row['docks'] as $dock) {
        $countEntry = $count[md5(idn_to_ascii($dock))];
        $ds['docks'][] = array(
            'domain'    => $dock,
            'domain_e'  => idn_to_ascii($dock),
            'ip'        => fetchDns($dock),
            'url'       => App::url('dock', $dock),
            'views'     => $countEntry['views'],
            'status'    => $countEntry['status'],
            'last'      => date('m.d H:i:s', $countEntry['last']),
        );
    }
    $ds['global'] = Cache::get('count_global');
    if(empty($ds['global'])) {
        $ds['global'] = array(
            'online'    => 0,
            'ip'        => 0
        );
    }
    
    header('Content-Type: application/json');
    echo json_encode($ds);
}


if($act == 'global') {
    $input = $_POST;

    $row = Cache::get("page_global");
    if(!empty($input)) {
        $rec = preSave($input);
        Cache::set('page_global', $rec);
        exit('成功 <a href="?act=global">返回</a><script>setTimeout(function(){location.href="?act=global";}, 1000)</script>');
    }
    $row = preView($row);
    include '../tpl/global.php';
}

if($act == 'check') {
    $host = $_GET['host'];
    if(!empty($host)) {
        $checkHost = $host;
        $hosts = array();
        for($i = 0; $i < 4; $i++) {
            $hosts[] = array(
                'host'  => $checkHost,
                'ip'    => fetchDns($checkHost),
                'last'  => time(),
                'status'=> Verify::check139($checkHost)
            );
            $checkHost = substr(md5(uniqid()), 0, 4) . '.' . $host;
        }
    }
    $short = $_GET['short'];
    if(!empty($short)) {
        $shortUrls = App::shortUrl(array($short));
    }
    include '../tpl/check.php';
}

if($act == 'qr') {
    include '../inc/phpqrcode.php';
    $url = $_GET['url'];
    \QRcode::png($url, false, QR_ECLEVEL_Q, 8, 0);
}

if($act == 'login') {
    if($_POST['password'] == $config['password']) {
        $_SESSION['login'] = true;
        header('Location: ?act=activity');
        exit;
    }
    include '../tpl/login.php';
}

function coll_elements_extend($keys, $src, $default = false){
    $return = array();

    foreach($src as $key=>$item) {
            $return[$key] =$item;
    }
    return $return;
}

function preSave($input) {
    $input = coll_walk($input, 'trim');
    $rec = coll_elements_extend(array('video', 'delay_time', 'statistics', 'platform_appid', 'platform_secret', 'path_entry', 'path_dock','link_rems'), $input);
    if(empty($input['titles'])) {
        $rec['titles'] = array();
    } else {
        $rec['titles'] = coll_walk(explode("\n", $input['titles']), 'trim');
    }
    $rec['ad_authors'] = array();
    if(!empty($input['ad_authors'])) {
        $ad_authors = coll_walk(explode("\n", $input['ad_authors']), 'trim');
        foreach($ad_authors as $ad_author) {
            $pieces = coll_walk(explode(",", $ad_author), 'trim');
            $rec['ad_authors'][] = array(
                'title' => $pieces[0],
                'url'   => $pieces[1]
            );
        }
    }
	
	$rec['link_rems'] = array();
    if(!empty($input['link_rems'])) {
        $link_rems = coll_walk(explode("\n", $input['link_rems']), 'trim');
        foreach($link_rems as $link_rem) {
            $pieces = coll_walk(explode(",", $link_rem), 'trim');
            $rec['link_rems'][] = array(
                'title' => $pieces[0],
                'url'   => $pieces[1]
            );
        }
    }
    
    $rec['ad_tops'] = array();
    if(!empty($input['ad_tops'])) {
        $ad_tops = coll_walk(explode("\n", $input['ad_tops']), 'trim');
        foreach($ad_tops as $ad_top) {
            $pieces = coll_walk(explode(",", $ad_top), 'trim');
            $rec['ad_tops'][] = array(
                'image' => $pieces[0],
                'url'   => $pieces[1],
                'pos'   => empty($pieces[2]) ? 1 : intval($pieces[2])
            );
        }
    }
    
    $rec['ad_bottoms'] = array();
    if(!empty($input['ad_bottoms'])) {
        $ad_bottoms = coll_walk(explode("\n", $input['ad_bottoms']), 'trim');
        foreach($ad_bottoms as $ad_bottom) {
            $pieces = coll_walk(explode(",", $ad_bottom), 'trim');
            $rec['ad_bottoms'][] = array(
                'image' => $pieces[0],
                'url'   => $pieces[1]
            );
        }
    }
    
    if(empty($input['ad_originals'])) {
        $rec['ad_originals'] = array();
    } else {
        $rec['ad_originals'] = coll_walk(explode("\n", $input['ad_originals']), 'trim');
    }
    if(empty($input['ad_backs'])) {
        $rec['ad_backs'] = array();
    } else {
        $rec['ad_backs'] = coll_walk(explode("\n", $input['ad_backs']), 'trim');
    }
    if(empty($input['images'])) {
        $rec['images'] = array();
    } else {
        $rec['images'] = coll_walk(explode("\n", $input['images']), 'trim');
    }
    
    if(empty($input['entries'])) {
        $rec['entries'] = array();
    } else {
        $rec['entries'] = coll_walk(explode("\n", $input['entries']), 'trim');
        $jumps = array();
        foreach($rec['entries'] as $entry) {
            $jumps[] = App::url('entry', $entry);
        }
        $wrappers = App::shortUrl($jumps);
        if(!is_error($wrappers)) {
            $rec['wrappers'] = $wrappers;
        }
    }
    if(empty($input['docks'])) {
        $rec['docks'] = array();
    } else {
        $rec['docks'] = coll_walk(explode("\n", $input['docks']), 'trim');
    }
    /*
    if(empty($input['wrappers'])) {
        $rec['wrappers'] = array();
    } else {
        $rec['wrappers'] = coll_walk(explode("\n", $input['wrappers']), 'trim');
    }
    */
    
    return $rec;
}

function preView($row) {
    $row['titles'] = implode("\n", $row['titles']);
    $ad_authors = '';
    foreach($row['ad_authors'] as $ad_author) {
        $ad_authors .= "{$ad_author['title']},{$ad_author['url']}\n";
    }
    $row['ad_authors'] = trim($ad_authors);

    $ad_tops = '';
    foreach($row['ad_tops'] as $ad_top) {
        $ad_tops .= "{$ad_top['image']},{$ad_top['url']},{$ad_top['pos']}\n";
    }
    $row['ad_tops'] = trim($ad_tops);

    $ad_bottoms = '';
    foreach($row['ad_bottoms'] as $ad_bottom) {
        $ad_bottoms .= "{$ad_bottom['image']},{$ad_bottom['url']}\n";
    }
    $row['ad_bottoms'] = trim($ad_bottoms);

    $row['ad_originals'] = implode("\n", $row['ad_originals']);
    $row['ad_backs'] = implode("\n", $row['ad_backs']);
    $row['images'] = implode("\n", $row['images']);
    
    $row['entries'] = implode("\n", $row['entries']);
    $row['docks'] = implode("\n", $row['docks']);
    $row['wrappers'] = implode("\n", $row['wrappers']);
    return $row;
}

function fetchDns($host) {
    $key = "dns_{$host}";
    $ip = Cache::get($key);
    if(empty($ip)) {
        $host = idn_to_ascii($host);
        $dns = dns_get_record($host, DNS_A);
        $ip = $dns[0]['ip'];
        if(!empty($ip)) {
            Cache::set($key, $ip, 180);
        }
    }
    return $ip;
}
