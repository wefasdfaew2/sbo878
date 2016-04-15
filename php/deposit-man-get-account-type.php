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
if(!empty($request->tel))$tel = $request->tel;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

//$sql = "SELECT * FROM channel_category GROUP BY channel_group ORDER BY c_sort";
$sql = "SELECT a.sbobet_member_type_id, a.sbobet_account_id,
(
 SELECT member_type_name FROM backend_member_type c
 WHERE c.member_type_id=a.sbobet_member_type_id
) as member_type_name,
(
 SELECT member_type_logo FROM backend_member_type c
 WHERE c.member_type_id=a.sbobet_member_type_id
) as member_type_logo

FROM
backend_sbobet_account a
WHERE
a.sbobet_username = '$account'";
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
    "get_account_type" => $data[0]['member_type_name'],
    "get_logo_type" => $data[0]['member_type_logo']
   );
  print json_encode($result_data);


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
