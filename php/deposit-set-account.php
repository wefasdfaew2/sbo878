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
$deposit_type = $request->auto_type_option;
$timeStamp = $request->timeStamp;
$date = $request->date;
$time = $request->time;
$bonus_type = $request->bonus_type;
$deposit_amount = $request->deposit_amount;

$deposit_bot_tunover_check_mark = '';
$deposit_firstpayment_promotion_mark = '';
$deposit_nextpayment_promotion_mark = '';
if($bonus_type == 'get_200_per' || $bonus_type == 'get_10_per'){
  $deposit_bot_tunover_check_mark = 'Yes';
}else {
  $deposit_bot_tunover_check_mark = 'No';
}
if($bonus_type == 'get_200_per'){
  $deposit_firstpayment_promotion_mark = 'Yes';
  $deposit_nextpayment_promotion_mark = 'No';
}else if($bonus_type == 'get_10_per'){
  $deposit_nextpayment_promotion_mark = 'Yes';
  $deposit_firstpayment_promotion_mark = 'No';
}else {
  $deposit_firstpayment_promotion_mark = 'No';
  $deposit_nextpayment_promotion_mark = 'No';
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM backend_bank_account";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data_bank[] = $row;
  }
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
}

if($deposit_type == '46'){
  $bank_account = 'visamastercard';
  $bank_name = 'creditcard';
  $deposit_amount = null;
}elseif ($deposit_type == '48') {
  $bank_account = 'paypalwallet';
  $bank_name = 'paypal';
  $deposit_amount = null;
}elseif ($deposit_type == '33') {
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'ไทยพาณิชย์'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }
}elseif ($deposit_type == '29') {
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กสิกรไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }
}elseif ($deposit_type == '37') {
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กรุงเทพ'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }
}elseif ($deposit_type == '45') {
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กรุงไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }
}elseif ($deposit_type == '41') {
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กรุงศรีอยุธยา'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }
}elseif ($deposit_type == '52') {
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'ธหารไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }
}elseif ($deposit_type == '28') {
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กสิกรไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }
}




$sql = "SELECT sbobet_account_id, sbobet_member_type_id FROM backend_sbobet_account WHERE sbobet_username = '$account'";
//$sql = "SELECT channel_group FROM channel_category";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
    //echo  $row["channel"];
  }
  //echo $data[0]['sbobet_member_type_id'];
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
  $sql = "SELECT member_nickname, member_telephone_1 FROM backend_member_account WHERE $member_type = $sbo_account_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
    }
    $member_nickname = $data[1]['member_nickname'];
    $member_telephone_1 = $data[1]['member_telephone_1'];

    $sql = "INSERT INTO backend_deposit_money (deposit_account, deposit_nickname, deposit_telephone, deposit_amount,
            deposit_type, deposit_bank_account, deposit_bank_name, deposit_date, deposit_time, deposit_regis, deposit_status_id,
            deposit_bot_tunover_check_mark, deposit_firstpayment_promotion_mark, deposit_nextpayment_promotion_mark)
            VALUES ('$account', '$member_nickname', '$member_telephone_1', '$deposit_amount', '$deposit_type', '$bank_account', '$bank_name',
            '$date', '$time', '$timeStamp', '1', '$deposit_bot_tunover_check_mark', '$deposit_firstpayment_promotion_mark',
            '$deposit_nextpayment_promotion_mark')";

    if ($conn->query($sql) === TRUE) {
      $result_data = array("set_status" => "success");
    } else {
      $result_data = array("set_status" => "fail3");
    }
    print json_encode($result_data);
  }
  else
  {
    echo("Error description: " . mysqli_error($conn));
    echo "0 results";
    $result_data = array("set_status" => "fail2");
    print json_encode($result_data);
  }

  mysqli_close($conn);

}
else
{
  //echo("Error description: " . mysqli_error($conn));
  //echo "0 results";
  $result_data = array("set_status" => "Error description: " . mysqli_error($conn));
  print json_encode($result_data);
}

mysqli_close($conn);
?>
