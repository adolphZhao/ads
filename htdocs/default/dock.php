<?php
include './inc/config.php';
include './inc/global.php';

//App::log(var_export($_GET, true));
//$input = inputRaw(false);
//App::log($input);
$cross = new Cross();
if(!$cross->checkSign()) {
    App::log('ticket signature failed');
    return;
}
$raw = $cross->getInputRaw();
$dom = new \DOMDocument();
$xml = '<?xml version="1.0" encoding="utf-8"?>' . $raw;
if(!$dom->loadXML($xml, LIBXML_DTDLOAD | LIBXML_DTDATTR)) {
    App::log('ticket decrypt failed');
    return;
}
//App::log($xml);
$xpath = new \DOMXPath($dom);
$type = $xpath->evaluate('string(//xml/InfoType)');
if($type == 'component_verify_ticket') {
    $ticket = $xpath->evaluate('string(//xml/ComponentVerifyTicket)');
    Cache::set("platform_open_ticket", $ticket);
    exit('success');
}
/*
if($type == 'unauthorized') {
    $appid = $xpath->evaluate('string(//xml/AppId)');
    $a = new Account();
    $account = $a->getOne($appid, true);
    $account['isconnect'] = '0';
    $a->modify(Account::ACCOUNT_WEIXIN, $account['id'], $account);
}
*/
