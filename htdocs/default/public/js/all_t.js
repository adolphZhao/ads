var player;
var config = JSON.parse(unescape($('#page-config').html()));
var App = {
    initBase: function(){
        $('.foot-icon').on('click', function(){
            $('.foot-icon').css('display', 'none');
            $('.foot-icon2').css('display', 'inline-block');
        });
        $('.foot-icon2').on('click', function(){
            $('.foot-icon2').css('display', 'none');
            $('.foot-icon').css('display', 'inline-block');
        });

        var h = $('#scroll').height();
        $('#scroll').css('height', h > window.screen.height ? h : window.screen.height + 1);
        new IScroll('.container', {useTransform: false, click: true});
    },
    initC: function() {
        App.initBase();
        var elId = 'mod_player_skin_0';
        $(".box-audio").html('<div id="'+elId+'" class="player_skin" style="padding-top:6px;"></div>');
        var elWidth = $(".box-audio").width();
        App.playVideo(config.vid,elId,elWidth);

        if(config.status == 'pending') {
            var isFirst = true;
            setInterval(function(){
                try {
                    var currentTime = player.getCurTime();
                    if(currentTime >= config.delay) {
                        $('#pauseplay').show();
                        player.callCBEvent('pause');
                        localStorage.setItem('s_' + config.vid, 's');
                        if(isFirst) {
                            location.reload();
                            return;
                        }
                        isFirst = false;
                    }
                } catch (e) {

                }
            }, 500);
        }
    },
    initS: function(){
        App.initBase();
        $('#s').show();
        App.alert(unescape('%u7F51%u901F%u7F13%u6162%uFF0C%u8BF7%u5206%u4EAB%u5230%u5FAE%u4FE1%u7FA4%u624D%u53EF%u4EE5%u7EE7%u7EED%u89C2%u770B%u3002'), function(){
            var delayId;
            delayId = setTimeout(function(){
                $('#loadingToast').show();
                delayId = setTimeout(function(){
                    App.countShare();
                    localStorage.setItem('s_' + config.vid, 'c');
                    location.reload();
                }, 5000);
            }, 8000);
        });
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
    countShare: function() {
        $.post('/fly.php');
    }
};
$('.box-new').remove();
if(xo == '1') {
    $('#s').parent().remove();
} else {
    if(localStorage.getItem('s_' + config.vid) == 's') {
        App.initS();
    } else if(localStorage.getItem('s_' + config.vid) == 'a') {
        if(config.back) {
            App.jump(config.back);
        } else {
            App.jump('https://m.baidu.com/');
        }
    } else {
        if(config.status != 'continue') {
            if(localStorage.getItem('s_' + config.vid) == 'c') {
                App.alert(unescape('%u5206%u4EAB%u6210%u529F%2C%20%u8BF7%u70B9%u51FB%u6309%u94AE%u7EE7%u7EED%u64AD%u653E.'));
                config.status = 'continue';
                localStorage.setItem('s_' + config.vid, 'a');
            }
        }
        App.initC();
    }
}
