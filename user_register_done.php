<?php
/*
Template Name: user_register_done
*/
?>
<?php get_header();?>
<div id="page" class="single">
 <div class="content">
  <div  ng-app="max_MyApp" ng-controller="max_user_detail" ng-cloak="">
<?php
/// mysql connection
 $configs = include('php_db_config/config.php');
  $servername = $configs['servername'];
  $username = $configs['username'];
  $password = $configs['password'];
  $dbname = "test_wordpress";
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset('utf8');
  // Check connection
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }
   //// otp authen
function generateRandom_otp_code($length) {
    $characters = '123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateRandom_otp_ref_code($length) {
    $characters = '123456789abcdefghijklmnpqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//check is user complete otp verify
   $sql_otp_verf = "SELECT phone_number,phone_number2,otp1_verf,otp2_verf FROM  wp_users WHERE is_complete=1 AND ID='".$current_user->ID."'";
  
  $result_otp_verf = $conn->query($sql_otp_verf);
  if ($result_otp_verf->num_rows > 0)
  {
    while($row = $result_otp_verf->fetch_assoc())
    {
	$u_phone_number = $row["phone_number"];
	$u_phone_number2 = $row["phone_number2"];
	$u_otp1_verf =  $row["otp1_verf"];
	$u_otp2_verf = $row["otp2_verf"];
    }
 	
 }
  //case otp_verify check
  if($u_otp1_verf==1 && $u_otp2_verf==1 ){
  //user verify completed
  echo "hit verify DONE";
   $otp_verify_completed=1;
  }elseif(strlen($u_phone_number2)>0){
 //so we verify both  phone_number,phone_number2
 //echo "hit verify both";
 $otp_html_no_form=2;
 //draw otp1,otp2 form
	
 //update_db otp_verify_completed status
 /*
 $sql_set_otp = "UPDATE wp_users SET 
	otp1_verf='1',
	otp2_verf='1'
	WHERE ID='".$current_user->ID."'";
//echo $sql;
if ($conn->query($sql_set_otp) === TRUE) {
	// $data['message'] = 'บันทึกสำเร็จ.. ระบบกำลังนำคุณไปหน้าหลัก';
} else {
	$data['errors']  = "Error: " . $sql_set_otp . "<br>" . $conn->error;
}
*/
//echo json_encode($data);
 //set otp_verify_completed status
 //$otp_verify_completed=1;
 
 }elseif(strlen($u_phone_number2)==0){
 //so we verify only phone_number
 //echo "hit verify one";
	$otp_html_no_form=1;
	//$otp_verify_completed=0;
 } 
$otp_verify_completed=0;

?>

 <div id="page" class="single">
 <div class="content">
<div  ng-app="max_MyApp" ng-controller="max_user_detail" ng-cloak="">
<div layout="row"   layout-align="space-around center">
  <div flex>
 <h3 class="frontTitle">สมัครสมาชิก</h3>
  </div>
 
 </div>
 
  <div layout="row" layout-align="center center">
   <pre>
        <div flex>
		<?php
		if($otp_verify_completed==0){
 echo '<img ng-src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/BarAPP2.png" alt="sbobet878" class="img-responsive center-block" >';
		}elseif($otp_verify_completed==1){
 echo '<img ng-src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/BarAPP3.png" alt="sbobet878" class="img-responsive center-block" >';
		}
		?>
  </div>
หลังจากสมัครเสร็จแล้วท่านสมาชิกจะได้รับ Account สำหรับการแทงในเว็บ sbobet, vegus168, ibcbet และ royal Gclub ทางอีเมลล์และ SMS ที่ท่านได้ลงทะเบียนไว้
 </pre>
 </div>
  <?php
  //if $otp_verify_completed=1 then show data and add user to another services
  if($otp_verify_completed==1 && $current_user->ID >0){
  $sql_query = "SELECT phone_number,phone_number2,user_email FROM  wp_users WHERE is_complete=1 AND ID='".$current_user->ID."'";
     
  if($current_user->ID!='0'){ 
  $result = $conn->query($sql_query);
 }else{
 exit;
 }
  if ($result->num_rows > 0)
  {
  echo '<div layout="row" layout-align="center center">';
echo '<table   style="width:40%">';
    while($row = $result->fetch_assoc())
    {
	  echo "<tr>"."<td>หมายเลขโทรศัพท์ </td>" ."<td>". $row["phone_number"] . "</td></tr>";
	  echo "<tr>"."<td></td>". "<td>".$row["phone_number2"]. "</td></tr>";
	  echo "<tr>"."<td>อีเมลล์</td>" . "<td>" . $row["user_email"] . "</td></tr>";
	//draw user data
    }
 echo '</table>';
 echo '</div>';
  }
  echo '
    <div layout="row" layout-align="center center">
  หลังจากท่านสมาชิกได้รับ Account แล้วท่านสมาชิกสามารถเติมเครดิตได้ทันที --ทีนี่-- หรือศึกษาวิธีการแทงบอล/เล่นพนันได้ --ที่นี่-- 
  </div>
  <div layout="row" layout-align="center center" style="color:red;font-weight: bold;">
  หากพบปัญหาใดๆ อย่าเพิกเฉย กรุณาติดต่อทีมงานทันที เรามีความยินดีให้ความช่วยเหลือท่านสมาชิกตลอด24 ชั่วโมงทุกวัน
</div>
</br>';
  }elseif($otp_verify_completed==0 && $current_user->ID >0){//end $otp_verify_completed== 
  if($otp_html_no_form==1){
  
 $otp_ref_code = generateRandom_otp_ref_code(4);
   $otp_code = generateRandom_otp_code(4);
   
  //insert db
  $sql_insert_otp_1 = "INSERT INTO user_otp (ID, ref_otp_code, otp_code)
VALUES ('".$current_user->ID."', '".$otp_ref_code."' , '".$otp_code."')";
//send sms to $u_phone_number
    include("php_sms_class/sms.class.php");
	
	$username_sms = '0932531478';
	$password_sms = '961888';
	$msisdn_sms = $u_phone_number;
	$message_sms = 'รหัส OTP = '. $otp_code .' Ref Code : '.$otp_ref_code;
	$sender_sms = 'XCLUBCASINO';
	$ScheduledDelivery_sms =  '';
	$force_sms = 'Standard';
	
	//$result_sms = sms::send_sms($username_sms,$password_sms,$msisdn_sms,$message_sms,$sender_sms,$ScheduledDelivery_sms,$force_sms);
	 echo $result_sms;
 //draw form
  	echo '<div style="border-style: dashed;">
	<md-content class="md-padding">
	  <div layout="row" layout-align="center center">
	ระบบกำลังดำเนินการส่งหมายเลข OTP ไปยังเบอร์โทรศัพท์มือถือหมายเลข ';
	echo $u_phone_number;
	$js_otp_ref_code = "'".$otp_ref_code."'";
	 
	echo '
	</div>
	</br>
	<form    name="userForm_otp_1" ng-submit="submitForm_otp_1('.$current_user->ID.','.$js_otp_ref_code.')">
    <div layout="row"  layout-align="center center">
	   <md-input-container>
        <label>กรอกหมายเลข OTP ที่ได้รับ</label>
         <input required name="user_otp1" type="text" name="user_otp1"  ng-model="user_otp.user_otp1">
		 <div>';
		 echo 'Ref Code : '.$otp_ref_code ;
	echo'</div>
		 <div ng-messages="userForm_otp_1.user_otp1.$error">
          <div ng-message="required">โปรดกรอกข้อมูล</div>
         </div>
	   </md-input-container> 
	   
	    
	   <md-button ng-show="{{message_bt_otp1}}" ng-disabled=" {{!message_bt_otp1}}" type="submit" class="md-raised md-primary">ยืนยัน
	   </md-button> 
	
	 <span ng-show="message_bt_otp1">{{message_bt_otp1}} 
</div>
    </form>
	
	<form   name="userForm_otp_1_renew" ng-submit="submitForm_otp_1_renew(1)">
    <div layout="row"  layout-align="center center">
	   <md-button type="submit" class="md-raised md-warn">หากท่านไม่ได้รับ sms ภายใน 5 นาที กรุณากดปุ่มนี้ เพือรับ sms ใหม่อีกครั้ง</md-button> 
</div>
    </form>
	</md-content>
	 </div>';
 
 
 
if ($conn->query($sql_insert_otp_1) === TRUE) {
    //echo "New record created successfully";
} else {
    echo "Error: " . $sql_insert_otp_1 . "<br>" . $conn->error;
}
  
   
  //createform call js check table otp_db
  //show message if ok  
  }elseif($otp_html_no_form==2){
  echo "form otp two";
  }
  
  
  }
   
  
  ?>
  </div> <!-- angularjs-->
 
<?php get_footer(); ?>
