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
if(!empty($request->check_otp))$check_otp = $request->check_otp;
if(!empty($request->otp_ref))$otp_ref = $request->otp_ref;
if(!empty($request->otp))$otp = $request->otp;


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

if($check_otp == 'false'){

  $otp = generateRandom_otp_code(6);
  $otp_ref = generateRandom_otp_ref_code(5);
  //$sql = "SELECT * FROM channel_category GROUP BY channel_group ORDER BY c_sort";
  $sql = "INSERT INTO backend_withdraw_otp (withdraw_username, withdraw_otp, withdraw_otp_ref)
          VALUES ('$account', '$otp', '$otp_ref')";

  if ($conn->query($sql) === TRUE) {
      //echo "New record created successfully";
      $result_data = array("otp_ref" => "$otp_ref");
  } else {
      //$result_data = "Error: " . $sql . "<br>" . $conn->error;
      $result_data = array("otp_ref" => "error");
  }

  print json_encode($result_data);
  $conn->close();

}elseif ($check_otp == 'true') {
  $sql = "SELECT withdraw_otp FROM backend_withdraw_otp WHERE withdraw_username = '$account' AND withdraw_otp_ref = '$otp_ref'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
    }
    //print_r ($data);
    if($data[0]['withdraw_otp'] == $otp){
      $result_data = array("check_otp_status" => "pass");
    }else{
      $result_data = array("check_otp_status" => "not pass");
    }
    print json_encode($result_data);
  } else {
      echo "0 results";
  }
  $conn->close();
}
function generateRandom_otp_code($length) {
    $characters = '123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandom_otp_ref_code($length) {
    $characters = '123456789abcdefghijklmnpqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
