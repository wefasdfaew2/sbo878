<?php
/*
Template Name: withdraw-check
*/
?>
<?php get_header();?>
<?php
  wp_register_script('withdraw-check', get_template_directory_uri() . '/js/withdraw-check.js', true);
  wp_enqueue_script('withdraw-check');
?>

 <div id="page" class="single">
   <div class="content">
     <div ng-app="MyWithdrawCheck" ng-controller="WithdrawCheck as mc" ng-cloak="" style="margin-top:10px;">

       <center>
         <h2 class="" style="width: 100%;background-color: #1f4611;color: #fff;">
           <div style="width: 80%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">ตรวจสอบรายการถอน (อัพเดตสถานะอัตโนมัติ)</div>
         </h2>
         <br>
       </center>

       <table  class="table table-striped" st-pipe="mc.callServer" st-table="mc.displayed">
         <tr>
      		<th colspan="2">
      		</th>
      		<th>
      			<input st-search="withdraw_account" placeholder="ค้นจาก username" class="input-sm form-control" type="search"/>
      		</th>
          <th colspan="3">
      		</th>
      	</tr>
        <thead>
      	<tr>
      		<th style="white-space:nowrap;text-align: center;">วันที่ทำรายการ</th>
          <th style="white-space:nowrap;text-align: center;">ประเภทบัญชี</th>
      		<th style="white-space:nowrap;text-align: center;">Username</th>
      		<th style="white-space:nowrap;text-align: center;">ถอนเข้าบัญชีเลขที่</th>
          <th style="white-space:nowrap;text-align: center;">สถานะรายการ</th>
          <th>หมายเหตุ</th>
      	</tr>
      	</thead>
      	<tbody ng-show="!mc.isLoading">
      	<tr ng-repeat="row in mc.displayed">
      		<td style="vertical-align: middle;text-align: center;">{{ row.withdraw_regis }}</td>
      		<td style="vertical-align: middle;text-align: center;">{{ row.withdraw_member_name }}</td>
          <td style="vertical-align: middle;text-align: center;">{{ row.hide_withdraw_account }}</td>
          <td style="vertical-align: middle;text-align: center;">
            <div layout="column"  layout-align="center center">
              <img ng-src="<?php echo get_template_directory_uri(); ?>{{ row.withdraw_type_name }}"/>
              <div>{{ row.withdraw_bank_account }}</div>
            </div>
          </td>

      		<td style="vertical-align: middle;white-space:nowrap;text-align: center;">
            <img
            ng-src="<?php echo get_template_directory_uri(); ?>/images/withdraw-Status{{ row.withdraw_status_id }}.gif"
            />
          </td>
      		<td style="vertical-align: middle;text-align: center;">{{ row.withdraw_note }}</td>
      	</tr>
      	</tbody>
        <tbody ng-show="mc.isLoading">
          <tr>
            <td colspan="5" class="text-center">Loading ... </td>
          </tr>
        </tbody>
        <tfoot>
    <tr>
        <td colspan="6" class="text-center">
            <div st-items-by-page="10" st-pagination="" st-template="<?php echo get_template_directory_uri(); ?>/deposit.pagination.html"></div>
        </td>
    </tr>
    </tfoot>
      </table>
     </div>


<?php get_footer(); ?>
