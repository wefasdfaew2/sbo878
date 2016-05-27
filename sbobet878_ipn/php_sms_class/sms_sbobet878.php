<?php
//db
/*
27.254.86.81
27.254.86.155
27.254.86.156
202.183.231.3
*/
//PLEASE ALLOW only our server ip to reach this page

 //$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
//if($check_direct_access === false)die('Restricted access');



date_default_timezone_set("Asia/Bangkok");



function check_carrier($sms_telephone){
//$sms_telephone=substr_replace($sms_telephone,"+66",0,1);
  $configs = include('../php_db_config/config.php');
  $servername = $configs['servername'];
  $username = $configs['username'];
  $password = $configs['password'];
  $dbname = "sbobet878";
  //check is_complete
 // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset('utf8');
  // Check connection
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }
		$sql_carrier = "SELECT `mobile_carrier`
						FROM `mobile_carrier_lookup`
						WHERE `member_telephone`='".$sms_telephone."'
						ORDER BY  `id`  DESC limit 1
						";

		$result_carrier = $conn->query($sql_carrier);
		  if ($result_carrier->num_rows > 0){
			while($row = $result_carrier->fetch_assoc())
			{
			  $db_carrier= $row["mobile_carrier"];
			}
			}

		return $db_carrier;
}
  // echo sendsms('0832382227','ได้มั๊ย',2);

function sendsms($sms_telephone,$sms_message,$sms_flag){
// 1. ค่ายอื่น ๆ ส่งผ่าน เบอร์ 0952353577 com6 ( เว็บ http://119.160.210.164:9710 )
//2. ทรูส่งผ่านเบอร์ 0957426254 com10 ( เว็บ http://119.160.210.165:9711 )

if($sms_flag==1){
//if $sms_telephone exist in db mobile_carrier_lookup
//if mobile_carrier_lookup=true then SEND BY diafaan
	if(check_carrier($sms_telephone)=='true'){
	 $sms_message_cast = str_replace(' ', '%20', $sms_message);
		send_sms_diafaan($sms_telephone,$sms_message_cast,'9711');
		//echo "send_sms_diafaan";
	}else{//else SEND BY tmtopup
		//send_sms_tmtopup($sms_telephone,$sms_message);
		//echo "send_sms_tmtopup";
    send_sms_thaibulksms($sms_telephone,$sms_message);
	}


}elseif($sms_flag==2){ //if flag=2 is otp then sent auto and thaibluk

	if(check_carrier($sms_telephone)=='true'){
	 $sms_message_cast = str_replace(' ', '%20', $sms_message);
		  send_sms_diafaan($sms_telephone,$sms_message_cast,'9711');

	}else{//else SEND BY tmtopup
		send_sms_tmtopup($sms_telephone,$sms_message);

	}
	//also send thaibluk
	   send_sms_thaibulksms($sms_telephone,$sms_message);

}elseif($sms_flag==3){

if(check_carrier($sms_telephone)=='true'){
		$sms_message_cast = str_replace(' ', '%20', $sms_message);
		 send_sms_diafaan($sms_telephone,$sms_message_cast,'9711');

	}else{
		$sms_message_cast = str_replace(' ', '%20', $sms_message);
		 send_sms_diafaan($sms_telephone,$sms_message_cast,'9710');

	}
}


return 1;
}

function send_sms_tmtopup($sms_telephone,$sms_message){
// กำหนด UID ของท่าน
/*
ตัวแปรที่ใช้ในการส่ง SMS
uid UID ของท่าน
token API Token สำหรับใช้ในการส่ง SMS
msisdn เบอร์โทรศัพท์ผู้รับ 10 หลัก เช่น 0812345678
message ข้อความที่ท่านต้องการ (URL-encode ด้วย rawurlencode)
(ความยาวสูงสุด 70 ตัวอักษร สำหรับภาษาไทย และ 140 ตัวอักษร สำหรับภาษาอังกฤษ)
*/
$UID="152502";
$TOKEN="b6a4eee60ed90d0c5f01842bf50a57b2";
//define('UID', '152502');
// กำหนด API Token ของท่าน
//define('TOKEN', 'b6a4eee60ed90d0c5f01842bf50a57b2');
$postfields = 'uid='.$UID.'&token='.$TOKEN.'&msisdn='.$sms_telephone.'&message='.rawurlencode($sms_message);

$curl = curl_init('https://www.tmtopup.com/sendsms_api.php');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_TIMEOUT, 10);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
$curl_content = curl_exec($curl);
curl_close($curl);
}

