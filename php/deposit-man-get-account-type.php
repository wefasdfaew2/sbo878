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
if(!empty($request->tel)){
    $tel = $request->tel;
}else {
  $tel = '';
}





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

  if($data[0]['sbobet_member_type_id'] == 1){
    $member_type = 'member_sbobet_account_id';
  }elseif ($data[0]['sbobet_member_type_id'] == 2) {
    $member_type = 'member_gclub_account_id';
  }elseif ($data[0]['sbobet_member_type_id'] == 3) {
    $member_type = 'member_ibcbet_account_id';
  }elseif ($data[0]['sbobet_member_type_id'] == 4) {
    $member_type = 'member_vegus168_account_id';
  }else {

  }
  $sbo_account_id = $data[0]['sbobet_account_id'];
  //print json_encode($data);
  $sql = "SELECT member_telephone_1, member_telephone_2, member_bank_priority FROM backend_member_account WHERE $member_type = $sbo_account_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
      //echo  $row["channel"];
    }

    if($data[1]['member_telephone_1'] == ''){
      $data[1]['member_telephone_1'] = 'qwsdvhuio';
    }
    if($data[1]['member_telephone_2'] == ''){
      $data[1]['member_telephone_2'] = 'qwsdvhuio';
    }

    if($tel == $data[1]['member_telephone_1'] || $tel == $data[1]['member_telephone_2']){
      $result_data = array(
        "get_account_type" => $data[0]['member_type_name'],
        "get_logo_type" => $data[0]['member_type_logo'],
        "user_priority" => $data[1]['member_bank_priority']
       );
      print json_encode($result_data);
    }else {
      $result_data = array("get_account_type" => "no_account");
      print json_encode($result_data);
    }
  }
  else
  {
    $result_data = array("get_account_type" => "no_account");
    print json_encode($result_data);
  }

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
