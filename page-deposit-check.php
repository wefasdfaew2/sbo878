<?php
/*
Template Name: deposit-check
*/
?>
<?php get_header();?>
<?php
  wp_register_script('deposit-check', get_template_directory_uri() . '/js/deposit-check.js', true);
  wp_enqueue_script('deposit-check');
?>

 <div id="page" class="single">
   <div class="content">
     <div ng-app="MyDepositCheck" ng-controller="DepositCheck" ng-cloak="" style="margin-top:10px;">

       <center>
         <h2 class="" style="width: 100%;background-color: #792825;color: #fff;">
           <div style="width: 80%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">ตรวจสอบรายการฝาก (อัพเดตสถานะอัตโนมัติ)</div>
         </h2>
         <br>
       </center>

       <table  st-table="display_deposit_state" st-safe-src="deposit_state" class="table table-striped">
      	<thead>
      	<tr>
      		<th style="white-space:nowrap;width:150px;text-align: center;">วันที่ทำรายการ</th>
      		<th style="white-space:nowrap;width:150px;text-align: center;">Username</th>
      		<th style="white-space:nowrap;width:160px;text-align: center;">ช่องทางชำระเงิน</th>
      		<th style="white-space:nowrap;width:180px;text-align: center;">สถานะรายการ</th>
          <th style="text-align: center;">หมายเหตุ</th>
      	</tr>
      	</thead>
      	<tbody>
      	<tr ng-repeat="row in display_deposit_state">
      		<td style="vertical-align: middle;white-space:nowrap;text-align: center;">{{ row.deposit_regis }}</td>
      		<td style="vertical-align: middle;text-align: center;">{{ row.deposit_account }}</td>
      		<td style="vertical-align: middle;text-align: center;">
            <img ng-src="<?php echo get_template_directory_uri(); ?>{{ row.deposit_type_name }}" width="80" height="33"/>            
          </td>
      		<td style="vertical-align: middle;white-space:nowrap;text-align: center;">
            <img ng-if="row.deposit_status_id == 1"
            ng-src="<?php echo get_template_directory_uri(); ?>/images/deposit-Status1.gif"
            width="150" height="33" />
            <img ng-if="row.deposit_status_id == 2"
            ng-src="<?php echo get_template_directory_uri(); ?>/images/deposit-Status2.gif"
            width="150" height="33" />
            <img ng-if="row.deposit_status_id != 1 && row.deposit_status_id != 2"
            ng-src="<?php echo get_template_directory_uri(); ?>/images/deposit-Status{{ row.deposit_status_id }}.gif"
            width="150" height="33" />
          </td>
      		<td style="vertical-align: middle;text-align: center;">{{ row.deposit_note }}</td>
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
