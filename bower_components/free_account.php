<?php
/*
Template Name: free_account
*/
?>
<?php get_header();?>
 <?php
 wp_register_script('user_redeem_point', get_template_directory_uri() . '/js/user_redeem_point.js', true);
  wp_enqueue_script('user_redeem_point');
   wp_register_script('ui-bootstrap', get_template_directory_uri() . '/js/ui-bootstrap-tpls-1.1.2.min.js', true);
 wp_enqueue_script('ui-bootstrap');
 ?>
 <div id="page" class="single">
 <div class="content">

  <div class="alert alert-info" >

 <strong><h3>SBOBET878 ใจดีแจกให้ฟรี 4 Account</h3></strong> </br>&nbsp;&nbsp;&nbsp;&nbsp;สำหรับให้ท่านสมาชิกเอาไปโหลดหนัง  AV, ดูบอล VIP, ดูหนังออนไลน์ และ โหลดหนัง HD ได้ฟรีๆ เพียงทำตามขั้นตอนง่ายๆ ด้านล่างนี้

 </div>
 <div class="alert alert-success" >
 <strong>สี่ขั้นตอนง่ายๆ</strong>
 </br>
 1. ทำการสมัครสมาชิกกับเว็บไซต์ sbobet878.com ซึ่งหลังจากการสมัครเสร็จแล้ว ท่านจะได้รับ Account สำหรับโหลดหนัง AV, ดูบอล VIP, ดูหนังออนไลน์ และโหลดหนัง HD ไปพร้อมกันทันที
 </br>
 </br>
 2. ทุก Account ทีท่านได้รับจะมีวัน VIP แถมให้แล้ว 1 วันทันที และท่านสมาชิกสามารถแลกวัน VIP เพิ่มได้เรื่อยๆ เมื่อท่านสมาชิกเริ่มทำการแทงบอลกับเรา
 </br>
 </br>
3. ระบบจะทำการคำนวณแต้ม (Points) ที่จะใช้แลกวัน VIP ให้กับท่านสมาชิกเวลา 1.00 (ตีหนึ่ง) ของทุกๆวัน โดยแต้ม (Points) ดังกล่าวจะถูกคำนวณมาจากยอดการแทงได้เสียของท่านสมาชิกในวันนั้น
 </br>
 </br>
4. ท่านสมาชิกนำแต้ม (points) ที่มีมากดแลกวัน VIP ได้ทันทีที่แบบฟอร์มด้านล่างนี้
 </div>


 <div  ng-app="app_user_redeem_point" ng-controller="cont_user_redeem_point" ng-cloak=""><!-- angularjs-->
 <md-toolbar class="md-hue-2">
   <div class="md-toolbar-tools">
      <h1>
        <span>กรุณากรอกแบบฟอร์มด้านล่างนี้เพื่อ Login และทำการแลกวัน VIP สำหรับเว็บพันธมิตรของเรา</span>
      </h1>
    </div>
	</md-toolbar >
 <div  class="alert alert-info"  layout="row"  layout-align="center center">

	   <md-input-container class="md-block"  >
        <label><font color="blue">กรุณาใส่ username</font></label>

		    <input  style="width:250px;"  required ng-change="check_authen(user_input.username,user_input.phone_number)" ng-model-options="{debounce:1500}"  name="username_input" type="text"   title="กรุณาใส่ username"   ng-model="user_input.username">
 </md-input-container>

      <md-input-container  class="md-block"  >
      <label><font color="blue">กรุณาใส่เบอร์มือถือที่ได้ลงทะเบียนไว้</font></label>

		<input style="width:250px;" required ng-change="check_authen(user_input.username,user_input.phone_number)" ng-model-options="{debounce:1500}"  name="phone_number_input" type="text"   pattern="[0-9]{10}" maxlength="10" title="รูปแบบ:: 0871234567"  ng-model="user_input.phone_number">

	 </md-input-container>

</div>

<div align="center">
	 <span ng-show="message_err"><font color="red">{{message_err}}</font></span>
     </div>