function send_sms_diafaan($sms_telephone,$sms_message,$port){
//$sms_telephone=substr_replace($sms_telephone,"+66",0,1);

$host= '119.160.210.164';
//$port= '9710';
$userName= 'admin';
$password= 's4722team24164';
    // Create a TCP/IP socket.
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        return "socket_create() failed: reason: " . socket_strerror(socket_last_error());
    }
    // Make a connection to the Diafaan SMS Server host
    $result = socket_connect($socket, $host, $port);
    if ($result === false) {
        return "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket));
    }
    // Create the HTTP API query string
    $query = '/http/send-message/';
    $query .= '?username='.urlencode($userName);
    $query .= '&password='.urlencode($password);
    $query .= '&to='.urlencode($sms_telephone);
	$query .= '&message-type=sms.automatic';
    $query .= '&message='.$sms_message;
    // Send the HTTP GET request
    $in = "GET ".$query." HTTP/1.1\r\n";
    $in .= "Host: 127.0.0.1\r\n";
    $in .= "Connection: Close\r\n\r\n";
    $out = '';
    socket_write($socket, $in, strlen($in));
    // Get the HTTP response
    $out = '';
    while ($buffer = socket_read($socket, 2048)) {
        $out = $out.$buffer;
    }
    socket_close($socket);
    // Extract the last line of the HTTP response to filter out the HTTP header and get the send result
    $lines = explode("\n", $out);
    return end($lines);
}

function send_sms_thaibulksms($sms_telephone,$sms_message){

            $data = array(
                'username' => '0932531478',
                'password' => '961888',
                'msisdn' => $sms_telephone,
                'message' => $sms_message,
                'sender' => 'SBOBET878',
                'ScheduledDelivery' => '',
                'force' => 'premium'
            );
            $data_string = http_build_query($data);
            $agent = "ThaiBulkSMS API PHP Client";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://www.thaibulksms.com:8081/sms_api.php');
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            $xml_result = curl_exec($ch);
            $code = curl_getinfo($ch);
            curl_close($ch);
            if ($code['http_code'] == 200) {
                $sms_result = new SimpleXMLElement($xml_result);
                if (count($sms_result->QUEUE) > 0) {
                    if ($sms_result->QUEUE[0]->Status == 1) {
           					//success insert db
							$sms_log_type	= '2';
                            $sms_log_from	= 'SBOBET878';
                            $sms_log_to		= $sms_result->QUEUE[0]->Msisdn;
                            $sms_log_msg	= $sms_message;
                            $sms_log_status = '1';
                            $sms_log_transaction	= $sms_result->QUEUE[0]->Transaction;
                            $sms_log_dn_msg	= 'Successfully.';
                            $sms_log_time	= date("Y-m-d H:i:s");
							//'success';
							$status_send_sms=true;

                    } else {//if status error in queue now we have only 1 queue
                          	$sms_log_type	= '2';
                            $sms_log_from	= 'SBOBET878';
                            $sms_log_to		= $sms_result->QUEUE[0]->Msisdn;
                            $sms_log_msg	= $sms_message;
                            $sms_log_status = '0';
                            $sms_log_transaction	= $sms_result->QUEUE[0]->Transaction;
                            $sms_log_dn_msg	= 'sent Error.';
                            $sms_log_time	= date("Y-m-d H:i:s");
							//'send error';
							$status_send_sms=false;
                    }
                }
            } else {//if http error http_code not 200
				    $sms_log_type	=	'2';
                    $sms_log_from	=	'SBOBET878';
                    $sms_log_to		=	$sms_telephone;
                    $sms_log_msg	=	$sms_message;
                    $sms_log_status	=	'0';
                    $sms_log_transaction ='';
                    $sms_log_dn_msg	=	'SMS Gateway Error http_code!=200.';
                    $sms_log_time	= date("Y-m-d H:i:s");
                //'send error';
					$status_send_sms=false;
            }

	//insert db

 $configs = include('../php_db_config/config.php');
  $servername = $configs['servername'];
  $username = $configs['username'];
  $password = $configs['password'];
  $dbname2 = "sbobet878";
$conn2 = new mysqli($servername, $username, $password, $dbname2);
$conn2->set_charset('utf8');
  // Check connection
  if ($conn2->connect_error)
  {
      die("Connection failed: " . $conn2->connect_error);
  }
	$sql_insert_sms_log= "INSERT INTO backend_sms_log
									(sms_log_type, sms_log_from,
									sms_log_to,sms_log_msg,
									sms_log_status,sms_log_transaction,
									sms_log_dn_msg,sms_log_time
									)
									VALUES ('".$sms_log_type."','".$sms_log_from."',
									       '".$sms_log_to."','".$sms_log_msg."',
										   '".$sms_log_status."','".$sms_log_transaction."',
										   '".$sms_log_dn_msg."','".$sms_log_time."')";
  if ($conn2->query($sql_insert_sms_log) === TRUE) {
	// $data['message'] = 'เธเธฑเธเธ—เธถเธเธชเธณเน€เธฃเนเธ เธเธฃเธธเธ“เธฒเธฃเธญเธเธฑเธเธเธฃเธนเน...';
} else {
echo $conn2->error;

}

return $status_send_sms;

}




