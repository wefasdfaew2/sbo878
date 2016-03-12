
var app = angular.module('max_MyApp', ['ngMaterial', 'ngMessages','ng.deviceDetector','ipCookie']);
 
 
    
   
  var v_email = false;
  var v_phone = false;
  var v_phone2 = false;
 


app.controller('max_user_detail', function($scope, $http,deviceDetector,ipCookie,$timeout) {
  

 $scope.bt_otp1 =true;
 $scope.bt_otp2 =true;
 //$scope.bt_validate=true;
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
  var mytimer =  setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.text(minutes + ":" + seconds);
		if(--timer == 0){
		$scope.bt_otp1 =false;
		$scope.$apply();
		 clearInterval(mytimer);
		}
/* if loop
        if (--timer < 0) {
            timer = duration;
        }*/
    }, 1000);
}
function startTimer2(duration, display) {
    var timer = duration, minutes, seconds;
  var mytimer =  setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.text(minutes + ":" + seconds);
		if(--timer == 0){
		$scope.bt_otp2 =false;
		$scope.$apply();
		 clearInterval(mytimer);
		}
/* if loop
        if (--timer < 0) {
            timer = duration;
        }*/
    }, 1000);
}

jQuery(function ($) {
    var fiveMinutes = 60 * 1,
        display = $('#bt_time1');
    startTimer(fiveMinutes, display);
});

jQuery(function ($) {
    var fiveMinutes = 60 * 1,
        display = $('#bt_time2');
    startTimer2(fiveMinutes, display);
});

 $scope.bank_name = [
          "ธนาคารกรุงเทพ",
          "ธนาคารกรุงศรีอยุธยา",
          "ธนาคารกสิกรไทย",
		   "ธนาคารไทยพาณิชย์",
		    "ธนาคารกรุงไทย",
          "ธนาคารทหารไทย"
      ];
	  
	   $scope.m_type = [
          "sbobet", 
          "gclub"
      ];
  
   $scope.user_init = {
  
      bname: 'ธนาคารกรุงเทพ',
	  mtype: 'sbobet'
	  
    };
	 

  // social register create a blank object to handle form data.
        $scope.user = {};
		      // calling our submit function.
        $scope.submitForm = function(id,ip) {
	 
	 	 $scope.user.REGIS_FROM = 'social';
         $scope.user.ID = id;
		 $scope.user.IP = ip;
		 $scope.user.OS = deviceDetector.os;
		 $scope.user.DEVICE = deviceDetector.device;
		 $scope.user.BROWSER = deviceDetector.browser;
		 $scope.user.COOKIE = ipCookie('sbobet878', ip, { encode: function (value) { return value; } });
		 
		 
        $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/update-user-data', 
		  data    : $scope.user,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		   
         })
          .success(function(data) {
           
              $scope.message = data.message;
			  setTimeout("location.href = ' http://sbogroup.t-wifi.co.th/wordpress/index.php/user-register-done';",500);
		 
          });
        };	  
		  // wp register create a blank object to handle form data.
        $scope.user_wp = {};
		      // calling our submit function.
        $scope.submitForm_user_wp = function(ip) {
	 	 $scope.user_wp.REGIS_FROM = 'wp';
		 $scope.user_wp.IP = ip;
		 $scope.user_wp.OS = deviceDetector.os;
		 $scope.user_wp.DEVICE = deviceDetector.device;
		 $scope.user_wp.BROWSER = deviceDetector.browser;
		 $scope.user_wp.COOKIE = ipCookie('sbobet878', ip, { encode: function (value) { return value; } });
		  //console.log(ip);
		 
        $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/update-user-data', 
		  data    : $scope.user_wp,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		   
         })
          .success(function(data) {
           
              $scope.message = data.message;
			   setTimeout("location.href = ' http://sbogroup.t-wifi.co.th/wordpress/index.php/user-register-done';",500);
		  
		 
          });
        };	  
	 
 
		//call select data
		$scope.user_data = {};
		$scope.submitForm_query= function(id) {
 
        $scope.user_data.ID = id;
		 $scope.user_data.id_cmd = id; //if query data
		 
        $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/update-user-data', 
		  data    : $scope.user_data,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		   
         })
          .success(function(user_detail) {
           
              $scope.json_user_detail = user_detail;
			 
          });
        };
		
		// otp 1 number create a blank object to handle form data.
		 
        $scope.user_otp = {};
		      // calling our submit function.
        $scope.submitForm_otp_1 = function(id,ref_otp) {
		$scope.user_otp.REGIS_FROM = 'otp';
		$scope.user_otp.ID = id;
		$scope.user_otp.ref_otp = ref_otp;
        $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/update-user-data', 
		  data    : $scope.user_otp,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
          .success(function(data) {
            $scope.message_bt_otp1 = data.message_bt_otp1;
			$scope.message_otp1 = data.message_otp1;
			   
			   if (data.otp_status=='yes')//then update otp _verf db
				{
				$scope.user_otp.REGIS_FROM = 'otp_update_verf';
				  $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/update-user-data', 
		  data    : $scope.user_otp,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		 
         }) 
		 .success(function(data){
		 setTimeout("location.href = ' http://sbogroup.t-wifi.co.th/wordpress/index.php/user-register-done';",500);
		});
		 		}
			 
          });
        };	
	// otp 2 number create a blank object to handle form data.
		 
        $scope.user_otps = {};
		      // calling our submit function.
        $scope.submitForm_otps = function(id,ref_otp1,ref_otp2) {
		$scope.user_otps.REGIS_FROM = 'otps';
		$scope.user_otps.ID = id;
		$scope.user_otps.ref_otp1 = ref_otp1;
		$scope.user_otps.ref_otp2 = ref_otp2;
        $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/update-user-data', 
		  data    : $scope.user_otps,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
          .success(function(data) {
            $scope.message_otps = data.message_otps;
			$scope.message_otps1 = data.message_otps1;
			 $scope.message_otps2 = data.message_otps2;  
			// console.log(data);
		 
			   if (data.otp_status=='yes')//then update otp _verf db
				{
				$scope.user_otps.REGIS_FROM = 'otp_update_verf';
				  $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/update-user-data', 
		  data    : $scope.user_otps,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		 
         }) 
		 .success(function(data){
		 setTimeout("location.href = ' http://sbogroup.t-wifi.co.th/wordpress/index.php/user-register-done';",500);
		});
		 		}
			 
          });
        };
		
			//renew_otp
		$scope.user_otps_renew = {};
		$scope.submitForm_otp_renew= function(id,ref_otp,phone_number,bt_num) {
		$scope.user_otps_renew.REGIS_FROM = 'otps_renew';
        $scope.user_otps_renew.ID = id;
		$scope.user_otps_renew.ref_otp = ref_otp;
		$scope.user_otps_renew.phone_number = phone_number;
		$scope.user_otps_renew.bt_num = bt_num;
		 
        $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/update-user-data', 
		  data    : $scope.user_otps_renew,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		   
         })
          .success(function(data) {
           
              $scope.msg_user_otps_bt_1 = data.msg_user_otps_bt_1;
			  $scope.msg_user_otps_bt_2 = data.msg_user_otps_bt_2;
			  if (data.msg_user_otps_bt_1=='yes')//then update otp _verf db
				{
				$scope.bt_error =true;
			 
				
				}else if(data.msg_user_otps_bt_2=='yes'){
					$scope.bt_error2 =true;
				
				
				}
		 
			 
          });
        };
		
