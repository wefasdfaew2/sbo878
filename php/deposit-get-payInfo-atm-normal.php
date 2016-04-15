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
if(!empty($request->auto_type_option))$auto_type_option = $request->auto_type_option;
if(!empty($request->deposit_amount))$deposit_amount = $request->deposit_amount;


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT deposit_bank_name, deposit_bank_account,
        (SELECT deposit_type_name FROM backend_deposit_type WHERE deposit_type_id = '$auto_type_option') as from_bank_name,
        (SELECT deposit_type_emailnotify_image FROM backend_deposit_type WHERE deposit_type_id = '$auto_type_option') as how_to_img
        FROM backend_deposit_money
        WHERE deposit_account = '$account' AND deposit_amount = '$deposit_amount' AND deposit_regis = '$timeStamp'";
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
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
}

mysqli_close($conn);

?>
