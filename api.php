<?php

require 'autoload.php';

use app\MobileQuery;

defined("API") or define("API", __DIR__);

$mobile = trim($_POST['mobile']);
$result = MobileQuery::query($mobile);
if ( ! is_array($result) ) {
    exit (json_encode(array('success'=>FALSE, 'error'=>'手机号码异常')));
} else {
    exit (json_encode(array('success'=>TRUE, 'result'=>$result)));
}

