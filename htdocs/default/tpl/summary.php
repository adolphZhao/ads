<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>活动列表</title>
    <link rel="stylesheet" href="//g.alicdn.com/sui/sui3/0.0.18/css/sui.min.css">
    <link href="https://cdn.bootcss.com/animate.css/3.5.2/animate.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/vue/2.4.2/vue.min.js"></script>
    <style>
        .modal-dialog.modal-sm{width:500px;}
        .pointer{cursor:pointer;}
        .s-show{text-decoration:underline;}
        .qr{width:200px;height:200px;padding:10px;border: 1px solid #ccc;background-color:#fff;position:absolute;right:190px;}
        *[v-cloak]{display:none;}
    </style>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="?act=summary">概览</a></li>
                <li><a href="?act=global">全局参数</a></li>
                <li><a href="?act=interface">公众号配置</a></li>
                <li><a href="?act=check">检查域名</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid" id="app" v-cloak>
    <div style="margin:-10px auto 5px auto;">
        <a href="javascript:;" class="btn btn-default" @click="releaseSlb()">统计可用IP</a>
        <a href="javascript:;" class="btn btn-default" @click="clean()">清空统计</a>
        <?php if($config['tj']){?>
        <span class="label label-default">在线: {{global.online}} 本日IP: {{global.ip}}</span>
        <?php }?>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <table class="table table-hover" style="width:100%;">
                <tr>
                    <th>入口域名(IP)</th>
                    <th style="width:140px;">命中次数</th>
                    <th style="width:50px;">访问</th>
                    <th style="width:120px;">配置</th>
                </tr>
                <tr v-for="(item, index) in dataSet.entries">
                    <td>
                        {{item.domain}} ({{item.ip}})
                        <template v-if="item.domain != item.domain_e"><br>{{item.domain_e}}</template>
                    </td>
                    <td>
                        <span class="label label-default">{{item.hits}}</span>
                    </td>
                    <td>
                        <img :src="'?act=qr&url=' + item.url" alt="" class="img-rounded qr hide">
                        <a class="link-view" :href="item.url" target="_blank" @mouseover="setQr" @mouseout="setQr">查看</a>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="javascript:;" class="btn btn-default btn-sm" @click="setOption(item);">删除域名</a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-sm-6">
            <table class="table table-hover" style="width:100%;">
                <tr>
                    <th>落地域名(IP)</th>
                    <th style="width:120px;">访问次数</th>
                    <th style="width:180px;">状态</th>
                    <th style="width:50px;">访问</th>
                    <th style="width:120px;">配置</th>
                </tr>
                <tr v-for="(item, index) in dataSet.docks">
                    <td>
                        {{item.domain}} ({{item.ip}})
                        <template v-if="item.domain != item.domain_e"><br>{{item.domain_e}}</template>
                    </td>
                    <td>
                        <span class="label label-default">{{item.views}}</span>
                    </td>
                    <td>
                        <template v-if="item.status && item.last != '01.01 08:00:00'">
                            <span class="label label-danger" v-if="item.status == 'bad'">被封</span>
                            <span class="label label-success" v-if="item.status == 'ok'">正常</span>
                            <span class="label label-default" v-if="item.status == 'error'">错误</span>
                            <span class="label label-default">{{item.last}}</span>
                        </template>
                    </td>
                    <td>
                        <img :src="'?act=qr&url=' + item.url" alt="" class="img-rounded qr hide">
                        <a class="link-view" :href="item.url" target="_blank" @mouseover="setQr" @mouseout="setQr">查看</a>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="javascript:;" class="btn btn-default btn-sm" @click="setExport(item);">导流</a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/lodash.js/4.17.4/lodash.min.js"></script>
<script src="//g.alicdn.com/sj/lib/jquery/dist/jquery.min.js"></script>
<script src="//g.alicdn.com/sui/sui3/0.0.18/js/sui.min.js"></script>
<script>
    var refreshId;
    new Vue({
        el: '#app',
        data: {
            dataSet: {
                entries: [],
                docks: []
            },
            global: {}
        },
        mounted() {
            this.refresh();
        },
        methods: {
            refresh() {
                var $this = this;
                $.post('?act=refresh', 'json').then(function(dat){
                    $this.dataSet.entries = dat.entries;
                    $this.dataSet.docks = dat.docks;
                    $this.global = dat.global;
                    refreshId = setTimeout(function(){
                        $this.refresh();
                    }, 3000);
                });
            },
            clean() {
                var $this = this;
                var pars = {};
                pars.method = 'clean_count';
                $.post('?act=config', pars).success(function(){
                    clearTimeout(refreshId);
                    $this.refresh();
                    $.toast('成功清空', 'success', 'top center');
                });
            },
            setOption(entry) {
                $this = this;
                if(!entry.option) {
                    entry.option = {};
                }
                $._modal({
                    title: '确认导流目的',
                    okbtn: '确认',
                    cancelbtn: '取消',
                    width: '80%',
                    body: _.template($('#dialog').html())(entry.option),
                    okHide: function(){
                        var pars = {};
                        pars.key = entry.key;
                        pars.method = 'export';
                        pars.export = $('.export-url').val();
                        $.post("?act=config", pars, 'json').success(function(resp){
                            clearTimeout(refreshId);
                            $this.refresh();
                        });
                    }
                });
            },
            setExport(entry) {
                $.toast('暂不支持');
            },
            setQr(event) {
                if(event.type == 'mouseover') {
                    $(event.srcElement).prev().removeClass('hide');
                }
                if(event.type == 'mouseout') {
                    $(event.srcElement).prev().addClass('hide');
                }
            },
            releaseSlb() {
                var output = [];
                for(var entry of this.dataSet.entries) {
                    output.push(entry.ip);
                }
                for(var entry of this.dataSet.docks) {
                    output.push(entry.ip);
                }
                output = _.uniq(output);
                var text = "['" + output.join("','") + "']";

                $.alert('批量删除负载代码', "<p style='word-break:break-all'>angular.forEach(angular.element('.table-hover').scope().store, function(row){row.selected = " + text + ".indexOf(row.Address) == -1;})</p>");
            },
        }
    });
</script>
</body>
</html>