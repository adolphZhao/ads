<?php

function escape($string, $in_encoding = 'UTF-8',$out_encoding = 'UCS-2') {
    $return = '';
    if (function_exists('mb_get_info')) {
        for($x = 0; $x < mb_strlen ( $string, $in_encoding ); $x ++) {
            $str = mb_substr ( $string, $x, 1, $in_encoding );
            if (strlen ( $str ) > 1) { // 多字节字符 
                $return .= '%u' . strtoupper ( bin2hex ( mb_convert_encoding ( $str, $out_encoding, $in_encoding ) ) );
            } else {
                $return .= '%' . strtoupper ( bin2hex ( $str ) );
            }
        }
    }
    return $return;
}

/**
 * 构造错误数组
 *
 * @param int $errno 错误码，0为无任何错误。
 * @param string $errormsg 错误信息，通知上层应用具体错误信息。
 * @return array
 */
function error($errno, $message = '') {
    return array(
        'errno' => $errno,
        'message' => $message,
    );
}

/**
 * 检测返回值是否产生错误
 *
 * 产生错误则返回true，否则返回false
 *
 * @param mixed $data 待检测的数据
 * @return boolean
 */
function is_error($data) {
    if (empty($data) || !is_array($data) || !array_key_exists('errno', $data) || (array_key_exists('errno', $data) && $data['errno'] == 0)) {
        return false;
    } else {
        return true;
    }
}

function inputRaw($jsonDecode = true) {
    $post = file_get_contents('php://input');
    if($jsonDecode) {
        $post = @json_decode($post, true);
    }
    return $post;
}

/**
 * 该函数从一个数组中取得若干元素。
 * 该函数测试（传入）数组的每个键值是否在（目标）数组中已定义；
 * 如果一个键值不存在，该键值所对应的值将被置为FALSE，
 * 或者你可以通过传入的第3个参数来指定默认的值。
 *
 * @param array $keys 需要筛选的键名列表
 * @param array $src 要进行筛选的数组
 * @param mixed $default 如果原数组未定义某个键，则使用此默认值返回
 * @return array
 */
function coll_elements($keys, $src, $default = false) {
    $return = array();
    if(!is_array($keys)) {
        $keys = array($keys);
    }
    foreach($keys as $key) {
        if(isset($src[$key])) {
            $return[$key] = $src[$key];
        } else {
            if($default !== null) {
                $return[$key] = $default;
            }
        }
    }
    return $return;
}

function coll_key($ds, $key) {
    if(!empty($ds) && !empty($key)) {
        $ret = array();
        foreach($ds as $row) {
            $ret[$row[$key]] = $row;
        }
        return $ret;
    }
    return array();
}
/**
 * 取出ds的key字段组成新数组
 */
function coll_neaten($ds, $key) {
    if(!empty($ds) && !empty($key)) {
        $ret = array();
        foreach($ds as $row) {
            $ret[] = $row[$key];
        }
        return $ret;
    }
    return array();
}

function coll_walk($ds, $callback, $key = null) {
    if(!empty($ds) && is_callable($callback)) {
        $ret = array();
        if(!empty($key)) {
            foreach($ds as $k => $row) {
                $ret[$k] = call_user_func($callback, $row[$key]);
            }
        } else {
            foreach($ds as $k => $row) {
                $ret[$k] = call_user_func($callback, $row);
            }
        }
        return $ret;
    }
    return array();
}

if(!function_exists('idn_to_ascii')) {
    function idn_to_ascii($domain) {
        return $domain;
    }
}

if(!function_exists('idn_to_utf8')) {
    function idn_to_utf8($domain) {
        return $domain;
    }
}

class App {
    
    public static function fetchPage() {
        $page = Cache::get("page_global");
        $page['title'] = self::fetchOneOfColl($page['titles'], 6);
        $page['ad_author'] = self::fetchOneOfColl($page['ad_authors'], 6);
        $adTopGroups = array();
        foreach($page['ad_tops'] as $adTop) {
            if(empty($adTop['pos'])) {
                $adTop['pos'] = 1;
            }
            $adTopGroups[$adTop['pos']][] = $adTop;
        }
        foreach($adTopGroups as $key => $adTopGroup) {
            $page['ad_top'][$key] = self::fetchOneOfColl($adTopGroup, 6);
        }
        $page['ad_original'] = self::fetchOneOfColl($page['ad_originals'], 6);
        $page['ad_back'] = self::fetchOneOfColl($page['ad_backs'], 6);
        $page['ad_bottom'] = self::fetchOneOfColl($page['ad_bottoms'], 6);
        $page['image'] = self::fetchOneOfColl($page['images'], 6);
        return $page;
    }
    
