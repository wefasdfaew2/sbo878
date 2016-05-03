<?php

$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');

header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');
include('google-shortener-url-api.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);
//$account = $request->username;
if(!empty($request->username))$account = $request->username;
if(!empty($request->tel))$tel = $request->tel;
//$account = 'zkc8688000';
//$tel = '0617305006';

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
  $sql = "SELECT member_id, member_telephone_1, member_telephone_2, member_refer_url FROM backend_member_account WHERE $member_type = $sbo_account_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
    }
    if($tel == $data[1]['member_telephone_1'] || $tel == $data[1]['member_telephone_2']){
      $member_id = $data[1]['member_id'];
      $data_refer = array();
      if($data[1]['member_refer_url'] == null || $data[1]['member_refer_url'] == ''){
        $key = 'AIzaSyCG7qGLyfF_bEV1YJBVQfQnQcLoHbFwa3A';
        $googer = new GoogleURLAPI($key);
        //$short_url = $googer->shorten("https://sbobet878.com/refer_promo_cookie.php?refercode=".$data[1]['member_id']);
        $short_url = $googer->shorten("http://sbogroup.t-wifi.co.th/wordpress/wp-content/themes/point/php/refer_promo_cookie.php?refercode=".$data[1]['member_id']);

        $sql = "UPDATE backend_member_account SET member_refer_url = '$short_url' WHERE member_id = $member_id";

        if (mysqli_query($conn, $sql)) {

        } else {
            //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

      }else {
        $short_url = $data[1]['member_refer_url'];
      }

      $sql = "SELECT a.promo_refer_transaction_timestamp, promo_refer_transaction_amount, promo_refer_transaction_type,
              (SELECT b.promo_refer_type
                FROM promotion_refer_type b
                WHERE b.promo_refer_id = a.promo_refer_transaction_type) as refer_type,
                (SELECT SUM(promo_refer_transaction_amount)
                  FROM promotion_refer_transaction
                  WHERE promo_refer_transaction_member_id = $member_id
                AND promo_refer_transaction_amount > 0) as current_amount,
                (SELECT SUM(promo_refer_transaction_amount)
                  FROM promotion_refer_transaction
                  WHERE promo_refer_transaction_member_id = $member_id
                ) as can_withdraw,
                (SELECT SUM(promo_refer_transaction_amount)
                  FROM promotion_refer_transaction
                  WHERE promo_refer_transaction_member_id = $member_id
                AND promo_refer_transaction_amount < 0) as withdrawed
              FROM promotion_refer_transaction a
              WHERE a.promo_refer_transaction_member_id = $member_id
              AND a.promo_refer_transaction_amount > 0";

      $result = $conn->query($sql);
      if ($result->num_rows > 0)
      {

        while($row = $result->fetch_assoc())
        {
          $phpdate = strtotime( $row['promo_refer_transaction_timestamp'] );
          $thai_year = date('Y',$phpdate) + 543;
          $row['promo_refer_transaction_timestamp'] = date('d-m-'.$thai_year.' H:i:s', $phpdate);
          if($row['promo_refer_transaction_type'] == 1){
            $row['promo_refer_transaction_type'] = '10%';
          }elseif ($row['promo_refer_transaction_type'] == 2) {
            $row['promo_refer_transaction_type'] = '0.25%';
          }
          $data_refer[] = $row;
        }

        $sql = "SELECT promo_refer_transaction_timestamp, promo_refer_transaction_amount
                FROM promotion_refer_transaction
                WHERE promo_refer_transaction_amount < 0";

                $result = $conn->query($sql);
                if ($result->num_rows > 0)
                {
                  while($row = $result->fetch_assoc())
                  {
                    $phpdate = strtotime( $row['promo_refer_transaction_timestamp'] );
                    $thai_year = date('Y',$phpdate) + 543;
                    $row['promo_refer_transaction_timestamp'] = date('d-m-'.$thai_year.' H:i:s', $phpdate);
                    $data_withdrawed[] = $row;
                  }

                }
                else
                {
                  echo("Error description: " . mysqli_error($conn));
                  echo "0 results";
                }
      }else
      {
        echo("Error description: " . mysqli_error($conn));
        echo "0 results";
      }
      // Test: Expand a URL
      //$longDWName = $googer->expand($shortDWName);
      //echo $longDWName; // returns https://davidwalsh.name

      $result_data = array(
        "check_status" => "pass",
        "short_url" => $short_url,
        "promo_refer_info" => $data_refer,
        "data_withdrawed" => $data_withdrawed);

        //print "<pre>";
        //print_r($result_data);
        //print "</pre>";
      print json_encode($result_data);
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
  $result_data = array("check_status" => $sql);
  print json_encode($result_data);
}

mysqli_close($conn);
?>
