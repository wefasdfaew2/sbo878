<?php
/*
Template Name: live_streaming
*/
?>
<?php get_header();?>

<?php
wp_register_script( 'jwplayer', 'https://content.jwplatform.com/libraries/tO4hwnMO.js', true );
wp_enqueue_script( 'jwplayer' );

function get_ip_address2(){
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

$userIP = get_ip_address2();

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

  $isp_ip = unserialize(file_get_contents('http://pro.ip-api.com/php/'.$userIP.'?key=utwEtyx2f6XGIFr'.'&fields=isp,org,reverse,status'));
  if($isp_ip && $isp_ip['status'] == 'success') {
  $user_org = strtolower($isp_ip['org']);
  $user_isp = strtolower($isp_ip['isp']);
  $user_reverse = strtolower($isp_ip['reverse']);
  //echo $user_ip_provider;
  } else {
  $user_isp = "Unable to get isp";
  $user_org = "Unable to get org";
  $user_reverse = "Unable to get reverse";
   echo 'Unable to get isp';
  }

  // 1. org 2. ISP 3. reverse dns
  $key_word_3bb="/jastel|tripletnet|triple|jastel|3bb|tt&t|jastel|jasmine/";
  $key_word_trueonline="/true|trueinternet/";
  $key_word_tot="/tot/";
  $key_word_cat="/cat|hinet/";
  $key_word_ais="/superbroadbandnetwork|awn|sbn|advance/";
  $key_word_dtac="/total|dtac|trinet/";
  $key_word_truemove="/true move|realmove|truemove/";
  if (preg_match($key_word_3bb, $user_isp)== true || preg_match($key_word_3bb, $user_org) || preg_match($key_word_3bb, $user_reverse) ){
    $isp_call="3bb";
  }elseif(preg_match($key_word_trueonline, $user_isp)== true || preg_match($key_word_trueonline, $user_org) || preg_match($key_word_trueonline, $user_reverse) ){
    $isp_call="trueonline";
  }elseif(preg_match($key_word_dtac, $user_isp)== true || preg_match($key_word_dtac, $user_org) || preg_match($key_word_dtac, $user_reverse) ){
    $isp_call="dtac";
  }elseif(preg_match($key_word_tot, $user_isp)== true || preg_match($key_word_tot, $user_org) || preg_match($key_word_tot, $user_reverse) ){
    $isp_call="tot";
  }elseif(preg_match($key_word_ais, $user_isp)== true || preg_match($key_word_ais, $user_org) || preg_match($key_word_ais, $user_reverse) ){
    $isp_call="ais";
  }elseif(preg_match($key_word_truemove, $user_isp)== true || preg_match($key_word_truemove, $user_org) || preg_match($key_word_truemove, $user_reverse) ){
    $isp_call="truemove";
  }else{
    $isp_call="อื่นๆ";
  }
  //echo $isp_call;
 ?>
 <div id="page" class="single">
 <div class="content"><!--get_channel_list('0');-->
<div ng-app="MyApp" ng-controller="Player" ng-cloak="" style="margin-top:10px;"
				ng-init="get_fast_tabs(); gen_token('<?php echo $userIP ?>');
        promote_play(<?php echo $id ?>,'<?php echo $server ?>','<?php echo $bitrate ?>','<?php echo $mode ?>');
        get_internet_isp('<?php echo $isp_call ?>')">

<div layout="row" layout-align="center center">
    <h2 ng-bind-html="channel_title_html"></h2>
</div>
<div layout="row" layout-align="end center">
  <a href="<?php echo get_permalink(314); ?>">
    <md-button class="md-raised md-primary" md-no-focus-style="true" style="padding-left:15px;padding-right:15px;margin-right:20px;">
      ตารางถ่ายทอดสด
    </md-button>
  </a>
</div>
<div ng-show="youtube_id == false" layout="column" style="padding-left:16px;padding-right:16px;">

  <div layout="row">
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
  		<div>เลือกระดับความคมชัด &nbsp;</div>
      <md-input-container>
  	    <label></label>
  	      <md-select ng-model="bitrate" ng-change="set_cookies('bitrate',bitrate)" aria-label="bitrate">
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
</div>
<div layout="row" layout-align="center center">
  <div ng-style="{ 'display' : jwplayer_display }">
	   <div id='playerKXSDPIwKERSva'></div>
  </div>
  <div ng-style="{ 'display' : ios_android_display }" >
    <img ng-if="(deviceDetector == 'ios') && (from_promote_link == false)" ng-src="{{ siteurl + '/images/Safari-player.jpg' }}" >
    <!--<img ng-if="(deviceDetector == 'android') == (from_promote_link == false)" ng-src="{{ siteurl + '/images/android-player.jpg' }}">-->
    <div ng-if="(deviceDetector == 'android') && (from_promote_link == false)">
      <table width="940" height="230" border="0" cellpadding="0" cellspacing="0">
      	<tr>
      		<td colspan="3">
      			<img src="<?php echo get_template_directory_uri(); ?>/images/MXInstall_01.jpg" width="940" height="150" alt=""></td>
      	</tr>
      	<tr>
      		<td rowspan="2">
      			<img src="<?php echo get_template_directory_uri(); ?>/images/MXInstall_02.jpg" width="684" height="80" alt=""></td>
      		<td>
      			<a href="https://play.google.com/store/apps/details?id=com.mxtech.videoplayer.ad" target="_blank">
      				<img src="<?php echo get_template_directory_uri(); ?>/images/InstallMXPlayer.jpg" width="220" height="53" border="0" alt=""></a></td>
      		<td rowspan="2">
      			<img src="<?php echo get_template_directory_uri(); ?>/images/MXInstall_04.jpg" width="36" height="80" alt=""></td>
      	</tr>
      	<tr>
      		<td>
      			<img src="<?php echo get_template_directory_uri(); ?>/images/MXInstall_05.jpg" width="220" height="27" alt=""></td>
      	</tr>
      </table>
    </div>
  </div>
  <div ng-bind-html="link_promote_player" ></div>

  <div ng-style="{ 'display' : youtube_display }">
    <iframe width="940" height="534" ng-src="{{ youtube_link }}" frameborder="0" allowfullscreen></iframe>
  </div>
</div>
<div ng-show="youtube_id == false" layout="row" class="md-padding" layout-align="end center" style="">
	<div layout="row" layout-align="end center">
	<div>เลือกรุปแบบ Stream: &nbsp;</div>
  <!--<md-input-container>
    <label></label>
      <md-select ng-model="player_protocol" ng-change="set_cookies('player_protocol',player_protocol)">
        <md-option value="rtmp">FLASH (ดูได้เฉพาะบน PC)</md-option>
        <md-option value="http">HTTP (ดูได้ทุกอุปกรณ์)</md-option>
    </md-select>
  </md-input-container>-->

	<md-radio-group layout="row" ng-model="player_protocol" ng-change="set_cookies('player_protocol',player_protocol)">
    <md-radio-button value="rtmp" class="md-primary">FLASH (ดูได้เฉพาะบน PC)</md-radio-button>
		<md-radio-button value="http" class="md-primary">HTTP (ดูได้ทุกอุปกรณ์)</md-radio-button>
  </md-radio-group>
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
  <div id="fastTabs"></div>
  <div id="fastTabssss"></div>



	<!--<md-tabs  md-dynamic-height md-border-bottom>

		<md-tab ng-repeat="x in channel_cat | orderBy: '+sort' | filter:{enable: 'true'}:true" label="{{x.cat_name}}" ng-click="get_channel_list2(x.id)">
			<md-content class="md-padding" layout="row" layout-wrap layout-align="center center" style="background-color: #ECEFF1;">
				<div layout="row" layout-wrap layout-align="center center" style="padding-top:5px;padding-bottom:5px;">
					<div ng-repeat="channel in channel_list | filter:{enable: 'true'}:true">
						&nbsp;
						<a ng-click="get_player_link(channel.id)" style="cursor: pointer;">
							<img ng-src={{channel.channel_logo_ssl}} class="md-avatar" class="img-responsive center-block" style="padding-top:10px;"/>
						</a>
					</div>
				</div>
			</md-content>
		</md-tab>
	</md-tabs>-->
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