</br>
<!-- draw form -->
<div ng-switch on="disp_form">
<!-- case-->
	 <div ng-switch-when="1"></div>
	 <div   style=  "padding-left:25px;" ng-switch-when="2"><!-- display table-->
	 <font color="blue"><h1>คุณมีแต้ม (Points) จำนวน  {{u_point}} แต้ม</h1></font>

	  <table class="table  table-borderless" >
    <thead  style="color: #0000;">
      <tr align="center">
		<th class="col-xs-6">เลือกแลกวัน VIP กับเว็บไซต์ที่ต้องการแลก</th>
		<th class="col-xs-6"></th>
      </tr>
    </thead>
    <tbody >
	  <tr >
        <td style="border-top: none;padding:0px;vertical-align:baseline;">
		<md-checkbox ng-model="checklist_data.cb1" ng-click="set_cb1(!checklist_data.cb1)"  >
            <strong>เว็บไซต์ : <a target="_blank" href="http://jav-thai.com:443">http://jav-thai.com:443</a></strong>
          </md-checkbox>
		</td>
		<td style="border-top: none;padding:0px;vertical-align:baseline;">
		<md-input-container>
		  <input aria-label="cb1" ng-disabled="!checklist_data.cb1"  ng-change="validate_day()" ng-model-options="{debounce:100}" style="width:50px;" ng-model="checklist_data.p_cb1"  type="number"  min="0" max="999" step="1">
		  </md-input-container><strong> วัน </strong><span ng-show="confirm_date1_err"><font color="red">{{confirm_date1_err}}</font></span>
		</td>
	  </tr>
	   <tr>
        <td style="border-top: none;padding:0px;vertical-align:baseline;">
		<md-checkbox ng-model="checklist_data.cb2"  ng-click="set_cb2(!checklist_data.cb2)"  >
            <strong>เว็บไซต์ : <a target="_blank" href="http://direct-torrent.com:443">http://direct-torrent.com:443</a></strong>
          </md-checkbox>
		</td>
		<td style="border-top: none;padding:0px;vertical-align:baseline;">
		<md-input-container>
		  <input aria-label="cb2" ng-disabled="!checklist_data.cb2"  ng-change="validate_day()" ng-model-options="{debounce:100}" style="width:50px;" ng-model="checklist_data.p_cb2"  type="number" min="0" max="999" step="1">
		  </md-input-container><strong> วัน </strong><span ng-show="confirm_date2_err"><font color="red">{{confirm_date2_err}}</font></span>

		  </td>
	  </tr>
	   <tr>
        <td style="border-top: none;padding:0px;vertical-align:baseline;">
		<md-checkbox ng-model="checklist_data.cb3" aria-label="cb3" ng-click="set_cb3(!checklist_data.cb3)">
            <strong>เว็บไซต์ : <a target="_blank" href="http://www.tv2hd.com">http://www.tv2hd.com</a></strong>
          </md-checkbox>
		</td>
		<td style="border-top: none;padding:0px;vertical-align:baseline;">
		<md-input-container>
		  <input aria-label="cb3" ng-disabled="!checklist_data.cb3"  ng-change="validate_day()" ng-model-options="{debounce:100}"  style="width:50px;" ng-model="checklist_data.p_cb3"  type="number" min="0" max="999" step="1">
		  </md-input-container><strong> วัน </strong><span ng-show="confirm_date3_err"><font color="red">{{confirm_date3_err}}</font></span>
		</td>
	  </tr>
	   <tr>
        <td style="border-top: none;padding:0px;vertical-align:baseline;">
		<md-checkbox ng-model="checklist_data.cb4" aria-label="cb4" ng-click="set_cb4(!checklist_data.cb4)" >
           <strong>เว็บไซต์ : <a target="_blank" href="https://www.football-hd.com">https://www.football-hd.com</a></strong>
          </md-checkbox>
		</td>
		<td style="border-top: none;padding:0px;vertical-align:baseline;">
		<md-input-container>
		  <input aria-label="cb4" ng-disabled="!checklist_data.cb4"  ng-change="validate_day()" ng-model-options="{debounce:100}"  style="width:50px;" ng-model="checklist_data.p_cb4"  type="number" min="0" max="20" step="1">
		  </md-input-container><strong> วัน </strong><span ng-show="confirm_date4_err"><font color="red">{{confirm_date4_err}}</font></span>

		</td>
	  </tr>
	  <tr>
	  <td style="border-top: none;padding:0px;vertical-align:baseline;">
	  <span ng-show="confirm_message_err"><font color="red">{{confirm_message_err}}</font></span>
	  <span ng-show="!confirm_message_err"><font color="blue">สรุป คุณใช้แต้ม (Points) ไปจำนวนทั้งสิ้น {{sum_point}} แต้ม คงเหลือ {{u_point-sum_point}} แต้ม</font></span>
	  </td>
	  <td style="border-top: none;padding:0px;vertical-align:baseline;">

	  <md-button ng-disabled="bt_submit"  ng-click="confirm_redeem(u_name,u_member_id)" class=" md-raised md-primary" >ยืนยันการแลกแต้มเป็นวัน VIP</md-button>
	  </td>
	  </tr>
	   </tbody>
	  </table>



	 </div><!-- end display table-->
</div><!-- end case-->
<!-- end draw form	-->
</br>
<div  class="alert alert-warning"  layout="row"  layout-align="center center" >
  <div flex ><img src="http://upic.me/i/b0/mid-right1.png" alt="sbobet878"></div>
  <div  flex><strong>เว็บไซต์ : <a target="_blank" href="http://jav-thai.com:443">http://jav-thai.com:443</a></strong></br>
  <I>ประเภทเว็บไซต์ : เว็บโหลดหนัง AV</I></br></br>
   rate การให้วัน vip จากเว็บ jav-thai.com</br>
   <h3>ใช้ <font color="red">1 แต้ม </font>(Points) ในการแลก <font color="red">VIP 1 วัน</font></h3>
   </div>
