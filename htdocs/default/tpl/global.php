<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>新增/编辑活动</title>
    <link rel="stylesheet" href="//g.alicdn.com/sui/sui3/0.0.18/css/sui.min.css">
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <style>
        textarea.form-control{word-wrap:normal;overflow:auto;white-space:nowrap;}
    </style>
	<script>
        var textIndex = 0;
		function add_ads(){
			var c = document.getElementById('container');
			var cc = c.cloneNode(true);
            $(cc).attr('id',$(c).attr('id')+textIndex);

			var cinpitems = cc.getElementsByTagName('input');
			for(var n=0;n<cinpitems.length;n++ ){
				$(cinpitems.item(n)).val('');
                $(cinpitems.item(n)).attr('name', $(cinpitems.item(n)).attr('name')+textIndex);
			}
				
			var ctextitems = cc.getElementsByTagName('textarea');
			for(var n=0;n<ctextitems.length;n++ ){
                $(ctextitems.item(n)).val('');
                $(ctextitems.item(n)).attr('name', $(ctextitems.item(n)).attr('name')+textIndex);
            }

			document.getElementById('postForm').insertBefore(cc,document.getElementById('postForm').childNodes[2]);
			textIndex++;
		}
		
		function load(){
			<?php 
				$arr=[];
				for($i=0;$i<100;$i++){
					if(isset( $row['video'.$i] )){
						$arr[$i]=$i;
					}
					else{
						break;
					}
				}
				echo sprintf('%s','var total='.count($arr).';');
		
			?>
			for(i=0;i<total;i++){
					add_ads();
			}
			var json = <?php echo json_encode($row);?>;
			
			for(jn in json){
				$("[name="+jn+"]").val(json[jn]);
			}
		}
		$(function(){
			load();
		});
	</script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="?act=summary">概览</a></li>
                <li class="active"><a href="?act=global">全局参数</a></li>
                <li><a href="?act=check">检查域名</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <form action="" method="post" id="postForm">
		<div class="form-group">
			<input type="button"  class="btn btn-default" value="增加文章" onclick="add_ads()" />
			 <button type="submit" class="btn btn-default">提交保存</button>
		</div>
        <div class="form-group" id="container">
            <label>文章信息</label>
            <div class="row">
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">视频编号</span>
                        <input name="video" type="text" class="form-control" value="<?php echo $row['video']?>">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">延迟分享时间</span>
                        <input name="delay_time" type="text" class="form-control" value="<?php echo $row['delay_time']?>">
                    </div>
                </div>
                  <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">视频ID</span>
                        <input name="video_num" type="text" class="form-control" value="<?php echo $row['video_num']?>">
                    </div>
                </div>
            </div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>文章标题</label>
						<textarea name="titles" rows="6" class="form-control"><?php echo $row['titles']?></textarea>
						<span class="help-block">文章标题, 随机使用其中一个</span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>作者链接</label>
						<textarea name="ad_authors" rows="3" class="form-control"><?php echo $row['ad_authors']?></textarea>
						<div class="help-block">
							格式如下, 随机取出其中一条:
							<blockquote>
								author,url<br>
								author,url<br>
							</blockquote>
						</div>
					</div>
				</div>
			</div>
			
        </div>
       <hr>
       <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>视频顶部图片广告</label>
                        <textarea name="ad_tops" rows="3" class="form-control"><?php echo $row['ad_tops']?></textarea>
                        <div class="help-block">
                            格式如下, 随机取出其中一条(可以指定头部广告位置, 默认是第一个广告位):
                            <blockquote>
                                image,url<br>
                                image,url,2<br>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>视频底部轮播广告</label>
                        <textarea name="ad_bottoms" rows="3" class="form-control"><?php echo $row['ad_bottoms']?></textarea>
                        <div class="help-block">
                            格式如下, 所有图片轮播:
                            <blockquote>
                                image,url<br>
                                image,url<br>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>原文阅读链接</label>
                        <textarea name="ad_originals" rows="3" class="form-control"><?php echo $row['ad_originals']?></textarea>
                        <div class="help-block">
                            每行一个链接, 随机取出一条链接
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>返回时跳转链接</label>
                        <textarea name="ad_backs" rows="3" class="form-control"><?php echo $row['ad_backs']?></textarea>
                        <div class="help-block">
                            每行一个链接, 随机取出一条链接
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>统计代码</label>
                        <textarea name="statistics" rows="3" class="form-control"><?php echo $row['statistics']?></textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>分享图片</label>
                        <textarea name="images" rows="3" class="form-control"><?php echo $row['images']?></textarea>
                    </div>
                </div>
            </div>
             <hr>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>入口域名</label>
                    <textarea name="entries" rows="3" class="form-control"><?php echo $row['entries']?></textarea>
                    <div class="help-block">跳转域名</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>落地域名</label>
                    <textarea name="docks" rows="3" class="form-control"><?php echo $row['docks']?></textarea>
                    <div class="help-block">需要绑定开放平台域名</div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>入口大站连接跳转</label>
                    <textarea name="wrappers" rows="6" class="form-control"><?php echo $row['wrappers']?></textarea>
                    <div class="help-block">格式(使用{link}替换): http://wapwbclick.mobile.sina.cn/pclogin/pclclick.lua?adurl={link}</div>
                </div>
            </div>
            <div class="col-sm-6">
                <label>开放平台参数</label>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">APPID</span>
                                <input name="platform_appid" type="text" class="form-control" value="<?php echo $row['platform_appid']?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">SECRET</span>
                                <input name="platform_secret" type="text" class="form-control" value="<?php echo $row['platform_secret']?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">AESKEY</span>
                                <input readonly type="text" class="form-control" value="<?php echo $config['platform']['AESKEY']?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">TOKEN</span>
                                <input readonly type="text" class="form-control" value="<?php echo $config['platform']['TOKEN']?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">入口路径</span>
                                <input name="path_entry" type="text" class="form-control" value="<?php echo $row['path_entry']?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">落地路径</span>
                                <input name="path_dock" type="text" class="form-control" value="<?php echo $row['path_dock']?>">
                            </div>
                        </div>
                    </div>
                    <span class="help-block">更改路径后, 还需要配合服务器重写路径</span>
                </div>
            </div>
        </div>
       
    </form>
