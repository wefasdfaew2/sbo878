<?php
/*
Template Name: register
*/
?>
<?php 
if ( ! defined( 'ABSPATH' ) ) die( 'Error!' );
get_header();
?>
<div id="page" class="single">
 <div class="content">
  <div  ng-app="max_MyApp" ng-controller="max_user_detail" ng-cloak="">
 
 
 <?php
	global $current_user;
	   get_currentuserinfo();
	   function getRealIpAddr() {
       if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip; 
    }
	$user_ip = "'".getRealIpAddr()."'";
	 if(intval($current_user->ID) == 0){
  
  echo ' <div layout="row"   layout-align="space-around center">
  <div flex>
 <h3 class="frontTitle">สมัครสมาชิก</h3>
  </div>
 
 </div>
  <div layout="row" layout-align="center center">
   <pre>
        <div flex>
 <img ng-src="';echo  content_url().'/uploads/2016/02/BarAPP1.png" alt="sbobet878" class="img-responsive center-block" >
  </div>
หลังจากสมัครเสร็จแล้วท่านสมาชิกจะได้รับ Accountสำหรับการแทงในเว็บ sbobet,vegus168,ibcbet และ royal Gclub ทางอีเมลล์และ SMS ที่ท่านได้ลงทะเบียนไว้
 </pre>
 </div>
 
 
<div   layout="row" layout-align="center center" layout-xs="column">
  <div flex>
	 <md-content >
	 <md-toolbar class="md-warn" >
	 <div class="md-toolbar-tools"  >
	 <h2>
          กรุณากรอกข้อมูลลงในฟอร์มนี้ 
        </h2>
		 
	 </div>
	 </md-toolbar>
	  
	<form    name="userForm" ng-submit="submitForm_user_wp('.$user_ip.')">
     
    <div layout="column">
	 <div align="center">
		<font color="blue">*จำเป็นต้องกรอก</font>
		</div>
	<md-input-container >
        <label>*ชื่อ สกุล จริงตรงกับหน้าบัญชีธนาคาร</label>
        <input required  name="bank_account_name_input"  type="text"  pattern="[ก-๙]+\s{1,}[ก-๙]+$|[\w]+\s{1,}[\w]+$" title="ชื่อ  นามสุกล"  ng-model="user_wp.bank_account_name">
	 	<div role="alert">
    <span class="error" ng-show="userForm.bank_account_name_input.$error.pattern">
      รูปแบบไม่ถูกต้อง</span>
  </div>
	  </md-input-container>
	  
      <md-input-container  class="md-block">
        <label>ชื่อธนาคาร</label>
        <md-select  ng-model="user_wp.bank_name" required name="bank_name">
          <md-option ng-repeat="(index,item)  in bank_name" value="{{index+1}}" ng-selected="(index == 0) ? true:false">
            {{item}}
			           </md-option>
		            </md-select>
		 <div ng-messages="userForm.bank_name.$error">
          <div ng-message="required">โปรดกรอกข้อมูล</div>
         </div>
			   </md-input-container>
			   
        <md-input-container>
        <label>*หมายเลขบัญชี (ตัวเลขติดกัน)</label>
        <input required name="bank_number_input"  type="text" pattern="[0-9]{1,12}" maxlength="12"  title="รูปแบบ:: 0123456789"  ng-model="user_wp.bank_number">
		<div role="alert">
    <span class="error" ng-show="userForm.bank_number_input.$error.pattern">
      รูปแบบไม่ถูกต้อง</span>
  </div>
	  </md-input-container>

 
      <md-input-container>
      <label>*เบอร์โทรศัพท์ (เลขติดกัน 10 ตัว)</label>
	    <md-progress-linear ng-show="load_phone_validate == 1" md-mode="indeterminate"></md-progress-linear>
		<input required ng-change="validate_exist(user_wp.phone_number,2,true)" ng-model-options="{debounce:1500}" name="phone_number_input" type="text"   pattern="[0-9]{10}" maxlength="10" title="รูปแบบ:: 0871234567"  ng-model="user_wp.phone_number">
			<div role="alert">
				<span class="error" ng-show="userForm.phone_number_input.$error.pattern">
				รูปแบบเบอร์โทรไม่ถูกต้อง
				</span>
				<span class="error" ng-show="userForm.phone_number_input.$error.unique_phone_number">
				 เบอร์นี้ใช้ลงทะเบียนแล้ว
				</span>	
			</div> 
	   </md-input-container> 
	   
	    <md-input-container>
        <label>เบอร์โทรศัพท์สำรอง (เลขติดกัน 10 ตัว)</label>
		 <md-progress-linear ng-show="load_phone_validate2 == 1" md-mode="indeterminate"></md-progress-linear>
         <input   ng-change="validate_exist(user_wp.phone_number2,3,true)"  ng-model-options="{debounce:1500}" name="phone_number2_input" type="text"  pattern="[0-9]{10}" maxlength="10" title="รูปแบบ:: 0871234567" ng-model="user_wp.phone_number2">
			<div role="alert">
			<span class="error" ng-show="userForm.phone_number2_input.$error.pattern">
			รูปแบบเบอร์โทรไม่ถูกต้อง</span>
			</div>
			<span class="error" ng-show="userForm.phone_number2_input.$error.unique_phone_number2">
				 เบอร์นี้ใช้ลงทะเบียนแล้ว
			</span>	
	   </md-input-container> 
	   
	   
	   <md-input-container>
        <label>*อีเมลล์ </label>
	 	 <md-progress-linear ng-show="load_email_validate == 1" md-mode="indeterminate"></md-progress-linear>
		    <input   required    ng-change="validate_exist(user_wp.user_email,1,true)" ng-model-options="{debounce:1500}"  name="user_email_input" type="email" title="รูปแบบ:: admin@sbobet878.com"   ng-model="user_wp.user_email">
		<div role="alert">		  
		<span class="error" ng-show="userForm.user_email_input.$error.email">
		รูปแบบอีเมลล์ไม่ถูกต้อง
		</span>
		<span class="error" ng-show="userForm.user_email_input.$error.unique_email">
		อีเมลล์นี้ใช้ลงทะเบียนแล้ว
		</span>		 
	   </md-input-container> 
		</div>
		
		<div align="center"> 
 	   <md-button type="submit" ng-disabled="bt_validate" class="md-raised md-warn">ตกลง</md-button> 
	   
	    </div>
		
    </form>
	<div align="center"> 
	 <span ng-show="message">{{message}}</span>
     </div>
	</md-content>  
	</div>
 </div> 
  
 <div flex>
    <img ng-src="';echo  content_url().'/uploads/2016/02/or.png" alt="sbobet878"  class="center-block" style="height:50%; width:50%;">
	 </div>
  <div class="center-block" flex>';
 do_action( 'wordpress_social_login' ); 
echo '</div>
	</div>';

echo '<div class="alert alert-danger">
    <strong>อ่านตรงนี้ก่อน!!! กดปุ่ม -- ตกลง --</strong></br> 
	1. ระบบอนุญาตให้ท่านสมาชิก 1 คนสมัคร Account ได้เพียง 1 Account เท่านั้น</br>
	2. กรณีที่ท่านสมาชิกใช้ User เดียวกัน โดยมีการเล่นทั้ง 2 ฝั่งสวนทางกัน ทางทีมงานจะดำเนินการตัดสิทธิโปรโมชั่นของท่านทันที</br>
	3. กรณีที่ท่านสมาชิกใช้หลาย User โดยมีการเล่นทั้ง 2 ฝั่งสวนทางกัน ทางทีมงานจะตัดสิทธิโปรโมชั่นของท่านทันที</br>
	4. กรณีระบบตรวจพบว่า User ของท่านสมาชิกมีพฤติกรรมการเล่น ที่ผิดปกติ หรือจงใจเล่นเพื่อหวังผลประโยชน์ใด ๆ จากโบนัสหรือโปรโมชั่นต่าง ๆ ทีมงานจะทำการปิด Account ของท่านทันที</br>
	5. การตัดสินของทีมงาน SBOBET878 ถือเป็นที่สิ้นสุด
  </div>
 </div>';
 }else{
 //echo 'ขณะนี้คุณอยู่ในระบบ';
 //then logout
 //wp_logout();
   //echo wp_logout_url( get_permalink() ); 
   echo '<div align="center" class="alert alert-danger"><a href='. wp_logout_url( get_permalink() ).'> กรุณา คลิกที่นี่ หากต้องการเริ่มสมัครสมาชิกใหม่ </a></div>';
 }
 ?>
  
<?php get_footer(); ?>
