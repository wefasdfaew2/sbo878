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
            }
          }
        }else {
          echo("Error description: " . mysqli_error($conn));
          echo "0 results";
        }

      $sql = "SELECT a.withdraw_status_id,
          COUNT(a.withdraw_account) as withdraw_account_num ,
          (SELECT withdraw_status_name FROM backend_withdraw_status c
           WHERE c.withdraw_status_id=a.withdraw_status_id
          ) as withdraw_status_text
          FROM
          backend_withdraw_money a
          WHERE a.withdraw_account = '$account'";

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

          if($withdraw_status_id == 1 || $withdraw_status_id == 8 || $withdraw_status_id == 9){
            $result_data = array("check_status" => $withdraw_status_text);
          }elseif ($withdraw_status_id == 5) {
            $result_data = array("check_status" => "pass");
          }elseif ($withdraw_status_id == 2 || $withdraw_status_id == 3) {
            $result_data = array("check_status" => "wait_another_withdraw");
          }else{
            $result_data = array("check_status" => "wait_another_withdraw");
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