</div>
<div  class="alert alert-warning"  layout="row"  layout-align="center center" >
  <div flex ><img src="http://upic.me/i/bb/mid-right2.png" alt="sbobet878"></div>
  <div  flex><strong>เว็บไซต์ : <a target="_blank" href="http://direct-torrent.com:443">http://direct-torrent.com:443</a></strong></br>
  <I>ประเภทเว็บไซต์ : เว็บโหลดหนัง HD, โหลดซอฟแวร์ มีให้โหลดทุกอย่าง</I></br></br>
   rate การให้วัน vip จากเว็บ direct-torrent.com</br>
   <h3>ใช้ <font color="red">1 แต้ม </font>(Points) ในการแลก <font color="red">VIP 1 วัน</font></h3>
   </div>
</div>
<div  class="alert alert-warning"  layout="row"  layout-align="center center" >
  <div flex ><img src="http://upic.me/i/sb/mid-right3.png" alt="sbobet878"></div>
  <div  flex><strong>เว็บไซต์ : <a target="_blank" href="http://www.tv2hd.com">http://www.tv2hd.com</a></strong></br>
  <I>ประเภทเว็บไซต์ : ดูบอลออนไลน์ vip</I></br></br>
   rate การให้วัน vip จากเว็บ tv2hd.com</br>
   <h3>ใช้ <font color="red">1 แต้ม </font>(Points) ในการแลก <font color="red">VIP 1 วัน</font></h3>
   </div>
</div>
<div  class="alert alert-warning"  layout="row"  layout-align="center center" >
  <div flex ><img src="http://upic.me/i/ur/mid-right4.png" alt="sbobet878"></div>
  <div  flex><strong>เว็บไซต์ : <a target="_blank" href="https://www.football-hd.com">https://www.football-hd.com</a></strong></br>
  <I>ประเภทเว็บไซต์ : ดูหนังออนไลน์, ดูบอลออนไลน์ vip</I></br></br>
   rate การให้วัน vip จากเว็บ football-hd.com</br>
   <h3>ใช้ <font color="red">1 แต้ม </font>(Points) ในการแลก <font color="red">VIP 1 วัน</font></h3>
   </div>
</div>
<div  class="alert alert-warning"  layout="row"  layout-align="center center" >
  <div flex ><img src="https://www.sbobet878.com/wp-content/themes/point/images/mid-right5.png" alt="sbobet878"></div>
  <div  flex><strong>เว็บไซต์ : <a target="_blank" href="https://clipfin.com/">https://clipfin.com/</a></strong></br>
  <I>ประเภทเว็บไซต์ : เว็บโหลดหนัง AV</I></br></br>
   rate การให้วัน vip จากเว็บ clipfin.com</br>
   <h3>ใช้ <font color="red">1 แต้ม </font>(Points) ในการแลก <font color="red">VIP 1 วัน</font></h3>
   </div>
</div>
<!--
<div  class="alert alert-danger"  layout="column" >

  <div  flex><strong>ตัวอย่างการคำนวณ</strong></div>
  </br>

  <div align="center"  flex>
	สมมติท่านสมาชิกทำการเติมเครดิตเพือแทงบอลหรือเล่นคาสินโนจำนวน 2,200 บาท ท่านสมาชิกจะได้รับจำนวนวัน vip ของแต่ละเว็บดังนี้
  </div>
  </br>
  <div   class="alert alert-warning"  layout="row"    >
  <div align="center"  flex>
  <b>JAV-THAI</b></br>
  <font color="red"><h2>14 วัน</h2></font></br>
  <font style="font-size:small;">วิธีการคำนวน (2200/150=14.67 วัน)</font>
  </div>

    <div align="center"  flex>
  <b>DIRECT-TORRENT</b></br>
  <font color="red"><h2>11 วัน</h2></font></br>
  <font style="font-size:small;">วิธีการคำนวน (2200/200=11 วัน)</font>
  </div>

   <div align="center"  flex>
  <b>TV2HD</b></br>
  <font color="red"><h2>14 วัน</h2></font></br>
  <font style="font-size:small;">วิธีการคำนวน (2200/150=14.67 วัน)</font>
  </div>

   <div align="center"  flex  >
  <b>FOOTBALL-HD</b></br>
   <font color="red"><h2>11 วัน</h2></font></br>
  <font style="font-size:small;">วิธีการคำนวน (2200/200=11 วัน)</font>
  </div>
  </div>
 <div align="center">
 <font color="red">*หากท่านสมาชิกเติมเงินแล้วไม่ได้ทำการแทงหรือเล่นพนันระบบจะไม่ทำการเติมวัน vip ทั้ง 4 เว็บไซต์ด้านบนให้</font>
 </div>

</div>
 -->

 </div><!-- angularjs-->


<?php get_footer(); ?>
