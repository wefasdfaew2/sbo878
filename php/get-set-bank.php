<?php


$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');

header('Content-Type: text/html; charset=utf-8');
include("../php_sms_class/sendsms_daifaan.php");
$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);

if(!empty($request->username)){
  $account = $request->username;
}
if (!empty($request->option)) {
  $option = $request->option;
}
if (!empty($request->bank_number_2)) {
  $bank_number_2 = $request->bank_number_2;
}
if (!empty($request->bank_number_3)) {
  $bank_number_3 = $request->bank_number_3;
}
if (!empty($request->bank_name_2)) {
  $bank_name_2 = $request->bank_name_2;
}
if (!empty($request->bank_name_3)) {
  $bank_name_3 = $request->bank_name_3;
}
if (!empty($request->otp_ref_num)) {
  $otp_ref_num = $request->otp_ref_num;
}
if (!empty($request->otp)) {
  $otp = $request->otp;
}
if (!empty($request->tel)) {
  $tel = $request->tel;
}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

if($option == 'get'){
    $sql = "SELECT sbobet_member_type_id, sbobet_account_id
            FROM backend_sbobet_account
            WHERE sbobet_username = '$account'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
        $data[] = $row;
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

      $sql = "SELECT member_bank_name, member_bank_name_2, member_bank_name_3,
              member_bank_account, member_bank_account_2, member_bank_account_3,
              member_nickname, member_telephone_1
              FROM backend_member_account
              WHERE $member_type = $sbo_account_id";
      $result = $conn->query($sql);

      if ($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          $result_data[] = $row;
        }
          print json_encode($result_data);
      }else {
          $result_data = array("is_account" => "no_account");
          print json_encode($result_data);
      }
    }
    else
    {
      $result_data = array("is_account" => "no_account");
      print json_encode($result_data);
    }
}else if($option == 'set'){
  $sql = "SELECT sbobet_member_type_id, sbobet_account_id
          FROM backend_sbobet_account
          WHERE sbobet_username = '$account'";

  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
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

    $sql = "UPDATE backend_member_account SET
            member_bank_name_2 = '$bank_name_2',
            member_bank_name_3 = '$bank_name_3',
            member_bank_account_2 = '$bank_number_2',
            member_bank_account_3 = '$bank_number_3'
            WHERE $member_type = $sbo_account_id";
    $result = $conn->query($sql);

    if ($conn->query($sql) === TRUE)
    {
      $result_data = array("update_bank" => "success");
      print json_encode($result_data);
    }else {
        $result_data = array("update_bank" => "fail");
        print json_encode($result_data);
    }
  }
  else
  {
    $result_data = array("is_account" => "no_account");
    print json_encode($result_data);
  }
}elseif ($option == 'gen_otp') {
  $otp = generateRandom_otp_code(6);
  $otp_ref = generateRandom_otp_ref_code(5);
  //$sql = "SELECT * FROM channel_category GROUP BY channel_group ORDER BY c_sort";
  $sql = "INSERT INTO backend_addbank_otp (addbank_username, addbank_otp, addbank_otp_ref)
          VALUES ('$account', '$otp', '$otp_ref')";

  if ($conn->query($sql) === TRUE) {

    $daifaan_sms = 'รหัส%20OTP%20=%20'.$otp.'%20Ref%20Code%20:%20'.$otp_ref;
    SendMessage_daifaan($tel, $daifaan_sms );

      $result_data = array("otp_ref" => "$otp_ref");
  } else {
      //$result_data = "Error: " . $sql . "<br>" . $conn->error;
      $result_data = array("otp_ref" => "error");
  }

  print json_encode($result_data);
  //$conn->close();
}elseif ($option == 'check_otp') {
  $sql = "SELECT addbank_otp FROM backend_addbank_otp WHERE addbank_username = '$account' AND addbank_otp_ref = '$otp_ref_num'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
    }
    //print_r ($data);
    if($data[0]['addbank_otp'] == $otp){
      $result_data = array("check_otp_status" => "pass");
    }else{
      $result_data = array("check_otp_status" => "not_pass");
    }
    print json_encode($result_data);
  } else {
      echo "0 results";
  }
  //$conn->close();
}elseif($option == 'get_bank'){
    $sql = "SELECT sbobet_member_type_id, sbobet_account_id
            FROM backend_sbobet_account
            WHERE sbobet_username = '$account'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
        $data[] = $row;
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

      $sql = "SELECT member_bank_name, member_bank_name_2, member_bank_name_3,
              member_bank_account, member_bank_account_2, member_bank_account_3,
              member_nickname
              FROM backend_member_account
              WHERE $member_type = $sbo_account_id";
      $result = $conn->query($sql);

      if ($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          $result_data[] = $row;
        }

          print json_encode($result_data);
      }else {
          $result_data = array("is_account" => "no_account");
          print json_encode($result_data);
      }
    }
    else
    {
      $result_data = array("is_account" => "no_account");
      print json_encode($result_data);
    }
}


$conn->close();

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