    public static function fetchCfg($key) {
        $cfg = Cache::get("config_{$key}");
        $cfgGlobal = Cache::get('config_global');
        if($cfgGlobal['switch_share'] == 'on' || $cfgGlobal['switch_share'] == 'off') {
            $cfg['switch_share'] = $cfgGlobal['switch_share'];
        }
        if($cfgGlobal['switch_ad'] == 'on' || $cfgGlobal['switch_ad'] == 'off') {
            $cfg['switch_ad'] = $cfgGlobal['switch_ad'];
        }
        if($cfgGlobal['mode_share'] == 'timeline' || $cfgGlobal['mode_share'] == 'app') {
            $cfg['mode_share'] = $cfgGlobal['mode_share'];
        }
        return $cfg;
    }
    
    public static function log($content, $file = 'error.log') {
        $path = dirname(dirname(__FILE__)) . '/logs/';
        mkdir($path);
        $filename = $path . $file;
        $fp = fopen($filename, 'a+');
        $now = date('Y-m-d H:i:s');
        fwrite($fp, "{$now}----\n");
        fwrite($fp, $content);
        fwrite($fp, "\n");
        fclose($fp);
    }
    
    public static function fetchOneOfColl($coll, $minHash = 6) {
        $now = floor(time() / (60 * $minHash));
        $hashIndex = $now % count($coll);
        return $coll[$hashIndex];
    }

    //fly, view, jump
    public static function url($type = 'entry', $host = '') {
        $global = Cache::get('page_global');
        $url = '';
        if($type == 'entry') {
            $entry = $host;
            if(empty($entry)) {
                $entry = App::fetchOneOfColl($global['entries'], 15);
            }
            $entry = idn_to_ascii($entry);
            $url = "http://{$entry}{$global['path_entry']}";
        }
        if($type == 'dock') {
            $dock = $host;
            if(empty($dock)) {
                $dock = $global['docks'][0];
            }
            $dock = idn_to_ascii($dock);
            $url = "http://{$dock}{$global['path_dock']}";
        }
        return $url;
    }
    
    public static function wrapper($url) {
        $page = Cache::get('page_global');
        if(parse_url($page['wrappers'][0], PHP_URL_HOST) == parse_url($url, PHP_URL_HOST)) {
            return $url;
        }
        $link = urlencode($url);
        $wrapper = App::fetchOneOfColl($page['wrappers']);
        $url = str_replace('{link}', $link, $wrapper);
        return $url;
    }

    public static function verifyHost($key) {
        $allHosts = Cache::get("hosts_{$key}");
        $newAllHosts = array();
        foreach($allHosts as $host) {
            if($host['status'] != 'bad' && $host['last'] < time() - 60) {
                $host['status'] = Verify::check139($host['host']);
                $host['last'] = time();
            }
            $newAllHosts[$host['host']] = $host;
        }
        Cache::set("hosts_{$key}", $newAllHosts);
    }
    
    private static function generateStr($len = 32) {
        $str = '';
        while(true) {
            $str .= md5(uniqid());
            if(strlen($str) >= $len) {
                return $str;
            }
        }
    }
    
    public static function getKey($currentHost = '') {
        if(empty($currentHost)) {
            $currentHost = getenv('HTTP_HOST');
        }
        $currentHost = trim($currentHost, '.');
        $currentHost = idn_to_utf8($currentHost);
        $currentKey = '';
        $keys = Cache::get('activities');
        foreach($keys as $key => $host) {
            if(!empty($host[$currentHost])) {
                $currentKey = $key;
                break;
            }
        }
        return $currentKey;
    }
    
    public static function checkUA() {
        if(empty($_GET['debug'])) {
            $ua = getenv('HTTP_USER_AGENT');
            if(stripos($ua, 'micromessenger') === false) {
                header('Location: https://v.qq.com/');
                exit;
            }
        }
    }
    
    public static function accountSaver($account) {
        $access = @unserialize($account['access']);
        if(!empty($access)) {
            if(!empty($account['agent'])) {
                $accessKey = "access_{$account['agent']}_{$account['appid']}";
            } else {
                $accessKey = "access_{$account['appid']}";
            }
            Cache::set($accessKey, $account['access'], $access['expire'] - time() - 600);
        }
        $jsticket = @unserialize($account['jsticket']);
        if(!empty($jsticket)) {
            if(!empty($account['agent'])) {
                $jsticketKey = "jsticket_{$account['agent']}_{$account['appid']}";
            } else {
                $jsticketKey = "jsticket{$account['appid']}";
            }
            Cache::set($jsticketKey, $account['jsticket'], $jsticket['expire'] - time() - 600);
        }
    }
    
