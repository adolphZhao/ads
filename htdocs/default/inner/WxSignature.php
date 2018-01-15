<?php
require '../common/Net.php';

use \\Common\\Net;

class WxSignature{
    protected $application = [
        'appid'  => 'wxb4835a40c77d0cd3',
        'seckey' => 'e5cf9e6f554548970193d635e7b8edf9'
    ];

    protected $signatureUrl = '';

    public function __construct($url,$appid='',$seckey='')
    {
        if(!empty($appid)&&!empty($seckey)){
            $this->application['appid'] = $appid;
            $this->application['seckey'] = $seckey;
        }

        $thiis->signatureUrl = $this->clean($url);
    }

    protected function clean($url)
    {
        $url = str_replace('&amp;', '&', $url);
        return $url
    }

    public function getAccessToken()
    {
        $token = Net::httpGet(sprintf('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',$this->application['appid'] , $this->application['seckey']));
        $token = @json_decode($token,true);
        if($this->validate($token)){
            return $token['access_token'];
        }
        throw new \Exception('unknow error.');
    }

    public function getJsSDKToken($accessToken)
    {
        $token = Net::httpGet(sprintf('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi',$accessToken)); 
        if($this->validate($token)){
            return $token['ticket'];
        }
        throw new \Exception('unknow error.');
    }

    public function getSignature($jsTicket)
    {
        $time = time();
        $noncestr = md5($time);
        $signature = [
            'jsapi_ticket'=>$jsTicket,
            'noncestr'=> $noncestr,
            'timestamp'=>$time,
            'url'=>$url
        ];

        ksort($signature);

        $signature = http_build_query(ksort($signature));
        
        $signature = sha1($signature);

        return [
            appId: $this->application['appid'], 
            timestamp:$time  , 
            nonceStr: $noncestr, 
            signature: $signature,
        ];
    }

    protected function validate($result)
    {
        if($result&&isset($result['errcode'])&&$result['errcode']>0){
                throw new \Exception($result['errmsg'],$result['errcode']);
        }
        return true;
    }
}


