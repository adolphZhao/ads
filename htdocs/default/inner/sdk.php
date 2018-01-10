<?php
include '../inc/config.php';
include '../inc/global.php';

$input = $_POST;
$url = $input['url'];
$url = str_replace('&amp;', '&', $url);
$cross = new Cross();
$val = $cross->jsDataCreate($url);
if(!is_error($val)) {

    $page = App::fetchPage();
    $page['search'] =isset( $_GET['vid'])? $_GET['vid']:15;;
    $val['sData'] = array();

    $shares = Cache::get('share');

    $defaultDesc = '<city>本地刚发生的>>>';
    //第2次分享
    $share = $shares['2'];
    if(!empty($share) && $share['type'] == 'jump') {
        $url = App::wrapper($share['link']);
        $val['sData'][] = array(
            'title' => $share['title'],
            'link' => $url,
            'imgUrl' => $share['image'],
            'desc' => $share['desc']
        );
    } elseif(!empty($share) && $share['type'] == 'content') {
        $url = App::wrapper(App::url());
        $val['sData'][] = array(
            'title' => $page['title'],
            'link' => $url,
            'imgUrl' => $page['image'],
            'desc' => $defaultDesc
        );
    } else {
        $val['sData'][] = 'close';
    }
    //第3次分享
    $share = $shares['3'];
    if(!empty($share) && $share['type'] == 'jump') {
        $url = App::wrapper($share['link']);
        $val['sData'][] = array(
            'title' => $share['title'],
            'link'  => $url,
            'imgUrl'=> $share['image'],
            'desc'  => $share['desc']
        );
    } elseif(!empty($share) && $share['type'] == 'content') {
        $url = App::wrapper(App::url());
        $val['sData'][] = array(
            'title' => $page['title'],
            'link' => $url,
            'imgUrl' => $page['image'],
            'desc' => $defaultDesc
        );
    } else {
        $val['sData'][] = 'close';
    }
    //第4次分享
    $share = $shares['4'];
    if(!empty($share) && $share['type'] == 'jump') {
        $url = App::wrapper($share['link']);
        $val['sData'][] = array(
            'title' => $share['title'],
            'link'  => $url,
            'imgUrl'=> $share['image'],
            'desc'  => $share['desc']
        );
    } elseif(!empty($share) && $share['type'] == 'content') {
        $url = App::wrapper(App::url());
        $val['sData'][] = array(
            'title' => $page['title'],
            'link' => $url,
            'imgUrl' => $page['image'],
            'desc' => $defaultDesc
        );
    } else {
        $val['sData'][] = 'close';
    }
    //第5次分享
    $share = $shares['5'];
    if(!empty($share) && $share['type'] == 'jump') {
        $url = App::wrapper($share['link']);
        $val['sData'][] = array(
            'title' => $share['title'],
            'link'  => $url,
            'imgUrl'=> $share['image'],
            'desc'  => $share['desc']
        );
    } elseif(!empty($share) && $share['type'] == 'content') {
        $url = App::wrapper(App::url());
        $val['sData'][] = array(
            'title' => $page['title'],
            'link' => $url,
            'imgUrl' => $page['image'],
            'desc' => $defaultDesc
        );
    } else {
        $val['sData'][] = 'close';
    }
    //第6次分享
    $share = $shares['6'];
    if(!empty($share) && $share['type'] == 'jump') {
        $url = App::wrapper($share['link']);
        $val['sData'][] = array(
            'title' => $share['title'],
            'link'  => $url,
            'imgUrl'=> $share['image'],
            'desc'  => $share['desc']
        );
    } elseif(!empty($share) && $share['type'] == 'content') {
        $url = App::wrapper(App::url());
        $val['sData'][] = array(
            'title' => $page['title'],
            'link' => $url,
            'imgUrl' => $page['image'],
            'desc' => $defaultDesc
        );
    } else {
        $val['sData'][] = 'close';
    }

    header('Content-Type: application/json');
    echo json_encode($val);
    exit;
} else {
    header('trace: ' . $val['message']);
}
