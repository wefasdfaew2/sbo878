<?php

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

//$sql = "SELECT * FROM channel_category GROUP BY channel_group ORDER BY c_sort";
$sql = "SELECT COUNT(deposit_account) FROM backend_deposit_money WHERE deposit_account = '$account'";
//$sql = "SELECT channel_group FROM channel_category";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
    //echo  $row["channel"];
  }

  $result_data = array(
    "account_is_deposited" => $data[0]['COUNT(deposit_account)']
   );
  print json_encode($result_data);
}
else
{
  $result_data = array("account_is_deposited" => "Error description:");
  print json_encode($result_data);
  //echo("Error description: " . mysqli_error($conn));
  //echo "0 results";
}

mysqli_close($conn);
?>