    public static function createWx($host) {
        $accounts = Cache::get('accounts_global');
        $key = self::getKey($host);
        $hosts = Cache::get("hosts_{$key}");
        $account = $accounts[$hosts[$host]['account']];
        if(!empty($account)) {
            if(!empty($account['agent'])) {
                $accessKey = "access_{$account['agent']}_{$account['appid']}";
            } else {
                $accessKey = "access_{$account['appid']}";
            }
            $account['access'] = Cache::get($accessKey);
            
            if(!empty($account['agent'])) {
                $jsticketKey = "jsticket_{$account['agent']}_{$account['appid']}";
            } else {
                $jsticketKey = "jsticket{$account['appid']}";
            }
            $account['jsticket'] = Cache::get($jsticketKey);
            $wx = new WeiXin($account);
            return $wx;
        }
        return null;
    }
    
    public static function shortUrl($fullUrls) {
        $url = 'http://api.meituan.com/group/v1/shorturl';
        $headers = array(
            'Content-Type: application/json'
        );
        $pars = array();
        $pars['urls'] = $fullUrls;
        $dat = json_encode($pars);
        $resp = Net::httpRequest($url, $dat, $headers);
        if(is_error($resp)) {
            return $resp;
        }
        $dat = json_decode($resp['content'], true);
        return coll_neaten($dat['data'], 'shortUrl');
    }
}

class Verify {
    public static function check($host) {
        $key = '3e3bb68ab0b986c836d53f0e5b52326d';
        $url = "http://wx.api-export.com/api/checkdomain?key={$key}&url=http%3a%2f%2f{$host}";
        $resp = Net::httpPost($url, '', '', 10);
        if(is_error($resp)) {
            return 'error';
        }
        $ret = @json_decode($resp, true);
        if(!empty($ret) && isset($ret['code'])) {
            if($ret['code'] == '0') {
                return 'ok';
            }
            if($ret['code'] == '2') {
                return 'bad';
            }
            echo "\n{$resp}\n";
        }
        return 'error';
    }

    public static function check139($host) {
        global $config;
        $host = idn_to_ascii($host);
        //$user = 'll0358';
        //$key = 'f447e803c2f167464e5cef4f80d7b03f';
        //$url = "http://vip.weixin139.com/weixin/345435142.php?domain={$host}";
        $url = str_replace('{domain}', $host, $config['check-api']);
        $resp = Net::httpGet($url, "", 10);
        if(is_error($resp)) {
            return 'error';
        }
        $ret = @json_decode($resp, true);
        if(!empty($ret)) {
            if($ret['status'] == '0') {
                return 'ok';
            }
            if($ret['status'] == '2') {
                return 'bad';
            }
            echo "\n{$resp}\n";
        }
        return 'error';
    }
}

class Net {
    /**
     * @param string $url     URL
     * @param string $post    提交POST的数据
     * @param array $headers  附加的请求头
     * @param string $forceIp 强制使用特定IP
     * @param int $timeout    访问超时
     * @param array $options  其他选项
     * @return array|error
     */
    public static function httpRequest($url, $post = '', $headers = array(), $forceIp = '', $timeout = 60, $options = array()) {
        $urls = parse_url($url);
        if(empty($urls['path'])) {
            $urls['path'] = '/';
        }
        if(!empty($urls['query'])) {
            $urls['query'] = "?{$urls['query']}";
        }
        if(empty($urls['port'])) {
            $urls['port'] = $urls['scheme'] == 'https' ? '443' : '80';
        }
        if(!empty($forceIp)) {
            $headers['Host'] = $urls['host'];
            $headers['Expect'] = '';
            $urls['host'] = $forceIp;
        }

        $url = "{$urls['scheme']}://{$urls['host']}:{$urls['port']}{$urls['path']}{$urls['query']}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            if(is_array($post)) {
                $filepost = false;
                foreach($post as $name => $value) {
                    if(substr($value, 0, 1) == '@' || (class_exists('\CURLFile') && $value instanceof \CURLFile)) {
                        $filepost = true;
                        break;
                    }
                }
                if(!$filepost) {
                    $post = http_build_query($post);
                }
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        if (!empty($options) && is_array($options)) {
            foreach($options as $key => $val) {
                if(is_int($key)) {
                    curl_setopt($ch, $key, $val);
                } else {
                    curl_setopt($ch, constant($key), $val);
                }
            }
        }

        $ret = array();
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($ch, $header) use(&$ret) {
            if(!empty($header)) {
                $pieces = explode(':', $header, 2);
                if(count($pieces) == 2) {
                    $key = strtolower($pieces[0]);
                    $var = trim($pieces[1]);
                    $ret['headers'][$key] = $var;
                }
            }
            return strlen($header);
        });
        $ret['content'] = curl_exec($ch);
        $ret['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if(!empty($errno)) {
            return error(1, $error);
        } else {
            return $ret;
        }
    }

    public static function httpGet($url, $forceIp = '', $timeout = 60, $mobile = false) {
        $array = array();
        if($mobile) {
            $array['mobile'] = true;
        }
        $resp = self::httpRequest($url, '', $array, $forceIp, $timeout);
        if(!is_error($resp)) {
            return $resp['content'];
        }
        return $resp;
    }

    public static function httpPost($url, $data, $forceIp = '', $timeout = 60) {
        $headers = array('Content-Type: application/x-www-form-urlencoded');
        $resp = self::httpRequest($url, $data, $headers, $forceIp, $timeout);
        if(!is_error($resp)) {
            return $resp['content'];
        }
        return $resp;
    }
}

