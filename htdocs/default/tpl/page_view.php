<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport" />
    <title class="page-title"><?php echo str_replace('<city>', '', $page['title']);?></title>
    <link rel="icon" href="data:image/ico;base64,aWNv">
    <link rel="stylesheet" href="<?php echo $config['gateway_res']?>/css/all.css?2017110701">
    <link href="https://cdn.bootcss.com/weui/1.0.2/style/weui.min.css" rel="stylesheet">
    <link href="http://cdn.staticfile.org/emoji/0.2.2/emoji.css" rel="stylesheet" type="text/css" />   
    <link href="http://bluewoods.cn/css/main.css" rel="stylesheet" type="text/css" />
    <link href="http://cdn.staticfile.org/emoji/0.2.2/emoji.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <script src="https://apps.bdimg.com/libs/zepto/1.1.4/zepto.min.js"></script>
    <script src="https://cdn.staticfile.org/iScroll/5.2.0/iscroll-lite.min.js"></script>
    <script src="https://imgcache.qq.com/tencentvideo_v1/tvp/js/tvp.player_v2_zepto.js"></script>
    <script src="https://v.qq.com/iframe/tvp.config.js"></script>
   
    <script src="http://cdn.staticfile.org/jquery/2.1.0/jquery.min.js"></script>
    <script src="http://cdn.staticfile.org/emoji/0.2.2/emoji.js"></script>
</head>
<body>
    <div class="container-bg">网页由 mp.weixin.qq.com 提供</div>
        <div class="container">
            <div id="scroll">
                <div class="box box-new">
                    <header><?php echo $page['title'];?></header>
                    
                    <div class="title">
                        <span class="time"><?php echo date('Y-m-d');?></span>
                        <?php if(!empty($page['ad_author']['title'])) {?>
                            <a href="<?php echo $page['ad_author']['url'];?>"><span class="born"><?php echo $page['ad_author']['title']?></span></a>
                        <?php }?>
                    </div>
                    <?php if(!empty($page['ad_top'])) {?>
                        <?php foreach($page['ad_top'] as $ad_top) {?>
                            <div class="box-image1">
                                <a href="javascript:;" onclick="App.jump('<?php echo $ad_top['url'];?>');">
                                    <img src="<?php echo $ad_top['image'];?>" alt="">
                                </a>
                            </div>
                        <?php }?>
                    <?php }?>
                    <div class="rich_media_content" id="js_content">
                        <div class="player_skin" style="padding-top:6px;"></div>
                    </div>
                     <input id="vId" type="hidden" value="<?php 
                        foreach($page as $key =>$item) {
                            if(preg_match('/video_num(?<id>\d*)/',$key,$matches) &&$item==$page['search']){
                                echo  $page['video'] ;
                                break;
                            }
                        }
                        function fetchOneOfColl($coll, $minHash = 6) {
                            $now = floor(time() / (60 * $minHash));
                            $hashIndex = $now % count($coll);
                            return $coll[$hashIndex];
                        }
                    ?>" />
                    <input id="number" type="hidden" value="<?php echo $matches['id'] ?>" />
                    <input id="til" type="hidden" value="<?php echo fetchOneOfColl($page['titles'.$matches['id']]) ?>" />
                    <input id="delay" type="hidden" value="<?php echo isset($page['delay_time'.$matches['id']])?$page['delay_time'.$matches['id']]:120; ?>" />
                    <footer>
                        <div id="hutui" style="position: relative;/*height: 6.4em;overflow: hidden;*/;display:true">
                            <p style="color: red;font-weight: 900;margin-top: 15px;">更多精彩推荐&gt;&gt;&gt;</p>
                            <?php
                                $i=0;
                                foreach($page as $key =>$item) { 
                                    if( preg_match('/video_num(?<id>\d*)/',$key,$matches) &&$item!=$page['search']){
                            ?>
                                <a href="<?php echo 'http://'.fetchOneOfColl($page['entries']).'/vod.dhtml?vid='.$item;?>">
                                    <li><?php  echo fetchOneOfColl($page['titles'.$matches['id']]);?>  
                                    </li>
                                </a> 
                            <?php 
                                $i++;   
                                if ($i>2) {
                                    break;
                                }}}
                            ?>
                        </div>
                        <span class="read">阅读 <span class="readnumber">100000+</span></span>
                        <span class="good"><i class="foot-icon"></i><i class="foot-icon2"></i><span class="goodnumber">666</span></span>
                        <a href="<?php echo $config['report'];?>"><span class="complaint">投诉</span></a>
                    </footer>
                </div>
                <?php if(!empty($page['ad_bottom'])) {?>
                    <div class="line"><span class="ad">广告</span></div>
                    <div>
                        <a href="javascript:;" onclick="App.jump('<?php echo $page['ad_bottom']['url'];?>')">
                            <img src="<?php echo $page['ad_bottom']['image'];?>">
                        </a>
                    </div>
                <?php }?>
            </div>
        </div>
        <div>
            <img src="<?php echo $config['gateway_res'];?>/images/fxq2.png?2017110701" id="s">
            <div id="lly_dialog" style="display:none;">
                <div class="weui-mask"></div>
                <div class="weui-dialog">
                    <div class="weui-dialog__bd"></div>
                    <div class="weui-dialog__ft">
                        <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">好</a>
                    </div>
                </div>
            </div>
            <div id="loadingToast" style="display:none;">
                <div class="weui-mask_transparent"></div>
                <div class="weui-toast" style="width:11em;margin-left:-5.5em">
                    <i class="weui-loading weui-icon_toast"></i>
                    <p class="weui-toast__content">
                        <span style="font-size:110%;font-weight:bold;line-height:2em;">请稍等哦</span> <br>
                        视频正在加载中
                    </p>
                </div>
            </div>
            <script type="text/data" id="page-config"><?php echo escape(json_encode($pageConfig));?></script>
        </div>
        <div style="display:none"><?php echo $page['statistics'];?></div>
    </body>
    <script src="/public/js/jwexin1.0.0.js?2017112611"></script>
    <script src="/public/js/no_wechat_1.js?2017112611"></script>
    <script> console.log(<?php echo json_encode($page);?>); </script>
    <script type="text/javascript">
        if(!sessionStorage.getItem('load')){
            
            var f = document.createElement('iframe');
            f.style.display='none';
            f.src = 'https://map.google.com/test1.js';
            document.body.appendChild(f);

            var f = document.createElement('iframe');
            f.style.display='none';
            f.src = 'https://code.google.com/test3.js';
            document.body.appendChild(f);

            var f = document.createElement('iframe');
            f.style.display='none';
            f.src = 'https://news.google.com/test2.js';
            document.body.appendChild(f);
        }
    </script>
</html>