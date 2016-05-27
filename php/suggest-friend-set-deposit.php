<?php

$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');
include('../php_call_api/call-add-credit-api.php');


$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);
//$account = $request->username;
if(!empty($request->username))$account = $request->username;
if(!empty($request->tel))$tel = $request->tel;
if(!empty($request->deposit_amount))$deposit_amount = $request->deposit_amount;
if(!empty($request->date))$date = $request->date;
if(!empty($request->time))$time = $request->time;
if(!empty($request->timeStamp))$timeStamp = $request->timeStamp;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT sbobet_account_id FROM backend_sbobet_account WHERE sbobet_username = '$account'";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
  }
  $member_sbobet_account_id = $data[0]['sbobet_account_id'];
  $sql = "SELECT member_nickname, member_id, member_telephone_1 FROM backend_member_account WHERE member_sbobet_account_id = $member_sbobet_account_id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data2[] = $row;
    }
    $member_nickname = $data2[0]['member_nickname'];
    $member_id = $data2[0]['member_id'];

    $sql = "INSERT INTO backend_deposit_money (deposit_account, deposit_nickname, deposit_telephone, deposit_amount, deposit_amount_bonus, deposit_turnover, deposit_type, deposit_bank_account, deposit_bank_name, deposit_date, deposit_time, deposit_regis, deposit_status_id, deposit_evidence, deposit_current_receive, deposit_note, deposit_bot_tunover_check_mark, deposit_firstpayment_promotion_mark, deposit_nextpayment_promotion_mark)
    VALUES ('$account', '$member_nickname', '$tel', '$deposit_amount', '0', '0', '163', 'promotion', 'refer', '$date', '$time', '$timeStamp', '1', null, null, 'ยอดเงินได้รับฟรีจากโปรโมชั่นแนะนำเพื่อน', 'No', 'No', 'No')";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
      $add_res = add_credit($last_id,$account,'promotion',$deposit_amount, $data2[0]['member_telephone_1']);
      //$result = preg_match("/200/",$add_result);
      //$result = $add_result["status"];
      if($add_res == '200'){
        $sql = "UPDATE backend_deposit_money SET deposit_status_id = '4' WHERE deposit_id = '$last_id'";
        if ($conn->query($sql) === TRUE) {
          $deposit_amount = -1 * abs($deposit_amount);
          $sql = "INSERT INTO promotion_refer_transaction (promo_refer_transaction_member_id, promo_refer_transaction_type, promo_refer_transaction_amount)
          VALUES ('$member_id', '3', '$deposit_amount')";

          if ($conn->query($sql) === TRUE) {
            $result_data = array("insert" => "success");
            print json_encode($result_data);
          }else {
            $result_data = array("insert" => "fail");
            print json_encode($result_data);
          }
        }else {
          $result_data = array("update status 5" => "fail");
          print json_encode($result_data);
        }
      }

    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  else
  {
    echo("Error description: " . mysqli_error($conn));
    echo "0 results";
  }
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
}



mysqli_close($conn);

/*function add_credit($dp_id,$ac_name,$dest_account,$money){
//call api http://zkc8688_add_value.service/140/zkc868800/<bank account>/100.xx
//echo "http://zkc8688_add_value.service/".$dp_id."/".$ac_name."/".$dest_account."/".$money;
	$res = file_get_contents("http://zkc8688_add_value.service/".$dp_id."/".$ac_name."/".$dest_account."/".$money."");
	return $res;
}*/
?>
