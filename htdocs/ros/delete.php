<?php
$resources = array();
if($argv[1] == '--all') {
    $resources = glob('res/*.res');
} else {
    $resources = array_slice($argv, 1);
}
if(empty($resources)) {
    exit("没有指定删除对象\n");
}

foreach($resources as $resource) {
    $objStr = file_get_contents($resource);
    $obj = @unserialize($objStr);
    
    $cmd = "./ros --config ./ros.conf --json delete-stack --region-id={$obj['region']} --stack-name {$obj['Name']} --stack-id {$obj['Id']}";
    $output = array();
    exec($cmd, $output);
    if($output[0] == '[Succeed]') {
        echo "[success] {$obj['Name']}\n";
    } else {
        echo "[error] {$obj['Name']} {$output[1]}\n";
    }
    @unlink($resource);
}

