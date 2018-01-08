<?php
include './inc/config.php';
include './inc/global.php';

$poster = new Poster();
$init = function() use($poster) {
    global $config;
    $page = Cache::get('page_global');
    $postHosts = array();
    $postHosts[] = parse_url($config['wrapper'], PHP_URL_HOST);
    $postHosts[] = $page['docks'][0];
    echo "提交到开放平台的域名\n";
    print_r($postHosts);
    $ret = $poster->postModify($postHosts);
    echo is_error($ret) ? $ret['message'] : '失败', "\n";
};
//$init();

while(true) {
    $page = Cache::get('page_global');
    if(empty($page) || empty($page['entries']) || empty($page['docks'])) {
        sleep(1);
        continue;
    }
    
    echo "检测域名是否被封\n";
    $count = Cache::get('count');
    if(empty($count)) {
        $count = array();
    }
    
    $failDocks = array();
    $okDocks = array();
    foreach($page['docks'] as $dock) {
        $key = md5(idn_to_ascii($dock));
        $countEntry = $count[$key];
        $countEntry['domain'] = $dock;
        if($countEntry['status'] == 'bad') {
            $failDocks[$key] = $countEntry;
        } else {
            //需要检测
            if(count($okDocks) > 0) {
                $okDocks[$key] = $countEntry;
            } else {
                $ret = Verify::check139($dock);
                sleep(2);
                $countEntry['status'] = $ret;
                $countEntry['last'] = time();
                if($ret == 'bad') {
                    $failDocks[$key] = $countEntry;
                } else {
                    $okDocks[$key] = $countEntry;
                }
            }
        }
    }
    if(empty($okDocks)) {
        //没有可用域名了
        //电话提示
    } else {
        //第一个域名不可用的情况
        $firstOk = current($okDocks)['domain'];
        if($page['docks'][0] != $firstOk) {
            echo "提交到开放平台的域名\n";
            $postHosts = array();
            $postHosts[] = parse_url($page['wrappers'][0], PHP_URL_HOST);
            //$postHosts[] = parse_url($page['wrappers'][1], PHP_URL_HOST);
            $postHosts[] = current($okDocks)['domain'];
            print_r($postHosts);
            $ret = $poster->postModify($postHosts);
            echo is_error($ret) ? $ret['message'] : '失败', "\n";

            $count = array();
            $count = array_merge($okDocks, $failDocks);

            echo "写入新排序\n";
            $page = Cache::get('page_global');
            $docks = array();
            foreach($count as $entry) {
                if(in_array($entry['domain'], $page['docks'])) {
                    $docks[] = $entry['domain'];
                }
            }
            $page['docks'] = $docks;
            Cache::set('page_global', $page);

            echo "写入统计信息\n";
            $delKeys = array();
            foreach($page['docks'] as $dock) {
                $key = md5(idn_to_ascii($dock));
                if(empty($count[$key])) {
                    $delKeys[] = $key;
                }

            }
            foreach($delKeys as $delKey) {
                unset($count[$delKey]);
            }
            Cache::set('count', $count);
        } else {
            echo "第一个域名没有被封-----[ok]\n";
        }
    }
    
    echo "计算访问量和分享量\n";
    Counter::sum();
    
    echo "获取在线统计数据\n";
    if(preg_match('/web_id=(?<siteId1>\d+)|cnzz_stat_icon_(?<siteId2>\d+)/', $page['statistics'], $match)) {
        $siteId = !empty($match['siteId1']) ? $match['siteId1'] : $match['siteId2'];
        $spider = new Spider($siteId);
        $tj = $spider->fetchData();
        if(is_error($tj)) {
            echo "{$tj['message']}\n";
        } else {
            if(!empty($tj['ip']) && !empty($tj['online'])) {
                $count = Cache::get("count_global");
                if(empty($count)) {
                    $count = array();
                }
                $count['ip'] = $tj['ip'];
                $count['online'] = $tj['online'];
                Cache::set("count_global", $count);
            }
        }
    }

    exec('chown -R www:www /c/htdocs/default');
    sleep(1);
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

