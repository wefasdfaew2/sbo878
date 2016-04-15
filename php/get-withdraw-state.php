<?php

$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');

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

//$sql = "SELECT * FROM channel_category GROUP BY channel_group ORDER BY c_sort";
$sql = "SELECT a.withdraw_id, a.withdraw_account, a.withdraw_bank_account,
a.withdraw_regis,
(
 SELECT member_type_name FROM backend_member_type c
 WHERE c.member_type_id=a.withdraw_member_type_id
) as withdraw_member_name,
(
 SELECT withdraw_type_logo FROM backend_withdraw_type d
 WHERE d.withdraw_type_name=a.withdraw_bank_name
) as withdraw_type_name,
a.withdraw_note,a.withdraw_status_id
FROM
backend_withdraw_money a,
backend_withdraw_status b
WHERE
a.withdraw_status_id = b.withdraw_status_id ORDER BY a.withdraw_id DESC";
//$sql = "SELECT channel_group FROM channel_category";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
    //echo  $row["channel"];
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
