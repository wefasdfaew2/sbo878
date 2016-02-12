<?php

header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$data = json_decode(file_get_contents("php://input"));
//echo $data->name;
if(!empty($data->user) && !empty($data->timestamp) && !empty($data->ip) && !empty($data->token)) {

    $user = $data->user;
    $timestamp = $data->timestamp;
    $ip = $data->ip;
    $token = $data->token;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

//$sql = "SELECT * FROM channel_category GROUP BY channel_group ORDER BY c_sort";
$sql = "INSERT INTO user_token (user, ts, ip, token) VALUES ('$user', '$timestamp', '$ip', '$token')";
//$sql = "SELECT channel_group FROM channel_category";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


mysqli_close($conn);
}else {
  echo "Error: no post data";
}
?>
