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
$account = $request->username;


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT COUNT(*) as first_cc_pp
  FROM backend_deposit_money
  WHERE deposit_account = '$account' AND deposit_status_id = 5 AND (deposit_type = 46 OR deposit_type = 48)";

$result = $conn->query($sql);

if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
  }

  if($data[0]['first_cc_pp'] == 0){
    $result_data = array(
      "first_cc_pp" => 'Yes'
     );
  }else {
    $result_data = array(
      "first_cc_pp" => 'No'
     );
  }

  print json_encode($result_data);
}
else
{
  $result_data = array("account_is_deposited" => "Error description:");
  print json_encode($result_data);
  
}

mysqli_close($conn);
?>
