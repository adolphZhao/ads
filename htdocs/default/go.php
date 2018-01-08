<?php
include './inc/config.php';
include './inc/global.php';

$cross = new Cross();
$authCode = $_GET['auth_code'];
if(!empty($authCode)) {
    $authorizer = $cross->getAuthorizer($authCode);
    if(!is_error($authorizer)) {
        exit('成功授权公众号');
    }
    exit('接口调用错误' . $authorizer['message']);
}

$url = 'http://' . getenv('HTTP_HOST') . '/go.php';
$forward = $cross->createAuthUrl($url);
if(is_error($forward)) {
    exit($forward['message']);
}
?>
<a href="<?php echo $forward?>">授权</a>
