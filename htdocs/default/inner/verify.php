<?php
$v = $_GET['v'];
$v = str_replace('/MP_verify_', '', $v);
$v = str_replace('/WW_verify_', '', $v);
$v = str_replace('.txt', '', $v);
echo $v;