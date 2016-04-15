<?php
//db
//if ( ! defined( 'ABSPATH' ) ) die( 'Error!' );
date_default_timezone_set("Asia/Bangkok");

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
            curl_setopt($ch, CURLOPT_URL, 'http://www.thaibulksms.com/sms_api.php');
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
$servername = '27.254.86.130';
$username = 'sc';
$password = '27qr9rseGY7C59L8';
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


	?>
