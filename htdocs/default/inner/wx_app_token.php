<?php
require '../common/WxSignature.php';
require '../inc/global.php';
require '../common/Database.php';

use \Common\Database;

$input = $_POST;

$url = $input['url'];

function  getShareData(){

	$page = Database::fetchPages();

	$hosts = [
		'http://cdn.greenlowcarbon.com.cn/s.xhtml',
		'http://img.lowcarbonlife.com.cn/s.xhtml',
		'http://img.microtiny.com.cn/s.xhtml'
	];

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
    $signature = new \Common\WxSignature($url);

    $config = $signature ->getAPISignauture();

    $config['share_data']= getShareData();

    header('Content-Type:application/json');

    echo  json_encode($config);

    return ;

} catch (\Exception $ex) {
    
    throw $ex;
}

