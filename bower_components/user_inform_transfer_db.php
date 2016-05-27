<?php
/*
Template Name: user_inform_trans_db
*/
?>
<?php
//prevent direct access
 //if ( ! defined( 'ABSPATH' ) ) die( 'Error!1' );
$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');
 //prevent direct get data from outsite



//sms_thaibulk
     include("php_sms_class/sms_sbobet878.php");

$errors = array();
$data = array();

// Getting posted data and decodeing json
 date_default_timezone_set("Asia/Bangkok");
$_POST = json_decode(file_get_contents('php://input'), true);
  $configs = include('php_db_config/config.php');
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
///con3 86.11
  $servername_ip11 = '27.254.86.11';
  $username_ip11 = 'sbobet878';
  $password_ip11 = 'sbobet878password';
 $dbname_ip11_direct = "direct-torrent";
  $dbname_ip11_jav = "jav-thai";
 ///con4 86.9
 $servername_ip9 = '27.254.86.9';
  $username_ip9 = 'sbobet878';
  $password_ip9 = 'sbobet878password';
  $dbname_ip9 = "dooballv3";
//check is_complete sbobet878 / sbobet878password
 // Create connection




function get_time_convert($str_time) {

    	$url_cast = urldecode($str_time);
	$time_converted = str_replace('T',' ',$url_cast);

return substr($time_converted,11,11);
}

