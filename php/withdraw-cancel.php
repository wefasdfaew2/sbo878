<?php

header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);
$account = $request->username;
$amount = $request->amount;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE backend_withdraw_money SET withdraw_status_id = '5', withdraw_amount = '0'
  WHERE withdraw_account = '$account'";

if ($conn->query($sql) === TRUE) {
    //echo "Record updated successfully";
    $result_data = array("withdraw_status" => "successfully");
    print json_encode($result_data);
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();

?>
