<?php

$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');

header('Content-Type: text/html; charset=utf-8');

//include("../php_sms_class/sms.class.php");
include("../php_sms_class/sms_sbobet878.php");
//include("../php_sms_class/sendsms_daifaan.php");

$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);

if(!empty($request->username))$account = $request->username;
if(!empty($request->otp_ref))$otp_ref = $request->otp_ref;
if(!empty($request->tel))$tel = $request->tel;



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT withdraw_otp FROM backend_withdraw_otp WHERE withdraw_username = '$account' AND withdraw_otp_ref = '$otp_ref'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
  }
  /**if($data[0]['withdraw_otp'] == $otp){
    $result = array("check_otp_status" => "pass");
  }else{
    $result = array("check_otp_status" => "not pass");
  }
  print json_encode($result);**/

	/**$msisdn_sms = $tel;
	$message_sms = 'รหัส%20OTP%20=%20'. $data[0]['withdraw_otp'] .'%20Ref%20Code%20:%20'.$otp_ref;
	$sender_sms = 'SBOBET878';
	$ScheduledDelivery_sms =  '';
	$force_sms = 'Standard';

  $result_sms = SendMessage_daifaan($msisdn_sms,$message_sms);**/
  $msisdn_sms_1 = $tel;
  //error_log('tel= '.$msisdn_sms_1.' xxx');
  $message_sms_1 = 'รหัส OTP = '. $data[0]['withdraw_otp'] .' Ref Code : '.$otp_ref;
  sendsms($msisdn_sms_1, $message_sms_1, 2);
  //$result_sms = sms::send_sms($username_sms,$password_sms,$msisdn_sms,$message_sms,$sender_sms,$ScheduledDelivery_sms,$force_sms);
  //echo $result_sms;
} else {
    echo "0 results";
}

$conn->close();

?>
