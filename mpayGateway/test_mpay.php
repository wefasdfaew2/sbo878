<?php

  header('Content-Type: text/html; charset=utf-8');

  define("DEBUG", 1);

  //echo urldecode('https%3A%2F%2Fsaichon-beauty.ais.co.th%3A8002%2Fpaymentgateway%2FhomePage.do%3Fmode%3Dstart%26numId%3DZU4qd8STMns%253D');
  //echo '<br>';
  $integrityStr = hash('sha256', '+vo6J8Mz7HQEohIFZhrePQ==745045612345SaltTEPS');
  //echo $integrityStr.'<br>';
  $data = array(
    'projectCode' => 'TEPS',
    'command' => 'RequestOrderTepsApi',
    'sid' => '+vo6J8Mz7HQEohIFZhrePQ==',
    'merchantId' => '7450',
    'orderId' => '456',
    'currency' => 'THB',
    'purchaseAmt' => '12345',
    'paymentMethod' => '5',
    'ref1' => 'paymentCode',
    'integrityStr' => $integrityStr
  );

  $data_for_code = array(
    'projectCode' => 'TEPS',
    'command' => 'InquiryApi',
    'merchantId' => '7450',
    'orderId' => '456',
    'purchaseAmt' => '12345',
    'saleId' => '108154',
    'paymentCode' => 'Y',
    'paymentMethodHd' => '5',
    'paymentMethod' => '5',
    'mode' => 'ok'
  );
  /**$projectCode = 'TEPS';
  $command = 'RequestOrderTepsApi';
  $sid = '%2Bvo6J8Mz7HQEohIFZhrePQ%3D%3D';
  $merchantId = '7450';
  $orderId = '456';
  $currency = 'THB';
  $purchaseAmt = '12345';
  $paymentMethod = '5';
  $integrityStr = 'C680604FA22296E17BDC6D9174D4313BBBF74BA1D76EDD447CED77CD1ED36B42';
  $req = "projectCode=$projectCode&command=$command&sid=$sid&merchantId=$merchantId&orderId=$orderId&currency=$currency&purchaseAmt=$purchaseAmt&paymentMethod=$paymentMethod&integrityStr=$integrityStr";
**/
  $post_data = http_build_query($data_for_code);
  $bodysize = strlen(http_build_query($data_for_code));
  $test_api_url = "https://saichon-beauty.ais.co.th:8002/AISMPAYPartnerInterface/InterfaceService?";
  $ch = curl_init($test_api_url);
  if ($ch == FALSE) {
  	return FALSE;
  }

  curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  //curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
  curl_setopt($ch, CURLOPT_SSLVERSION, 4);

  if(DEBUG == true) {
  	curl_setopt($ch, CURLOPT_HEADER, 1);
  	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
  }

  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
  //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', "Content-Length: $bodysize", "Content-Type: application/x-www-form-urlencoded"));



  $res = curl_exec($ch);

  //$info = curl_getinfo($ch);
  //echo '<pre>';
  //print_r ($info);
  //echo '</pre>';

  if (curl_errno($ch) != 0) // cURL error
  	{
  	if(DEBUG == true) {
  		error_log(date('[Y-m-d H:i e] '). "Can't connect to mpay " . curl_error($ch));
  	}
  	curl_close($ch);
  	exit;
  } else {
  		// Log the entire HTTP response if debug is switched on.
  		if(DEBUG == true) {
  			error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" );
  			error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" );
        //echo date('[Y-m-d H:i e] '). "HTTP response of validation request: $res";
  		}
  		curl_close($ch);
  }

  $tokens = explode("\r\n\r\n", trim($res));
  $res = trim(end($tokens));
  $simpleXml = simplexml_load_string($res);
  $json = json_encode($simpleXml);
  $array = json_decode($json,TRUE);
  //echo '<pre>', $json, '</pre>';
  echo '<pre>';
  print_r ($array);
  echo '</pre>';

?>
