<?php
/*
Template Name: point_adduserdata
*/
?>
<?php

$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');

$errors = array();
$data = array();
//sms_thaibulk
     include("php_sms_class/sms_sbobet878.php");
//sms_daifaan
    // include("php_sms_class/sendsms_daifaan.php");
//mail
	 require("php_email_class/class.phpmailer.php");




// Getting posted data and decodeing json
 date_default_timezone_set("Asia/Bangkok");
$_POST = json_decode(file_get_contents('php://input'), true);
  $configs = include('php_db_config/config.php');
  $servername = $configs['servername'];
  $username = $configs['username'];
  $password = $configs['password'];
  $dbname = "test_wordpress";
//check is_complete
 // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset('utf8');
  // Check connection
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }

///con2
$dbname2 = "sbobet878";
  $conn2 = new mysqli($servername, $username, $password, $dbname2);
  $conn2->set_charset('utf8');
  // Check connection
  if ($conn2->connect_error)
  {
      die("Connection failed: " . $conn2->connect_error);
  }
///con3 86.11
  $servername_ip11 = '27.254.86.11';
  $username_ip11 = 'sbobet878';
  $password_ip11 = 'sbobet878password';

 ///con4 86.9
 $servername_ip9 = '27.254.86.9';
  $username_ip9 = 'sbobet878';
  $password_ip9 = 'sbobet878password';
  $dbname_ip9 = "dooballv3";
//check is_complete sbobet878 / sbobet878password
 // Create connection
  $conn_ip9 = new mysqli($servername_ip9, $username_ip9, $password_ip9, $dbname_ip9);
  $conn_ip9->set_charset('utf8');
  // Check connection
  if ($conn_ip9->connect_error)
  {
      die("Connection failed: " . $conn_ip9->connect_error);
  }

