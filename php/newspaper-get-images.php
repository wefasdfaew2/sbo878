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

$newspaper_name = $request->newspaper_name;


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

if($newspaper_name == 'sportpool'){
  $newspaper_name = 'สปอร์ตพูล';
}elseif ($newspaper_name == 'sportman') {
  $newspaper_name = 'สปอร์ตแมน';
}elseif ($newspaper_name == 'tarad') {
  $newspaper_name = 'ตลาดลูกหนัง';
}elseif ($newspaper_name == 'starsoccer') {
  $newspaper_name = 'สตาร์ซอคเกอร์';
}

$sql = "SELECT * FROM newspaper WHERE name = '$newspaper_name'";

$result = $conn->query($sql);

if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
  }
  print json_encode($data);
}
else
{
  $result_data = array("get_account_type" => "no_account");
  print json_encode($result_data);
  //echo("Error description: " . mysqli_error($conn));
  //echo "0 results";
}

mysqli_close($conn);
?>
