<?php
include './inc/config.php';
include './inc/global.php';
include './common/Net.php';

//$poster = new Poster();

function detectDomainStatus($domain)
{
    $checkedStatus = \Common\Net::httpGet(sprintf('http://vip.weixin139.com/weixin/ll0358a.php?domain=%s',$domain));
    $checkedStatus = json_decode($checkedStatus);
    // var_dump($checkedStatus->errmsg);
    // var_dump($checkedStatus->status);
    // var_dump($checkedStatus->domain);
    return $checkedStatus;
}

function delByValue($arr, $value){  
    $key = array_search($value,$arr);  
    var_dump($key);
    if(isset($key)){  
        unset($arr[$key]);  
    }  
    return $arr;  
}  

function removeDomainFromPool($domain){
    echo "删除无效的域名  => " .$domain['domain']."\n";
    $page = Cache::get('page_global');
    $docks = $page['docks'];
    $entries = $page['entries'];
    $page['docks'] = delByValue($docks,$domain['domain']);
    $page['entries'] = delByValue($entries,$domain['domain']);
    Cache::set('page_global',$page);
    return true;
}

function flagDomainFromPool($domain,$status){
    if($status){
        whealth($domain);
    }else{
        dhealth($domain);
    }
    
}

while(true) {
    $failureArr=[];

    $domainPool = Cache::get("page_interface");

    $retPool = [];
    $retPool['domain'] = [];
    foreach($domainPool as $wechatDomain){
          $retPool['domain']  = array_merge($retPool['domain'] ,$wechatDomain['bind_url']);
    }
   
    if(empty($retPool['domain'])) {
        echo "没有检测到需要测试的域名......\n";
        sleep(30);
        continue;
    }

    $domainArr = $retPool['domain'];

    foreach($domainArr as $domain) {
      
        echo '检测Domain => '. $domain['host'] . "\n";


        $status = detectDomainStatus($domain['host']);


        if($status->status ==0 ||$status->status ==3)
        {
            echo $status->errmsg .'  =>  '.$domain['host']."\n";
            flagDomainFromPool($domain['host'],0);
        }else{
            //标记域名检测不通过
            echo $status->errmsg .'  =>  '.$domain['host'].'.'. $status->status ."\n";
            flagDomainFromPool($domain['host'],1);
        }  
        echo "--------------------------------\n";
        sleep(4);
    }

    //exec('chown -R www:www /c/htdocs/default');

    sleep(8);
}

class Poster {
    private $cookieFile = '';
    private $appid = '';
    private $token = '';

    public function __construct() {
        global $config;
        $this->cookieFile = dirname(__FILE__) . "/data/poster.cookie.jar";
        $this->appid = $config['platform']['APPID'];
    }

    public function test() {
        $hosts = array();
        $hosts[]  = 'weibo.cn';
        $hosts[]  = 'wii.adxya.cn';
        $hosts[]  = 'wx.lingdianshuwu.cn';
        $ret = $this->postModify($hosts);
        var_dump($ret);
        echo "\n";
    }

