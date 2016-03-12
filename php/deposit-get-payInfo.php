<?php

header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);

$account = $request->username;//'zkc8688000';//
$timeStamp = $request->timeStamp;//'2016-03-12 22:41:41';//
$deposit_amount = $request->deposit_amount;//'45000.51';//

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT deposit_bank_name, deposit_bank_account FROM backend_deposit_money
        WHERE deposit_account = '$account' AND deposit_amount = '$deposit_amount' AND deposit_regis = '$timeStamp'";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
  }
  //print json_encode($data);
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
}

$bank_name = $data[0]['deposit_bank_name'];
$sql = "SELECT deposit_type_wellknown_name, deposit_type_logo_large, deposit_type_emailnotify_image
        FROM backend_deposit_type WHERE deposit_type_name = '$bank_name' AND deposit_type_subtype = 'Internet Banking'
        AND deposit_type_type = 'auto'";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[0]['deposit_type_wellknown_name'] = $row['deposit_type_wellknown_name'];
    $data[0]['deposit_type_logo_large'] = $row['deposit_type_logo_large'];
    $data[0]['deposit_type_emailnotify_image'] = $row['deposit_type_emailnotify_image'];
  }
  print json_encode($data);
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
}

?>
