<?php
class sms{
	function send_sms($username,$password,$msisdn,$message,$sender = "THAIBULKSMS",$ScheduledDelivery = "",$force = "standard"){
		$url = "http://www.thaibulksms.com/sms_api.php";
		if(extension_loaded('curl')){
			$data = array(
			'username' => $username,
			'password' => $password,
			'msisdn' => $msisdn,
			'message' => $message,
			'sender' => $sender,
			'ScheduledDelivery' => $ScheduledDelivery,
			'force' => $force);
			$data_string = http_build_query($data);
			
			$agent = "ThaiBulkSMS API PHP Client";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
			$xml_result = curl_exec($ch);
			$code = curl_getinfo($ch);
			curl_close($ch);
			
			if($code['http_code'] == 200){
				if(function_exists('simplexml_load_string')) {
					$sms = new SimpleXMLElement($xml_result);
					$count = count($sms->QUEUE);
					if($count > 0){
						$count_pass = 0;
						$count_fail = 0;
						$used_credit = 0;
						for($i=0;$i<$count;$i++){
							if($sms->QUEUE[$i]->Status){	
								$count_pass++;	
								$used_credit += $sms->QUEUE[$i]->UsedCredit;
							}else{						
								$count_fail++; 
							}
						}
						if($count_pass > 0){
							$msg_string = "สามารถส่งออกได้จำนวน $count_pass หมายเลข, ใช้เครดิตทั้งหมด $used_credit เครดิต";
						} 				
						if($count_fail > 0){
							$msg_string = "ไม่สามารถส่งออกได้จำนวน $count_fail หมายเลข";
						}
					}else{
						$msg_string = "เกิดข้อผิดพลาดในการทำงาน, (".$sms->Detail.")";
					}
					
				}else if(function_exists('xml_parse')){
					$xml = sms::xml2array($xml_result);
					$count = count($xml['SMS']['QUEUE']);
					if($count > 0){
						$count_pass = 0;
						$count_fail = 0;
						$used_credit = 0;
						for($i=0;$i<$count;$i++){
							if($xml['SMS']['QUEUE'][$i]['Status']){	
									$count_pass++;	
									$used_credit += 				
									$xml['SMS']['QUEUE'][$i]['UsedCredit'];
								}else{						
									$count_fail++; 
								}
							}
						if($count_pass > 0){
							$msg_string = "สามารถส่งออกได้จำนวน $count_pass หมายเลข, ใช้เครดิตทั้งหมด $used_credit เครดิต";
						} 				
						if($count_fail > 0){
							$msg_string = "ไม่สามารถส่งออกได้จำนวน $count_fail หมายเลข";
						}
					}else{
						$msg_string = "เกิดข้อผิดพลาดในการทำงาน, (".$xml['SMS']['Detail'].")";
					}
				}else{
					$msg_string = "เกิดข้อผิดพลาดในการทำงาน: <br /> ระบบไม่รองรับฟังก์ชั่น XML";
				}
			}else{
				//$http_codes = parse_ini_file("http_code.ini");
		        //$msg_string = "เกิดข้อผิดพลาดในการทำงาน: <br />" . $code['http_code'] . " " . $http_codes[$code['http_code']];
		        $msg_string = "เกิดข้อผิดพลาดในการทำงาน: <br />" . $code['http_code'];
			}
		
		}else{
			if(function_exists('fsockopen')) {
				$msg_string = $this->sending_fsock($username,$password,$msisdn,$message,$sender,$ScheduledDelivery,$force);
			}else {
				$msg_string = "cURL OR fsockopen is not enabled";
			}
		}
		return $msg_string;
	}
	
	function check_credit($username,$password,$credit_type = "credit_remain"){
		if(extension_loaded('curl')){
			$url = "http://www.thaibulksms.com/sms_api.php";
			$data_string = "username=$username&password=$password&tag=$credit_type";
			
			$agent = "ThaiBulkSMS API PHP Client";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
			$result = curl_exec ($ch);
			$info = curl_getinfo($ch);
			curl_close ($ch);
			
			if($info['http_code'] == 200){
				if(is_numeric($result)){
					$msg_string = "จำนวนเครดิตคงเหลือ ".$result." เครดิต";
				}else{
					$msg_string = $result;
				}
			}else{
				//$http_codes = parse_ini_file("http_code.ini");
		        //$msg_string = "เกิดข้อผิดพลาดในการทำงาน: <br />" . $info['http_code'] . " " . $http_codes[$code['http_code']];
		        $msg_string = "เกิดข้อผิดพลาดในการทำงาน: <br />" . $info['http_code'];
			}
			
		}else if(function_exists('fsockopen')) {
			$result = $this->check_credit_fsock($username,$password,$credit_type);
			if(is_numeric($result)){
				$msg_string = "จำนวนเครดิตคงเหลือ ".$result." เครดิต";
			}else{
				$msg_string = $result;
			}
			
		}else{
			$msg_string = "cURL OR fsockopen is not enabled";
		}
			
		return $msg_string;
	}
	
