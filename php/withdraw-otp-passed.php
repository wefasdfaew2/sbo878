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

//$sql = "SELECT * FROM channel_category GROUP BY channel_group ORDER BY c_sort";
$sql = "SELECT sbobet_account_id, sbobet_member_type_id FROM backend_sbobet_account WHERE sbobet_username = '$account'";
//$sql = "SELECT channel_group FROM channel_category";
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
  //print json_encode($data);
  $sql = "SELECT * FROM backend_member_account WHERE $member_type = $sbo_account_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
    }

    //$sql = "SELECT COUNT(withdraw_account) FROM backend_withdraw_money WHERE withdraw_account = '$account'";
    //$result = $conn->query($sql);

  //  if ($result->num_rows > 0)
    //{
    //  while($row = $result->fetch_assoc())
    //  {
    //    $numOfAccount[] = $row;
    //  }

      //เช็คว่ามี account อยู่ในตารางหรือยัง
      //echo "string";
      //print_r ($numOfAccount);
      //if($numOfAccount[0]["COUNT(withdraw_account)"] == 0){
      //if(true){

        $withdraw_member_type_id = $data[0]['sbobet_member_type_id'];
        $withdraw_nickname = $data[1]['member_nickname'];
        $withdraw_bank_account = $data[1]['member_bank_account'];
        $withdraw_bank_name = $data[1]['member_bank_name'];

        //$sql = "INSERT INTO backend_withdraw_money (withdraw_member_type_id) VALUES ('1')";
        $sql = "INSERT INTO backend_withdraw_money (withdraw_member_type_id, withdraw_account,
          withdraw_nickname, withdraw_telephone, withdraw_amount, withdraw_bank_account, withdraw_bank_name,
          withdraw_status_id)
          VALUES ('$withdraw_member_type_id', '$account', '$withdraw_nickname', '$tel', '0', '$withdraw_bank_account',
          '$withdraw_bank_name', '8')";

        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            $result_data = array("set_status" => "success", 'insert_id' => $last_id);
        } else {
            $result_data = "Error: " . $sql . "<br>" . $conn->error;
        }
        print json_encode($result_data);
      /*}else {
        $sql = "UPDATE backend_withdraw_money SET withdraw_status_id = '8'
          WHERE withdraw_account = '$account'";

        if ($conn->query($sql) === TRUE) {
            //echo "Record updated successfully";
            $result_data = array("set_status" => "success");
            print json_encode($result_data);
        } else {
            echo "Error updating record: " . $conn->error;
        }
      }*/

    }else{
      echo("Error description: " . mysqli_error($conn));
      echo "0 results";
    }


  //}
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
}

mysqli_close($conn);
?>
