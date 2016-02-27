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

//$sql = "SELECT * FROM channel_category GROUP BY channel_group ORDER BY c_sort";
$sql = "SELECT a.deposit_id, a.deposit_account, a.deposit_status_id,
a.deposit_regis,
(
 SELECT deposit_status_name FROM backend_deposit_status c
 WHERE c.deposit_status_id=b.deposit_status_id
) as deposit_stataus_name,
(
 SELECT deposit_type_logo FROM backend_deposit_type d
 WHERE d.deposit_type_id=a.deposit_type
) as deposit_type_name,
a.deposit_note
FROM
backend_deposit_money a,
backend_deposit_status b
WHERE
a.deposit_status_id = b.deposit_status_id ORDER BY a.deposit_id DESC";
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