/////////////////////////////////////////////////
 /*
function send_sms($sms_telephone,$sms_message) {

            $data = array(
                'username' => '0932531478',
                'password' => '961888',
                'msisdn' => $sms_telephone,
                'message' => $sms_message,
                'sender' => 'SBOBET878',
                'ScheduledDelivery' => '',
                'force' => 'premium'
            );
            $data_string = http_build_query($data);
            $agent = "ThaiBulkSMS API PHP Client";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://www.thaibulksms.com:8081/sms_api.php');
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            $xml_result = curl_exec($ch);
            $code = curl_getinfo($ch);
            curl_close($ch);
            if ($code['http_code'] == 200) {
                $sms_result = new SimpleXMLElement($xml_result);
                if (count($sms_result->QUEUE) > 0) {
                    if ($sms_result->QUEUE[0]->Status == 1) {
           					//success insert db
							$sms_log_type	= '2';
                            $sms_log_from	= 'SBOBET878';
                            $sms_log_to		= $sms_result->QUEUE[0]->Msisdn;
                            $sms_log_msg	= $sms_message;
                            $sms_log_status = '1';
                            $sms_log_transaction	= $sms_result->QUEUE[0]->Transaction;
                            $sms_log_dn_msg	= 'Successfully.';
                            $sms_log_time	= date("Y-m-d H:i:s");
							//'success';
							$status_send_sms=true;

                    } else {//if status error in queue now we have only 1 queue
                          	$sms_log_type	= '2';
                            $sms_log_from	= 'SBOBET878';
                            $sms_log_to		= $sms_result->QUEUE[0]->Msisdn;
                            $sms_log_msg	= $sms_message;
                            $sms_log_status = '0';
                            $sms_log_transaction	= $sms_result->QUEUE[0]->Transaction;
                            $sms_log_dn_msg	= 'sent Error.';
                            $sms_log_time	= date("Y-m-d H:i:s");
							//'send error';
							$status_send_sms=false;
                    }
                }
            } else {//if http error http_code not 200
				    $sms_log_type	=	'2';
                    $sms_log_from	=	'SBOBET878';
                    $sms_log_to		=	$sms_telephone;
                    $sms_log_msg	=	$sms_message;
                    $sms_log_status	=	'0';
                    $sms_log_transaction ='';
                    $sms_log_dn_msg	=	'SMS Gateway Error http_code!=200.';
                    $sms_log_time	= date("Y-m-d H:i:s");
                //'send error';
					$status_send_sms=false;
            }

	//insert db

 $configs = include('../php_db_config/config.php');
  $servername = $configs['servername'];
  $username = $configs['username'];
  $password = $configs['password'];
  $dbname2 = "sbobet878";
$conn2 = new mysqli($servername, $username, $password, $dbname2);
$conn2->set_charset('utf8');
  // Check connection
  if ($conn2->connect_error)
  {
      die("Connection failed: " . $conn2->connect_error);
  }
	$sql_insert_sms_log= "INSERT INTO backend_sms_log
									(sms_log_type, sms_log_from,
									sms_log_to,sms_log_msg,
									sms_log_status,sms_log_transaction,
									sms_log_dn_msg,sms_log_time
									)
									VALUES ('".$sms_log_type."','".$sms_log_from."',
									       '".$sms_log_to."','".$sms_log_msg."',
										   '".$sms_log_status."','".$sms_log_transaction."',
										   '".$sms_log_dn_msg."','".$sms_log_time."')";
  if ($conn2->query($sql_insert_sms_log) === TRUE) {
	// $data['message'] = 'เธเธฑเธเธ—เธถเธเธชเธณเน€เธฃเนเธ เธเธฃเธธเธ“เธฒเธฃเธญเธเธฑเธเธเธฃเธนเน...';
} else {
echo $conn2->error;

}

return $status_send_sms;
        }
*/

	?>
