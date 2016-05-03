<?php
/*
Template Name: live_schedule
*/
?>
<?php
//prevent direct access
 if ( ! defined( 'ABSPATH' ) ) die( 'Error!' );
//prevent direct get data from outsite
/*
$http_refer ='http://sbogroup.t-wifi.co.th/wordpress/index.php/user_inform_transfer';
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $http_refer){
}else{
 die( 'Error!2' );
}
*/

get_header();
?>
 <?php
 wp_register_script('angular-locale_th-th', get_template_directory_uri() . '/js/angular-locale_th-th.js', true);
 wp_enqueue_script('angular-locale_th-th');

 wp_register_script('ui-bootstrap', get_template_directory_uri() . '/js/ui-bootstrap-tpls-1.1.2.min.js', true);
 wp_enqueue_script('ui-bootstrap');

 wp_register_script('backend_live_schedule', get_template_directory_uri() . '/js/backend_live_schedule.js', true);
  wp_enqueue_script('backend_live_schedule');

  if(empty($_POST["password"]))
    {

        $check_p = 'false';//true
    }else {
      if($_POST["password"] == 's4722team'){
        $check_p = 'false';
      }
    }

 ?>

 <style>
 #spanLoding {
   position: fixed;
   background-color: rgba(0, 0, 0, 1);
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

   <?php

	//echo $user_name;
   // echo '<div ng-app="app_user_inform_transfer" ng-controller="cont_user_inform_transfer" ng-cloak="" ng-init="user_waiting_list('.$user_name.')">';
 ?>

	<div ng-app="app_backend_live_schedule" ng-controller="cont_backend_live_schedule as ctrl" ng-cloak="" ng-init="data_list('0')">

 </br>

 <div class="container">
 <table class="table">
	  <thead  style="color: #000000;" >
      <tr align="center">
		<th class="col-md-2">วันที่</th>
		<th class="col-md-3">เวลา</th>
      </tr>

    </thead>
    <tbody>
      <tr>
        <td><uib-datepicker ng-model="u.dt" datepicker-options="inlineOptions"></uib-datepicker></td>
        <td><uib-timepicker   ng-model="u.mytime"  hour-step="hstep" minute-step="mstep" show-meridian="false"></uib-timepicker></td>
      </tr>

    </tbody>
  </table>
  <h3>เลือกลีกค์</h3>
    <div ng-repeat="list_league in json_data_league">
	    <input
    name="radir_list_league"
    type="radio"
    value="{{list_league.league_name}}"
    ng-model="$parent.radio1_league"
	ng-change="on_radir_list_league()"
	/>
	{{list_league.league_name}}
	</div>

	<div class="row">
  <div class="col-md-6  col-xs-6 col-sm-6 " >
	<h3>เลือกทีมเจ้าบ้าน</h3>
	 <div ng-repeat="list_team_hw in json_data_team_hw"   >
	    <input
    name="radio_list_team_h"
    type="radio"
    value="{{list_team_hw.team_name}}"
    ng-model="$parent.radio2_team_home"
	ng-change="on_radir_team_h()"
	/>
	{{list_team_hw.team_name}}
	</div>
  </div>

	 <div class="col-md-6  col-xs-6 col-sm-6 "  >
	<h3>เลือกทีมเยือน</h3>
	 <div ng-repeat="list_team_hw in json_data_team_hw"   >
	   <input
    name="radio_list_team_aw"
    type="radio"
    value="{{list_team_hw.team_name}}"
    ng-model="$parent.radio3_team_away"
	ng-change="on_radir_team_aw()"
	/>
	{{list_team_hw.team_name}}
	</div>
	</div>

	</div>

	<!--<div class="row">
  <div class="col-md-8  col-xs-8 col-sm-8 " >-->

  <div>
      <h3>ชื่อทีมที่ต้องการบันทึก (หรือสามารถแก้ไขได้ที่นี่ก่อนบันทึก)</h3>
	<!--<md-input-container>
        <label>ทีมเจ้าบ้าน</label>
        <input ng-model="insert_team_home">
      </md-input-container>
	   <md-input-container>
        <label>ทีมเยือน</label>
        <input ng-model="insert_team_away">
      </md-input-container>-->

      <div layout="row">
        <span flex></span>
        <div layout="column">
          <label>ทีมเจ้าบ้าน</label>
          <md-autocomplete
          style="width: 300px;"
             md-no-cache="true"
             md-selected-item="selectedhome"
             md-search-text-change="ctrl.searchTextChange(ctrl.searchText)"
             md-search-text="ctrl.searchText"
             md-selected-item-change="ctrl.selectedItemChange(selectedhome.team_name)"
             md-items="item in ctrl.querySearch(ctrl.searchText)"
             md-item-text="item.team_name"
             md-min-length="0"
             placeholder="Team name ?"
             >

             <md-item-template>
              <span md-highlight-text="ctrl.searchText" >{{item.team_name}}</span>
            </md-item-template>
            <md-not-found>
              ไม่มีทีม "{{ctrl.searchText}}" ในดาต้าเบส.
              <a ng-click="ctrl.newState(ctrl.searchText)">คลิกเพื่อใช้ทีมนี้</a>
            </md-not-found>
          </md-autocomplete>
        </div>
        <span flex="5"></span>
        <div layout="column">
          <label>ทีมเยือน</label>
          <md-autocomplete
          style="width: 300px;"
             md-no-cache="true"
             md-selected-item="selectedaway"
             md-search-text-change="ctrl.searchTextChange2(ctrl.searchText2)"
             md-search-text="ctrl.searchText2"
             md-selected-item-change="ctrl.selectedItemChange2(selectedaway.team_name)"
             md-items="item in ctrl.querySearch(ctrl.searchText2)"
             md-item-text="item.team_name"
             md-min-length="0"
             placeholder="Team name ?"
             >

             <md-item-template>
              <span md-highlight-text="ctrl.searchText2" >{{item.team_name}}</span>
            </md-item-template>
            <md-not-found>
              ไม่มีทีม "{{ctrl.searchText2}}" ในดาต้าเบส.
              <a ng-click="ctrl.newState2(ctrl.searchText2)">คลิกเพื่อใช้ทีมนี้</a>
            </md-not-found>
          </md-autocomplete>
        </div>
        <span flex></span>
      </div>


    </div>



    <br>
    <ul style="-webkit-column-count: 3;-moz-column-count: 3;column-count: 3;list-style: none;">
      <li ng-repeat="list_ch in json_data_list_ch">
        <input type="checkbox" ng-checked="ch_exists(list_ch.id, ch_selected)" ng-click="ch_toggle(list_ch.id, ch_selected)">
                    {{list_ch.channel_name}} ( {{ list_ch.id }} )
        <!--</md-checkbox>-->
      </li>
    </ul>




</div>



<center>
	 <div>
   <md-button ng-click="insertdata()" class="md-raised md-warn md-hue-2">ยืนยัน</md-button>
   </div>
      {{result}}
    </center>
   <div  ng-show="<?php echo $check_p; ?>" id="spanLoding">
     <form class="loading" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

      <input type="password" name="password" style="background-color:white;">
      <br><br>
      <center><input type="submit" style="background-color:white;"></center>
      </form>
   </div>


</div>



      <!-- end angularjs-->


<?php get_footer(); ?>
