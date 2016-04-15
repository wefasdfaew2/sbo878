<?php
/*
Template Name: promotion-cashback
*/
?>
<?php get_header();?>

<script type="text/javascript">
var app = angular.module('MyPromotionCashback', ['ngMaterial', 'ngMessages', 'smart-table']);

app.controller('PromotionCashback', function($scope, $http) {

  console.log("PromotionCashback !!!");

  $scope.templateUrl = WPURLS.templateurl + '/images';
  //$scope.lotto_winner = function(){
    var get_winner = $http({
      method: "post",
      url: WPURLS.templateurl + "/php/get-cashback-winner.php",
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    get_winner.success(function(winner) {
      $scope.winner_list = winner;

    });
  //}


});

</script>
<div id="page" class="single">
  <div class="content">
    <div  style="margin-top:0px;" ng-app="MyPromotionCashback" ng-controller="PromotionCashback" ng-cloak="">
      <center>
        <h2 class="page-title">
          <div style="width: 90%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">ตรวจสอบรายชื่อผู้โชคดี</div>
        </h2>
      </center>
      <table style="width:80%;margin:20px auto;" class="table table-striped" st-table="displayedCollection" st-safe-src="winner_list"  >
       <thead>
       <tr style="background-color:#ef473a;color:white;">
         <th style="text-align: center;">รอบเดือน</th>
         <th style="text-align: center;">Username ที่ได้รับ cashback</th>
         <th style="text-align: center;">จำนวนยอด</th>
         <th style="text-align: center;">หมายเหตุ</th>
       </tr>
       </thead>
       <tbody ng-show="!mc.isLoading">
       <tr ng-repeat="row in winner_list">
         <td style="vertical-align: middle;text-align: center;">{{ row.period_day }}</td>
         <td style="vertical-align: middle;text-align: center;">
           <img ng-src="{{ templateUrl }}/reward_{{ row.reward }}.png" />
           {{ row.username }}
         </td>
         <td style="vertical-align: middle;text-align: center;">{{ row.cashback_amount }}</td>
         <td style="vertical-align: middle;text-align: center;">{{ row.note }}</td>

       </tr>
       </tbody>
       <tbody ng-show="mc.isLoading">
         <tr>
           <td colspan="5" class="text-center">Loading ... </td>
         </tr>
       </tbody>
       <tfoot>
        <tr>
         <td colspan="4" class="text-center">
             <div st-items-by-page="50" st-pagination="" st-template="<?php echo get_template_directory_uri(); ?>/deposit.pagination.html"></div>
         </td>
        </tr>
      </tfoot>
     </table>

    </div>
<?php get_footer(); ?>
