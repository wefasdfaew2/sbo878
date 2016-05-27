<?php

//$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
//if($check_direct_access === false)die('Restricted access');


header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);
$bank_number = $request->bank_number;


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT bank_account FROM backend_bank_account WHERE bank_account_number = '$bank_number'";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
    while($row = $result->fetch_assoc())
    {
        $data = $row['bank_account'];
    }

    $results = array('bank_owner' => $data);
    print json_encode($results);
}
else {
    error_log("Can't Select");
}

$conn->close();
?>
