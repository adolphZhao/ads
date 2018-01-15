<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>批量检查域名</title>
    <link rel="stylesheet" href="//g.alicdn.com/sui/sui3/0.0.18/css/sui.min.css">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="?act=summary">概览</a></li>
                <li><a href="?act=global">全局参数</a></li>
                <li><a href="?act=interface">公众号配置</a></li>
                <li class="active"><a href="?act=check">检查域名</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <form action="" method="get">
        <input type="hidden" name="act" value="check">
        <div class="form-group">
            <label>请输入要检查的域名</label>
            <div class="row">
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="host" value="<?php echo $_GET['host'];?>">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">检查</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="short" value="<?php echo $_GET['short'];?>">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">缩短</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php if(!empty($hosts)) {?>
    <table class="table table-striped" style="min-width:1100px;">
        <tr>
            <th>域名(IP)</th>
            <th style="width:60px;">状态</th>
            <th style="width:140px;">检测时间</th>
        </tr>
        <?php foreach($hosts as $host) {?>
        <tr>
            <td><?php echo $host['host']?> (<?php echo $host['ip']?>)</td>
            <td>
                <?php if($host['status'] == 'ok') {?>
                <span class="label label-success">正常</span>
                <?php }?>
                <?php if($host['status'] == 'bad') {?>
                <span class="label label-danger">被封</span>
                <?php }?>
                <?php if($host['status'] == 'error') {?>
                <span class="label label-default">检测失败</span>
                <?php }?>
            </td>
            <td>
                <span class="label label-default"><?php echo date('y.m.d H:i:s', $host['last'])?></span>
            </td>
        </tr>
        <?php }?>
    </table>
    <?php }?>
    <?php if(!empty($shortUrls)) {?>
        <div class="alert alert-info"><?php echo $shortUrls[0];?></div>
    <?php }?>
</div>

<script type="text/javascript" src="//g.alicdn.com/sj/lib/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="//g.alicdn.com/sui/sui3/0.0.18/js/sui.min.js"></script>
</body>
</html>