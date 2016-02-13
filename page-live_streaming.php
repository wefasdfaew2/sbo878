<?php
/*
Template Name: live_streaming
*/
?>
<?php get_header();?>

<?php

function get_ip_address(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
}

$userIP = get_ip_address();

if(isset($_GET['id']) && isset($_GET['server']) && isset($_GET['bitrate']) && isset($_GET['mode'])) {
        $id = $_GET['id']; //channel_id
        $server = $_GET['server'];
        $bitrate = $_GET['bitrate'];
        $mode = $_GET['mode'];
}else{
	$id = 'no-promote';
	$server = 'no-promote';
	$bitrate = 'no-promote';
	$mode = 'no-promote';
}


 ?>
 <div id="page" class="single">
 <div class="content">
<div ng-app="MyApp" ng-controller="Player" ng-cloak="" style="margin-top:10px;"
				ng-init="gen_token('<?php echo $userIP ?>'); get_channel_list(0); promote_play(<?php echo $id ?>,'<?php echo $server ?>','<?php echo $bitrate ?>','<?php echo $mode ?>');">

<div layout="row" style="padding-left:16px;padding-right:16px;">
	<div layout="row" layout-align="start center">
		<div>เลือกเซิฟเวอร์ &nbsp;</div>
		<md-input-container>
	    <label>รายชื่อเซิฟเวอร์</label>
	      <md-select ng-model="serverurl" ng-change="set_cookies('serverurl',serverurl)">
	        <md-option ng-repeat="server in server_list | orderBy: '+id' | filter:{enable: 'true'}:true" value="{{server.server_url}}">
	             {{server.server_name}}
	        </md-option>
	    </md-select>
	  </md-input-container>
	</div>
	<span flex></span>
	<div layout="row" layout-align="end center">
		<div>Bitrate &nbsp;</div>
    <md-input-container>
	    <label></label>
	      <md-select ng-model="bitrate" ng-change="set_cookies('bitrate',bitrate)">
	        <md-option value="720p">720p</md-option>
          <md-option value="480p">480p</md-option>
          <md-option value="360p">360p</md-option>
          <md-option value="3g">3G/4G (ประหยัด Data)</md-option>
	    </md-select>
	  </md-input-container>
		<!--<md-radio-group layout="row" ng-model="bitrate" ng-change="set_cookies('bitrate',bitrate)">
	    <md-radio-button value="720p" class="md-primary">720p</md-radio-button>
			<md-radio-button value="480p" class="md-primary">480</md-radio-button>
			<md-radio-button value="360p" class="md-primary">360p</md-radio-button>
			<md-radio-button value="3g" class="md-primary">3G/4G (ประหยัด Data)</md-radio-button>
	  </md-radio-group>-->
	</div>
</div>
<div layout="row" layout-align="center center">
	<div id='playerKXSDPIwKERSva'></div>
</div>
<div layout="row" class="md-padding" layout-align="end center" style="">
	<div layout="row" layout-align="end center">
	<div>เลือกรุปแบบ Stream: &nbsp;</div>
  <md-input-container>
    <label></label>
      <md-select ng-model="player_protocol" ng-change="set_cookies('player_protocol',player_protocol)">
        <md-option value="rtmp">FLASH (ดูได้เฉพาะบน PC)</md-option>
        <md-option value="http">HTTP (ดูได้ทุกอุปกรณ์)</md-option>
    </md-select>
  </md-input-container>

<!--	<md-radio-group layout="row" ng-model="player_protocol" ng-change="set_cookies('player_protocol',player_protocol)">
    <md-radio-button value="rtmp" class="md-primary">FLASH (ดูได้เฉพาะบน PC)</md-radio-button>
		<md-radio-button value="http" class="md-primary">HTTP (ดูได้ทุกอุปกรณ์)</md-radio-button>
  </md-radio-group>-->
	</div>
</div>

<md-content class="md-padding">

	<md-toolbar class="md-primary">
    <div class="md-toolbar-tools">
      <span flex="5"></span>
      <h1>
        <span id="head1" style="color:white;">เลือกช่องตามหมวด</span>
      </h1>
      <span flex></span>
    </div>
  </md-toolbar>
	<md-tabs md-dynamic-height md-border-bottom>
		<md-tab ng-repeat="x in channel_cat | orderBy: '+sort' | filter:{enable: 'true'}:true" label="{{x.cat_name}}" ng-click="get_channel_list(x.id)">
			<md-content class="md-padding" layout="row" layout-wrap layout-align="center center" style="background-color: #ECEFF1;">
				<div layout="row" layout-wrap layout-align="center center" style="padding-top:5px;padding-bottom:5px;">
					<div ng-repeat="channel in channel_list | filter:{enable: 'true'}:true">
						&nbsp;
						<a ng-click="get_player_link(channel.id)" style="cursor: pointer;">
							<img ng-src={{channel.channel_logo_ssl}} class="md-avatar" class="img-responsive center-block" style="padding-top:10px;" />
						</a>
					</div>
				</div>
			</md-content>
		</md-tab>
	</md-tabs>
</md-content>
</div>
<?php get_footer(); ?>


	<!--<div id="page" class="single">
		<div class="article">
	<div layout="row">
		<div>testyy</div>
		<div>testyy</div>
		<div>testyy</div>
		<div>testyy</div>
		<div>testyy</div>
		<div>
				<input type="text" ng-model="name">
				<p>Hello, {{name}}!</p>
		</div>
	</div>
</div>-->


<?php/**if (!empty($_POST['id']) && !empty($_POST['server']) && !empty($_POST['bitrate']) && !empty($_POST['mode'])) {
    $id = $_POST['id']; //channel_id
        $server = $_POST['server'];
    $bitrate = $_POST['bitrate'];
    $mode = $_POST['mode'];
}**/
//$id = $_GET['id'];
//$server = $_GET['server'];
//$bitrate = htmlspecialchars($_GET['bitrate']);?>
