<?php

$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');

header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);


if(!empty($request->username))$account = $request->username;
if(!empty($request->paypal_account))$paypal_account = $request->paypal_account;
if(!empty($request->paypal_verified))$paypal_verified = $request->paypal_verified;
if(!empty($request->paypal_country))$paypal_country = $request->paypal_country;
if(!empty($request->paypal_own))$paypal_own = $request->paypal_own;
if(!empty($request->paypal_accpet))$paypal_accpet = $request->paypal_accpet;

if($creditcards_accpet == 'true'){
  $creditcards_accpet = 'yes';
}else {
  $creditcards_accpet = 'no';
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO evidence_paypal (878_account, paypal_email, paypal_verified, paypal_country, paypal_owner, accept)
        VALUES ('$account', '$paypal_account', '$paypal_verified', '$paypal_country', '$paypal_own', '$paypal_accpet')";

if ($conn->query($sql) === TRUE) {
  $result_data = array("set_status" => "success");
} else {
  $result_data = array("set_status" => "Error: " . $sql . "<br>" . $conn->error);
}

print json_encode($result_data);


mysqli_close($conn);


?>
