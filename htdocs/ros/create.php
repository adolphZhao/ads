<?php
$regionId = 'cn-shenzhen';
if(!empty($argv[3])) {
    $regionId = $argv[3];
}
$srcSlb = 'lb-wz9vbtbpuc0422lld89it';
if(!empty($argv[2])) {
    $srcSlb = $argv[2];
}
$count = intval($argv[1]);
    
for($i = 1; $i <= $count; $i++) {
    $name = 'create' . $i;
    $cmd = "./ros --config ./ros.conf --json --region-id={$regionId} create-stack --stack-name {$name} --template-url ./template.json --parameters Name={$name},SourceSLBId={$srcSlb}";
    $output = array();
    exec($cmd, $output);
    if($output[0] == '[Succeed]') {
        $jsonOutput = array_slice($output, 1);
        $jsonStr = implode("\n", $jsonOutput);
        $jsonObj = json_decode($jsonStr, true);
        $jsonObj['region'] = $regionId;
        file_put_contents("res/{$name}.res", serialize($jsonObj));
        echo "[success] {$name}\n";
    } else {
        echo "[error] {$name} {$output[1]}\n";
    }
}

