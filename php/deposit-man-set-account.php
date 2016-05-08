<?php

$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');


header('Content-Type: text/html; charset=utf-8');
//include("../php_sms_class/sendsms_daifaan.php");
include("../php_sms_class/sms_sbobet878.php");
$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);

if(!empty($request->username))$account = $request->username;
if(!empty($request->bonus_type))$bonus_type = $request->bonus_type;
if(!empty($request->deposit_amount))$deposit_amount = $request->deposit_amount;
if(!empty($request->bank_number))$bank_number = $request->bank_number;
if(!empty($request->bank_name))$bank_name = $request->bank_name;
if(!empty($request->bank_number_2))$bank_number_2 = $request->bank_number_2;
if(!empty($request->bank_name_2))$bank_name_2 = $request->bank_name_2;
if(!empty($request->bank_number_3))$bank_number_3 = $request->bank_number_3;
if(!empty($request->bank_name_3))$bank_name_3 = $request->bank_name_3;
if(!empty($request->notify_transfer_url))$notify_transfer_url = $request->notify_transfer_url;
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

$sql = "SELECT * FROM backend_bank_account WHERE bank_enable = 'Yes' AND bank_use_onweb = 'Yes' AND bank_priority = '$user_priority'";
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

$bank_name_show = '';
$bank_number_show = '';

foreach ($data_bank as $value) {
  if($bank_name == $value['bank_name'] || $bank_name_2 == $value['bank_name'] || $bank_name_3 == $value['bank_name']){
    $bank_name_show = $value['bank_name'];
    $bank_number_show = $value['bank_account_number'];
    break;
  }else {
    $bank_name_show = $data_bank[0]['bank_name'];
    $bank_number_show = $data_bank[0]['bank_account_number'];
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

    $member_telephone_1 = $data[1]['member_telephone_1'];

    $sql = "INSERT INTO backend_deposit_money (deposit_account, deposit_nickname, deposit_telephone, deposit_amount,
            deposit_bank_account, deposit_bank_name, deposit_status_id,
            deposit_bot_tunover_check_mark, deposit_firstpayment_promotion_mark, deposit_nextpayment_promotion_mark)
            VALUES ('$account', '$member_nickname', '$member_telephone_1', '$deposit_amount', '$bank_number_show', '$bank_name_show',
            '1', '$deposit_bot_tunover_check_mark', '$deposit_firstpayment_promotion_mark',
            '$deposit_nextpayment_promotion_mark')";

    if ($conn->query($sql) === TRUE) {

      $result_data = array(
        "amount" => $deposit_amount,
        "bank_number" => $bank_number_show,
        "bank_name" => $bank_name_show,
        "set_status" => "success");
        print json_encode($result_data);

      //$daifaan_sms = 'กรุณาโอนยอดจำนวน%0A'.$deposit_amount.'%20บาท%0A%0Aไปยังบัญชีเลขที่%0A'.
      //              $bank_number_show.'%0A(ธนาคาร'.$bank_name_show.')%0A%0Aหลังจากโอนเงินเสร็จเรียบร้อย%0A'.
      //              'แล้วกรุณาแจ้งการโอนเงินผ่าน%0Aแบบฟอร์มได้ที่%0A%0A'.$notify_transfer_url;
      $daifaan_sms = 'กรุณาโอนยอดจำนวน%0A'.$deposit_amount.'%20บาท%0A%0Aไปยังบัญชีเลขที่%0A'.
                     $bank_number_show.'%0A(ธนาคาร'.$bank_name_show.')%0A%0Aหลังจากโอนเงินเสร็จแล้ว%0A'.
                     'กรุณาแจ้งโอนเงินที่%0A%0A'.$notify_transfer_url;
        //$daifaan_sms = 'กรุณาโอนยอดจำนวน%0A'.$deposit_amount.'%20บาท';

        
      sendsms($member_telephone_1, $daifaan_sms, 3 );


    } else {
      $result_data = array("set_status" => "fail3");
      print json_encode($result_data);
    }

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
?>
