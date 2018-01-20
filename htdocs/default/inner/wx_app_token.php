<?php
require '../common/WxSignature.php';
require '../inc/global.php';
require '../common/Database.php';

use \Common\Database;

$input = $_POST;

$url = $input['url'];

function  getShareData($vid){

	$page = Database::fetchPages();

	$hosts = compareBindUrl(Cache::get('page_interface'),'vod.xhtml');

	$shareData = [];

	$special = [];

	foreach ($page['special'] as $item) {
		if($item['video_num'] == $vid){
			$special  = $item;
		}
	}

	$link = App::fetchOneOfColl($hosts,30);
	$title = App::fetchOneOfColl($special['titles'],6);
	$image = App::fetchOneOfColl($special['images'],6);
	$defaultDesc = '<city>本地刚发生的>>>';

	$shareData[] =[
		'title' => $title,
	    'link' => $link,
	    'imgUrl' => $image,
	    'desc' => $defaultDesc
	];
		
   	return $shareData;
}

try{
	$appid = '';
	$appsec = '';

	if(preg_match('/:\/\/([^\/]*)\//', $url,$matches))
	{
		$domain = $matches[1];

		$cKey = getHostKey($domain);
		$interface = Cache::get("page_interface");
		
		foreach($interface as $config){
			
			if(in_array($cKey, array_column($config['bind_url'],'key'))){
				 $appid = $config['appid'];
				 $appsec = $config['appsecret'];
				 break;
			}
		}
	}

	$vid = 15;

	if(preg_match('/vid=(\d+)/',$url,$matches)){
		$vid = $matches[1];
	}

    $signature = new \Common\WxSignature($url,$appid,$appsec);

    $config = $signature ->getAPISignauture();

    $config['share_data']= getShareData($vid);

    header('Content-Type:application/json');

    echo  json_encode($config);

    return ;

} catch (\Exception $ex) {
    
    throw $ex;
}

