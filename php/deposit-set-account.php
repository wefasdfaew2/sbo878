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


if(!empty($request->username)){
  $account = $request->username;
  $account = strtolower($account);
}

if(!empty($request->auto_type_option))$deposit_type = $request->auto_type_option;
if(!empty($request->timeStamp))$timeStamp = $request->timeStamp;
if(!empty($request->date))$date = $request->date;
if(!empty($request->time))$time = $request->time;
if(!empty($request->bonus_type))$bonus_type = $request->bonus_type;
if(!empty($request->deposit_amount))$deposit_amount = $request->deposit_amount;
if(!empty($request->deposit_telephone))$deposit_telephone = $request->deposit_telephone;
if(!empty($request->user_priority))$user_priority = $request->user_priority;

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

//$sql = "SELECT * FROM backend_bank_account WHERE bank_enable = 'Yes' AND bank_use_onweb = 'Yes' AND bank_priority = '$user_priority'";
if($user_priority == 'low'){
  $sql = "SELECT * FROM backend_bank_account WHERE bank_enable = 'Yes' AND bank_use_onweb = 'Yes' AND bank_priority = 'low'";
}elseif ($user_priority == 'medium') {
  $sql = "SELECT * FROM backend_bank_account WHERE bank_enable = 'Yes' AND bank_use_onweb = 'Yes' AND (bank_priority = 'medium' OR bank_priority = 'low')";
}elseif ($user_priority == 'high') {
  $sql = "SELECT * FROM backend_bank_account WHERE bank_enable = 'Yes' AND bank_use_onweb = 'Yes' AND (bank_priority = 'high' OR bank_priority = 'medium' OR bank_priority = 'low')";
}
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
  $bank_account = '9999999999';
  $bank_name = 'creditcard';
  $deposit_amount = null;
}elseif ($deposit_type == '48') {
  $bank_account = '8888888888';
  $bank_name = 'paypal';
  $deposit_amount = null;
}elseif ($deposit_type == '33') {

  $bank_data = get_bank($data_bank, 'ไทยพาณิชย์', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'ไทยพาณิชย์'){
      if($value['bank_priority'] == $user_priority){
        $bank_name = $value['bank_name'];
        $bank_account = $value['bank_account_number'];
        break;
      }else {
        $bank_name = $value['bank_name'];
        $bank_account = $value['bank_account_number'];
      }
    }else {
      if($value['bank_priority'] == $user_priority){
        $bank_name = $value['bank_name'];
        $bank_account = $value['bank_account_number'];
      }
    }
  }*/
  /**$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'ไทยพาณิชย์'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }**/
}elseif ($deposit_type == '29' || $deposit_type == '28') {
  $bank_data = get_bank($data_bank, 'กสิกรไทย', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กสิกรไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '37') {
  $bank_data = get_bank($data_bank, 'กรุงเทพ', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กรุงเทพ'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '45' || $deposit_type == '44') {
  $bank_data = get_bank($data_bank, 'กรุงไทย', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กรุงไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '41' || $deposit_type == '40') {
  $bank_data = get_bank($data_bank, 'กรุงศรีอยุธยา', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กรุงศรีอยุธยา'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '52' || $deposit_type == '51') {
  $bank_data = get_bank($data_bank, 'ธหารไทย', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'ธหารไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '28') {
  $bank_data = get_bank($data_bank, 'กสิกรไทย', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กสิกรไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '58' || $deposit_type == '59' || $deposit_type == '60') {

  $sql = "SELECT wallet_number FROM backend_wallet_account WHERE wallet_deposit_type_id = '$deposit_type' ORDER BY wallet_amount ASC LIMIT 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      //$data[] = $row;
      $bank_account = $row["wallet_number"];
    }
  }
  else
  {
    $result_data = array("set_status" => "fail to get wallet");
    print json_encode($result_data);
  }
  //$bank_account = '7777777777';
  if($deposit_type == '58'){
    $bank_name = 'TrueMoney Wallet';
  }elseif ($deposit_type == '59') {
    $bank_name = 'Jaew Wallet';
  }elseif ($deposit_type == '60') {
    $bank_name = 'AIS mPay Wallet';
  }

}
/**elseif ($deposit_type == '59') {
  $bank_name = 'Jaew Wallet';
  $bank_account = 'E-Money Wallet';
}elseif ($deposit_type == '60') {
  $bank_name = 'AIS mPay Wallet';
  $bank_account = 'E-Money Wallet';
}**/

elseif ($deposit_type == '26') {
  $bank_data = get_bank($data_bank, 'กสิกรไทย', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กสิกรไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '30') {
  $bank_data = get_bank($data_bank, 'ไทยพาณิชย์', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'ไทยพาณิชย์'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '34') {
  $bank_data = get_bank($data_bank, 'กรุงเทพ', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กรุงเทพ'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '38') {
  $bank_data = get_bank($data_bank, 'กรุงศรีอยุธยา', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กรุงศรีอยุธยา'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '42') {
  $bank_data = get_bank($data_bank, 'กรุงไทย', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'กรุงไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '49') {
  $bank_data = get_bank($data_bank, 'ทหารไทย', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'ทหารไทย'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '53') {
  $bank_data = get_bank($data_bank, 'ยูโอบี', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*$bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'ยูโอบี'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
}elseif ($deposit_type == '54') {
  $bank_data = get_bank($data_bank, 'CIMB', $user_priority);
  $bank_name = $bank_data['bank_name'];
  $bank_account = $bank_data['bank_account'];
  /*
  $bank_name = $data_bank[0]['bank_name'];
  $bank_account = $data_bank[0]['bank_account_number'];
  foreach ($data_bank as $value) {
    if($value['bank_name'] == 'CIMB'){
      $bank_name = $value['bank_name'];
      $bank_account = $value['bank_account_number'];
      break;
    }
  }*/
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
  $sql = "SELECT member_nickname, member_telephone_1,
          (SELECT current_satang_count FROM global_setting) as satang
          FROM backend_member_account WHERE $member_type = $sbo_account_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
    }

    if($data[1]['satang'] == 99){
      $update_satang = 11;
    }else {
      $update_satang = $data[1]['satang'] + 1;
    }

    $sql = "UPDATE global_setting SET current_satang_count = $update_satang";
    $result = $conn->query($sql);
    if ($conn->query($sql) === TRUE) {

    }
    else {
      echo "Error updating record: " . $conn->error;
      exit;
    }

    $member_nickname = $data[1]['member_nickname'];
    $satang = $data[1]['satang'];
    $deposit_amount = (string)$deposit_amount;
    $deposit_amount = $deposit_amount.'.'.(string)$satang;

    if($deposit_type == 46 || $deposit_type == 48){
      $deposit_amount = "NULL";
    }

    $deposit_amount_bonus = 0;
    $deposit_turnover = 0;
    /**if($deposit_type == '58' || $deposit_type == '59' || $deposit_type == '60') {

    }else {
      $deposit_amount_bonus = 0;
      $deposit_turnover = null;
    }**/

    $db_d_amount = floor($deposit_amount);
    $db_d_firstpayment = $deposit_firstpayment_promotion_mark;
    $db_d_nextpayment = $deposit_nextpayment_promotion_mark;
    if($db_d_amount >= 5000){
      if($db_d_firstpayment == 'Yes'){
        $check_turnover = 'Yes';
        $deposit_amount_bonus = $db_d_amount;
        $deposit_turnover = ($deposit_amount_bonus + $db_d_amount) * 8;
        if($deposit_amount_bonus > 1500){
          $deposit_amount_bonus = 1500;
        }
        if($deposit_turnover > 24000){
          $deposit_turnover = 24000;
        }
      }elseif($db_d_nextpayment == 'Yes'){
        $check_turnover = 'Yes';
        if($db_d_amount < 10000){
          $deposit_amount_bonus = 0.05 * $db_d_amount;
          $deposit_turnover =  ($deposit_amount_bonus + $db_d_amount) * 5;
        }elseif($db_d_amount >= 10000){
          $deposit_amount_bonus = 0.1 * $db_d_amount;
          $deposit_turnover =  ($deposit_amount_bonus + $db_d_amount)  * 5;
        }
      }else {
        $check_turnover = 'No';
        $db_d_firstpayment = 'No';
        $db_d_nextpayment = 'No';
      }
      $deposit_amount_bonus = round($deposit_amount_bonus, 2);
      $deposit_turnover = round($deposit_turnover, 2);
    }else {
      if($db_d_firstpayment == 'Yes'){
        $check_turnover = 'Yes';
        $deposit_amount_bonus = $db_d_amount;
        $deposit_turnover = ($deposit_amount_bonus + $db_d_amount) * 8;
        if($deposit_amount_bonus > 1500){
          $deposit_amount_bonus = 1500;
        }
        if($deposit_turnover > 24000){
          $deposit_turnover = 24000;
        }
      }else {
        $check_turnover = 'No';
        $db_d_firstpayment = 'No';
        $db_d_nextpayment = 'No';
      }
    }
    //$member_telephone_1 = $data[1]['member_telephone_1'];

    $sql = "INSERT INTO backend_deposit_money (deposit_account, deposit_nickname, deposit_telephone, deposit_amount,
            deposit_type, deposit_bank_account, deposit_bank_name, deposit_date, deposit_time, deposit_regis, deposit_status_id,
            deposit_bot_tunover_check_mark, deposit_firstpayment_promotion_mark, deposit_nextpayment_promotion_mark, deposit_amount_bonus, deposit_turnover)
            VALUES ('$account', '$member_nickname', '$deposit_telephone', '$deposit_amount', '$deposit_type', '$bank_account', '$bank_name',
            '$date', '$time', '$timeStamp', '1', '$deposit_bot_tunover_check_mark', '$deposit_firstpayment_promotion_mark',
            '$deposit_nextpayment_promotion_mark', '$deposit_amount_bonus', '$deposit_turnover')";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
      $result_data = array(
        "amount" => $deposit_amount,
        "wallet_number" => $bank_account,
        "insert_id" => $last_id,
        "set_status" => "success"
      );
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

  //mysqli_close($conn);

}
else
{
  //echo("Error description: " . mysqli_error($conn));
  //echo "0 results";
  $result_data = array("set_status" => "Error description: " . mysqli_error($conn));
  print json_encode($result_data);
}

mysqli_close($conn);

function get_bank($data_bank, $find_bank, $user_priority){
  $get_bank_name = 0;
  foreach ($data_bank as $value) {
    if($value['bank_name'] == $find_bank){
      $get_bank_name = 1;
      if($value['bank_priority'] == $user_priority){
        $bank_name = $value['bank_name'];
        $bank_account = $value['bank_account_number'];
        break;
      }else {
        $bank_name = $value['bank_name'];
        $bank_account = $value['bank_account_number'];
      }
    }else {
      if($value['bank_priority'] == $user_priority && $get_bank_name != 1){
          $bank_name = $value['bank_name'];
          $bank_account = $value['bank_account_number'];
      }
    }
  }
  $arrayName = array('bank_name' => $bank_name, 'bank_account' => $bank_account);
  return $arrayName;
}
?>
