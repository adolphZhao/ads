<?php
namespace Common;

require 'Net.php';
require 'Cache.php';

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

        $this->signatureUrl = $this->clean($url);
    }

    protected function clean($url)
    {
        if(preg_match('/%2F/', $url)){
            $url = urldecode($url);
        }
        $url = str_replace('&amp;', '&', $url);
        $url = preg_replace('/#.*/', '', $url);
        return $url;
    }

    public function getAccessToken()
    {
        $key = 'WECHAT_ACCESS_TOKEN';
        
        if(Cache::isExpired($key,7200))
        {
            $token = Net::httpGet(sprintf('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',$this->application['appid'] , $this->application['seckey']));
            $token = @json_decode($token,true);
            if($this->validate($token)){
                Cache::set($key,$token['access_token']);
                return $token['access_token'];
            }
        }
        return Cache::get($key);
    }

    public function getJsSDKToken($accessToken)
    {
        $key = 'WECHAT_JSSDK_TOKEN';
       
        if(Cache::isExpired($key,7200))
        {
            $token = Net::httpGet(sprintf('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi',$accessToken)); 
            $token = @json_decode($token,true);
            if($this->validate($token)){
                Cache::set($key,$token['ticket']);
                return $token['ticket'];
            }
        }
        return Cache::get($key);
    }

    public function getSignature($jsTicket)
    {
        $time = time();
        $noncestr = md5($time);
        $signature = [
            'jsapi_ticket' => $jsTicket,
            'noncestr' => $noncestr,
            'timestamp' => $time,
            'url' => $this->signatureUrl
        ];

        ksort($signature);

        $httpQuery = http_build_query($signature);
        $httpQuery =urldecode($httpQuery );
        $signature = sha1($httpQuery);

        return [
            'appid' => $this->application['appid'], 
            'timestamp' => $time  , 
            'nonce'=>  $noncestr, 
            'signature' => $signature,
        ];
    }

    public function getAPISignauture()
    {
        $token = $this ->getAccessToken();
        $ticket = $this ->getJsSDKToken($token);
        return $this->getSignature($ticket);
    }

    protected function validate($result)
    {
        if($result&&isset($result['errcode'])&&$result['errcode']>0){
                throw new \Exception($result['errmsg'],$result['errcode']);
        }
        return true;
    }
}