/////////////////////////////////////////////////////////case from js
if($_POST['REGIS_FROM']=="userdata_validate"){
//echo $_POST['vusedata'];
//echo $_POST['vtype'];


if(isset($_POST['vusedata']) && isset($_POST['vtype']) && $_POST['vtype']==1){//check email
$esc_vusedata = mysqli_real_escape_string($conn2, $_POST['vusedata']);
$sql_check_userdata_validate = "SELECT count(`member_email`) as db_exist
								FROM `backend_member_account`
								WHERE `member_email`='".$esc_vusedata."'";

$result_check_userdata_validate = $conn2->query($sql_check_userdata_validate);
  if ($result_check_userdata_validate->num_rows > 0){
    while($row = $result_check_userdata_validate->fetch_assoc())
    {
	  $db_exist= $row["db_exist"];
    }
	if(isset($_POST['vusedata']) && isset($_POST['vtype']) && $db_exist >="1"){ //data exist
$data['email_validate'] ='yes'; //bt_disable
	 echo json_encode($data);
}elseif(isset($_POST['vusedata']) && isset($_POST['vtype']) && $db_exist =="0"){
$data['email_validate'] ='no';
	 echo json_encode($data);
}
   }else{
  // echo "userdata_validate not found on db";
   }

}elseif(isset($_POST['vusedata']) && isset($_POST['vtype']) && $_POST['vtype']==2){//check phone
$esc_vusedata = mysqli_real_escape_string($conn2, $_POST['vusedata']);
$sql_check_userdata_validate = "SELECT count(`member_telephone_1`) as db_phone1, count(`member_telephone_2`) as db_phone2
								FROM `backend_member_account`
								WHERE  member_telephone_1='".$esc_vusedata."' or member_telephone_2='".$esc_vusedata."'";
$result_check_userdata_validate = $conn2->query($sql_check_userdata_validate);
  if ($result_check_userdata_validate->num_rows > 0){
    while($row = $result_check_userdata_validate->fetch_assoc())
    {
	  $db_phone1= $row["db_phone1"];
	  $db_phone2= $row["db_phone2"];
    }
   }else{
  // echo "userdata_validate not found on db";
   }
if(isset($_POST['vusedata']) && isset($_POST['vtype']) && $db_phone1 >="1" && $db_phone2 >="1" ){ //data exist
$data['phone_validate'] ='yes';//bt_disable

	 echo json_encode($data);
}elseif(isset($_POST['vusedata']) && isset($_POST['vtype']) && $db_phone1 =="0" && $db_phone2 =="0"){
$data['phone_validate'] ='no';

	 echo json_encode($data);
}

}elseif(isset($_POST['vusedata']) && isset($_POST['vtype']) && $_POST['vtype']==4){
$esc_vusedata = mysqli_real_escape_string($conn2, $_POST['vusedata']);
$sql_check_userdata_validate = "SELECT count(`member_telephone_1`) as db_phone1, count(`member_telephone_2`) as db_phone2
								FROM `backend_member_account`
								WHERE  member_telephone_1='".$esc_vusedata."' or member_telephone_2='".$esc_vusedata."'";
$result_check_userdata_validate = $conn2->query($sql_check_userdata_validate);
  if ($result_check_userdata_validate->num_rows > 0){
    while($row = $result_check_userdata_validate->fetch_assoc())
    {
	  $db_phone1= $row["db_phone1"];
	  $db_phone2= $row["db_phone2"];
    }
   }else{
  // echo "userdata_validate not found on db";
   }
if(isset($_POST['vusedata']) && isset($_POST['vtype']) && $db_phone1 =="1" && $db_phone2 =="1" ){ //data exist

$data['phone_update_validate'] ='yes'; //for vtype=4
	 echo json_encode($data);
}elseif(isset($_POST['vusedata']) && isset($_POST['vtype']) && $db_phone1 =="0" && $db_phone2 =="0"){

$data['phone_update_validate'] ='no';//for vtype=4
	 echo json_encode($data);
}



}elseif(isset($_POST['vusedata']) && isset($_POST['vtype']) && $_POST['vtype']==3){//check phone2
$esc_vusedata = mysqli_real_escape_string($conn2, $_POST['vusedata']);
$sql_check_userdata_validate = "SELECT count(`member_telephone_1`) as db_phone1, count(`member_telephone_2`) as db_phone2
								FROM `backend_member_account`
								WHERE  member_telephone_1='".$esc_vusedata."' or member_telephone_2='".$esc_vusedata."'";
		//echo 	$sql_check_userdata_validate;
$result_check_userdata_validate = $conn2->query($sql_check_userdata_validate);
  if ($result_check_userdata_validate->num_rows > 0){
    while($row = $result_check_userdata_validate->fetch_assoc())
    {
	    $db_phone1= $row["db_phone1"];
	    $db_phone2= $row["db_phone2"];
    }
	//echo $db_phone1.','.$db_phone2;
   }else{
  // echo "userdata_validate not found on db";
   }
if(isset($_POST['vusedata']) && isset($_POST['vtype']) && $esc_vusedata =="" ){
$data['phone_validate2'] ='no';
	 echo json_encode($data);
}elseif(isset($_POST['vusedata']) && isset($_POST['vtype']) && $db_phone1 =="1" && $db_phone2 =="1" ){ //data exist
$data['phone_validate2'] ='yes';//bt_disable
	 echo json_encode($data);
}elseif(isset($_POST['vusedata']) && isset($_POST['vtype']) && $db_phone1 =="0" && $db_phone2 =="0"){
$data['phone_validate2'] ='no';
	 echo json_encode($data);
}

}

}elseif($_POST['REGIS_FROM']=="update_phone_otp"){
 //update user verify success
 $esc_phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
 $esc_ID = mysqli_real_escape_string($conn, $_POST['ID']);
 $sql_update_phone_otp = "UPDATE wp_users SET
    phone_number='".$esc_phone_number."'
	WHERE ID='".$esc_ID."'";
//echo $sql;
if ($conn->query($sql_update_phone_otp) === TRUE) {
	 $data['update_phone_otp'] = 'yes';
	 $data['update_phone_otp_msg'] = 'กรุณารอสักครู่...';
	 echo json_encode($data);
} else {
	//$data['errors']  = "Error: " . $sql_update_phone_otp . "<br>" . $conn->error;
}
$conn->close();





}elseif($_POST['REGIS_FROM']=="otps_renew"){
//send otp again
//select otp_code
 //select otp_code user number
  $esc_ID = mysqli_real_escape_string($conn, $_POST['ID']);
  $esc_ref_otp = mysqli_real_escape_string($conn, $_POST['ref_otp']);

  $sql_check_otps_renew = "SELECT otp_code as otp_code_found
					FROM `user_otp`
					WHERE `ID`='".$esc_ID."' AND `ref_otp_code`= '".$esc_ref_otp."'";

   $result_check_otps_renew = $conn->query($sql_check_otps_renew);
   if ($result_check_otps_renew->num_rows > 0){
    while($row = $result_check_otps_renew->fetch_assoc())
    {
	  $db_otp_code= $row["otp_code_found"];
    }

   }else{
  // echo "ref_otp not found on db";
   }

//send sms to $u_phone_number

	$msisdn_sms = $_POST['phone_number'];
	$message_sms = 'รหัส OTP = '. $db_otp_code .' Ref Code : '.$_POST['ref_otp'];

 	//send_sms($msisdn_sms,$message_sms);
	sendsms($msisdn_sms,$message_sms,2);
 // echo $result_sms;

    //case return bt_renew status
	if($_POST['bt_num']=="1"){
	$data['msg_user_otps_bt_1'] ='yes';
	 echo json_encode($data);
	}elseif($_POST['bt_num']=="2"){
	$data['msg_user_otps_bt_2'] ='yes';
	 echo json_encode($data);
	}



}elseif($_POST['REGIS_FROM']=="otps"){

 //select otp_codes user number
 $esc_ref_otp1 = mysqli_real_escape_string($conn, $_POST['ref_otp1']);
 $esc_ref_otp2 = mysqli_real_escape_string($conn, $_POST['ref_otp2']);
 $esc_ID = mysqli_real_escape_string($conn, $_POST['ID']);
 $sql_check_otps  = " SELECT a.otp_code AS otp1_code_found, b.otp_code AS otp2_code_found
					FROM user_otp a,user_otp b
					WHERE a.ref_otp_code='".$esc_ref_otp1."' AND b.ref_otp_code='".$esc_ref_otp2."'
					AND a.ID='".$esc_ID."'";


   $result_check_otps = $conn->query($sql_check_otps);
   if ($result_check_otps->num_rows > 0){
    while($row = $result_check_otps->fetch_assoc())
    {
	  $db_otp1_code= $row["otp1_code_found"];
	  $db_otp2_code= $row["otp2_code_found"];
    }

	 //beware empty user_otps1
  if(!isset($_POST['user_otps1'])){
 $form_user_otps1="";
 }elseif(isset($_POST['user_otps1'])){
  $form_user_otps1=$_POST['user_otps1'];
 }
  //beware empty user_otps2
  if(!isset($_POST['user_otps2'])){
 $form_user_otps2="";
 }elseif(isset($_POST['user_otps2'])){
  $form_user_otps2=$_POST['user_otps2'];
 }

	if($form_user_otps1==$db_otp1_code && $form_user_otps2 ==$db_otp2_code){//check otp_code from webpage

	 	$data['message_otps1'] ='ถูกต้อง';
		$data['message_otps2'] ='ถูกต้อง';
		$data['message_otps'] ='สำเร็จ กรุณารอสักครู่...';
		$data['otp_status'] ='yes';
    echo json_encode($data);
	}elseif($form_user_otps1==$db_otp1_code && $form_user_otps2 !=$db_otp2_code ){

		$data['message_otps1'] ='ถูกต้อง';

		if($form_user_otps2==""){
			$data['message_otps2'] ='';
			$data['message_otps'] ='สำเร็จ กรุณารอสักครู่...';
			$data['otp_status'] ='yes1';
			}else{
			$data['message_otps2'] ='ไม่ยืนยัน';
			$data['message_otps'] ='โปรดตรวจสอบ หมายเลข OTP ของเบอร์สำรอง';
			$data['otp_status'] ='no';
			}


    echo json_encode($data);
	}elseif($form_user_otps1!=$db_otp1_code && $form_user_otps2 ==$db_otp2_code ){

			if($form_user_otps1==""){
			$data['message_otps1'] ='';
			$data['message_otps'] ='สำเร็จ กรุณารอสักครู่...';
			$data['otp_status'] ='yes2';
			}else{
			$data['message_otps1'] ='ไม่ยืนยัน';
			$data['message_otps'] ='โปรดตรวจสอบ หมายเลข OTP ของเบอร์หลัก';
			$data['otp_status'] ='no';
			}
		$data['message_otps2'] ='ถูกต้อง';

		echo json_encode($data);
	}elseif($form_user_otps1!=$db_otp1_code && $form_user_otps2 !=$db_otp2_code){


	if($form_user_otps1==""){
			$data['message_otps1'] ='';
			}else{
			$data['message_otps1'] ='ไม่ยืนยัน';
			}
	if($form_user_otps2==""){
			$data['message_otps2'] ='';
			}else{
			$data['message_otps2'] ='ไม่ยืนยัน';
			}
		$data['message_otps'] ='โปรดตรวจสอบ หมายเลข OTP';
		$data['otp_status'] ='no';
		echo json_encode($data);
	}


   }else{
  // echo "ref_otp not found on db";
   }


}elseif($_POST['REGIS_FROM']=="otp"){

 //select otp_code user number
 $esc_ID = mysqli_real_escape_string($conn, $_POST['ID']);
 $esc_ref_otp = mysqli_real_escape_string($conn, $_POST['ref_otp']);

  $sql_check_otp = "SELECT otp_code as otp_code_found
					FROM `user_otp`
					WHERE `ID`='".$esc_ID."' AND `ref_otp_code`= '".$esc_ref_otp."'";

   $result_check_otp = $conn->query($sql_check_otp);
   if ($result_check_otp->num_rows > 0){
    while($row = $result_check_otp->fetch_assoc())
    {
	  $db_otp_code= $row["otp_code_found"];
    }
	if($_POST['user_otp1']==$db_otp_code){//check otp_code from webpage
	 //echo "otp_ok match";
	 	$data['message_otp1'] ='สำเร็จ กรุณารอสักครู่...';
		$data['otp_status'] ='yes';
    echo json_encode($data);

	}else{
	// echo "otp_ok wrong from webpage";
	$data['message_otp1'] ='คุณกรอกรหัส OTP ไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง';
    $data['otp_status'] ='no';
    echo json_encode($data);
	}


   }else{
  // echo "ref_otp not found on db";
   }

   //echo $_POST['ID'];
  // echo $_POST['ref_otp'];
  //echo $_POST['user_otp1'];
 //$data['message_bt_otp1'] ='bt_off'; //success then disable button
  //echo json_encode($data);

}elseif($_POST['REGIS_FROM']=="otp_update_verf"){
 //update user verify success case
 $esc_ID = mysqli_real_escape_string($conn, $_POST['ID']);
 $sql_otp_update_verf = "UPDATE wp_users SET
	otp1_verf='1',
	otp2_verf='1'
	WHERE ID='".$esc_ID."'";
if ($conn->query($sql_otp_update_verf) === TRUE) {
	 $data['otp_update_verf_msg'] = true;
} else {
	//$data['errors']  = "Error: " . $sql_otp_update_verf . "<br>" . $conn->error;
}

////use phone case
if($_POST['OTP_VERF_CASE']=="yes1"){
//set empty phone2
 $esc_ID = mysqli_real_escape_string($conn, $_POST['ID']);
 $sql_phone_update_verf = "UPDATE wp_users
						   SET phone_number2=''
						   WHERE ID='".$esc_ID."'";
if ($conn->query($sql_phone_update_verf) === TRUE) {
	 $data['otp_update_verf_msg'] = true;
} else {
	//$data['errors']  = "Error: " . $sql_phone_update_verf . "<br>" . $conn->error;
}
}elseif($_POST['OTP_VERF_CASE']=="yes2"){
//replace phone1 with phone2 and empty phone2
 $esc_ID = mysqli_real_escape_string($conn, $_POST['ID']);
$sql_phone_update_verf = "UPDATE wp_users
						   SET phone_number= phone_number2,phone_number2=''
						   WHERE ID='".$esc_ID."'";
if ($conn->query($sql_phone_update_verf) === TRUE) {
	$data['otp_update_verf_msg'] = true;
} else {
	//$data['errors']  = "Error: " . $sql_phone_update_verf . "<br>" . $conn->error;
}
}


////REGISTER SUCCESS
///set cookie
///if success_otp.COOKIE = 'no' then retrive one from db and increase current_mac_count
if($_POST['COOKIE']=="no"){
$sql_get_cookie = "SELECT current_mac_count
				   FROM global_setting";
$result_get_cookie = $conn2->query($sql_get_cookie);
  if ($result_get_cookie->num_rows > 0){
    while($row = $result_get_cookie->fetch_assoc())
    {
	  $db_get_cookie= $row["current_mac_count"];
    }
  $data['new_cookie'] = 'yes';
  $data['new_cookie_val'] = $db_get_cookie;
    echo json_encode($data);
   }else{
   //echo "current_mac_count not found on db";
   }
//increase current_mac_count
 $db_update_cookie=intval($db_get_cookie)+1;
 $db_update_cookie = str_pad(strval($db_update_cookie), 12, "0", STR_PAD_LEFT);

$sql_update_get_cookie = "UPDATE global_setting
						  SET `current_mac_count`= '".$db_update_cookie."'";
  if ($conn2->query($sql_update_get_cookie) === TRUE) {
	// $data['message'] = 'บันทึกสำเร็จ กรุณารอสักครู่...';
} else {
	//$data['errors']  = "Error: " . $sql_update_get_cookie . "<br>" . $conn2->error;
}

}else{
$db_get_cookie=$_POST['COOKIE'];
 $data['new_cookie'] = 'no';
  //$data['new_cookie_val'] = $db_get_cookie;
    echo json_encode($data);
}


///select sbobet stock then
$m_sbobet_type_id1="0";
$m_sbobet_username="0";
$m_sbobet_password="0";

$m_gclub_type_id2="0";
$m_gclub_username="0";
$m_gclub_password="0";

$m_ibcbet_type_id3="0";
$m_ibcbet_username="0";
$m_ibcbet_password="0";

$m_vegus168_type_id4="0";
$m_vegus168_username="0";
$m_vegus168_password="0";
//decrypt password
$str_api_decrypt='http://decrypt.service/v1/password/';

$sql_select_id_stock ="SELECT sbobet_account_id,sbobet_member_type_id,sbobet_username,sbobet_password
						FROM backend_sbobet_account WHERE sbobet_account_id
						IN (SELECT MIN(sbobet_account_id) FROM backend_sbobet_account WHERE sbobet_status='1' GROUP BY sbobet_member_type_id )
						ORDER BY `backend_sbobet_account`.`sbobet_member_type_id` ASC";
$result_select_id_stock = $conn2->query($sql_select_id_stock);
  if ($result_select_id_stock->num_rows > 0){
    while($row = $result_select_id_stock->fetch_assoc())
    {
	//  `sbobet_username` ,  `sbobet_password`
		if($row["sbobet_member_type_id"]=="1"){
			$m_sbobet_type_id1= $row["sbobet_account_id"];
			$m_sbobet_username=$row["sbobet_username"];
			//decrypt passwd
			$m_sbobet_password=$row["sbobet_password"];
			$json_obj_decrypt = json_decode(file_get_contents($str_api_decrypt.$m_sbobet_password));
				if($json_obj_decrypt->{'status'}=='200'){
					$m_sbobet_password=$json_obj_decrypt->{'plantext'};
				}else{
					echo "obj_decrypt not 200";
				}

		}elseif($row["sbobet_member_type_id"]=="2"){
			$m_gclub_type_id2 = $row["sbobet_account_id"];
			$m_gclub_username=$row["sbobet_username"];
			$m_gclub_password=$row["sbobet_password"];
			$json_obj_decrypt = json_decode(file_get_contents($str_api_decrypt.$m_gclub_password));
				if($json_obj_decrypt->{'status'}=='200'){
					$m_gclub_password=$json_obj_decrypt->{'plantext'};
				}else{
					echo "obj_decrypt not 200";
				}
		}elseif($row["sbobet_member_type_id"]=="3"){
			$m_ibcbet_type_id3=$row["sbobet_account_id"];
			$m_ibcbet_username=$row["sbobet_username"];
			$m_ibcbet_password=$row["sbobet_password"];
			$json_obj_decrypt = json_decode(file_get_contents($str_api_decrypt.$m_ibcbet_password));
				if($json_obj_decrypt->{'status'}=='200'){
					$m_ibcbet_password=$json_obj_decrypt->{'plantext'};
				}else{
					echo "obj_decrypt not 200";
				}
		}elseif($row["sbobet_member_type_id"]=="4"){
			$m_vegus168_type_id4=$row["sbobet_account_id"];
			$m_vegus168_username=$row["sbobet_username"];
			$m_vegus168_password=$row["sbobet_password"];
			$json_obj_decrypt = json_decode(file_get_contents($str_api_decrypt.$m_vegus168_password));
				if($json_obj_decrypt->{'status'}=='200'){
					$m_vegus168_password=$json_obj_decrypt->{'plantext'};
				}else{
					echo "obj_decrypt not 200";
				}
		}
    }
   }else{
   //out of stockid
   //echo "sbobet_account_id not found on db";
   }

// UPDATE db:sbobet878 tb:backend_sbobet_account set sbobet_status=2 on sbobet_account_id that choosed

$sql_update_stock_sbobet_status_id1 = "UPDATE backend_sbobet_account SET `sbobet_status`='2' WHERE `sbobet_account_id`='".$m_sbobet_type_id1."'" ;
if ($conn2->query($sql_update_stock_sbobet_status_id1) === TRUE) {
	//echo "xxx";
} else {
//echo $conn2->error;
	//$data['errors']  = "Error: " . $sql_update_stock_sbobet_status_id1 . "<br>" . $conn2->error;
}

$sql_update_stock_sbobet_status_id2 = "UPDATE backend_sbobet_account SET `sbobet_status`='2' WHERE `sbobet_account_id`='".$m_gclub_type_id2."'";
if ($conn2->query($sql_update_stock_sbobet_status_id2) === TRUE) {
	//echo "xxx";
} else {
//echo $conn2->error;
	$data['errors']  = "Error: " . $sql_update_stock_sbobet_status_id2 . "<br>" . $conn2->error;
}

$sql_update_stock_sbobet_status_id3 = "UPDATE backend_sbobet_account SET `sbobet_status`='2' WHERE `sbobet_account_id`='".$m_ibcbet_type_id3."'";
if ($conn2->query($sql_update_stock_sbobet_status_id3) === TRUE) {
	//echo "xxx";
} else {
//echo $conn2->error;
	//$data['errors']  = "Error: " . $sql_update_stock_sbobet_status_id3 . "<br>" . $conn2->error;
}

$sql_update_stock_sbobet_status_id4 = "UPDATE backend_sbobet_account SET `sbobet_status`='2' WHERE `sbobet_account_id`='".$m_vegus168_type_id4."'";
if ($conn2->query($sql_update_stock_sbobet_status_id4) === TRUE) {
	//echo "xxx";
} else {
//echo $conn2->error;
	//$data['errors']  = "Error: " . $sql_update_stock_sbobet_status_id4 . "<br>" . $conn2->error;
}


///insert/update member db
//1 insert db:sbobet878 tb:backend_member_account
	//1.1 SELECT user data from wordpress
$esc_ID = mysqli_real_escape_string($conn, $_POST['ID']);
$sql_select_user_wp ="SELECT bank_account_name,phone_number,
							phone_number2,user_email,
							bank_number,bank_name,
							user_registered,user_ip
					  FROM wp_users
					  WHERE ID='".$esc_ID."'";
$result_select_user_wp = $conn->query($sql_select_user_wp);
  if ($result_select_user_wp->num_rows > 0){
    while($row = $result_select_user_wp->fetch_assoc())
    {
		 	$m_bank_account_name= $row["bank_account_name"];
			$m_phone_number= $row["phone_number"];
			$m_phone_number2= $row["phone_number2"];
			$m_user_email= $row["user_email"];
			$m_bank_number= $row["bank_number"];
			$m_bank_name= $row["bank_name"];
			$m_user_registered= $row["user_registered"];
			$m_user_ip= $row["user_ip"];


    }
   }else{
  // echo "select_user_wp not found on db";
   }

	//1.2 insert db:sbobet878




	// check refercode from cookie
		$cookie_name = "refercode";
		$refer_val=0;
		if(!isset($_COOKIE[$cookie_name])) {
				$refer_val=0;
				//echo "refer_val= " . $refer_val;
			} else {
				$refer_val=$_COOKIE[$cookie_name];
				//echo "refer_val= " . $refer_val;
			}
$sql_insert_backend_member_account = "INSERT INTO backend_member_account
									(member_sbobet_account_id, member_gclub_account_id,
									member_ibcbet_account_id,member_vegus168_account_id,
									member_nickname,member_telephone_1,
									member_telephone_2,member_email,
									member_bank_account,member_bank_name,
									member_regis,member_message,
									member_type_id,member_status_id,
									member_ip,member_mac_address,
									member_refer_by_id,
                  member_partner_points
									)
									VALUES ('".$m_sbobet_type_id1."','".$m_gclub_type_id2."',
									       '".$m_ibcbet_type_id3."','".$m_vegus168_type_id4."',
										   '".$m_bank_account_name."','".$m_phone_number."',
										   '".$m_phone_number2."','".$m_user_email."',
										   '".$m_bank_number."','".$m_bank_name."',
										   '".$m_user_registered."','',
										   '99','2',
										   '".$m_user_ip."','".$db_get_cookie."',
										   '".$refer_val."','2')";			 
  if ($conn2->query($sql_insert_backend_member_account) === TRUE) {
	// $data['message'] = 'บันทึกสำเร็จ กรุณารอสักครู่...';
} else {
//echo $conn2->error;
	//$data['errors']  = "Error: " . $sql_insert_backend_member_account . "<br>" . $conn2->error;
}
///SET count duplicate cookie
$sql_check_duplicate_cookie = "SELECT count(`member_mac_address`) as db_cookie_exist
								FROM backend_member_account
								WHERE `member_mac_address`= '".$db_get_cookie."'";
$result_check_duplicate_cookie = $conn2->query($sql_check_duplicate_cookie);
  if ($result_check_duplicate_cookie->num_rows > 0){
    while($row = $result_check_duplicate_cookie->fetch_assoc())
    {
	  $db_cookie_exist= $row["db_cookie_exist"];
    }
   }else{
   //echo "db_cookie_exist not found on db";
   }
///if count>1 duplicate cookie then update member_cookie_dup=1
if($db_cookie_exist>1){///if count>1
$sql_update_duplicate_cookie = "UPDATE backend_member_account
								SET `member_status_id`= '4'
								WHERE `member_mac_address`= '".$db_get_cookie."'";

  if ($conn2->query($sql_update_duplicate_cookie) === TRUE) {
	// $data['message'] = 'บันทึกสำเร็จ กรุณารอสักครู่...';
} else {
	//echo $conn2->error;
}
}///if count>1


if($m_sbobet_type_id1 !="0"){ //----------only if m_sbobet_type_id1!=0

//2 insert IP:27.254.86.11 db:direct-torrent tb:users
  $dbname_ip11 = "direct-torrent";
 // Create connection
  $conn_ip11 = new mysqli($servername_ip11, $username_ip11, $password_ip11, $dbname_ip11);
  $conn_ip11->set_charset('utf8');
  // Check connection
  if ($conn_ip11->connect_error)
  {
      die("Connection failed: " . $conn_ip11->connect_error);
  }
$sql_insert_direct_torrent_account = "INSERT INTO users
									(username, password,
									level,email,
									status,title,
									firstname,lastname,
									datecreated,createdip
									)
									VALUES ('".$m_sbobet_username."','".md5($m_sbobet_password)."',
									       '1','".$m_user_email."',
										   '1','Mr',
										   '".$m_bank_account_name."','".$m_bank_account_name."',
										   '".$m_user_registered."','".$m_user_ip."')";
  if ($conn_ip11->query($sql_insert_direct_torrent_account) === TRUE) {
	// $data['message'] = 'บันทึกสำเร็จ กรุณารอสักครู่...';
} else {
//echo $conn_ip11->error;
}
//3 insert IP:27.254.86.11 db:jav-thai tb:users
$dbname_ip11_2 = "jav-thai";
 // Create connection
  $conn_ip11_2 = new mysqli($servername_ip11, $username_ip11, $password_ip11, $dbname_ip11_2);
  $conn_ip11_2->set_charset('utf8');
  // Check connection
  if ($conn_ip11_2->connect_error)
  {
      die("Connection failed: " . $conn_ip11_2->connect_error);
  }
$sql_insert_jav_thai_account = "INSERT INTO users
									(username, password,
									level,email,
									status,title,
									firstname,lastname,
									datecreated,createdip
									)
									VALUES ('".$m_sbobet_username."','".md5($m_sbobet_password)."',
									       '1','".$m_user_email."',
										   '1','Mr',
										   '".$m_bank_account_name."','".$m_bank_account_name."',
										   '".$m_user_registered."','".$m_user_ip."')";
  if ($conn_ip11_2->query($sql_insert_jav_thai_account) === TRUE) {
	// $data['message'] = 'บันทึกสำเร็จ กรุณารอสักครู่...';
} else {
//echo $conn_ip11_2->error;
}
//4 insert IP:27.254.86.9 db:dooballv3 tb:users
$sql_insert_dooballv3_account = "INSERT INTO users
									(username, password,
									level,email,
									status,title,
									firstname,lastname,
									datecreated,createdip
									)
									VALUES ('".$m_sbobet_username."','".md5($m_sbobet_password)."',
									       '1','".$m_user_email."',
										   '1','Mr',
										   '".$m_bank_account_name."','".$m_bank_account_name."',
										   '".$m_user_registered."','".$m_user_ip."')";
  if ($conn_ip9->query($sql_insert_dooballv3_account) === TRUE) {
	// $data['message'] = 'บันทึกสำเร็จ กรุณารอสักครู่...';
} else {
//echo $conn_ip9->error;
}
//5 insert football-hd pending
//https://football-hd.com/rest/api/api.php?cmd=create_user_vip&app_id=BA278MK12BNjdm456zpRtq&login_name=sbo@sbo.com&password=sbobet878&days=1"
file_get_contents("https://football-hd.com/rest/api/api.php?cmd=create_user_vip&app_id=BA278MK12BNjdm456zpRtq&login_name=".$m_user_email."&password=".$m_sbobet_password."&days=1");




}//----------only if m_sbobet_type_id1!=0

/* if id =0 setmessage to user = "we will send later"
$m_sbobet_type_id1="0";
$m_gclub_type_id2="0";
$m_ibcbet_type_id3="0";
$m_vegus168_type_id4="0";
*/

//sendemail
if($m_sbobet_username=="0"){
$m_sbobet_username="จะจัดส่งให้ในภายหลัง";
}
if($m_sbobet_password=="0"){
$m_sbobet_password="จะจัดส่งให้ในภายหลัง";
}

if($m_gclub_username=="0"){
$m_gclub_username="จะจัดส่งให้ในภายหลัง";
}
if($m_gclub_password=="0"){
$m_gclub_password="จะจัดส่งให้ในภายหลัง";
}

if($m_ibcbet_username=="0"){
$m_ibcbet_username="จะจัดส่งให้ในภายหลัง";
}
if($m_ibcbet_password=="0"){
$m_ibcbet_password="จะจัดส่งให้ในภายหลัง";
}

if($m_vegus168_username=="0"){
$m_vegus168_username="จะจัดส่งให้ในภายหลัง";
}
if($m_vegus168_password=="0"){
$m_vegus168_password="จะจัดส่งให้ในภายหลัง";
}


 //must valid sender email
$send_mail_fm = "admin@sbogroup.net";
$send_mail_to = $m_user_email;
//$cc = ";
//$bcc = "";
$send_mail_subj = "ยินดีต้อนรับคุณ ". $m_bank_account_name ." สู่ sbobet878.com"; //<------ subject from user
$send_mail_mesg = "ต่อไปนี้เป็นรายละเอียดบัญชีสำหรับการเข้าเล่นพนัน และบัญชีสำหรับการดูบอล vip, ดูหนัง vip และดาวโหลดหนัง AV กับเว็บไซต์พันธมิตรของเรา". "\xA" ."\xA" .
        "Sbobet.com"."\xA" .
		"user: ". $m_sbobet_username . "\xA" .
        "pass: ". $m_sbobet_password . "\xA" ."\xA" .
		"RoyalGClub.com"."\xA" .
		"user: ". $m_gclub_username . "\xA" .
        "pass: ". $m_gclub_password . "\xA" ."\xA" .
		"Ibcbet.com"."\xA" .
		"user: ". $m_ibcbet_username . "\xA" .
        "pass: ". $m_ibcbet_password . "\xA" ."\xA" .
		"vegus168.com"."\xA" .
		"user: ". $m_vegus168_username . "\xA" .
        "pass: ". $m_vegus168_password . "\xA" ."\xA"."\xA".
		"เว็บไซต์พันธมิตร"."\xA" .
		"http://jav-thai.com:443"."\xA" .
		"user: ". $m_sbobet_username . "\xA" .
        "pass: ". $m_sbobet_password . "\xA" ."\xA".
		"http://direct-torrent.com:443"."\xA" .
		"user: ". $m_sbobet_username . "\xA" .
        "pass: ". $m_sbobet_password . "\xA" ."\xA".
		"http://www.tv2hd.com"."\xA" .
		"user: ". $m_sbobet_username . "\xA" .
        "pass: ". $m_sbobet_password . "\xA" ."\xA" .
		"https://www.football-hd.com"."\xA" .
		"user: ". $m_user_email . "\xA" .
        "pass: ". $m_sbobet_password . "\xA" ."\xA";



$php_mail = new PHPMailer();
$php_mail->CharSet = "utf-8";
$php_mail->IsSMTP();
$php_mail->Mailer = "smtp";
$php_mail->SMTPAuth = true;
//$mail->SMTPSecure = 'ssl'; // Uncomment this line if you want to use SSL.

$php_mail->Host = "in.mailjet.com"; //Enter your SMTPJET account's SMTP server.
$php_mail->Port = "587"; // 8025, 587 and 25 can also be used. Use Port 465 for SSL.
$php_mail->Username = "1698e84d690b09ba76ee8c7e8e0d4370";
$php_mail->Password = "f5e260597d8fb810a0ae7a4eede545dd";
//
//$php_$mail->SetFrom($send_mail_fm, 'SBOBET878 SYSTEM');
$php_mail->From = $send_mail_fm;
$php_mail->AddAddress($send_mail_to);
$php_mail->AddReplyTo($send_mail_fm);
//$mail->AddCC($cc);
//$mail->AddBCC($bcc);
$php_mail->Subject = $send_mail_subj;
$php_mail->Body = $send_mail_mesg;
$php_mail->WordWrap = 500;
//
if(!$php_mail->Send()) {
//echo 'Message was not sent.';
//echo 'ยังไม่สามารถส่งเมลล์ได้ในขณะนี้ ' . $php_mail->ErrorInfo;
exit;
} else {
//echo 'ส่งเมลล์สำเร็จ';
}

///sendsms
//	$msisdn_sms_m = $m_phone_number;
//	$message_sms_m = '++Sbobet878++  ยินดีต้อนรับ ... รายละเอียดจะจัดส่งใน sms ถัดไป';
 //	send_sms($msisdn_sms_m,$message_sms_m);

///sendsms by daifaan
/*  1
$daifaan_sms ='•Sbobet%0Au='.$m_sbobet_username.'%0Ap='.$m_sbobet_password.'%0A%0A•RoyalGClub%0Au='.$m_gclub_username.'%0Ap='.$m_gclub_password.'%0A%0A•Ibcbet%0Au='.$m_ibcbet_username.'%0Ap='.$m_ibcbet_password.'%0A%0A•vegus168%0Au='.$m_vegus168_username.'%0Ap='.$m_vegus168_password;

$daifaan_sms2 ='•jav-thai%0Au='.$m_sbobet_username.'%0Ap='.$m_sbobet_password.'%0A%0A•direct-torrent%0Au='.$m_sbobet_username.'%0Ap='.$m_sbobet_password.'%0A%0A•tv2hd%0Au='.$m_sbobet_username.'%0Ap='.$m_sbobet_password.'%0A%0A•football-hd%0Au='.$m_user_email.'%0Ap='.$m_sbobet_password;
*/

 	 $daifaan_sms ='Sbobet%0Auser='.$m_sbobet_username.'%0Apass='.$m_sbobet_password.'%0A%0Ajav-thai%0Auser='.$m_sbobet_username.'%0Apass='.$m_sbobet_password.'%0A%0Adirect-torrent%0Auser='.$m_sbobet_username.'%0Apass='.$m_sbobet_password.'%0A%0Atv2hd%0Auser='.$m_sbobet_username.'%0Apass='.$m_sbobet_password.'%0A%0Afootball-hd%0Auser='.$m_user_email.'%0Apass='.$m_sbobet_password;

/* 3
$daifaan_sms ='Sbobet%0Auser='.$m_sbobet_username.'%0Apass='.$m_sbobet_password.'%0A%0Ajav-thai%0Auser='.$m_sbobet_username.'%0Apass='.$m_sbobet_password.'%0A%0Adirect-torrent%0Auser='.$m_sbobet_username.'%0Apass='.$m_sbobet_password;

$daifaan_sms2='tv2hd%0Auser='.$m_sbobet_username.'%0Apass='.$m_sbobet_password.'%0A%0Afootball-hd%0Auser='.$m_user_email.'%0Apass='.$m_sbobet_password;
	*/
//$daifaan_sms ='Sbobet%0Auser='.$m_sbobet_username.'%0Apass='.$m_sbobet_password;
		//sendsms($sms_telephone,$sms_message,$sms_flag)
		sendsms($m_phone_number,$daifaan_sms,3);
		 //sendsms($m_phone_number,$daifaan_sms2,3);

	// echo $result_sms;
//call our sms api send detail

}elseif($_POST['REGIS_FROM']=="wp"){///if insert data when wp
 //select max(ID)+1 for user_login
  $sql_max_id = "SELECT `AUTO_INCREMENT`
				FROM  INFORMATION_SCHEMA.TABLES
				WHERE TABLE_SCHEMA = 'test_wordpress'
				AND   TABLE_NAME   = 'wp_users';";
  $result_max_id = $conn->query($sql_max_id);
   if ($result_max_id->num_rows > 0)
  {
    while($row = $result_max_id->fetch_assoc())
    {
	  $id_for_adduser = $row["AUTO_INCREMENT"];
    }
  }

$userdata = array(
    'user_login'  =>  'sbobet878'.$id_for_adduser,
	'user_pass'   =>  'sbobet878'.$id_for_adduser.'878'  // When creating an user, `user_pass` is expected.
);

$user_id = wp_insert_user( $userdata ) ;
//On success
if ( ! is_wp_error( $user_id ) ) {
	//logon
    $creds = array(
        'user_login'    => 'sbobet878'.$id_for_adduser,
        'user_password' => 'sbobet878'.$id_for_adduser.'878',
        'rememember'    => true
    );
//echo "User signon";
$user = wp_signon( $creds, false );

}

 //beware empty phone_number2

 if(!isset($_POST['phone_number2'])){
 $form_phone_number2="";
 }elseif(isset($_POST['phone_number2'])){
  $form_phone_number2=$_POST['phone_number2'];
 }
//update user data from webpage
$esc_bank_account_name = mysqli_real_escape_string($conn, $_POST['bank_account_name']);
$esc_bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
$esc_bank_number = mysqli_real_escape_string($conn, $_POST['bank_number']);
$esc_phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
$esc_form_phone_number2 = mysqli_real_escape_string($conn, $form_phone_number2);
$esc_IP = mysqli_real_escape_string($conn, $_POST['IP']);
$esc_OS = mysqli_real_escape_string($conn, $_POST['OS']);
$esc_DEVICE = mysqli_real_escape_string($conn, $_POST['DEVICE']);
$esc_BROWSER = mysqli_real_escape_string($conn, $_POST['BROWSER']);
$esc_user_email = mysqli_real_escape_string($conn, $_POST['user_email']);


$sql = "UPDATE wp_users SET
	bank_account_name='".$esc_bank_account_name."',
	bank_name='".$esc_bank_name."',
	bank_number='".$esc_bank_number."',
	phone_number='".$esc_phone_number."',
	phone_number2='".$esc_form_phone_number2."',
	user_ip='".$esc_IP."',
	user_os_type='".$esc_OS."',
	user_device_type='".$esc_DEVICE."',
	user_browser_type='".$esc_BROWSER."',
	user_registered='".date("Y-m-d H:i:s")."' ,
	user_email='".$esc_user_email."',
	is_complete=1
	WHERE ID='".$id_for_adduser."'";

if ($conn->query($sql) === TRUE) {
	$data['message'] = 'กรุณารอสักครู่...';
} else {
	//$data['errors']  = "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

echo json_encode($data);
}elseif($_POST['REGIS_FROM']=="social"){///if update data when social login/register

 //beware empty phone_number2
  if(!isset($_POST['phone_number2'])){
 $form_phone_number2="";
 }elseif(isset($_POST['phone_number2'])){
  $form_phone_number2=$_POST['phone_number2'];
 }

 $esc_bank_account_name = mysqli_real_escape_string($conn, $_POST['bank_account_name']);
 $esc_bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
 $esc_bank_number = mysqli_real_escape_string($conn, $_POST['bank_number']);
 $esc_phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
 $esc_form_phone_number2 = mysqli_real_escape_string($conn, $form_phone_number2);
 $esc_IP = mysqli_real_escape_string($conn, $_POST['IP']);
 $esc_OS = mysqli_real_escape_string($conn, $_POST['OS']);
 $esc_DEVICE = mysqli_real_escape_string($conn, $_POST['DEVICE']);
 $esc_BROWSER = mysqli_real_escape_string($conn, $_POST['BROWSER']);
 $esc_ID = mysqli_real_escape_string($conn, $_POST['ID']);

$sql_update_social = "UPDATE wp_users SET
	bank_account_name='".$esc_bank_account_name."',
	bank_name='".$esc_bank_name."',
	bank_number='".$esc_bank_number."',
	phone_number='".$esc_phone_number."',
	phone_number2='".$esc_form_phone_number2."',
	user_ip='".$esc_IP."',
	user_os_type='".$esc_OS."',
	user_device_type='".$esc_DEVICE."',
	user_browser_type='".$esc_BROWSER."',
	user_registered='".date("Y-m-d H:i:s")."' ,
	is_complete=1
	WHERE ID='".$esc_ID."'";


if ($conn->query($sql_update_social) === TRUE) {
	 $data['message'] = 'กรุณารอสักครู่...';
} else {
	//$data['errors']  = "Error: " . $sql_update_social . "<br>" . $conn->error;
}
$conn->close();
echo json_encode($data);
}
?>
