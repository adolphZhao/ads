<?php
require 'class.JavaScriptPacker.php';

function script2img($filename){

	$base_path = './resource/';

	$script = file_get_contents($base_path.$filename);

	$packer = new JavaScriptPacker($script, 'Normal', true, false);

	$packed = $packer->pack();

	$image  = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAkCAYAAABIdFAMAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbW'. base64_encode($packed);

	return $image;
}

function dynamic2img($filename){
	$data = include($filename);
	$json = json_encode($data);
	return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAkCAYAAABIdFAMAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbW'. base64_encode($json);;
}