class Spider {

    private $cookieFile = '';
    private $siteId = '';

    public function __construct($sideId) {
        $this->cookieFile = dirname(dirname(__FILE__)) . "/data/{$sideId}.cookie.jar";
        $this->siteId = $sideId;
    }

    public function fetchData() {
        $ret = array();
        $url = "https://web.umeng.com/main.php?siteid={$this->siteId}&c=flow&a=realtime&ajax=module=flash&type=Pie";
        $content = $this->get($url);
        if(is_error($content)) {
            return $content;
        }
        $obj = json_decode($content, true);
        if(empty($obj['data']['flash']) || empty($obj['data']['time'])) {
            //未登录
            if($this->login()) {
                $content = $this->get($url);
                $obj = json_decode($content, true);
            }
        }
        if(!empty($obj['data']['flash']) && !empty($obj['data']['time'])) {
            $ret['online'] = intval($obj['data']['flash']['data']['numEnd']);
        }

        $url = "https://web.umeng.com/main.php?c=site&a=overview&ajax=module%3Dsummary&siteid={$this->siteId}&_=" . time() . '562';
        $content = $this->get($url);
        if(is_error($content)) {
            return $content;
        }
        $obj = json_decode($content, true);
        if(!empty($obj['data']['summary'])) {
            $ret['ip'] = intval($obj['data']['summary']['items'][0]['ip']);
        }
        return $ret;
    }

