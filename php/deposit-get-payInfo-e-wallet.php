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
if(!empty($request->auto_type_option))$auto_type_option = $request->auto_type_option;
if(!empty($request->wallet_number))$wallet_number = $request->wallet_number;


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT deposit_type_wellknown_name, deposit_type_emailnotify_image
        /**(SELECT wallet_number FROM backend_wallet_account ORDER BY wallet_amount ASC LIMIT 1) as wallet_number,
        (SELECT wallet_deposit_type_id FROM backend_wallet_account ORDER BY wallet_amount ASC LIMIT 1) as wallet_id**/
        FROM backend_deposit_type
        WHERE deposit_type_id = '$auto_type_option'";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
  }

  $wallet_id = $auto_type_option;//$data[0]['wallet_id'];
  $sql = "SELECT deposit_type_emailnotify_image FROM backend_deposit_type WHERE deposit_type_id = '$wallet_id'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
    }
  }
  else
  {
    echo("Error description: " . mysqli_error($conn));
    echo "01 results";
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
