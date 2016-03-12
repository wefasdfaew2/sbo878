<?php

header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM backend_bank_account";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{

  while($row = $result->fetch_assoc())
  {
    $data[] = $row;

  }
  foreach ($data as $value) {
    echo $value['bank_name'] .'<br>';
  }
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
  //$result_data = array("set_status" => "Error description: " . mysqli_error($conn));
  //print json_encode($result_data);
}

 ?>
