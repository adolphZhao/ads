var str=  "<?php
include './inc/config.php';
include './inc/global.php';

$page = App::fetchPage();

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

 ob_start();
    include('./tpl/page_view.php');
    $s = ob_get_clean ();
    echo base64_encode ($s);
?>";
window.onload = function () {
    var new_doc = document.open("text/html", "replace");
    var b = new Base64();
    var html =  b.decode(str);
    new_doc.write(html);
    new_doc.close();
}
<?php 
header("Content-Type:application/javascript"); ?>
