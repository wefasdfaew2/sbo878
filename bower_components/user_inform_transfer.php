<?php
/*
Template Name: user_inform_transfer
*/
?>
<?php 
if ( ! defined( 'ABSPATH' ) ) die( 'Error!' ); 
get_header();
?>
 <?php
  wp_register_script('ui-bootstrap', get_template_directory_uri() . '/js/ui-bootstrap-tpls-1.1.2.min.js', true);
 wp_enqueue_script('ui-bootstrap');
 wp_register_script('user_inform_transfer', get_template_directory_uri() . '/js/user_inform_transfer.js', true);
  wp_enqueue_script('user_inform_transfer');
 ?>

 <div id="page" class="single">
   <div class="content">
     <div ng-app="app_user_inform_transfer" ng-controller="cont_user_inform_transfer" ng-cloak="">
 
    <?php
	 
	echo   '<div layout="row" layout-align="center center">
  
        <div  >
 <img ng-src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/BarAPP1.png" alt="sbobet878" class="img-responsive center-block" >
  </div>
 
 </div> 
 <div    align="center"  >
 
	 
	<form  style="width:450px;height:180px;"  name="user_inform_transfer_Form" ng-submit="submit_user_inform_transfer_Form()">
       
	   <md-input-container>
        <label>กรุณาใส่ username</label>
	 	 
		    <input  style="width:250px;"  required  name="username_input" type="text"   title="กรุณาใส่ username"   ng-model="user_inform_transfer.username">
		<div role="alert">		  
		<span class="error" ng-show="user_inform_transfer_Form.username_input.$error.pattern">
		กรุณาใส่ username
		</span>
	    </md-input-container> 
		</div>
		
	</br>
 </br>
      <md-input-container >
      <label>กรุณาใส่เบอร์มือถือที่ได้ลงทะเบียนไว้</label>
	    
		<input style="width:250px;" required  name="phone_number_input" type="text"   pattern="[0-9]{10}" maxlength="10" title="รูปแบบ:: 0871234567"  ng-model="user_inform_transfer.phone_number">
			<div role="alert">
				<span class="error" ng-show="user_inform_transfer_Form.phone_number_input.$error.pattern">
				รูปแบบเบอร์โทรไม่ถูกต้อง
				</span>
			</md-input-container> 	
			</div> 
		
		
		  
 	   <md-button type="submit" class="md-raised md-primary">ตกลง</md-button> 
 
	  
		   

    </form>
 	  
	</div>
	<div align="center"> 
	 <span ng-show="message"><font color="blue">{{message}}</font></span>
	 <span ng-show="message_err"><font color="red">{{message_err}}</font></span>
     </div>
	</br>
	 
	 ';
	?>
     

     </div> <!-- end angularjs-->
 

<?php get_footer(); ?>
