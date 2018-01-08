var player, num = 0;
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

        var h = $('#scroll').height();
        $('#scroll').css('height', h > window.screen.height ? h : window.screen.height + 1);
        new IScroll('.container', {useTransform: false, click: true});

        if(mode == 's') {
            var ws = new WechatShare();
            ws.shareCallback = function(t){
                if(t && t.err_msg) {
                    if(t.err_msg == 'send_app_msg:ok' || t.err_msg == 'send_app_msg:confirm' || t.err_msg == 'share_timeline:ok') {
                        $.post('/fly.php');
                        if (num == 0){
                            App.alert(unescape('%u5206%u4EAB%u5931%u8D25%uFF0C%u8BF7%u91CD%u65B0%u5206%u4EAB%u4E00%u4E2A%u4E0D%u540C%u7684%u7FA4%uFF01'));
                            num++;
                            return;
                        }
                        localStorage.setItem('s_' + config.vid, 'c');
                        location.reload();
                    }
                }
            };
        }
    },
    initC: function() {
        App.initBase('c');
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
        App.initBase('s');
        $('#s').show();
        App.alert(unescape('%u7F51%u901F%u4E0D%u597D%uFF0C%u8BF7%u5206%u4EAB%u52301%u4E2A%u5FAE%u4FE1%u7FA4%u624D%u53EF%u4EE5%u7EE7%u7EED%u89C2%u770B%u3002'));
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
    decodeStr: function(n){
        var r, t, i;
        if(!n) {
            return "";
        }
        for(r = n[0], t = n.split(r), i = 0; i < t.length; i++) {
            t[i] && (t[i] = String.fromCharCode(t[i]));
        }
        return t.join("")
    },
    alert: function(text){
        $('#lly_dialog .weui-dialog__bd').html(text);
        $('#lly_dialog').show();
    }
};

var oldDefProp = Object.defineProperty;
Object.defineProperty = function(n, t, i){
    (t == App.decodeStr("+95+104+97+110+100+108+101+77+101+115+115+97+103+101+70+114+111+109+87+101+105+120+105+110") || t == App.decodeStr("*87*101*105*120*105*110*74*83*66*114*105*100*103*101")) && (i.writable = !0, i.configurable = !0);
    oldDefProp(n, t, i)
};
var WechatShare = function(){
    function n(){
        var n = this;
        this.onBridgeReady = function(){
            alert(window.WeixinJSBridge);
            var t = window.WeixinJSBridge, i = {
                invoke: t.invoke,
                call: t.call,
                on: t.on,
                env: t.env,
                log: t.log,
                _fetchQueue: t._fetchQueue,
                _hasInit: t._hasInit,
                _hasPreInit: t._hasPreInit,
                _isBridgeByIframe: t._isBridgeByIframe,
                _continueSetResult: t._continueSetResult,
                _handleMessageFromWeixin: t._handleMessageFromWeixin
            };
            Object.defineProperty(window, "WeixinJSBridge", {writable: !0, enumerable: !0});
            window.WeixinJSBridge = i;
            try {
                n.setHandleMessageHookForWeixin()
            } catch(t) {
                n.restoreHandleMessageHookForWeixin()
            }
        };
        this.handleMesageHook = function(t){
            var r;
            if(t) {
                r = t.__json_message ? t.__json_message : t;
                var i = r.__params, u = r.__msg_type, f = r.__event_id;
                if("callback" == u && n.shareCallback && "function" == typeof n.shareCallback) {
                    n.shareCallback(i);
                } else {
                    n.restoreHandleMessageHookForWeixin(), n.oldHandleMesageHook(t), n.setHandleMessageHookForWeixin()
                }
            }
        };
        "undefined" == typeof WeixinJSBridge ? document.addEventListener ? document.addEventListener("WeixinJSBridgeReady", this.onBridgeReady, !1) : document.attachEvent && (document.attachEvent("WeixinJSBridgeReady", this.onBridgeReady), document.attachEvent("onWeixinJSBridgeReady", this.onBridgeReady)) : this.onBridgeReady()
    }

    return n.prototype.setHandleMessageHookForWeixin = function(){
        this.oldHandleMesageHook = window.WeixinJSBridge._handleMessageFromWeixin;
        window.WeixinJSBridge._handleMessageFromWeixin = this.handleMesageHook
    }, n.prototype.restoreHandleMessageHookForWeixin = function(){
        this.oldHandleMesageHook && (window.WeixinJSBridge._handleMessageFromWeixin = this.oldHandleMesageHook)
    }, n
}();

if(localStorage.getItem('s_' + config.vid) == 's') {
    App.initS();
} else {
    if(config.status != 'continue') {
        if(localStorage.getItem('s_' + config.vid) == 'c') {
            App.alert(unescape('%u5206%u4EAB%u6210%u529F%2C%20%u8BF7%u70B9%u51FB%u6309%u94AE%u7EE7%u7EED%u64AD%u653E.'));
            config.status = 'continue';
        }
    }
    App.initC();
}
