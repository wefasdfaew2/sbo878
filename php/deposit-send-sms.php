<?php

$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');

header('Content-Type: text/html; charset=utf-8');
include("../php_sms_class/sendsms_daifaan.php");


$postdata = file_get_contents('php://input');
$request = json_decode($postdata);

if(!empty($request->tel)){
  $tel = $request->tel;
}else {
  die('no number');
}
if (!empty($request->message)) {
  $message = $request->message;
}else {
  die('no message');
}

$daifaan_sms = $message;
SendMessage_daifaan($tel, $daifaan_sms );

?>