    private function login() {
        $url = "http://new.cnzz.com/v1/login.php?siteid={$this->siteId}";
        $ret = $this->get($url);
        if(!is_error($ret)) {
            $url = "http://new.cnzz.com/v1/login.php?t=login&siteid={$this->siteId}";
            $pars = array();
            $pars['password'] = 'Aa159357';

            $resp = $this->post($url, $pars);
            if(!is_error($resp)) {
                $redirect = $resp['headers']['location'];
                if(!empty($redirect)) {
                    $content = $this->get($redirect);
                    if(!is_error($content))  {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function get($url) {
        $options = array();
        $options[CURLOPT_COOKIEFILE] = $this->cookieFile;;
        $options[CURLOPT_COOKIEJAR] = $this->cookieFile;

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

        $headers = array('Content-Type: application/x-www-form-urlencoded');
        $resp = Net::httpRequest($url, $data, $headers, '', 5, $options);
        return $resp;
    }
}


class Cache {
    private static function filePath() {
        $path = dirname(dirname(__FILE__)) . '/data/';
        if(!is_dir($path)) {
            mkdir($path);
        }
        return $path;
    }
    
    public static function get($key) {
        $filename = self::filePath() . $key;
        if(is_file($filename)) {
            return @unserialize(file_get_contents($filename));
        }
        return null;
    }
    
    public static function set($key, $value) {
        $filename = self::filePath() . $key;
        if(isset($value)) {
            file_put_contents($filename, serialize($value));
        } else {
            @unlink($filename);
        }
    }
}

class Counter {
    public static function increase($key, $type = 'views') {
        $path = dirname(dirname(__FILE__)) . '/count/';
        if(!is_dir($path)) {
            mkdir($path);
        }
        $path .= $key;
        if(!is_dir($path)) {
            mkdir($path);
        }
        $filename = $path . '/' . md5(uniqid()) . ".{$type}";
        touch($filename);
    }

    public static function sum() {
        $count = Cache::get('count');
        if(empty($count)) {
            $count = array();
        }
        $path = dirname(dirname(__FILE__)) . "/count/";
        $dirs = glob($path . '*');
        foreach($dirs as $dir) {
            if(is_dir($dir)) {
                $keyName = pathinfo($dir, PATHINFO_BASENAME);
                $files = glob($dir . "/*.*");
                foreach ($files as $file) {
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $count[$keyName][$ext]++;
                    @unlink($file);
                }
            }
        }
        Cache::set('count', $count);
        return $count;
    }
}

class WeiXin {
    
    private function getAccessToken($appid, $secret) {
        if($this->isAgent) {
            $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$appid}&corpsecret={$secret}";
        } else {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
        }
        $content = Net::httpGet($url);
        if(is_error($content)) {
            return error(-1, '获取微信公众号授权失败, 请稍后重试！错误详情: ' . $content['message']);
        }
        $token = @json_decode($content, true);
        if(empty($token) || !is_array($token) || empty($token['access_token']) || empty($token['expires_in'])) {
            return error($token['errcode'], $token['errmsg']);
        }
        $record = array();
        $record['token'] = $token['access_token'];
        $record['expire'] = time() + $token['expires_in'];

        return $record;
    }
    
    private $isAgent = false;

    /**
     * 特定公众号平台的操作对象构造方法
     *
     * @param array $account 公号平台基础对象
     * @param null $saver
     */
    public function __construct($account, $saver = null) {
        $this->account = $account;
        if(empty($saver) || is_callable($saver)) {
            $saver = 'App::accountSaver';
        }
        $this->saver = $saver;
        $this->isAgent = !empty($account['agent']);
    }
    
    public function jsDataCreate($forceUrl = '') {
        $ticket = @unserialize($this->account['jsticket']);
        if(is_array($ticket) && !empty($ticket['ticket']) && !empty($ticket['expire']) && $ticket['expire'] > time()) {
            $t = $ticket['ticket'];
        } else {
            $token = $this->fetchToken();
            if(is_error($token)) {
                return $token;
            }
            if($this->isAgent) {
                $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token={$token}";
            } else {
                $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$token}&type=jsapi";
            }
            $resp = Net::httpGet($url);
            if(is_error($resp)) {
                return error(-1, "访问公众平台接口失败, 错误: {$resp['message']}");
            }
            $result = @json_decode($resp, true);
            if(empty($result)) {
                return error(-2, "接口调用失败, 错误信息: {$resp}");
            } elseif (!empty($result['errcode'])) {
                return error($result['errcode'], "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']}");
            }

            $rec = array();
            $rec['ticket'] = $result['ticket'];
            $rec['expire'] = time() + $result['expires_in'];
            $this->account['jsticket'] = serialize($rec);
            call_user_func($this->saver, $this->account);
            $t = $rec['ticket'];
        }

        $share = array();
        $share['appid'] = $this->account['appid'];
        $share['timestamp'] = time();
        $share['nonce'] = md5(uniqid());
        if(empty($forceUrl)) {
            $forceUrl = $_SERVER['REQUEST_URI'];
        }

        $string1 = "jsapi_ticket={$t}&noncestr={$share['nonce']}&timestamp={$share['timestamp']}&url={$forceUrl}";
        $share['signature'] = sha1($string1);
        return $share;
    }

    protected function fetchToken($force = false) {
        $access = unserialize($this->account['access']);
        if(!$force && !empty($access) && !empty($access['token']) && $access['expire'] > time()) {
            return $access['token'];
        } else {
            $ret = self::getAccessToken($this->account['appid'], $this->account['secret']);
            if(is_error($ret)) {
                return $ret;
            } else {
                $this->account['access'] = serialize($ret);
                call_user_func($this->saver, $this->account);

                return $ret['token'];
            }
        }
    }
}

class Cross {
    private $config = array();
    private $authorizer = array();
    private $inputRaw = null;

    function __construct($cfg = null) {
        global $config;
        if(empty($cfg)) {
            $cfg = $config['platform'];
        }
        $this->config = $cfg;
        $page = Cache::get('page_global');
        $this->config['APPID']  = $page['platform_appid'];
        $this->config['SECRET'] = $page['platform_secret'];
        
        $this->config['TICKET'] = Cache::get('platform_open_ticket');
        $this->config['ACCESS'] = Cache::get('platform_open_access');
        
        $this->authorizer = Cache::get('platform_open_authorizer');
    }

    public function decode($input) {
        $key = base64_decode($this->config['AESKEY'] . '=');
        $ciphertext = base64_decode($input);
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        $iv = substr($key, 0, 16);
        mcrypt_generic_init($module, $key, $iv);
        $decrypted = mdecrypt_generic($module, $ciphertext);
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);
        $pad = ord(substr($decrypted, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        $result = substr($decrypted, 0, (strlen($decrypted) - $pad));
        if (strlen($result) < 16) {
            return '';
        }
        $content = substr($result, 16, strlen($result));
        $len_list = unpack("N", substr($content, 0, 4));
        $useful_len = $len_list[1];
        $useful_content = substr($content, 4, $useful_len);
        return $useful_content;
    }

    public function encode($raw) {
        $key = base64_decode($this->config['AESKEY'] . '=');
        $text = util_random(16) . pack("N", strlen($raw)) . $raw . $this->config['APPID'];
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        $iv = substr($key, 0, 16);
        $block_size = 32;
        $text_length = strlen($text);
        $amount_to_pad = $block_size - ($text_length % $block_size);
        if ($amount_to_pad == 0) {
            $amount_to_pad = $block_size;
        }
        $pad_chr = chr($amount_to_pad);
        $tmp = '';
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp .= $pad_chr;
        }
        $text = $text . $tmp;
        mcrypt_generic_init($module, $key, $iv);
        $encrypted = mcrypt_generic($module, $text);
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);
        $encrypt_content = base64_encode($encrypted);
        return $encrypt_content;
    }

    public function response($input) {
        $pars = array();
        $pars['encrypt'] = $this->encode($input);
        $pars['stamp'] = time();
        $pars['nonce'] = util_random(10, true);

        $params = array_values($pars);
        $params[] = $this->config['TOKEN'];
        sort($params, SORT_STRING);
        $sign = sha1(implode($params));
        $xml = <<<DOC
<xml>
	<Encrypt><![CDATA[{$pars['encrypt']}]]></Encrypt>
	<MsgSignature><![CDATA[{$sign}]]></MsgSignature>
	<TimeStamp>{$pars['stamp']}</TimeStamp>
	<Nonce><![CDATA[{$pars['nonce']}]]></Nonce>
</xml> 
DOC;
        $xml = trim($xml);
        return $xml;
    }

    public function checkSign() {
        $params = array();
        $params[] = $this->config['TOKEN'];
        $params[] = $_GET['timestamp'];
        $params[] = $_GET['nonce'];
        sort($params, SORT_STRING);
        $string1 = implode($params);
        $sign1 = sha1($string1);
        if($_GET['encrypt_type'] != 'aes') {
            if($sign1 == $_GET['signature']) {
                $this->inputRaw = inputRaw(false);
                return true;
            }
            return false;
        }

        $input = inputRaw(false);
        
        $dom = new \DOMDocument();
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $input;
        if(!$dom->loadXML($xml, LIBXML_DTDLOAD | LIBXML_DTDATTR)) {
            return false;
        }
        $xpath = new \DOMXPath($dom);
        $encrypt = $xpath->evaluate('string(//xml/Encrypt)');
        $params[] = $encrypt;
        sort($params, SORT_STRING);
        $string2 = implode($params);
        $sign2 = sha1($string2);
        if($sign1 == $_GET['signature'] && $sign2 == $_GET['msg_signature']) {
            $this->inputRaw = $this->decode($encrypt);
            return true;
        }
        return false;
    }

    public function getInputRaw() {
        return $this->inputRaw;
    }

    public function createAuthUrl($callback) {
        $access = $this->getAccessToken();
        if(is_error($access)) {
            return $access;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$access}";
        $params = array();
        $params['component_appid'] = $this->config['APPID'];
        $content = Net::httpPost($url, json_encode($params));
        if(is_error($content)) {
            return error(-1, '微信通信失败(PreAuthCode), 请稍后重试！错误详情: ' . $content['message']);
        }
        $token = @json_decode($content, true);
        if(empty($token) || !is_array($token) || empty($token['pre_auth_code']) || empty($token['expires_in'])) {
            return error(-2, '微信通信失败(PreAuthCode), 请稍后重试！错误详情: ' . $content);
        }
        $code = $token['pre_auth_code'];
        $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$this->config['APPID']}&pre_auth_code={$code}&redirect_uri={$callback}";
        return $url;
    }

    public function getAuthorizer($authCode) {
        $access = $this->getAccessToken();
        if(is_error($access)) {
            return $access;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token={$access}";
        $params = array();
        $params['component_appid'] = $this->config['APPID'];
        $params['authorization_code'] = $authCode;
        $content = Net::httpPost($url, json_encode($params));
        if(is_error($content)) {
            return error(-1, '微信通信失败(QueryAuth), 请稍后重试！错误详情: ' . $content['message']);
        }
        $auth = @json_decode($content, true);
        if(empty($auth) || !is_array($auth) || empty($auth['authorization_info'])) {
            return error(-2, '微信通信失败(QueryAuth), 请稍后重试！错误详情: ' . $content);
        }
        $rec = array();
        $rec['appid'] = $auth['authorization_info']['authorizer_appid'];
        if(!empty($auth['authorization_info']['authorizer_access_token'])) {
            $rec['access']['token'] = $auth['authorization_info']['authorizer_access_token'];
            $rec['access']['expire'] = time() + intval($auth['authorization_info']['expires_in']);
            $rec['refresh'] = $auth['authorization_info']['authorizer_refresh_token'];
        }

        $url = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token={$access}";
        $params = array();
        $params['component_appid'] = $this->config['APPID'];
        $params['authorizer_appid'] = $rec['appid'];
        $content = Net::httpPost($url, json_encode($params));
        if(is_error($content)) {
            return error(-1, '微信通信失败(GetAuth), 请稍后重试！错误详情: ' . $content['message']);
        }
        $info = @json_decode($content, true);
        if(empty($info) || !is_array($info) || empty($info['authorizer_info'])) {
            return error(-2, '微信通信失败(GetAuth), 请稍后重试！错误详情: ' . $content);
        }
        $rec['title'] = $info['authorizer_info']['nick_name'];
        if(in_array($info['authorizer_info']['service_type_info']['id'], array('0', '1'))) {
            if(in_array($info['authorizer_info']['verify_type_info']['id'], array('0', '3', '4', '5'))) {
                $rec['level'] = '1';
            } else {
                $rec['level'] = '0';
            }
        } else {
            if(in_array($info['authorizer_info']['verify_type_info']['id'], array('0', '3', '4', '5'))) {
                $rec['level'] = '11';
            } else {
                $rec['level'] = '10';
            }
        }
        $rec['avatar'] = $info['authorizer_info']['head_img'];
        $rec['original'] = $info['authorizer_info']['user_name'];
        $rec['username'] = $info['authorizer_info']['alias'];
        $rec['functions'] = array();
        if(is_array($info['authorization_info']['func_info'])) {
            foreach($info['authorization_info']['func_info'] as $func) {
                $rec['functions'][] = $func['funcscope_category']['id'];
            }
        }
        
        Cache::set('platform_open_authorizer', $rec);
        return $rec;
    }

    public function getAuthorizerAccessToken($authorizer, $refresh) {
        $access = $this->getAccessToken();
        if(is_error($access)) {
            return $access;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token={$access}";
        $pars = array();
        $pars['component_appid'] = $this->config['APPID'];
        $pars['authorizer_appid'] = $authorizer;
        $pars['authorizer_refresh_token'] = $refresh;
        $content = Net::httpPost($url, json_encode($pars));
        if(is_error($content)) {
            return error(-1, '微信通信失败(AuthorizerAccessToken), 请稍后重试！错误详情: ' . $content['message']);
        }
        $token = @json_decode($content, true);
        if(empty($token) || !is_array($token) || empty($token['authorizer_access_token'])) {
            return error(-2, '微信通信失败(AuthorizerAccessToken), 请稍后重试！错误详情: ' . $content);
        }
        $rec = array();
        $rec['access']['token'] = $token['authorizer_access_token'];
        $rec['access']['expire'] = time() + intval($token['expires_in']);
        $rec['refresh'] = $token['authorizer_refresh_token'];
        return $rec;
    }

    public function jsDataCreate($forceUrl = '') {
        $authorizer = Cache::get('platform_open_authorizer');
        $ticket = $authorizer['jsticket'];
        if(is_array($ticket) && !empty($ticket['ticket']) && !empty($ticket['expire']) && $ticket['expire'] > time()) {
            $t = $ticket['ticket'];
        } else {
            $token = $this->fetchToken();
            if(is_error($token)) {
                return $token;
            }
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$token}&type=jsapi";
            $resp = Net::httpGet($url);
            if(is_error($resp)) {
                return error(-1, "访问公众平台接口失败, 错误: {$resp['message']}");
            }
            $result = @json_decode($resp, true);
            if(empty($result)) {
                return error(-2, "接口调用失败, 错误信息: {$resp}");
            } elseif (!empty($result['errcode'])) {
                return error($result['errcode'], "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']}");
            }

            $rec = array();
            $rec['ticket'] = $result['ticket'];
            $rec['expire'] = time() + $result['expires_in'];
            
            $authorizer['jsticket'] = $rec;
            Cache::set('platform_open_authorizer', $authorizer);
            
            $t = $rec['ticket'];
        }

        $share = array();
        $share['appid'] = $authorizer['appid'];
        $share['timestamp'] = time();
        $share['nonce'] = md5(uniqid());
        if(empty($forceUrl)) {
            $forceUrl = $_SERVER['REQUEST_URI'];
        }

        $string1 = "jsapi_ticket={$t}&noncestr={$share['nonce']}&timestamp={$share['timestamp']}&url={$forceUrl}";
        $share['signature'] = sha1($string1);
        return $share;
    }
    
    private function fetchToken() {
        $authorizer = Cache::get('platform_open_authorizer');
        $access = $authorizer['access'];
        if(!empty($access) && !empty($access['token']) && $access['expire'] > time()) {
            return $access['token'];
        } else {
            $ret = $this->getAuthorizerAccessToken($this->authorizer['appid'], $this->authorizer['refresh']);
           var_dump($ret);
            if(is_error($ret)) {
                return $ret;
            } else {
                $authorizer['refresh'] = $ret['refresh'];
                $authorizer['access'] = $ret['access'];
                Cache::set('platform_open_authorizer', $authorizer);
                
                return $ret['access']['token'];
            }
        }
    }
    
    /*
    public function createAuthorizerAuthUrl($authorizer, $type = 'snsapi_userinfo', $state = '', $callback = '') {
        if(empty($callback)) {
            $callback = __HOST__ . MAU('auth/auth');
        }
        $forward = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$authorizer}&redirect_uri={$callback}&response_type=code&scope={$type}&state={$state}&component_appid={$this->config['APPID']}#wechat_redirect";
        return $forward;
    }

    public function getAuthorizerUserInfo($authorizer, $code) {
        $access = $this->getAccessToken();
        if(is_error($access)) {
            return $access;
        }
        $url = "https://api.weixin.qq.com/sns/oauth2/component/access_token?appid={$authorizer}&code={$code}&grant_type=authorization_code&component_appid={$this->config['APPID']}&component_access_token={$access}";
        $content = Net::httpGet($url);
        if(is_error($content)) {
            return error(-1, '微信通信失败(GetUserInfo), 请稍后重试！错误详情: ' . $content['message']);
        }
        $token = @json_decode($content, true);
        if(empty($token) || !is_array($token) || empty($token['openid'])) {
            return error(-2, '微信通信失败(GetUserInfo), 请稍后重试！错误详情: ' . $content);
        }
        $user = array();
        $user['openid'] = $token['openid'];
        if($token['scope'] == 'snsapi_userinfo') {
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$token['access_token']}&openid={$user['openid']}&lang=zh_CN";
            $content = Net::httpGet($url);
            $info = @json_decode($content, true);
            if(!empty($info) && is_array($info) && !empty($info['openid'])) {
                $user['openid']          = $info['openid'];
                $user['unionid']         = $info['unionid'];
                $user['nickname']        = $info['nickname'];
                $user['gender']          = '保密';
                if($info['sex'] == '1') {
                    $user['gender'] = '男';
                }
                if($info['sex'] == '2') {
                    $user['gender'] = '女';
                }
                $user['city']            = $info['city'];
                $user['state']           = $info['province'];
                $user['avatar']          = $info['headimgurl'];
                $user['country']         = $info['country'];
                if(!empty($user['avatar'])) {
                    $user['avatar'] = rtrim($user['avatar'], '0');
                    $user['avatar'] .= '132';
                }
                $user['original'] = $info;
            }
        }
        return $user;
    }
    */

    private function getAccessToken() {
        $access = $this->config['ACCESS'];
        if(empty($access) || empty($access['token']) || $access['expire'] < time()) {
            if(empty($this->config['TICKET'])) {
                return error(-1, '未接收到Ticket!');
            }
            $url = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";
            $params = array();
            $params['component_appid'] = $this->config['APPID'];
            $params['component_appsecret'] = $this->config['SECRET'];
            $params['component_verify_ticket'] = $this->config['TICKET'];
            $content = Net::httpPost($url, json_encode($params));
            if(is_error($content)) {
                return error(-1, '微信通信失败(AccessToken), 请稍后重试！错误详情: ' . $content['message']);
            }
            $token = @json_decode($content, true);
            if(empty($token) || !is_array($token) || empty($token['component_access_token']) || empty($token['expires_in'])) {
                return error(-2, '微信通信失败(AccessToken), 请稍后重试！错误详情: ' . $content);
            }
            $record = array();
            $record['token'] = $token['component_access_token'];
            $record['expire'] = time() + $token['expires_in'];
            Cache::set('platform_open_access', $record);
            return $record['token'];
        }
        return $access['token'];
    }
}
