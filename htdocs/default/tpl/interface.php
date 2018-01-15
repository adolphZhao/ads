<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>批量检查域名</title>
    <link rel="stylesheet" href="//g.alicdn.com/sui/sui3/0.0.18/css/sui.min.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
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
					if(isset( $row['appid'.$i] )){
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
                <li><a href="?act=global">全局参数</a></li>
                <li class="active"><a href="?act=interface">公众号配置</a></li>
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
            <label>参数配置</label>
            <div class="row">
            	<div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">公众号标题</span>
                        <input name="title" type="text" class="form-control" value="<?php echo $row['title']?>">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">APPID</span>
                        <input name="appid" type="text" class="form-control" value="<?php echo $row['appid']?>">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">APPSECRET</span>
                        <input name="appsecret" type="text" class="form-control" value="<?php echo $row['appsecret']?>">
                    </div>
                </div>
            </div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>绑定URL</label>
						<textarea name="bind_url" rows="6" class="form-control"><?php echo $row['bind_url']?></textarea>
						<span class="help-block">绑定该公众号的url，随机抽取一个使用</span>
					</div>
				</div>
			</div>
        </div>
       <hr>
      </form>
  </div>
</body>
</html>