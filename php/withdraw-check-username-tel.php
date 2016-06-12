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
$account = $request->username;
if(!empty($request->tel))$tel = $request->tel;


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT sbobet_account_id, sbobet_member_type_id,
  (SELECT sbobet_withdraw_enable FROM global_setting) as sbobet_withdraw_enable,
  (SELECT sbobet_withdraw_enable_by_cc FROM global_setting) as sbobet_withdraw_enable_by_cc
  FROM backend_sbobet_account WHERE sbobet_username = '$account'";
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
    if($data[0]['sbobet_withdraw_enable'] == 'Yes' && $data[0]['sbobet_withdraw_enable_by_cc'] == 'Yes'){
      $withdraw_enable = 'Yes';
    }else {
      $withdraw_enable = 'No';
    }
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
  $sql = "SELECT member_telephone_1, member_telephone_2 FROM backend_member_account WHERE $member_type = $sbo_account_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
      //echo  $row["channel"];
    }

    if($tel == $data[1]['member_telephone_1'] || $tel == $data[1]['member_telephone_2']){

      if($withdraw_enable == 'No'){
        $result_data = array("check_status" => "not_enable");
        print json_encode($result_data);
        exit();
      }
      $sql = "SELECT member_status_id FROM backend_member_account WHERE member_sbobet_account_id
        IN (SELECT sbobet_account_id FROM backend_sbobet_account WHERE sbobet_username = '$account')";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
          while($row = $result->fetch_assoc())
          {
            if($row['member_status_id'] == 4){
              $result_data = array("check_status" => "4");
              print json_encode($result_data);
              exit();
            }elseif ($row['member_status_id'] == 5) {
              $result_data = array("check_status" => "5");
              print json_encode($result_data);
              exit();
            }else {
              $sql = "SELECT COUNT(*) as check_withdraw_24hr,
              (SELECT COUNT(withdraw_account)
              FROM backend_withdraw_money
              WHERE withdraw_account = '$account') as check_first_withdraw
              FROM backend_withdraw_money
              WHERE withdraw_account = '$account'
              AND withdraw_status_id = 4
              AND withdraw_regis <= (NOW() - INTERVAL 1 DAY) ORDER BY withdraw_regis DESC LIMIT 1";
              $result = $conn->query($sql);
              if ($result->num_rows > 0)
              {
                while($row = $result->fetch_assoc())
                {
                  if($row['check_first_withdraw'] > 0){
                    if($row['check_withdraw_24hr'] == '0'){
                      $result_data = array("check_status" => "less_than_24_hours");
                      print json_encode($result_data);
                      exit();
                    }
                  }
                }
              }else {
                echo("Error description: " . mysqli_error($conn));
                echo "Error order 24 hr";
              }
            }
          }
        }else {
          echo("Error description: " . mysqli_error($conn));
          echo "0 results";
        }

      $sql = "SELECT a.withdraw_status_id, a.withdraw_id,
          COUNT(a.withdraw_account) as withdraw_account_num ,
          (SELECT withdraw_status_name FROM backend_withdraw_status c
           WHERE c.withdraw_status_id=a.withdraw_status_id
          ) as withdraw_status_text
          FROM
          backend_withdraw_money a
          WHERE a.withdraw_account = '$account' AND a.withdraw_status_id != 4 AND a.withdraw_status_id != 5";

      $result = $conn->query($sql);

      if ($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          $account_num[] = $row;
        }
        if($account_num[0]['withdraw_account_num'] == '0'){
          $result_data = array("check_status" => "pass");
        }else {
          $withdraw_status_id = $account_num[0]['withdraw_status_id'];
          $withdraw_status_text = $account_num[0]['withdraw_status_text'];

          if($withdraw_status_id == 8 || $withdraw_status_id == 9){
            $result_data = array("check_status" => $withdraw_status_text, 'w_id' => $account_num[0]['withdraw_id'] );
          }elseif ($withdraw_status_id == 5) {
            $result_data = array("check_status" => "pass");
          }elseif ($withdraw_status_id == 1 || $withdraw_status_id == 2 || $withdraw_status_id == 3 || $withdraw_status_id == 7) {
            $result_data = array("check_status" => "wait_another_withdraw", 'w_id' => $account_num[0]['withdraw_id'] );
          }else{
            $result_data = array("check_status" => "wait_another_withdraw", 'w_id' => $account_num[0]['withdraw_id'] );
          }
          //$result_data = array("check_status" => "wait_another_withdraw");
        }
        print json_encode($result_data);

      }
      else
      {
        echo("Error description: " . mysqli_error($conn));
        echo "0 results";
      }

    }else {
      $result_data = array("check_status" => "not pass");
      print json_encode($result_data);
    }

  }
  else
  {
    //echo("Error description: " . mysqli_error($conn));
    //echo "0 results";
    $result_data = array("check_status" => "not pass");
    print json_encode($result_data);
  }

  //mysqli_close($conn);

}
else
{
  //echo("Error description: " . mysqli_error($conn));
  //echo "0 results";
  $result_data = array("check_status" => "not pass");
  print json_encode($result_data);
}

mysqli_close($conn);
?>
