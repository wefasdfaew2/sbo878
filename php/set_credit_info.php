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
if(!empty($request->creditcards_bank))$creditcards_bank = $request->creditcards_bank;
if(!empty($request->creditcards_type))$creditcards_type = $request->creditcards_type;
if(!empty($request->creditcards_stolen))$creditcards_stolen = $request->creditcards_stolen;
if(!empty($request->creditcards_own))$creditcards_own = $request->creditcards_own;
if(!empty($request->creditcards_accpet))$creditcards_accpet = $request->creditcards_accpet;

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

$sql = "INSERT INTO evidence_creditcards (878_account, creditcards_bank, creditcards_type, creditcards_stolen, creditcards_owner, accept)
        VALUES ('$account', '$creditcards_bank', '$creditcards_type', '$creditcards_stolen', '$creditcards_own', '$creditcards_accpet')";

if ($conn->query($sql) === TRUE) {
  $result_data = array("set_status" => "success");
} else {
  $result_data = array("set_status" => "fail");
}

print json_encode($result_data);


mysqli_close($conn);


?>
