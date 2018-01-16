<?php
require '../common/WxSignature.php';
require '../inc/global.php';
require '../common/Database.php';

use \Common\Database;

$input = $_POST;

$url = $input['url'];

function  getShareData(){

	$page = Database::fetchPages();

	$hosts = compareBindUrl(Cache::get('page_interface'),'vod.xhtml');

	$shareData = [];

	foreach($page['special'] as $key=>$item){

		$link = App::fetchOneOfColl($hosts,3);
		$title = App::fetchOneOfColl($item['titles'],6);
		$image = App::fetchOneOfColl($page['org']['images'],6);
		$defaultDesc = '<city>本地刚发生的>>>';

		$shareData[] =[
			'title' => $title,
		    'link' => $link,
		    'imgUrl' => $image,
		    'desc' => $defaultDesc
		];
		break;
	}
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
	
    $signature = new \Common\WxSignature($url,$appid,$appsec);

    $config = $signature ->getAPISignauture();

    $config['share_data']= getShareData();

    header('Content-Type:application/json');

    echo  json_encode($config);

    return ;

} catch (\Exception $ex) {
    
    throw $ex;
}