	function xml2array($url, $get_attributes = 1, $priority = 'tag'){
	    $contents = "";
	    $xml_values = "";
	    if (!function_exists('xml_parser_create'))
	    {
	        return array ();
	    }
	    $parser = xml_parser_create('');
	    if (!($fp = @ fopen($url, 'rb')))
	    {
	        return array ();
	    }
	    while (!feof($fp))
	    {
	        $contents .= fread($fp, 8192);
	    }
	    fclose($fp);
	    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
	    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	    xml_parse_into_struct($parser, trim($contents), $xml_values);
	    xml_parser_free($parser);
	    if (!$xml_values)
	        return; //Hmm...
	    $xml_array = array ();
	    $parents = array ();
	    $opened_tags = array ();
	    $arr = array ();
	    $current = & $xml_array;
	    $repeated_tag_index = array (); 
	    foreach ($xml_values as $data)
	    {
	        unset ($attributes, $value);
	        extract($data);
	        $result = array ();
	        $attributes_data = array ();
	        if (isset ($value))
	        {
	            if ($priority == 'tag')
	                $result = $value;
	            else
	                $result['value'] = $value;
	        }
	        if (isset ($attributes) and $get_attributes)
	        {
	            foreach ($attributes as $attr => $val)
	            {
	                if ($priority == 'tag')
	                    $attributes_data[$attr] = $val;
	                else
	                    $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
	            }
	        }
	        if ($type == "open")
	        { 
	            $parent[$level -1] = & $current;
	            if (!is_array($current) or (!in_array($tag, array_keys($current))))
	            {
	                $current[$tag] = $result;
	                if ($attributes_data)
	                    $current[$tag . '_attr'] = $attributes_data;
	                $repeated_tag_index[$tag . '_' . $level] = 1;
	                $current = & $current[$tag];
	            }
	            else
	            {
	                if (isset ($current[$tag][0]))
	                {
	                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
	                    $repeated_tag_index[$tag . '_' . $level]++;
	                }
	                else
	                { 
	                    $current[$tag] = array (
	                        $current[$tag],
	                        $result
	                    ); 
	                    $repeated_tag_index[$tag . '_' . $level] = 2;
	                    if (isset ($current[$tag . '_attr']))
	                    {
	                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
	                        unset ($current[$tag . '_attr']);
	                    }
	                }
	                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
	                $current = & $current[$tag][$last_item_index];
	            }
	        }
	        elseif ($type == "complete")
	        {
	            if (!isset ($current[$tag]))
	            {
	                $current[$tag] = $result;
	                $repeated_tag_index[$tag . '_' . $level] = 1;
	                if ($priority == 'tag' and $attributes_data)
	                    $current[$tag . '_attr'] = $attributes_data;
	            }
	            else
	            {
	                if (isset ($current[$tag][0]) and is_array($current[$tag]))
	                {
	                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
	                    if ($priority == 'tag' and $get_attributes and $attributes_data)
	                    {
	                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
	                    }
	                    $repeated_tag_index[$tag . '_' . $level]++;
	                }
	                else
	                {
	                    $current[$tag] = array (
	                        $current[$tag],
	                        $result
	                    ); 
	                    $repeated_tag_index[$tag . '_' . $level] = 1;
	                    if ($priority == 'tag' and $get_attributes)
	                    {
	                        if (isset ($current[$tag . '_attr']))
	                        { 
	                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
	                            unset ($current[$tag . '_attr']);
	                        }
	                        if ($attributes_data)
	                        {
	                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
	                        }
	                    }
	                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
	                }
	            }
	        }
	        elseif ($type == 'close')
	        {
	            $current = & $parent[$level -1];
	        }
	    }
	    return ($xml_array);
	}
	