</div>
<div id="share" style="padding:15px;">
    <div style="margin-bottom:10px;">
        <a href="javascript:;" class="btn btn-default" @click="edit(1)">分享次数1</a>
        <a href="javascript:;" class="btn btn-default" @click="edit(2)">分享次数2</a>
        <a href="javascript:;" class="btn btn-default" @click="edit(3)">分享次数3</a>
        <a href="javascript:;" class="btn btn-default" @click="edit(4)">分享次数4</a>
        <a href="javascript:;" class="btn btn-default" @click="edit(5)">分享次数5(圈)</a>
        <a href="javascript:;" class="btn btn-default" @click="edit(6)">分享次数6(圈)</a>
    </div>
    <div class="modal fade" id="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="myModalLabel">设置分享内容</h5>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" v-model="type" value="content"> 裂变内容
                            </label>
                            <label class="radio-inline">
                                <input type="radio" v-model="type" value="jump"> 跳转广告
                            </label>
                            <label class="radio-inline">
                                <input type="radio" v-model="type" value="close"> 关闭
                            </label>
                        </div>
                    </div>
                    <div v-if="type == 'jump'">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">标题</span>
                                <input type="text" class="form-control" v-model="input.title">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">图片</span>
                                <input type="text" class="form-control" v-model="input.image">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">链接</span>
                                <input type="text" class="form-control" v-model="input.link">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">描述</span>
                                <input type="text" class="form-control" v-model="input.desc">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-lg" data-ok="modal" @click="save();">保存</button>
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.bootcss.com/lodash.js/4.17.4/lodash.min.js"></script>
<script src="//g.alicdn.com/sj/lib/jquery/dist/jquery.min.js"></script>
<script src="//g.alicdn.com/sui/sui3/0.0.18/js/sui.min.js"></script>
<script src="https://cdn.bootcss.com/vue/2.5.8/vue.min.js"></script>
<script>
    new Vue({
        el: '#share',
        data: {
            index: 0,
            type: 'content',
            input: {
                title: '',
                image: '',
                link: '',
                desc: ''
            }
        },
        methods: {
            edit: function(index) {
                var $this = this;
                $this.index = index;
                var pars = {};
                pars.index = index;
                $.post('?act=share', pars).success(function(dat) {
                    $this.type = dat.type;
                    $this.input = dat;
                    $('#dialog').modal('show');
                });
            },
            save: function() {
                var $this = this;
                var pars = {};
                pars.index = $this.index;
                pars.type = $this.type;
                pars.title = $this.input.title;
                pars.image = $this.input.image;
                pars.link = $this.input.link;
                pars.desc = $this.input.desc;
                pars.method = 'save';
                $.post('?act=share', pars).success(function () {
                    $('#dialog').modal('close');
                });

            }
        }
    });
</script>
</body>
</html>