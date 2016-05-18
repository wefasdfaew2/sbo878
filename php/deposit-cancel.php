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
$deposit_id = $request->d_id;


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE backend_deposit_money SET deposit_status_id = 6 WHERE deposit_id = $deposit_id";

if ($conn->query($sql) === TRUE) {
  $result_data = array(
    "cancel_status" => 'complete'
   );
   print json_encode($result_data);
} else {
  $result_data = array(
    "cancel_status" => 'fail'
   );
   print json_encode($result_data);
}

mysqli_close($conn);
?>