//	//call select bet_link_url_all
	$scope.ispname_bet_link_url = {};
	  $scope.bet_link_url = function(isp_name,option) {
	  if(option==1){
	   $scope.ispname_bet_link_url.cmd = 'isp_list';
	  }else if(option==2){
	   $scope.ispname_bet_link_url.cmd = 'isp_list_auto';
	     
	  }
	     
        $scope.ispname_bet_link_url.isp_name = isp_name;
		 
    var request = $http({
      method: 'POST',
      url: "http://sbogroup.t-wifi.co.th/wordpress/index.php/bet_link_url",
      data: $scope.ispname_bet_link_url,	
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request.success(function(data) {
      $scope.json_bet_link_url = data;
	 
	
    });  
	};
		
 // validate userdata
  
  
 $scope.userdata_validate = {};
$scope.validate_exist= function(vusedata,vtype) {
	$scope.userdata_validate.REGIS_FROM = 'userdata_validate';
	$scope.userdata_validate.vusedata = vusedata;
	$scope.userdata_validate.vtype = vtype; 
	 $scope.bt_validate=true;
	if(vtype==1){
	$scope.load_email_validate=1;
	}else if(vtype==2){
	$scope.load_phone_validate=1;
	}else if(vtype==3){
	$scope.load_phone_validate2=1;
	}
 //not allow same phone NO.
 // if($scope.user_wp.phone_number===$scope.user_wp.phone_number){
 
 // console.log($scope.user_wp.phone_number.localeCompare($scope.user_wp.phone_number2));
 
  //}
 //console.log(userdata_validate);
 
  $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/update-user-data', 
		  data    : $scope.userdata_validate,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		   
         })
          .success(function(data) {
		 // console.log(data);
		  /*
		  var bt_onoff=true;
		  //bt_validate=
		  if(){
		   bt_onoff = true;
		  }else{
		   bt_onoff = false;
		  }
		  */
           
				if (data.email_validate=='yes'){
					$scope.userForm.user_email_input.$setValidity("unique_email", false);
					v_email=true;
					$scope.load_email_validate=0;
				}else if(data.email_validate=='no'){
					$scope.userForm.user_email_input.$setValidity('unique_email', true);
					
					v_email=false;
					
					
					$scope.load_email_validate=0;
				}else{
					$scope.load_email_validate=0;
					 
				}
				//
				if(data.phone_validate=='yes'){
					$scope.userForm.phone_number_input.$setValidity("unique_phone_number", false);
					v_phone=true;
					$scope.load_phone_validate=0;
				}else if(data.phone_validate=='no'){
					$scope.userForm.phone_number_input.$setValidity('unique_phone_number', true);
					v_phone=false;
					$scope.load_phone_validate=0;
				}else{
					$scope.load_phone_validate=0;
					 
				}
				//
					if(data.phone_validate2=='yes'){
					$scope.userForm.phone_number2_input.$setValidity("unique_phone_number2", false);
					v_phone2=true;
					$scope.load_phone_validate2=0;
				}else if(data.phone_validate2=='no'){
					$scope.userForm.phone_number2_input.$setValidity('unique_phone_number2', true);
					v_phone2=false;
					$scope.load_phone_validate2=0;
				}else{
					$scope.load_phone_validate2=0;
				 
				}
				
				//set bt_validate
				console.log(v_mail);
				console.log(v_phone);
			    console.log(v_phone2);
          });
 
}
   
});