	function sending_fsock($username,$password,$msisdn,$message,$sender,$ScheduledDelivery,$force){
		$url = "www.thaibulksms.com";
		$port = "80";
		$uri = "/sms_api.php";
		$data_string = "username=" . urlencode($username) . "&password=" . urlencode($password) . "&msisdn=" . urlencode($msisdn) . "&message=" . urlencode($message) . "&sender=" . urlencode($sender) . "&ScheduledDelivery=" . urlencode($ScheduledDelivery) . "&force=" . urlencode($force);
		$result = $this->httpPost( $url , $port , $uri, $data_string);
		
		return $result;
	}
	
	function check_credit_fsock($username,$password,$credit_type){
		$url = "www.thaibulksms.com";
		$port = "80";
		$uri = "/sms_api.php";
		$data_string = "username=" . urlencode($username) . "&password=" . urlencode($password) . "&tag=" . urlencode($credit_type);
		$result = $this->httpPost( $url , $port , $uri, $data_string);
		
		return $result;
	}
	
	function httpPost($ip=null,$port=80,$uri=null,$content=null) {
		if (empty($ip))         { return false; }
		if (!is_numeric($port)) { return false; }
		if (empty($uri))        { return false; }
		if (empty($content))    { return false; }
		// generate headers in array.
		$t   = array();
		$t[] = 'POST ' . $uri . ' HTTP/1.1';
		$t[] = 'Content-Type: application/x-www-form-urlencoded';
		$t[] = 'Host: ' . $ip . ':' . $port;
		$t[] = 'Content-Length: ' . strlen($content);
		$t[] = 'Connection: close';
		$t   = implode("\r\n",$t) . "\r\n\r\n" . $content;

		//
		// Open socket, provide error report vars and timeout of 10
		// seconds.
		//
		$fp  = @fsockopen($ip,$port,$errno,$errstr,10);
		// If we don't have a stream resource, abort.
		if (!(get_resource_type($fp) == 'stream')) { return false; }
		//
		// Send headers and content.
		//
		if (!fwrite($fp,$t)) {
			fclose($fp);
			return false;
		}
		//
		// Read all of response into $rsp and close the socket.
		//
		$rsp = '';
		while(!feof($fp)) { $rsp .= fgets($fp,8192); }
		fclose($fp);
		//
		// Call parseHttpResponse() to return the results.
		//
		return $this->parseHttpResponse($rsp);
	}

	//
	// Accepts provided http content, checks for a valid http response,
	// unchunks if needed, returns http content without headers on
	// success, false on any errors.
	//
	function parseHttpResponse($content=null) {
		if (empty($content)) { return false; }
		// split into array, headers and content.
		$hunks = explode("\r\n\r\n",trim($content));
		if (!is_array($hunks) or count($hunks) < 2) {
			return false;
		}
		$header  = $hunks[count($hunks) - 2];
		$body    = $hunks[count($hunks) - 1];
		$headers = explode("\n",$header);
		unset($hunks);
		unset($header);
		if (!$this->validateHttpResponse($headers)) { return false; }
		if (in_array('Transfer-Coding: chunked',$headers)) {
			return trim($this->unchunkHttpResponse($body));
		} else {
			return trim($body);
		}
	}

	//
	// Validate http responses by checking header.  Expects array of
	// headers as argument.  Returns boolean.
	//
	function validateHttpResponse($headers=null) {
		if (!is_array($headers) or count($headers) < 1) { return false; }
		switch(trim(strtolower($headers[0]))) {
			case 'http/1.0 100 ok':
			case 'http/1.0 200 ok':
			case 'http/1.1 100 ok':
			case 'http/1.1 200 ok':
				return true;
				break;
		}
		return false;
	}

	//
	// Unchunk http content.  Returns unchunked content on success,
	// false on any errors...  Borrows from code posted above by
	// jbr at ya-right dot com.
	//
	function unchunkHttpResponse($str=null) {
		if (!is_string($str) or strlen($str) < 1) { return false; }
		$eol = "\r\n";
		$add = strlen($eol);
		$tmp = $str;
		$str = '';
		do {
			$tmp = ltrim($tmp);
			$pos = strpos($tmp, $eol);
			if ($pos === false) { return false; }
			$len = hexdec(substr($tmp,0,$pos));
			if (!is_numeric($len) or $len < 0) { return false; }
			$str .= substr($tmp, ($pos + $add), $len);
			$tmp  = substr($tmp, ($len + $pos + $add));
			$check = trim($tmp);
		} while(!empty($check));
		unset($tmp);
		return $str;
	}
}
?>