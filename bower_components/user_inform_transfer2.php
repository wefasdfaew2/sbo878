<?php
/*
Template Name: user_inform_transfer2
*/
?>
<?php
//prevent direct access
 //if ( ! defined( 'ABSPATH' ) ) die( 'Error!' );
//prevent direct get data from outsite
    if(!isset($_SERVER['HTTP_REFERER'])){
     die(); //exit page after outputting the message.
	 }else{
$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($check_direct_access === false)die('Restricted access');
 }

get_header();
?>
 <?php
 wp_register_script('angular-locale_th-th', get_template_directory_uri() . '/js/angular-locale_th-th.js', true);
 wp_enqueue_script('angular-locale_th-th');

 wp_register_script('ui-bootstrap', get_template_directory_uri() . '/js/ui-bootstrap-tpls-1.1.2.min.js', true);
 wp_enqueue_script('ui-bootstrap');

 wp_register_script('user_inform_transfer', get_template_directory_uri() . '/js/user_inform_transfer.js', true);
  wp_enqueue_script('user_inform_transfer');
 ?>

 <div id="page" class="single">
   <div class="content">

   <?php
   
   if(!isset($_GET['data'])){
     //die(); //exit page after outputting the message.
$user_name='';
	 }else{
	 $user_name=$_GET['data'];
}

   
   

	//echo $user_name;
   // echo '<div ng-app="app_user_inform_transfer" ng-controller="cont_user_inform_transfer" ng-cloak="" ng-init="user_waiting_list('.$user_name.')">';
 ?>

	<div ng-app="app_user_inform_transfer" ng-controller="cont_user_inform_transfer" ng-cloak="" ng-init="user_waiting_list('<?php echo $user_name;?>')">
	 			<md-toolbar class="md-raised" style="padding-left:10px;padding-top:10px;">
				<font size="4">ท่านสมาชิก username : <?php echo $user_name;?></font>
			<font size="3" ng-if="num_row==0"> มีรายการรอแจ้งรายละเอียดการโอนทั้งสิ้น  :  0  รายการ</font>
			<font size="3" ng-if="num_row>0"> มีรายการรอแจ้งรายละเอียดการโอนทั้งสิ้น  :  {{num_row}} รายการ</font>
            </md-toolbar>
 </br>
 <div class="container">


  <table class="table table-hover table-bordered" align="center">
    <thead  style="color: #fff;  background-color:#339933" >
      <tr align="center">
		<th class="col-md-1">ธุรกรรมเลขที่</th>
		<th class="col-md-2">ยอดเงินฝาก</th>
		<th class="col-md-2">เลขที่บัญชีที่ต้องโอนเข้า</th>
		<th class="col-md-2">ธนาคารที่ต้องโอนเข้า</th>
		<th class="col-md-1">ขอรับโบนัส 200%</th>
		<th class="col-md-1">ขอรับโบนัส 10%</th>
		<th class="col-md-2" colspan="2">ดำเนินการ</th>
      </tr>

    </thead>
    <tbody>
      <tr ng-repeat-start="u_list in json_user_waiting_list">
        <td>{{u_list.deposit_id}}</td>
	  <td>{{u_list.deposit_amount}}</td>
	  <td>{{u_list.deposit_bank_account}}</td>
	  <td>{{u_list.deposit_bank_name}}</td>
	  <td>
	  <img ng-show="u_list.deposit_firstpayment_promotion_mark=='Yes'"  ng-src="<?php echo  content_url(); ?>/uploads/2016/03/yes_24px.png"/>
	  <img ng-show="u_list.deposit_firstpayment_promotion_mark=='No'"  ng-src="<?php echo  content_url(); ?>/uploads/2016/03/no_24px.png"/>
	  </td>

	   <td>
	   <img ng-show="u_list.deposit_nextpayment_promotion_mark=='Yes'"  ng-src="<?php echo  content_url(); ?>/uploads/2016/03/yes_24px.png"/>
	  <img ng-show="u_list.deposit_nextpayment_promotion_mark=='No'"  ng-src="<?php echo  content_url(); ?>/uploads/2016/03/no_24px.png"/>
	   </td>

	  <td><md-button ng-if="num_row>0" ng-click="confirm_trans(u_list.deposit_id)" class=" md-raised md-primary" >แจ้งฝากรายการนี้</md-button></td>
	   <td><md-button ng-if="num_row>0" ng-click="cancle_trans(u_list.deposit_id)" class=" md-raised md-warn">ยกเลิกรายการนี้</md-button></td>
      </tr>


	  <tr  ng-repeat-end="" ng-switch on="confirm_form">
	 <!-- span confirm_form && u_list.deposit_id==trans_id_num -->
	 <td colspan="12" ng-switch-when="1" ng-if="u_list.deposit_id==trans_id_num && bt_confirm_tg">
	 <div class="alert alert-success">
  <strong>แจ้งยืนยันรายการฝากที่ : {{u_list.deposit_id}}</strong>
	</div>
	 <table class="table">
    <tbody>
      <tr>
        <td>Username</td>
        <td><?php echo $user_name;?></td>
      </tr>
       <td>ยอดเงินฝาก</td>
        <td>{{u_list.deposit_amount}}</td>
      </tr>
	   <tr>
        <td>เลขบัญชีที่โอนเข้า</td>
        <td>{{u_list.deposit_bank_account}}</td>
      </tr>
	   <tr>
        <td>ธนาคารที่โอนเข้า</td>
        <td>{{u_list.deposit_bank_name}}</td>
      </tr>
	   <tr>
        <td>ขอรับโบนัส 200%</td>
        <td ng-show="u_list.deposit_firstpayment_promotion_mark=='Yes'">รับ</td>
		<td ng-show="u_list.deposit_firstpayment_promotion_mark=='No'">ไม่รับ</td>
      </tr>
	   <tr>
        <td>ขอรับโบนัส 10%</td>
        <td ng-show="u_list.deposit_nextpayment_promotion_mark=='Yes'">รับ</td>
		<td ng-show="u_list.deposit_nextpayment_promotion_mark=='No'">ไม่รับ</td>
      </tr>

    </tbody>
  </table>
  	 <div class="alert alert-info">
  <strong>กรุณากรอกรายละเอียดการโอนเงินด้านล่างนี้</strong>
	</div>
 
	 <table class="table">
	  <thead  style="color: #000000;" >
      <tr align="center">
		<th class="col-md-2">วันที่ฝากเงิน</th>
		<th class="col-md-3">เวลาที่ฝากเงิน</th>
      </tr>

    </thead>
    <tbody>
      <tr>
        <td><uib-datepicker ng-model="u.dt" datepicker-options="inlineOptions"></uib-datepicker></td>
        <td><uib-timepicker   ng-model="u.mytime"  hour-step="hstep" minute-step="mstep" show-meridian="false"></uib-timepicker></td>
      </tr>
   
    </tbody>
  </table>
 
	
