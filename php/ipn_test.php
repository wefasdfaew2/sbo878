<?php
// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// Set this to 0 once you go live or don't require logging.
//$version = curl_version();
//$ssl_supported= ($version['features'] & CURL_VERSION_SSL);
//echo $ssl_supported;
//phpinfo();


header('Content-Type: text/html; charset=utf-8');



include('php_call_api/call-add-credit-api.php');
$configs = include('php_db_config/config.php');


$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";



define("DEBUG", 0);
// Set to 0 once you're ready to go live
define("USE_SANDBOX", 0);
//define("LOG_FILE", "./ipn.log");
// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);
	} else {
		$value = urlencode($value);
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);
	}
	$req .= "&$key=$value";
}
// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data
if(USE_SANDBOX == true) {
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}
$ch = curl_init($paypal_url);
if ($ch == FALSE) {
	return FALSE;
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);

if(DEBUG == true) {
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}
// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.
//$cert = __DIR__ . "./cacert.pem";
//curl_setopt($ch, CURLOPT_CAINFO, $cert);
$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
	{
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch));
	}
	curl_close($ch);
	exit;
} else {
		// Log the entire HTTP response if debug is switched on.
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" );
			error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" );
		}
		curl_close($ch);
}
// Inspect IPN validation result and act accordingly
// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp ($res, "VERIFIED") == 0) {
//if (true) {

	//error_log('VERIFIED');
	// check whether the payment_status is Completed
	// check that txn_id has not been previously processed
	// check that receiver_email is your PayPal email
	// check that payment_amount/payment_currency are correct
	// process payment and mark item as paid.
	// assign posted variables to local variables

  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset("utf8");


  $custom1 = 	$_POST['option_selection2'];//'214-zkc8688000';//
  $custom1String = mysqli_real_escape_string($conn, addslashes($custom1));
  $custom1String = htmlspecialchars($custom1String);


  $payment_amount = $_POST['mc_gross'];
  $payment_amountString = mysqli_real_escape_string($conn, addslashes($payment_amount));
  $payment_amountString = htmlspecialchars($payment_amountString);

  $txn_id = $_POST['txn_id'];
  $txn_idString = mysqli_real_escape_string($conn, addslashes($txn_id));
  $txn_idString = htmlspecialchars($txn_idString);

  $deposit_id = substr($custom1String,0,strpos($custom1String,'-'));
	$deposit_account = substr($custom1String,strpos($custom1String,'-')+1);


  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT deposit_amount, deposit_bank_account, deposit_note, deposit_telephone,
          (SELECT COUNT(deposit_note) FROM backend_deposit_money WHERE deposit_note = 'อ้างอิง txn=$txn_idString') as txn
          FROM backend_deposit_money WHERE deposit_id = $deposit_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
    }

/**error_log($data[0]['deposit_amount']);
error_log($payment_amountString);
error_log($data[0]['txn']);
error_log($deposit_id);
error_log($deposit_account);**/

    $db_txn = substr($data[0]['deposit_note'],strpos($data[0]['deposit_note'],'txn=') + 4);
    if($data[0]['txn'] == 0){

			$sql = "UPDATE backend_deposit_money SET deposit_status_id = 2 WHERE deposit_id = $deposit_id";
			if ($conn->query($sql) === TRUE) {
			    //error_log("deposit_status_id = 2 updated successfully");
					$sql = "UPDATE backend_deposit_money SET deposit_status_id = 4 WHERE deposit_id = $deposit_id";
					if ($conn->query($sql) === TRUE) {
					    //error_log("deposit_status_id = 4 updated successfully");
							$add_res = add_credit($deposit_id,$deposit_account,$data[0]['deposit_bank_account'],$payment_amountString, $data[0]['deposit_telephone']);
							//$result = preg_match("/200/",$add_result);
							//$result = $add_result["status"];
							if($add_res == '200'){
								$sql = "UPDATE backend_deposit_money SET deposit_status_id = 5, deposit_note = 'อ้างอิง txn=$txn_idString' WHERE deposit_id = $deposit_id";
								if ($conn->query($sql) === TRUE) {

									//error_log("update deposit_status_id = 5 and txn successfully");
									//$msisdn_sms_1 = $data[0]['deposit_telephone'];
									//$message_sms_1 = 'เติมเครดิเข้าบัญชี '.$deposit_account.' จำนวน '.$payment_amountString.' บาท สำเร็จแล้ว';
									//$result_sms = sendsms($msisdn_sms_1,$message_sms_1,1);
									//if($result_sms != 1){
									//	error_log('sms not send');
									//}

								}else {
								  error_log("Error updating record1: " . $conn->error);
								}
							}else{
								error_log("add_credit failed.");
							}
					} else {
					    error_log("Error updating record2: " . $conn->error);
					}
			} else {
			    error_log("Error updating record3: " . $conn->error);
			}

    }else {
      error_log('txn already exists or invalid deposit_amount');
    }

  }
  else
  {
    echo("Error description: " . mysqli_error($conn));
    error_log('no results');
    echo "0 results";
  }



	//$item_name = $_POST['item_name'];
	//$item_number = $_POST['item_number'];
	//$payment_status = $_POST['payment_status'];
	//$payment_amount = $_POST['mc_gross'];
	//$payment_currency = $_POST['mc_currency'];
	//$txn_id = $_POST['txn_id'];
	//$receiver_email = $_POST['receiver_email'];
	//$payer_email = $_POST['payer_email'];

	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ");
	}

	mysqli_close($conn);
} else if (strcmp ($res, "INVALID") == 0) {
	// log for manual investigation
	// Add business logic here which deals with invalid IPN messages
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" );
	}
}

/**function add_credit($dp_id,$ac_name,$dest_account,$money){
//call api http://zkc8688_add_value.service/140/zkc868800/<bank account>/100.xx
//echo "http://zkc8688_add_value.service/".$dp_id."/".$ac_name."/".$dest_account."/".$money;
	$res = file_get_contents("http://zkc8688_add_value.service/".$dp_id."/".$ac_name."/".$dest_account."/".$money."");
	return $res;
}**/

?>
