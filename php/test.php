<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="Free Web tutorials">
<meta name="keywords" content="HTML,CSS,XML,JavaScript">
<meta name="author" content="Hege Refsnes">
<meta name="referrer" content="origin">
</head>
<body>

<p>All meta information goes in the head section...</p>



<?php

$custom1 = 	'56-zkc8688002';//$_POST['option_selection2'];//'214-zkc8688000';//
$custom1String = mysqli_real_escape_string($conn, addslashes($custom1));
$custom1String = htmlspecialchars($custom1String);


$payment_amount = '530.00';//$_POST['mc_gross'];
$payment_amountString = mysqli_real_escape_string($conn, addslashes($payment_amount));
$payment_amountString = htmlspecialchars($payment_amountString);

$txn_id = '6NW88401L9632242X';//$_POST['txn_id'];
$txn_idString = mysqli_real_escape_string($conn, addslashes($txn_id));
$txn_idString = htmlspecialchars($txn_idString);

$deposit_id = substr($custom1String,0,strpos($custom1String,'-'));
$deposit_account = substr($custom1String,strpos($custom1String,'-')+1);

echo $data[0]['deposit_amount'];
echo $payment_amountString;
echo $data[0]['txn'];
echo $deposit_id;
echo $deposit_account;

header('Content-Type: text/html; charset=utf-8');

function get_ip_address(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
}

$userIP = get_ip_address();

$isp_ip = unserialize(file_get_contents('http://pro.ip-api.com/php/'.$userIP.'?key=utwEtyx2f6XGIFr'.'&fields=region,isp,org,as,reverse,mobile,proxy,query,status,message'));
if($isp_ip && $isp_ip['status'] == 'success') {
$user_org = strtolower($isp_ip['org']);
$user_isp = strtolower($isp_ip['isp']);
$user_reverse = strtolower($isp_ip['reverse']);
//echo $user_ip_provider;
//echo $isp_ip;
echo "<pre>";
print_r($isp_ip);
echo "</pre>";
//$isp_ip['org'] = 'SamnaknganTamruatHaeng';
$check_key_word="/Ministry|Gover|SamnaknganTamruatHaeng|Chat|Leased|Krom|Police|Giver|Department|Court|1222|Royal/i";
foreach ($isp_ip as $key => $value) {
  if (preg_match($check_key_word, $value) == true){
    die('Exit');
  }
}

} else {
$user_isp = "Unable to get isp";
$user_org = "Unable to get org";
$user_reverse = "Unable to get reverse";
 echo 'Unable to get isp';
}



//foreach($_SERVER as $key => $value){
//echo '$_SERVER["'.$key.'"] = '.$value."<br />";//
//}

//echo $_SERVER['HTTP_REFERER'].'<br>';
//echo $_SERVER['SERVER_ADDR'].'<br>';
//echo $_SERVER['REMOTE_ADDR'].'<br>';
//echo getenv('HTTP_HOST');
//include("http://sbogroup.t-wifi.co.th/wordpress/wp-content/themes/point/php_sms_class/sendsms_daifaan.php");

/**$add_result = json_decode('{"status" : "200", "error" : "zzzzzz"}',true);
//$result = preg_match("/200/",$add_result);
$result = $obj->{'status'};

//print_r($add_result);

echo $add_result["status"];
echo $add_result["error"];
echo $add_result[0]->status;
if($add_result == null){
  echo 'abc';
}**/
//echo "<a href='http://sbogroup.t-wifi.co.th/wordpress/wp-content/themes/point/php/test.php'>aaaa</a>";

/**$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($pos===false){
  $pos = strpos($_SERVER['HTTP_REFERER'],'sbolive.asia');
  if($pos===false){
    die('Restricted access1');
  }
}**/

//echo "string";
/**$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO backend_deposit_money (deposit_account)
VALUES ('John')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();**/
//echo $_SERVER['HTTP_X_REQUESTED_WITH'];
//echo 'asdfg';
/**$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT current_satang_count FROM global_setting;";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{

  while($row = $result->fetch_assoc())
  {
    $data[] = $row;

  }
  $deposit_amount = 5500;
  $deposit_amount = (string)$deposit_amount;
  $deposit_amount = $deposit_amount.'.'.(string)$data[0]['current_satang_count'];
  echo $deposit_amount;

  if($data[0]['current_satang_count'] == 99){
    $update_satang = 11;
  }else {
    $update_satang = $data[0]['current_satang_count'] + 1;
  }


  $sql = "UPDATE global_setting SET current_satang_count = $update_satang";
  $result = $conn->query($sql);
  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  }
  else {
    echo "Error updating record: " . $conn->error;
  }
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
  //$result_data = array("set_status" => "Error description: " . mysqli_error($conn));
  //print json_encode($result_data);
}
$conn->close();**/
 ?>
</body>
</html>