//post command fillter
 if($_POST['CMD_FROM']=="check_user_pass"){
 $esc_username = mysqli_real_escape_string($conn, $_POST['username']);
 $esc_phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

 //select username
  $sql_check_username = "SELECT `sbobet_account_id`, `sbobet_member_type_id`
						FROM `backend_sbobet_account`
						WHERE  `sbobet_username` ='".$esc_username."'";

  $result_check_username = $conn->query($sql_check_username);
   if ($result_check_username->num_rows > 0){
    while($row = $result_check_username->fetch_assoc())
    {
	  $db_sbobet_account_id= $row["sbobet_account_id"];
	  $db_sbobet_member_type_id= $row["sbobet_member_type_id"];
    }
	 //select on check_member_account registered db
 if($db_sbobet_member_type_id=='1'){
  $sql_check_member_account = "SELECT member_telephone_1,member_telephone_2,member_partner_points,member_id
							FROM `backend_member_account`
							WHERE member_sbobet_account_id='".$db_sbobet_account_id."'";
 }elseif($db_sbobet_member_type_id=='2'){
 $sql_check_member_account = "SELECT member_telephone_1,member_telephone_2,member_partner_points,member_id
						WHERE member_gclub_account_id='".$db_sbobet_account_id."'";
 }elseif($db_sbobet_member_type_id=='3'){
  $sql_check_member_account = "SELECT member_telephone_1,member_telephone_2,member_partner_points,member_id
						WHERE member_ibcbet_account_id='".$db_sbobet_account_id."'";
 }elseif($db_sbobet_member_type_id=='4'){
 $sql_check_member_account = "SELECT member_telephone_1,member_telephone_2,member_partner_points,member_id
						WHERE member_vegus168_account_id='".$db_sbobet_account_id."'";
 }

 $result_check_member_account = $conn->query($sql_check_member_account);

   if ($result_check_member_account->num_rows > 0){
    while($row = $result_check_member_account->fetch_assoc())
    {
	  $db_member_telephone_1= $row["member_telephone_1"];
	  $db_member_telephone_2= $row["member_telephone_2"];
	  $db_member_partner_points= $row["member_partner_points"];
	  $db_member_id= $row["member_id"];


    }
	//return success
	if($esc_phone_number==$db_member_telephone_1 || $esc_phone_number==$db_member_telephone_2 ){
	$data['message'] ='ข้อมูลถูกต้อง กรุณารอสักครู่';
	$data['success'] =true;
	$data['u_name'] =$esc_username;
	$data['u_point'] = $db_member_partner_points;
	$data['u_member_id'] = $db_member_id;

	echo json_encode($data);
	}else{
	$data['message_err'] ='ข้อมูล username หรือ เบอร์โทรไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง';
	$data['success'] =false;

	echo json_encode($data);
	}
	}else{ //not found number
	//return error
	$data['message_err'] ='ข้อมูล username หรือ เบอร์โทรไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง';
	$data['success'] =false;

	echo json_encode($data);
	}
	}else{ //else first select username failed
	//return error
	$data['message_err'] ='ข้อมูล username หรือ เบอร์โทรไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง';
	$data['success'] =false;

	echo json_encode($data);
	}

}elseif($_POST['CMD_FROM']=="check_user_pass2"){ //step2 waiting_inform_list

 $esc_username = mysqli_real_escape_string($conn, $_POST['username']);
  $sql_waiting_inform_list =  "SELECT `deposit_id`,`deposit_amount`,`deposit_bank_account`,
								`deposit_bank_name`,`deposit_firstpayment_promotion_mark`,
								`deposit_nextpayment_promotion_mark`
								FROM `backend_deposit_money`
								WHERE `deposit_account`='".$esc_username."' AND deposit_type IS NULL AND deposit_status_id= '1' ORDER BY deposit_id ";
		//echo $sql_waiting_inform_list;
  $result_waiting_inform_list = $conn->query($sql_waiting_inform_list);
   if ($result_waiting_inform_list->num_rows > 0){
    while($row = $result_waiting_inform_list->fetch_assoc())
    {
	   $db_waiting_inform_list[] = $row;

    }

	//query their bank_accounts
	 //select username
  $sql_bank_accounts = "SELECT `sbobet_account_id`, `sbobet_member_type_id`
						FROM `backend_sbobet_account`
						WHERE  `sbobet_username` ='".$esc_username."'";

	$result_bank_accounts = $conn->query($sql_bank_accounts);
 if ($result_bank_accounts->num_rows > 0){
    while($row = $result_bank_accounts->fetch_assoc())
    {
	  $db_sbobet_account_id= $row["sbobet_account_id"];
	  $db_sbobet_member_type_id= $row["sbobet_member_type_id"];
    }
	 if($db_sbobet_member_type_id=='1'){
		$sql_check_member_account = "SELECT member_bank_account,member_bank_name,
								member_bank_account_2,member_bank_name_2,
								member_bank_account_3,member_bank_name_3,member_nickname
							FROM `backend_member_account`
							WHERE member_sbobet_account_id='".$db_sbobet_account_id."'";
	}elseif($db_sbobet_member_type_id=='2'){
		$sql_check_member_account = "SELECT member_bank_account,member_bank_name,
								member_bank_account_2,member_bank_name_2,
								member_bank_account_3,member_bank_name_3,member_nickname
						WHERE member_gclub_account_id='".$db_sbobet_account_id."'";
	}elseif($db_sbobet_member_type_id=='3'){
		$sql_check_member_account = "SELECT member_bank_account,member_bank_name,
								member_bank_account_2,member_bank_name_2,
								member_bank_account_3,member_bank_name_3,member_nickname
						WHERE member_ibcbet_account_id='".$db_sbobet_account_id."'";
	}elseif($db_sbobet_member_type_id=='4'){
		$sql_check_member_account = "SELECT member_bank_account,member_bank_name,
								member_bank_account_2,member_bank_name_2,
								member_bank_account_3,member_bank_name_3,member_nickname
						WHERE member_vegus168_account_id='".$db_sbobet_account_id."'";
 }

$result_check_member_account = $conn->query($sql_check_member_account);
	  if ($result_check_member_account->num_rows > 0){
    while($row = $result_check_member_account->fetch_assoc())
    {

	  //bank_accounts
	  $db_member_bank_account= $row["member_bank_account"];
	  $db_member_bank_name= $row["member_bank_name"];

	  $db_member_bank_account_2= $row["member_bank_account_2"];
	  $db_member_bank_name_2= $row["member_bank_name_2"];

	  $db_member_bank_account_3= $row["member_bank_account_3"];
	  $db_member_bank_name_3= $row["member_bank_name_3"];

	  $db_member_nickname= $row["member_nickname"];

    }
			$data['u_ba'] =$db_member_bank_account;
			$data['u_bn'] =$db_member_bank_name;
			$data['u_ba2'] =$db_member_bank_account_2;
			$data['u_bn2'] =$db_member_bank_name_2;
			$data['u_ba3'] =$db_member_bank_account_3;
			$data['u_bn3'] =$db_member_bank_name_3;

			$data['u_nn'] =$db_member_nickname;

			$data['num_row'] = $result_waiting_inform_list->num_rows;
			$data['db_waiting_inform_list'] = $db_waiting_inform_list;
			echo json_encode($data);
	}

	}



	}else{//let them og event if empty list

	$db_waiting_inform_list[]=false;
	$data['num_row']=0;
	$data['db_waiting_inform_list'] = $db_waiting_inform_list;
	echo json_encode($data);
}
}elseif($_POST['CMD_FROM']=="user_cancle_id"){
	$esc_user_cancle_id = mysqli_real_escape_string($conn, $_POST['trans_id_num']);

	 $sql_user_cancle_id = "UPDATE backend_deposit_money SET
							deposit_date='".date("Y-m-d")."',
							deposit_time='".date("H:i:s")."',
							deposit_regis='".date("Y-m-d H:i:s")."',
							deposit_status_id='6',
							deposit_note='ยกเลิกโดยสมาชิก',
							deposit_bot_tunover_check_mark='no'
							WHERE deposit_id='".$esc_user_cancle_id."'";
	//'".date("Y-m-d H:i:s")."'
		//echo $sql_waiting_inform_list;
  if ($conn->query($sql_user_cancle_id) === TRUE) {
	 $data['user_cancle_id_success'] = true;
	 echo json_encode($data);
} else {
	$data['user_cancle_id_success'] = false;
	 echo json_encode($data);
	//$data['errors']  = "Error: " . $sql_update_phone_otp . "<br>" . $conn->error;
}


}elseif($_POST['CMD_FROM']=="user_confirm_id"){

	$esc_user_confirm_id = mysqli_real_escape_string($conn, $_POST['trans_id_num']);
	$esc_channel_transf = mysqli_real_escape_string($conn, $_POST['channel_transf']);
	$esc_from_bank_transf = mysqli_real_escape_string($conn, $_POST['from_bank_transf']);
	$esc_u_dt = mysqli_real_escape_string($conn, $_POST['u_dt']);
	$esc_mytime = mysqli_real_escape_string($conn, $_POST['mytime']);

	   $deposit_amount_bonus =0;
	 $deposit_turnover =0;

	//cast esc_from_bank_transf
	$bank_pieces = explode(",", $esc_from_bank_transf);
	$esc_from_bank_transf_number=$bank_pieces[0];
	$esc_from_bank_transf_name=$bank_pieces[1];
	//cast time
	 $esc_mytime = strtotime($esc_mytime);
	 $esc_mytime = date('H:i:s',$esc_mytime);


	 /*
	 echo $esc_user_confirm_id."\n";
	echo $esc_channel_transf."\n";
	echo $esc_from_bank_transf_number."\n";
	echo $esc_from_bank_transf_name."\n";
	echo $esc_u_dt."\n";
	echo $esc_mytime."\n";
	 */
	//retrive deposit_type_id from backend_deposit_type and deposit_type_type=manual
	   $sql_deposit_type = "SELECT deposit_type_id
						FROM `backend_deposit_type`
						WHERE  `deposit_type_name` ='".$esc_from_bank_transf_name."' AND
							   `deposit_type_subtype` =".$esc_channel_transf." AND
								`deposit_type_type`='manual'";

	$result_deposit_type = $conn->query($sql_deposit_type);
 if ($result_deposit_type->num_rows > 0){
    while($row = $result_deposit_type->fetch_assoc())
    {
	  $db_deposit_type_id= $row["deposit_type_id"];
    }
	//update firstpayment_promotion,nextpayment_promotion

	 $sql_deposit_promotion ="SELECT  `deposit_amount`,`deposit_firstpayment_promotion_mark`,`deposit_nextpayment_promotion_mark`
	 FROM `backend_deposit_money`
	 WHERE  `deposit_id`='".$esc_user_confirm_id."'";
	 $result_deposit_promotion = $conn->query($sql_deposit_promotion);
			 if ($result_deposit_promotion->num_rows > 0){
			while($row = $result_deposit_promotion->fetch_assoc())
			{
			  $db_d_amount = $row["deposit_amount"];
			  $db_d_firstpayment = $row["deposit_firstpayment_promotion_mark"];
			  $db_d_nextpayment = $row["deposit_nextpayment_promotion_mark"];

			}
      $db_d_amount = floor($db_d_amount);
      if($db_d_amount >= 5000){
        if($db_d_firstpayment == 'Yes'){
          $check_turnover = 'Yes';
          $deposit_amount_bonus = $db_d_amount;
          $deposit_turnover = ($deposit_amount_bonus + $db_d_amount) * 8;
          if($deposit_amount_bonus > 1500){
            $deposit_amount_bonus = 1500;
          }
          if($deposit_turnover > 24000){
            $deposit_turnover = 24000;
          }
        }elseif($db_d_nextpayment == 'Yes'){
          $check_turnover = 'Yes';
          if($db_d_amount < 10000){
            $deposit_amount_bonus = 0.05 * $db_d_amount;
            $deposit_turnover =  ($deposit_amount_bonus + $db_d_amount) * 5;
          }elseif($db_d_amount >= 10000){
            $deposit_amount_bonus = 0.1 * $db_d_amount;
            $deposit_turnover =  ($deposit_amount_bonus + $db_d_amount)  * 5;
          }
        }else {
          $check_turnover = 'No';
          $db_d_firstpayment = 'No';
          $db_d_nextpayment = 'No';
        }
        $deposit_amount_bonus = round($deposit_amount_bonus, 2);
        $deposit_turnover = round($deposit_turnover, 2);
      }else {
        if($db_d_firstpayment == 'Yes'){
          $check_turnover = 'Yes';
          $deposit_amount_bonus = $db_d_amount;
          $deposit_turnover = ($deposit_amount_bonus + $db_d_amount) * 8;
          if($deposit_amount_bonus > 1500){
            $deposit_amount_bonus = 1500;
          }
          if($deposit_turnover > 24000){
            $deposit_turnover = 24000;
          }
        }else {
          $check_turnover = 'No';
          $db_d_firstpayment = 'No';
          $db_d_nextpayment = 'No';
        }
      }

			}
			//$deposit_amount_bonus =round($deposit_amount_bonus, 2);
			//$deposit_turnover =round($deposit_turnover, 2);


	  // echo $db_d_amount,$db_d_firstpayment,$db_d_nextpayment,$deposit_amount_bonus,$deposit_turnover;
	//then update backend_deposit_money
	 $sql_user_confirm_id = "UPDATE backend_deposit_money SET
							deposit_type='".$db_deposit_type_id."',
							deposit_date='".$esc_u_dt."',
							deposit_time='".$esc_mytime."',
							deposit_regis='".$esc_u_dt." ".$esc_mytime."',
							deposit_status_id='1',
							deposit_note=NULL,
							deposit_bot_tunover_check_mark='Yes',
							deposit_amount_bonus='".$deposit_amount_bonus."',
							deposit_turnover='".$deposit_turnover."',
							deposit_cc_notice='".$esc_from_bank_transf_number."'
							WHERE deposit_id='".$esc_user_confirm_id."'";


		if ($conn->query($sql_user_confirm_id) === TRUE) {
	 $data['user_confirm_id_success'] = true;

	 echo json_encode($data);
	 
	 //sendsms
	 $sql = "SELECT phone, (SELECT COUNT(deposit_type)
			FROM backend_deposit_money
			JOIN backend_deposit_type ON backend_deposit_type.deposit_type_id = backend_deposit_money.deposit_type
			WHERE backend_deposit_type.deposit_type_type = 'manual' AND backend_deposit_money.deposit_status_id = 1 ) as deposit_wait_number
			FROM callcenter_number";

        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
          while($row = $result->fetch_assoc())
          {
            $deposit_wait_number = $row['deposit_wait_number'];
			$cc_phone = $row['phone'];
            $sms_text = "มีรายการแจ้งฝากใหม่%201%20รายการ%20และมีของเดิมค้าง%20$deposit_wait_number%20รายการ";
              sendsms( $cc_phone , $sms_text, 3 ); 
          }
        }else {
          //$result_data = array("set_status" => "Error description: " . mysqli_error($conn));
          //print json_encode($result_data);
        }
	 
	 
} else {
	$data['user_confirm_id_success'] = false;
	 echo json_encode($data);
	//$data['errors']  = "Error: " . $sql_update_phone_otp . "<br>" . $conn->error;
}

	}


}elseif($_POST['CMD_FROM']=="check_user_redeem"){
$esc_username = mysqli_real_escape_string($conn, $_POST['username']);
$esc_user_member_id = mysqli_real_escape_string($conn, $_POST['member_id']);
$esc_p_cb1 = mysqli_real_escape_string($conn, $_POST['p_cb1']);
$esc_p_cb2 = mysqli_real_escape_string($conn, $_POST['p_cb2']);
$esc_p_cb3 = mysqli_real_escape_string($conn, $_POST['p_cb3']);
$esc_p_cb4 = mysqli_real_escape_string($conn, $_POST['p_cb4']);
$esc_u_point =mysqli_real_escape_string($conn, $_POST['u_point']);
 //echo $esc_user_member_id.",".$esc_username.",".$esc_p_cb1.",".$esc_p_cb2.",".$esc_p_cb3.",".$esc_p_cb4.",".$esc_u_point;
 //date_time
 $date = new DateTime();
 $date_add = new DateTime();
 //balance point using
 $sum_using_points = intval($esc_p_cb1)+intval($esc_p_cb2)+intval($esc_p_cb3)+intval($esc_p_cb4);
 $esc_u_point=intval($esc_u_point);
 $points_bl = $esc_u_point-$sum_using_points;


 if($points_bl>=0){
 //do update vip on panther db
 //1 http://jav-thai.com:443 $esc_p_cb1
 if($esc_p_cb1==0){
 $data['confirm_date1_err'] = 'สำเร็จ 0 รายการ';
 }elseif($esc_p_cb1>0){
  //set date point number
    $esc_p_cb1='P'.$esc_p_cb1.'D';
   	$set_cb1_date_interval = new DateInterval($esc_p_cb1);
 //do update
  $conn_ip11 = new mysqli($servername_ip11, $username_ip11, $password_ip11, $dbname_ip11_jav);
  $conn_ip11->set_charset('utf8');
  // Check connection
  if ($conn_ip11->connect_error)
  {
      die("Connection failed: " . $conn_ip11->connect_error);
  }
 //select level
 	   $sql_cb1_level = "SELECT level,paidExpiryDate
						FROM `users`
						WHERE  `username` ='".$esc_username."'";
	$result_cb1_level = $conn_ip11->query($sql_cb1_level);
 if ($result_cb1_level->num_rows > 0){
    while($row = $result_cb1_level->fetch_assoc())
    {
	  $db_cb1_level = $row["level"];
	  $db_cb1_paidExpiryDate = $row["paidExpiryDate"];
    }
	//if level = free user or paid user 'free user', 'paid user
	if($db_cb1_level=="free user"){
	   $date_add->add($set_cb1_date_interval);
	 $sql_cb1_update_vip_date = "UPDATE users SET
							level='paid user',
							lastPayment='".$date->format('Y-m-d H:i:s')."',
							paidExpiryDate='".$date_add->format('Y-m-d H:i:s')."'
							WHERE  `username` ='".$esc_username."'";
	}elseif($db_cb1_level=="paid user"){
	  $date_add_paid = date_create_from_format('Y-m-d H:i:s', $db_cb1_paidExpiryDate);
	  $date_add_paid->add($set_cb1_date_interval);
		 $sql_cb1_update_vip_date = "UPDATE users SET
		 					lastPayment='".$date->format('Y-m-d H:i:s')."',
		 					paidExpiryDate='".$date_add_paid->format('Y-m-d H:i:s')."'
		 					WHERE  `username` ='".$esc_username."'";
	}
	//after fillter then update db
	 if ($conn_ip11->query($sql_cb1_update_vip_date) === TRUE){
		$data['confirm_date1_err'] = 'สำเร็จ 1 รายการ';
	 	}else{
		$data['confirm_date1_err'] = 'update error';

		}
	}

 }

 //2 http://direct-torrent.com:443 $esc_p_cb2
 if($esc_p_cb2==0){
 $data['confirm_date2_err'] = 'สำเร็จ 0 รายการ';
 }elseif($esc_p_cb2>0){
  //set date point number
    $esc_p_cb2='P'.$esc_p_cb2.'D';
   	$set_cb2_date_interval = new DateInterval($esc_p_cb2);
 //do update
  $conn_ip11 = new mysqli($servername_ip11, $username_ip11, $password_ip11, $dbname_ip11_direct);
  $conn_ip11->set_charset('utf8');
  // Check connection
  if ($conn_ip11->connect_error)
  {
      die("Connection failed: " . $conn_ip11->connect_error);
  }
 //select level
 	   $sql_cb2_level = "SELECT level,paidExpiryDate
						FROM `users`
						WHERE  `username` ='".$esc_username."'";
	$result_cb2_level = $conn_ip11->query($sql_cb2_level);
 if ($result_cb2_level->num_rows > 0){
    while($row = $result_cb2_level->fetch_assoc())
    {
	  $db_cb2_level = $row["level"];
	  $db_cb2_paidExpiryDate = $row["paidExpiryDate"];
    }
	//if level = free user or paid user 'free user', 'paid user
	if($db_cb2_level=="free user"){
	   $date_add->add($set_cb2_date_interval);
	 $sql_cb2_update_vip_date = "UPDATE users SET
							level='paid user',
							lastPayment='".$date->format('Y-m-d H:i:s')."',
							paidExpiryDate='".$date_add->format('Y-m-d H:i:s')."'
							WHERE  `username` ='".$esc_username."'";
	}elseif($db_cb2_level=="paid user"){
	  $date_add_paid = date_create_from_format('Y-m-d H:i:s', $db_cb2_paidExpiryDate);
	  $date_add_paid->add($set_cb2_date_interval);
		 $sql_cb2_update_vip_date = "UPDATE users SET
		 					lastPayment='".$date->format('Y-m-d H:i:s')."',
		 					paidExpiryDate='".$date_add_paid->format('Y-m-d H:i:s')."'
		 					WHERE  `username` ='".$esc_username."'";
	}
	//after fillter then update db
	 if ($conn_ip11->query($sql_cb2_update_vip_date) === TRUE){
		$data['confirm_date2_err'] = 'สำเร็จ 1 รายการ';
	 	}else{
		$data['confirm_date2_err'] = 'update error';

		}
	}

 }

 //3 http://www.tv2hd.com $esc_p_cb3
 if($esc_p_cb3==0){
 $data['confirm_date3_err'] = 'สำเร็จ 0 รายการ';
 }elseif($esc_p_cb3>0){
  //set date point number
    $esc_p_cb3='P'.$esc_p_cb3.'D';
   	$set_cb3_date_interval = new DateInterval($esc_p_cb3);
 //do update
 $conn_ip9 = new mysqli($servername_ip9, $username_ip9, $password_ip9, $dbname_ip9);
  $conn_ip9->set_charset('utf8');
  // Check connection
  if ($conn_ip9->connect_error)
  {
      die("Connection failed: " . $conn_ip9->connect_error);
  }
 //select level
 	   $sql_cb3_level = "SELECT level,paidExpiryDate
						FROM `users`
						WHERE  `username` ='".$esc_username."'";
	$result_cb3_level = $conn_ip9->query($sql_cb3_level);
 if ($result_cb3_level->num_rows > 0){
    while($row = $result_cb3_level->fetch_assoc())
    {
	  $db_cb3_level = $row["level"];
	  $db_cb3_paidExpiryDate = $row["paidExpiryDate"];
    }
	//if level = free user or paid user 'free user', 'paid user
	if($db_cb3_level=="free user"){
	   $date_add->add($set_cb3_date_interval);
	 $sql_cb3_update_vip_date = "UPDATE users SET
							level='paid user',
							lastPayment='".$date->format('Y-m-d H:i:s')."',
							paidExpiryDate='".$date_add->format('Y-m-d H:i:s')."'
							WHERE  `username` ='".$esc_username."'";
	}elseif($db_cb3_level=="paid user"){
	  $date_add_paid = date_create_from_format('Y-m-d H:i:s', $db_cb3_paidExpiryDate);
	  $date_add_paid->add($set_cb3_date_interval);
		 $sql_cb3_update_vip_date = "UPDATE users SET
		 					lastPayment='".$date->format('Y-m-d H:i:s')."',
		 					paidExpiryDate='".$date_add_paid->format('Y-m-d H:i:s')."'
		 					WHERE  `username` ='".$esc_username."'";
	}
	//after fillter then update db
	 if ($conn_ip9->query($sql_cb3_update_vip_date) === TRUE){
		$data['confirm_date3_err'] = 'สำเร็จ 1 รายการ';
	 	}else{
		$data['confirm_date3_err'] = 'update error';

		}
	}

 }

 //4 https://www.football-hd.com $esc_p_cb4
   if($esc_p_cb4==0){
 $data['confirm_date4_err'] = 'สำเร็จ 0 รายการ '  ;

 }elseif($esc_p_cb4>20){
 $data['confirm_date4_err'] = 'สำเร็จ 0 รายการ  แลกได้ไม่เกิน 20 คะแนน'  ;

 }elseif($esc_p_cb4>0 && $esc_p_cb4<=20 ){
// get user email
$sql_member_email = "SELECT member_email
						FROM `backend_member_account`
						WHERE  `member_id` ='".$esc_user_member_id."'";

	$result_member_email = $conn->query($sql_member_email);
 if ($result_member_email->num_rows > 0){
    while($row = $result_member_email->fetch_assoc())
    {
	  $db_member_email = $row["member_email"];
    }

//do add
 // https://football-hd.com/rest/api/api.php?cmd=add_points&app_id=A2278MK12BNjdm456zpRtq&login_name=tong_test4@gmail.com&points=50
//points=1-1000 from sbobet878 must point=point*50
$esc_p_cb4 = intval($esc_p_cb4)*50;

file_get_contents("https://football-hd.com/rest/api/api.php?cmd=add_points&app_id=BA278MK12BNjdm456zpRtq&login_name=".$db_member_email."&points=".$esc_p_cb4);

//echo $f_hd_api;
$data['confirm_date4_err'] = 'สำเร็จ 1 รายการ';

}else{
 $data['confirm_date4_err'] = 'สำเร็จ 0 รายการ '  ;
 }
 }



 // update sum_point backend_member_account

  //balance point using revise again if update faied not count
 //$sum_using_points = intval($esc_p_cb1)+intval($esc_p_cb2)+intval($esc_p_cb3)+intval($esc_p_cb4);
 //echo $sum_using_points;
 //$esc_u_point=intval($esc_u_point);
 //$points_bl = $esc_u_point-$sum_using_points;

$sql_member_points = "UPDATE backend_member_account SET
							member_partner_points='".$points_bl."'
							WHERE  `member_id` ='".$esc_user_member_id."'";
 if ($conn->query($sql_member_points) === TRUE){
	$data['u_point'] = $points_bl;
	$data['success'] =true;
	$data['confirm_message_err'] = 'แต้มคงเหลือ '.$points_bl.' แต้ม';
	 	}else{
		$data['confirm_message_err'] = 'update member_points error';
		}
 //echo $sql_member_points;
 echo json_encode($data);
 }else{
 //return not enough
 $data['confirm_message_err'] = 'poin not enough';
 }



}//end $_POST['CMD_FROM']


?>
