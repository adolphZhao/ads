<?php

require '../common/WxSignature.php';

$url = 'http://img.lowcarbonlife.com.cn/s.xhtml?vid=16#ad_1515673739192';

try{
    $signature = new \Common\WxSignature($url);

 	$token = $signature ->getAccessToken();

 	echo ($token."\n");

    $ticket = $signature ->getJsSDKToken($token);

    echo ($ticket ."\n");

    var_dump($signature->getSignature($ticket));

    return ;

} catch (\Exception $ex) {

    throw $ex;
    
}