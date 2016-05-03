<?php
/*
Template Name: live-schedule-frontend
*/
?>
<?php get_header();?>
<?php
  wp_register_script('date-thai', get_template_directory_uri().'/js/angular-locale_th-th.js', true);
  wp_enqueue_script('date-thai');
?>
<script type="text/javascript">
var app = angular.module('MyLiveSchedule', ['ngMaterial', 'ngMessages', 'smart-table']);

app.controller('LiveSchedule', function($scope, $http, $filter) {

  //console.log("LiveSchedule !!!");

  var today = $filter('date')(Date.now(), 'yyyy-MM-dd', '+0700');
  var be = parseInt($filter('date')(Date.now(), 'yyyy', '+0700')) + 543;
  $scope.show_today = $filter('date')(Date.now(), 'EEEEที่ dd MMMM พ.ศ. ' + be, '+0700');

  var get_league = $http({
    method: "post",
    url: WPURLS.templateurl + "/php/get-league-list.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  get_league.success(function(league) {
    $scope.league_list = league;

  });

  var get_schedule = $http({
    method: "post",
    url: WPURLS.templateurl + "/php/get-live-schedule.php",
    data: {
      today: today
    },
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  get_schedule.success(function(schedule) {
    $scope.schedule_list = schedule;
    //$scope.channel_logo =
    //console.log($scope.schedule_list);
     //var res = str.split(" ");
  });


});

</script>
<div id="page" class="single">
  <div class="content">
    <div  style="margin-top:0px;" ng-app="MyLiveSchedule" ng-controller="LiveSchedule" ng-cloak="">
      <center>
      <h2 class="page-title">
        <div style="width: 80%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">ตารางถ่ายทอดสด</div>
      </h2>
      <div style="margin:20px;font-size:16px;">ตารางถ่ายทอดสด โปรแกรมบอล โปรแกรมฟุตบอล วันนี้ {{ show_today }}</div>
    </center>
      <div ng-repeat="league in league_list">
        <div style="background-color:#387ef5;font-weight: bold;text-indent: 10px;width:90%;margin:10px auto 0px auto;color:white;padding: 10px 5px 5px 5px;" ng-if="(schedule_list|filter:{schedule_league:league.league_name}).length != 0">
          <img ng-if="league.league_logo != ''" ng-src="<?php echo get_template_directory_uri(); ?>/images/{{ league.league_logo }}" alt="ดูบอลออนไล์ ดูบอลสด" style="margin-right: 3px;" width="35" height="35"/>
          <img ng-if="league.league_logo == ''" ng-src="<?php echo get_template_directory_uri(); ?>/images/noimage.jpg" alt="ดูบอลออนไล์ ดูบอลสด" style="margin-right: 3px;" width="35" height="35"/>{{ league.league_name }}
        </div>
        <table  style="width:90%;margin:0 auto;" ng-if="(schedule_list|filter:{schedule_league:league.league_name}).length != 0" class="table table-striped">
         <thead>
         	<tr style="background-color:#73a4f8;color:white;">
         		<th style="text-align: center;">เวลา</th>
         		<th style="text-align: right;">เจ้าบ้าน</th>
         		<th style="text-align: left;">ทีมเยือน</th>
         		<th style="text-align: center;">ช่องที่ถ่ายทอดสด</th>
         	</tr>
       	 </thead>
          <tbody>
           <tr ng-repeat="row in schedule_list | orderBy: '+schedule_time' | filter:{schedule_league: league.league_name}:true">
           		<td style="vertical-align: middle;width:76px;white-space:nowrap;text-align: center;">{{ row.schedule_time }}</td>
           		<td style="vertical-align: middle;width:195px;text-align: right;">
                {{ row.schedule_home }}
                <img ng-src="<?php echo get_template_directory_uri(); ?>/images/{{ row.home_logo }}" style="margin-left:3px;" width="35" height="35"/>
              </td>
           		<td style="vertical-align: middle;width:195px;text-align: left;">
                <img ng-src="<?php echo get_template_directory_uri(); ?>/images/{{ row.away_logo }}" style="margin-right:3px;" width="35" height="35"/>
                {{ row.schedule_away }}
              </td>
              <td style="vertical-align: middle;width:400px;text-align: center;">
                <a ng-if="key != ''" ng-repeat="(key, value) in row.schedule_channel" href="<?php echo get_permalink(74); ?>?id={{ key }}&server=auto&bitrate=360&mode=http" >
                  <img ng-src="{{ value }}" style="margin:2px;" width="117" height="60" alt="ดูบอลออนไล์ ดูบอลสด"/>
                </a>
              </td>
           	</tr>
       	  </tbody>
       </table>
      </div>
    </div>
<?php get_footer(); ?>
