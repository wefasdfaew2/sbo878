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
if(!empty($request->timeStamp))$timeStamp = $request->timeStamp;
if(!empty($request->deposit_amount))$deposit_amount = $request->deposit_amount;
if(!empty($request->set_option))$option = $request->set_option;
if(!empty($request->auto_type_option))$auto_type_option = $request->auto_type_option;


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
$sql = "SELECT deposit_type_wellknown_name, deposit_type_logo_large, deposit_type_emailnotify_image,
        (SELECT deposit_type_wellknown_name FROM backend_deposit_type WHERE deposit_type_id = '$auto_type_option') as selected_bank_wellknown_name,
        (SELECT deposit_type_logo_large FROM backend_deposit_type WHERE deposit_type_id = '$auto_type_option') as selected_bank_logo,
        (SELECT deposit_type_emailnotify_image FROM backend_deposit_type WHERE deposit_type_id = '$auto_type_option') as selected_bank_emailnotify_image
        FROM backend_deposit_type WHERE deposit_type_name = '$bank_name' AND deposit_type_subtype = '$option'
        AND deposit_type_type = 'auto'";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[0]['deposit_type_wellknown_name'] = $row['deposit_type_wellknown_name'];
    $data[0]['deposit_type_logo_large'] = $row['deposit_type_logo_large'];
    $data[0]['deposit_type_emailnotify_image'] = $row['deposit_type_emailnotify_image'];

    $data[0]['selected_bank_wellknown_name'] = $row['selected_bank_wellknown_name'];
    $data[0]['selected_bank_logo'] = $row['selected_bank_logo'];
    $data[0]['selected_bank_emailnotify_image'] = $row['selected_bank_emailnotify_image'];
  }
  print json_encode($data);
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
}

mysqli_close($conn);
?>