    public function postModify($hosts) {
        if(empty($this->token)) {
            $ret = $this->login();
            if(is_error($ret)) {
                return $ret;
            }
            return $this->postModify($hosts);
        }
        $url = "https://open.weixin.qq.com/cgi-bin/component_acct?action=modify&t=manage/plugin_modify&appid={$this->appid}&token={$this->token}&lang=zh_CN";
        $content = $this->get($url);
        if(is_error($content)) {
            return $content;
        }
        if(empty($content) || strpos($content, '登录超时') > -1) {
            //未登录
            $ret = $this->login();
            if(is_error($ret)) {
                return $ret;
            }
            return $this->postModify($hosts);
        }
        if(preg_match('/appid: "(?<appid>.*?)",.*name: "(?<name>.*?)",.*desc: "(?<desc>.*?)",.*site: "(?<official_site>.*?)",.*icon_url: "(?<icon_url>.*?)",.*token: "(?<auth_token>.*?)",.*auth_domain: "(?<auth_domain>.*?)",.*ticket_url: "(?<ticket_url>.*?)",.*msg_url: "(?<msg_url>.*?)",.*raw_white_ip: "(?<white_ip>.*?)",.*raw_white_acct: "(?<white_acct>.*?)",.*sns_domain: "(?<sns_domain>.*?)",.*symmetric_key: "(?<symmetric_key>.*?)".*/s', $content, $match)) {
            //获取页面数据
            $pars = array();
            $pars['name']           = $match['name'];
            $pars['desc']           = $match['desc'];
            $pars['official_site']  = $match['official_site'];
            $pars['icon_url']       = $match['icon_url'];
            $pars['auth_token']     = $match['auth_token'];
            $pars['auth_domain']    = $match['auth_domain'];
            $pars['ticket_url']     = $match['ticket_url'];
            $pars['msg_url']        = $match['msg_url'];
            $pars['white_ip']       = $match['white_ip'];
            $pars['white_acct']     = $match['white_acct'];
            $pars['category_list']  = '1;4;3';
            $pars['symmetric_key']  = $match['symmetric_key'];
            $pars['sns_domain']     = implode(';', $hosts);

            $pars['wxa_server_domain'] = '';
            $pars['enter_url']      = 'http://undefined';
            $pars['tag_id_list']    = '2006;1001;1010';
            $pars['appid']          = $this->appid;
            $pars['token']          = $this->token;
            $pars['lang']           = 'zh_CN';
            $pars['f']              = 'json';
            $pars['ajax']           = '1';
            $pars['action']         = 'modify';
            $pars['key']            = 'modify';

            $url = "https://open.weixin.qq.com/cgi-bin/component_acct";
            $resp = $this->post($url, $pars);
            if(is_error($resp)) {
                return $resp;
            }
            $ret = json_decode($resp, true);
            if($ret['err_code'] == '0') {
                return true;
            }
            
        }
        return error(-1, '未知提交错误');
    }

    private function login() {
        global $config;
        $resp = $this->get('https://open.weixin.qq.com');
        if(is_error($resp)) {
            return $resp;
        }
        $token = '';
        if(preg_match('/token: "(?<token>.*?)"/s', $match)) {
            $token = $match['token'];
        }
        if(empty($token)) {
            $url = "https://open.weixin.qq.com/cgi-bin/login";
            $pars = array();
            $pars['account']= $config['platform']['username'];
            $pars['passwd'] = md5($config['platform']['password']);
            $pars['token']  = '';
            $pars['lang']   = 'zh_CN';
            $pars['f']      = 'json';
            $pars['ajax']   = '1';
            $pars['key']    = '1';

            $resp = $this->post($url, $pars);
            if(!is_error($resp)) {
                $ret = json_decode($resp, true);
                if($ret['base_resp']['ret'] == '0') {
                    $this->token = $ret['base_resp']['token'];
                    return true;
                }
                return error(-1, '未知登录错误');
            } else {
                return $resp;
            }
        } else {
            $this->token = $token;
            return true;
        }
    }

    private function get($url) {
        $options = array();
        $options[CURLOPT_COOKIEFILE] = $this->cookieFile;;
        $options[CURLOPT_COOKIEJAR] = $this->cookieFile;
        $options[CURLOPT_REFERER]   = 'https://open.weixin.qq.com/';

        $resp = Net::httpRequest($url, '', array(), '', 5, $options);
        if(!is_error($resp)) {
            return $resp['content'];
        }
        return $resp;
    }

    private function post($url, $data) {
        $options = array();
        $options[CURLOPT_COOKIEFILE] = $this->cookieFile;;
        $options[CURLOPT_COOKIEJAR] = $this->cookieFile;
        $options[CURLOPT_REFERER]   = 'https://open.weixin.qq.com/';

        $headers = array('Content-Type: application/x-www-form-urlencoded');
        $resp = Net::httpRequest($url, $data, $headers, '', 5, $options);
        if(!is_error($resp)) {
            return $resp['content'];
        }
        return $resp;
    }
}

