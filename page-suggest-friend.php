<?php
/*
Template Name: suggest-friend
*/
?>
<?php
  get_header();
  wp_register_script('suggest-friend', get_template_directory_uri() . '/js/suggest-friend.js', true);
  wp_enqueue_script('suggest-friend',true);

  wp_register_script('angularSlideables', get_template_directory_uri() . '/js/angularSlideables.js', true);
  wp_enqueue_script('angularSlideables');
?>
<style>
#spanLoding {
  position: fixed;
  background-color: rgba(0, 0, 0, 0.5);
  top: 50%;
  left: 50%;
  width: 100%;
  height: 100%;
  z-index: 1000;
  transform: translate(-50%, -50%);
}
.loading {
  position: fixed;
  left: 50%;
  top: 50%;
  /*background-color: white;*/
  z-index: 100;
  /*margin-top: -9em; set to a negative number 1/2 of your height*/
  /*margin-left: -15em; set to a negative number 1/2 of your width*/
  transform: translate(-50%, -50%);
}
</style>
 <div id="page" class="single">
   <div class="content">
     <div ng-app="MySuggestFriend" ng-controller="SuggestFriend" ng-cloak="" style="margin-top:10px;">

         <h2 class="page-title text-center">
           <div style="width: 99%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">แนะนำเพื่อน</div>
         </h2>
         <br>


       <div style="background-color:#f0f0f0;border-radius:10px;">
         <h4 class="page-sub-title" style="border-top-right-radius:5px;border-top-left-radius:5px;">
           <div style="margin: 0 auto;padding: 0.4em 0.625em;">
             แนะนำเพื่อนมาแทงบอล เล่นพนันเว็บนี้รับส่วนแบ่ง 5% ตลอดชีพ
           </div>
         </h4>
         <div style="padding:16px;">
           <p style="text-indent: 3em;font-size:110%;">
             เพียงคุณนำ Link, รูปป้ายโฆษณาด้านล่างนี้ไปแนะนำเพื่อนของคุณ หรือนำไปโพสแนะนำในเว็บบรอ์ด Facebook
             หรือช่องทางอื่น ๆ ให้มาเล่นพนันกับเว็บ sbobet878.com เพียงเท่านี้คุณก็จะได้ส่วนแบ่ง 5% จากยอดเสียของคนที่คุณแนะนำมา ไม่จำกัดวงเงินต่อเดือน ยิ่งแนะนำมาก ยิ่งได้มาก
           </p>
           <div style="padding:16px;">
             <ul style="font-size:110%;">
              <li>
                เมื่อเพื่อนที่คุณแนะนำมาทำการเติมเงินครั้งแรกและมียอด Turn Over 1 เกิน 1 เท่าจากยอดเดิมที่มาครั้งแรก
                คุณจะได้รับ 10% เข้าบัญชีของคุณทันที (คุณได้เฉพาะยอดเงินฝากครั้งแรก)
              </li>
              <li>
                เมื่อเพื่อนของคุณได้เล่นพนัน หรือแทงบอล คุณจะได้รับ 5% ไม่ว่าเพื่อนคุณจะเล่นได้หรือเสีย (คุณได้ตลอดไปที่เพื่อนที่คุณแนะนำยังเล่นกับเราอยู่)
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div style="background-color:#f0f0f0;border-radius:10px;">
        <h4 class="page-sub-title" style="border-top-right-radius:5px;border-top-left-radius:5px;">
          <div style="margin: 0 auto;padding: 0.4em 0.625em;">
            ตัวอย่างรายได้
          </div>
        </h4>
        <center>
          <img src="<?php echo get_template_directory_uri()?>/images/example5percent.jpg" />
       </center>
       <br>
     </div>

     <div style="background-color:#f0f0f0;border-radius:10px;">
       <h4 class="page-sub-title" style="border-top-right-radius:5px;border-top-left-radius:5px;">
         <div style="margin: 0 auto;padding: 0.4em 0.625em;">
           คำถามที่ถามกันบ่อย ๆ
         </div>
       </h4>
       <div style="padding:16px;">
         <ol type="1">
           <li>
              FAQ : เมื่อไหร่ถึงจะมียอดขึ้นให้ถอน<br>
              ANS : ทุก ๆ วันที่ 1 ของทุกเดือน เวลาประมาณ 2.00 น. ระบบจะทำการคำนวณรายได้ของคุณ
           </li>
           <br>
           <li>
             FAQ : หลังจากกดถอนเงินที่ได้จากการแนะนำเพื่อนจะสามารถรับเงินได้ที่ไหน<br>
             ANS : เครดิตจะถูกเติมเข้าบัญชี Sbobet ของท่านสมาชิก ท่านสมาชิกสามารถนำไปเล่นพนันต่อได้หรือสั่งถออนเป็นเงินสดได้
           </li>
           <br>
           <li>
             FAQ : หากนำ Link แนะนำไปแปะแล้วคนที่กดสามารถลบ Link แนะนำได้หรือไม่<br>
             ANS : ไม่ได้ ระบบจะทำการบันทึกว่าคอมพิวเตอร์เครื่องนั้นที่กด Link ถูกแนะนำโดย ID ของคุณตลอดไป
           </li>
         </ol>


      </div>
    </div>

    <div style="background-color:#f0f0f0;border-radius:10px;">
      <h4 class="page-title text-center" style="border-top-right-radius:5px;border-top-left-radius:5px;">

          <div style="margin: 0 auto;padding: 0.5em 0.625em;" ng-show="loged_in">
            ท่านสามารถนำ Link หรือสื่อโฆษณาด้านล่างนี้ไปแนะนำเพื่อนได้ทันที
          </div>

          <div style="margin: 0 auto;padding: 0.5em 0.625em;" ng-hide="loged_in">
            เริ่มต้นหารายได้แบบง่าย ๆ เพียง Login เข้าสู่ระบบ
          </div>

      </h4>


      <div style="padding:16px;margin-bottom:16px;" ng-hide="loged_in" id="login_zone">
        <form>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2 text-right" style="height:34px;">
              <label style="position: relative;top: 50%;transform: translateY(-50%);">Username:</label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
              <input ng-model="login.username" type="text" class="form-control" >
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 text-right" style="height:34px;">
              <label style="position: relative;top: 50%;transform: translateY(-50%);">Tel:</label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
              <input ng-model="login.tel" type="password" class="form-control" >
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <button ng-click="login_check(login.username, login.tel)" ng-disabled="login_button_disable" type="button" class="btn btn-primary">เข้าสู่ระบบ</button>
            </div>
          </div>
      </form>
     </div>

      <div style="padding:16px;" ng-show="loged_in">
      <div layout="row">
        <div flex="20">Link แนะนำเพื่อนของคุณคือ:</div>
        <div style="color:red;">{{ promo_link }}</div>
      </div>
      <br>
      <div layout="row">
        <div flex="18">รูปป้าย Banner สำหรับการแนะนำเพื่อนของคุณ</div>
        <div flex="82">
          <div layout="row">
            <a href="{{ promo_link }}" target="_blank">
              <img ng-src="<?php echo get_template_directory_uri(); ?>/images/Banner1.gif" width="750" height="120"/>
            </a>
          </div>
          <br>
          <div layout="row">
            <div flex="40">
              <div layout="row" layout-wrap>
                <div flex="none">
                  <a href="{{ promo_link }}" target="_blank">
                    <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner3.png" width="120" height="600"/>
                  </a>
                </div>
                <div flex="none" style="width:160px;height:600px;">
                  <a href="{{ promo_link }}" target="_blank">
                    <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner4.png" width="160" height="600"/>
                  </a>
                </div>
              </div>
            </div>
            <div flex="60">
              <div layout="row" layout-wrap>
                <div flex="none">
                  <a href="{{ promo_link }}" target="_blank">
                    <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner5.png" width="125" height="125"/>
                  </a>
                </div>
                <div flex="none">
                  <a href="{{ promo_link }}" target="_blank">
                    <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner7.png" width="120" height="60"/>
                  </a>
                </div>
                <div flex="none">
                  <a href="{{ promo_link }}" target="_blank">
                    <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner6.png" width="120" height="90"/>
                  </a>
                </div>
              </div>
              <br>
              <div layout="row">
                <div flex="none">
                  <a href="{{ promo_link }}" target="_blank">
                    <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner8.png" width="120" height="240"/>
                  </a>
                </div>
                <div flex="none">
                  <a href="{{ promo_link }}" target="_blank">
                    <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner9.png" width="234" height="60"/>
                  </a>
                </div>
              </div>
              <br>
              <div layout="row">
                <div flex="none">
                  <a href="{{ promo_link }}" target="_blank">
                    <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner2.png" width="468" height="60"/>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div layout="column" style="width:99%;margin: 0 auto;" ng-show="loged_in">
      <center>
        <h4 class="page-title text-center" style="padding:16px;text-transform: lowercase;">
          <div style="margin: 0 auto;">
            สรุปยอดรายได้ของ User : {{ login.username }}
          </div>
        </h4>
      </center>

      <div layout="column">
        <div style="width:99%;margin: 16px auto 10px auto;font-weight:bold;font-size:105%;">รายละเอียดทั่วไป</div>
        <table class="table table-striped" style="width:99%;margin: 0 auto;">
          <tr>
    				<td style="width:200px;background-color:#444444;color:white;">จำนวนยอดคงเหลือที่ถอนได้</td>
    				<td style="text-align: left;padding-left:20px;">{{login.can_withdraw }} บาท</td>
    			</tr>
          <tr>
    				<td style="width:200px;background-color:#444444;color:white;">จำนวนยอดที่ถอนแล้ว</td>
    				<td style="text-align: left;padding-left:20px;">{{login.withdrawed}} บาท</td>
    			</tr>
          <tr>
            <td style="width:200px;background-color:#444444;color:white;">ยอดรายได้ทั้งหมด</td>
            <td style="text-align: left;padding-left:20px;">{{login.can_withdraw + login.withdrawed}} บาท</td>
          </tr>
    		</table>
        <div align="right" style="width:99%;margin: auto;">
         <a slide-toggle="#refer_withdraw">
            <button style="margin:15px;background-color:#387ef5;" type="button" class="btn btn-primary">ถอนเงินที่ได้จากการแนะนำเพื่อน</button>
         </a>
        </div>
        <div id="refer_withdraw" class="slideable" style="margin-bottom:16px;">
          <div style="width:60%;margin:0 auto;border: 1px solid #26A65B;padding-bottom:40px;">
            <div style="background-color:#26A65B;padding:10px;color:white;" class="text-center">รายละเอียดการถอน</div>
            <div class="text-center" style="margin-top:10px;">ถอนเงินเข้า Account : {{ login.username }}  </div>
            <div class="text-center" style="padding:10px 0 10px 0;font-weight:bold;font-size:110%;background-color:#ef473a;color:white;margin: 10px 0 10px 0;">ยอดเงินคงเหลือถอนได้สูงสุด {{ login.can_withdraw }} บาท</div>
            <center>
              <md-input-container>
                <label>ยอดที่ต้องการถอน</label>
                <input ng-change="cal_withdraw_money(login.withdraw_money)" min="1" max="{{ max_money }}" ng-model="login.withdraw_money" type="number" placeholder="ใส่ยอดที่ต้องการถอน" style="width:200px;">
              </md-input-container>
              <div ng-show="show_withdraw_error" style="color:red;">{{ error_text }}</div>
              <br>
              <md-button ng-disabled="disable_ok" class="md-raised md-primary" ng-click="refer_set_deposit(login.username, login.tel, login.withdraw_money)">ตกลง</md-button>
              <div ng-show="show_withdraw_success" style="color:green;">{{ waiting_text }}</div>
            </center>
          </div>
        </div>

        <div style="width:99%;margin: 0px auto 10px auto;font-weight:bold;font-size:105%;">รายการแนะนำเพื่อน</div>
        <table style="width:99%;margin:0 auto;"st-table="displayedCollection" st-safe-src="login.promo_refer_info" class="table table-striped">
    			<thead style="background-color:#444444;color:white;">
    			<tr >
    				<th>วันที่ได้รับส่วนแบ่ง</th>
    				<th>ประเภทส่วนแบ่ง</th>
    				<th>เปอร์เซ็นส่วนแบ่ง</th>
    				<th>ยอดที่ได้รับ</th>
    			</tr>
    			</thead>
    			<tbody>
    			<tr ng-repeat="row in displayedCollection">
    				<td>{{row.promo_refer_transaction_timestamp}}</td>
    				<td>{{row.refer_type}}</td>
    				<td>{{row.promo_refer_transaction_type}}</td>
    				<td>{{row.promo_refer_transaction_amount}}</td>
    			</tr>
    			</tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-center">
                  <div st-items-by-page="30" st-pagination="" st-template="<?php echo get_template_directory_uri(); ?>/deposit.pagination.html"></div>
              </td>
            </tr>
          </tfoot>
    		</table>

        <div style="width:99%;margin: 16px auto 10px auto;font-weight:bold;font-size:105%;">รายการสั่งถอน</div>
        <table style="width:99%;margin:0 auto;"st-table="displayedCollection2" st-safe-src="login.data_withdrawed" class="table table-striped">
    			<thead style="background-color:#444444;color:white;">
    			<tr>
    				<th class="text-center" style="vertical-align: middle;">วันที่สั่งถอนเงิน <br> (เฉพาะรายได้จากการแนะนำเพื่อน)</th>
    				<th class="text-center" style="vertical-align: middle;">จำนวนเงิน</th>
    				<th class="text-center" style="vertical-align: middle;">ผลการถอน</th>
    			</tr>
    			</thead>
    			<tbody>
    			<tr ng-repeat="row2 in displayedCollection2">
    				<td class="text-center">{{row2.promo_refer_transaction_timestamp}}</td>
    				<td class="text-center">{{row2.promo_refer_transaction_amount | abs}}</td>
    				<td class="text-center">สำเร็จ</td>
    			</tr>
    			</tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-center">
                  <div st-items-by-page="30" st-pagination="" st-template="<?php echo get_template_directory_uri(); ?>/deposit.pagination.html"></div>
              </td>
            </tr>
          </tfoot>
    		</table>
      </div>
    </div>


   </div>

   <div  ng-show="showSpin" id="spanLoding">
     <md-progress-circular class="loading" md-mode="indeterminate" md-diameter="100"></md-progress-circular>
   </div>

    </div>

<?php get_footer(); ?>