</br>
	<font size="3"><b>ช่องทางที่ท่านสมาชิกใช้ฝากเงิน</b></font>
	<div style="padding-top:10px;padding-left:20px;">
	   <md-radio-group ng-model="radio1_user.channel_transf">
      <md-radio-button value="1">ATM</md-radio-button>
      <md-radio-button value="3">ตู้ฝากเงินสด</md-radio-button>
      <md-radio-button value="5">Internet Banking</md-radio-button>
	  <md-radio-button value="4">ธนาคารทางโทรศัพท์ (Application)</md-radio-button>
    </md-radio-group>
	 </div>
 
	 <font size="3"><b>บัญชีของท่านสมาชิกที่ใช้ฝากเงินให้กับเรา</b></font>
	 
	<!-- ng-repeat user bank lists -->  
	<div style="padding-top:10px;padding-left:20px;">
	   <md-radio-group ng-model="radio2_user.from_bank_transf">
  <md-radio-button  value="{{u_ba+','+u_bn}}" ng-if="u_ba.length != 0">{{u_ba}} {{u_bn}} {{u_nn}}</md-radio-button>
  <md-radio-button  value="{{u_ba2+','+u_bn2}}" ng-if="u_ba2.length != 0">{{u_ba2}} {{u_bn2}} {{u_nn}}</md-radio-button>
  <md-radio-button  value="{{u_ba3+','+u_bn3}}" ng-if="u_ba3.length != 0">{{u_ba3}} {{u_bn3}} {{u_nn}}</md-radio-button> 
    </md-radio-group>
	 </div>
 	 <div style="padding-top:10px;padding-left:20px;">
	 <button type="button" class="btn btn-sm btn-info" ng-click="apply_confirm_trans(u_list.deposit_id,<?php echo "'".$user_name."'";?>)">ยืนยัน</button>
	</div>
	 </td>
	 <!-- span cancle_form && u_list.deposit_id==trans_id_num -->
	  <td style="text-align:center" colspan="12" ng-switch-when="2" ng-if="u_list.deposit_id==trans_id_num && bt_cancle_tg">
	  คุณต้องการยกเลิกรายการฝากเลขที่ : {{u_list.deposit_id}} <md-button ng-click="apply_cancle_trans(u_list.deposit_id,<?php echo "'".$user_name."'";?>)" class="md-raised md-warn md-hue-2">ยืนยัน</md-button>
	 </td>

	  </tr>


    </tbody>
  </table>

</div>

   <!-- <tr>
		<td>ธุรกรรมเลขที่</td>
		<td>ยอดเงินฝาก</td>
		<td>เลขที่บัญชีที่ต้องโอนเข้า</td>
		<td>ธนาคารที่ต้องโอนเข้า</td>
		<td>ขอรับโบนัส 200%</td>
		<td>ขอรับโบนัส 10%</td>
		<td>ดำเนินการ</td>
	</tr>
     <tr ng-repeat="u_list in json_user_waiting_list">
	 <td>{{u_list.deposit_id}}</td>
	  <td>{{u_list.deposit_amount}}</td>
	  <td>{{u_list.deposit_bank_account}}</td>
	  <td>{{u_list.deposit_bank_name}}</td>
	  <td>{{u_list.deposit_firstpayment_promotion_mark}}</td>
	  <td>{{u_list.deposit_nextpayment_promotion_mark}}</td>
	  <td>แจ้งฝากรายการนี้</td>


	 </tr>

</table>
	 -->

     </div> <!-- end angularjs-->


<?php get_footer(); ?>
