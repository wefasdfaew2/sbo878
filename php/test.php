<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="Free Web tutorials">
<meta name="keywords" content="HTML,CSS,XML,JavaScript">
<meta name="author" content="Hege Refsnes">
<meta name="referrer" content="origin">
</head>
<body>

<p>All meta information goes in the head section...</p>



<?php



header('Content-Type: text/html; charset=utf-8');
//echo $_SERVER['HTTP_REFERER'].'<br>';
//echo $_SERVER['SERVER_ADDR'].'<br>';
//echo $_SERVER['REMOTE_ADDR'].'<br>';
//echo getenv('HTTP_HOST');
include("http://sbogroup.t-wifi.co.th/wordpress/wp-content/themes/point/php_sms_class/sendsms_daifaan.php");

echo "<a href='http://sbogroup.t-wifi.co.th/wordpress/wp-content/themes/point/php/test.php'>aaaa</a>";

$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($pos===false){
  $pos = strpos($_SERVER['HTTP_REFERER'],'sbolive.asia');
  if($pos===false){
    die('Restricted access1');
  }
}

echo "string";
/**$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO backend_deposit_money (deposit_account)
VALUES ('John')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();**/
//echo $_SERVER['HTTP_X_REQUESTED_WITH'];
//echo 'asdfg';
/**$configs = include('../php_db_config/config.php');

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

$sql = "SELECT current_satang_count FROM global_setting;";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{

  while($row = $result->fetch_assoc())
  {
    $data[] = $row;

  }
  $deposit_amount = 5500;
  $deposit_amount = (string)$deposit_amount;
  $deposit_amount = $deposit_amount.'.'.(string)$data[0]['current_satang_count'];
  echo $deposit_amount;

  if($data[0]['current_satang_count'] == 99){
    $update_satang = 11;
  }else {
    $update_satang = $data[0]['current_satang_count'] + 1;
  }


  $sql = "UPDATE global_setting SET current_satang_count = $update_satang";
  $result = $conn->query($sql);
  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  }
  else {
    echo "Error updating record: " . $conn->error;
  }
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
  //$result_data = array("set_status" => "Error description: " . mysqli_error($conn));
  //print json_encode($result_data);
}
$conn->close();**/
 ?>
</body>
</html>
