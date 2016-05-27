
var app = angular.module('max_MyApp', ['ngMaterial', 'ngMessages','ng.deviceDetector','ipCookie']);
 
app.controller('max_user_detail', function($scope, $http,deviceDetector,ipCookie,$timeout) {
  
  
 $scope.bt_otp1 =true;
 $scope.bt_otp2 =true;
 $scope.bt_confirm_otps =true;
 $scope.form_update_phone=false;
 
  
 $scope.call_update_phone_form= function(){
 
 $scope.form_update_phone=true;
 
 }
 
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
    }, 1000);
}

 

jQuery(function ($) {
     var fiveMinutes = 5 * 1,
        display = $('#bt_time1');
    startTimer(fiveMinutes, display);
});

jQuery(function ($) {
    var fiveMinutes = 5 * 1,
        display = $('#bt_time2');
    startTimer2(fiveMinutes, display);
});

 $scope.bank_name = [
          "ธนาคารกสิกรไทย",
		   "ธนาคารไทยพาณิชย์",
		   "ธนาคารกรุงเทพ",
		     "ธนาคารกรุงศรีอยุธยา",
		    "ธนาคารกรุงไทย",
		   "ธนาคารเกียรตินาคิน",
		   "ธนาคารซีไอเอ็มบี ไทย",
		   "ธนาคารทหารไทย",
		   "ธนาคารทิสโก้",
		   "ธนาคารธนชาต",
		   "ธนาคารยูโอบี",
		   "ธนาคารแลนด์ แอนด์ เฮ้าส์",
		   "ธนาคารสแตนดาร์ดชาร์เตอร์ด",
		   "ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร",
		   "ธนาคารออมสิน",
		   "ธนาคารอาคารสงเคราะห์",
		   "ธนาคารไทยเครดิต เพื่อรายย่อย"
 
 
      ];
	  
	   $scope.m_type = [
          "sbobet", 
          "gclub"
      ];
  
   $scope.user_init = {
  
      bname: 'ธนาคารกรุงเทพ',
	  mtype: 'sbobet'
	  
    };
	 

        $scope.user = {};
        $scope.submitForm = function(id,ip) {
	 
	 	 $scope.user.REGIS_FROM = 'social';
         $scope.user.ID = id;
		 $scope.user.IP = ip;
		 $scope.user.OS = deviceDetector.os;
		 $scope.user.DEVICE = deviceDetector.device;
		 $scope.user.BROWSER = deviceDetector.browser;
	  
        $http({
          method  : 'POST',
         url     : WPURLS.home_url+'/update-user-data', 
		  data    : $scope.user,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		   
         })
          .success(function(data) {
           
              $scope.message = data.message;
			 setTimeout("location.href ='" + WPURLS.home_url +  "/user-register-done';",500);
		      
          });
        };	  
	
        $scope.user_wp = {};
        $scope.submitForm_user_wp = function(ip) {
	 	 $scope.user_wp.REGIS_FROM = 'wp';
		 $scope.user_wp.IP = ip;
		 $scope.user_wp.OS = deviceDetector.os;
		 $scope.user_wp.DEVICE = deviceDetector.device;
		 $scope.user_wp.BROWSER = deviceDetector.browser;
		 
		 
		
        $http({
          method  : 'POST',
         url     : WPURLS.home_url+'/update-user-data', 
		  data    : $scope.user_wp,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		   
         })
          .success(function(data) {
              $scope.message = data.message;
			 
		 setTimeout("location.href ='" + WPURLS.home_url +  "/user-register-done';",500);
          });
        };	  
	 
		$scope.user_data = {};
		$scope.submitForm_query= function(id) {
        $scope.user_data.ID = id;
		$scope.user_data.id_cmd = id;

        $http({
          method  : 'POST',
         url     : WPURLS.home_url+'/update-user-data',  
		  data    : $scope.user_data,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		   
         })
          .success(function(user_detail) {
           
              $scope.json_user_detail = user_detail;
			 
          });
        };
		
		
		
		
		$scope.success_otp = {};
        $scope.user_otp = {};
        $scope.submitForm_otp_1 = function(id,ref_otp) {
		$scope.user_otp.REGIS_FROM = 'otp';
		$scope.user_otp.ID = id;
		$scope.user_otp.ref_otp = ref_otp;
        $http({
          method  : 'POST',
         url     : WPURLS.home_url+'/update-user-data',  
		  data    : $scope.user_otp,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
          .success(function(data) {
            $scope.message_bt_otp1 = data.message_bt_otp1;
			$scope.message_otp1 = data.message_otp1;
			   
			   if (data.otp_status=='yes')
				{
					$scope.success_otp.REGIS_FROM = 'otp_update_verf';
					 $scope.success_otp.OTP_VERF_CASE = data.otp_status;
					 $scope.success_otp.ID = id;
						if(ipCookie('sbobet878_mac')==undefined){
							$scope.success_otp.COOKIE = 'no';
						}else{
							$scope.success_otp.COOKIE = ipCookie('sbobet878_mac');
							//console.log("cookie= ",$scope.success_otp.COOKIE);
							}
					 
				
			  $http({
          method  : 'POST',
         url     : WPURLS.home_url+'/update-user-data', 
		  data    : $scope.success_otp,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		 
         }) 
		 .success(function(data){
		 	   if(data.new_cookie=='yes'){
		   ipCookie('sbobet878_mac', data.new_cookie_val);
		   }else{
		   }
		   		 
		  setTimeout("location.href ='" + WPURLS.home_url +  "/user-register-done';",500);
		});
		 		}
			 
          });
        };	

        $scope.user_otps = {};
        $scope.submitForm_otps = function(id,ref_otp1,ref_otp2) {
		$scope.user_otps.REGIS_FROM = 'otps';
		$scope.user_otps.ID = id;
		$scope.user_otps.ref_otp1 = ref_otp1;
		$scope.user_otps.ref_otp2 = ref_otp2;
		 
        $http({
          method  : 'POST',
         url     : WPURLS.home_url+'/update-user-data', 
		  data    : $scope.user_otps, 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
          .success(function(data) {
            $scope.message_otps = data.message_otps;
			$scope.message_otps1 = data.message_otps1;
			 $scope.message_otps2 = data.message_otps2;  
		 
			   if (data.otp_status=='yes' || data.otp_status=='yes1' || data.otp_status=='yes2')
				{
				$scope.success_otp.REGIS_FROM = 'otp_update_verf';
				$scope.success_otp.OTP_VERF_CASE = data.otp_status;
				$scope.success_otp.ID = id;
					if(ipCookie('sbobet878_mac')==undefined){
							$scope.success_otp.COOKIE = 'no';
					}else{
							$scope.success_otp.COOKIE = ipCookie('sbobet878_mac');
					}
				  $http({
          method  : 'POST',
         url     : WPURLS.home_url+'/update-user-data', 
		  data    : $scope.success_otp, 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		 
         }) 
		 .success(function(data){
		 	   if(data.new_cookie=='yes'){
		   ipCookie('sbobet878_mac', data.new_cookie_val);
		   }else{
		   }
		 setTimeout("location.href ='" + WPURLS.home_url +  "/user-register-done';",500);
		});
		 		} 
			 
          });
		   
        };
		
		$scope.otps_input_check=function(){
		 //check empty string
		if($scope.user_otps.user_otps1==undefined){
		var otp_len=0;
	 
		}else{
		var otp_len= (''+$scope.user_otps.user_otps1).length;
		}
		
		if($scope.user_otps.user_otps2==undefined){
		var otp2_len=0;
	 
		}else{
		var otp2_len= (''+$scope.user_otps.user_otps2).length;
		}
	 
		 
		//enable bt case
		if(otp_len==0 && otp2_len==0 ){
		$scope.message_otps='กรุณากรอกอย่างน้อย 1 otp';
		$scope.bt_confirm_otps=true;
		$scope.message_otps1='';
		$scope.message_otps2='';
		
		}else{
		$scope.message_otps='';
		$scope.bt_confirm_otps=false;
		}
		
		}
		
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
         url     : WPURLS.home_url+'/update-user-data',  
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
      url: WPURLS.home_url+"/bet_link_url",
      data: $scope.ispname_bet_link_url,	
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request.success(function(data) {
      $scope.json_bet_link_url = data;
	 
	
    });  
	};
		
  var v_email = false;
  var v_phone = false;
  var v_phone2 = true;
  var v_phone_dup = true;
 var v_check_email =0;
  
 $scope.userdata_validate = {};
$scope.validate_exist= function(vusedata,vtype,check_email) {
	$scope.userdata_validate.REGIS_FROM = 'userdata_validate';
	$scope.userdata_validate.vusedata = vusedata;
	$scope.userdata_validate.vtype = vtype; 
	 $scope.bt_validate=true;
	 
	 v_check_email=check_email;
	 
	if(vtype==1){
	$scope.load_email_validate=1;
	}else if(vtype==2){
	$scope.load_phone_validate=1;
	}else if(vtype==3){
	$scope.load_phone_validate2=1;
	}
	 
	var phone1_len= (''+$scope.user_wp.phone_number).length;
	var phone2_len= (''+$scope.user_wp.phone_number2).length;
	
	
	var phone1_social_len= (''+$scope.user.phone_number).length;
	var phone2_social_len= (''+$scope.user.phone_number2).length;
	
	if(vtype==4){
	$scope.load_phone_validate=1;
	v_phone_dup=true;
	}else{

 if(phone1_len==10 && phone2_len==10){
 if($scope.user_wp.phone_number.localeCompare($scope.user_wp.phone_number2)==0 ){
 v_phone_dup=false;
  
	    
 $scope.message='ไม่อนุญาติให้ใช้เบอร์ซ้ำกัน';
 }else{
 v_phone_dup=true;
 
 $scope.message='';
 }
 }else if(phone1_len==0 || phone2_len==0){
 v_phone_dup=true;
 $scope.message='';
 }

  if(phone1_social_len==10 && phone2_social_len==10){//strlen str.length;
 if($scope.user.phone_number.localeCompare($scope.user.phone_number2)==0 ){
 v_phone_dup=false;
   
 $scope.message='ไม่อนุญาติให้ใช้เบอร์ซ้ำกัน';
 }else{
 v_phone_dup=true;
 $scope.message='';
 }
 }else if(phone1_social_len==0 || phone2_social_len==0){
 v_phone_dup=true;
 $scope.message='';
 }
 
  }
 
  $http({
          method  : 'POST',
         url     : WPURLS.home_url+'/update-user-data',  
		  data    : $scope.userdata_validate,				//------------------------------------------------------------forms user object 
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		   
         })
		  
          .success(function(data) {
		 
           
				if (data.email_validate=='yes'){
					$scope.userForm.user_email_input.$setValidity("unique_email", false);
					v_email=false;
					$scope.load_email_validate=0;
				}else if(data.email_validate=='no'){
					$scope.userForm.user_email_input.$setValidity('unique_email', true);
					
					v_email=true;
					
					
					$scope.load_email_validate=0;
				}else{
					$scope.load_email_validate=0;
					 
				}
				if(data.phone_validate=='yes'){
					$scope.userForm.phone_number_input.$setValidity("unique_phone_number", false);
					v_phone=false;
					$scope.load_phone_validate=0;
				}else if(data.phone_validate=='no'){
					$scope.userForm.phone_number_input.$setValidity('unique_phone_number', true);
					v_phone=true;
					$scope.load_phone_validate=0;
				}else{
					$scope.load_phone_validate=0;
					 
				}
			
				if(data.phone_update_validate=='yes'){
					$scope.userForm_update_phone.phone_number_input.$setValidity("unique_phone_number", false);
					v_phone=false;
					v_phone2=true;
					 v_email=true;
					v_phone_dup=true;
					$scope.load_phone_validate=0;
				}else if(data.phone_update_validate=='no'){
					$scope.userForm_update_phone.phone_number_input.$setValidity('unique_phone_number', true);
					v_phone=true;
					v_phone2=true;
					 v_email=true;
					 v_phone_dup=true;
					$scope.load_phone_validate=0;
				}else{
					$scope.load_phone_validate=0;
					 
				}
				//
					if(data.phone_validate2=='yes'){
					$scope.userForm.phone_number2_input.$setValidity("unique_phone_number2", false);
					v_phone2=false;
						 
					$scope.load_phone_validate2=0;
				}else if(data.phone_validate2=='no'){
					$scope.userForm.phone_number2_input.$setValidity('unique_phone_number2', true);
					v_phone2=true;
					$scope.load_phone_validate2=0;
				}else{
					$scope.load_phone_validate2=0;
				 
				}
				 
				
				if(v_check_email==false){
				v_email=true;
				}
			
				if(v_phone && v_phone2 && v_email && v_phone_dup){  
				
				$scope.bt_validate=false;
			 
			 
				}else{
				  
				$scope.bt_validate=true;
				 
			 
				}
				
          });
  
}


	$scope.update_phone_otp = {};
	  $scope.submitForm_update_phone = function(id,option) {
	  $scope.update_phone_otp.REGIS_FROM = 'update_phone_otp';
	  $scope.update_phone_otp.ID = id;
	  
    var request = $http({
      method: 'POST',
      url: WPURLS.home_url+'/update-user-data', 
      data: $scope.update_phone_otp,	
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request.success(function(data) {
      $scope.json_update_phone_otp = data.update_phone_otp;
	 
	 $scope.json_update_phone_otp_msg = data.update_phone_otp_msg;
	 if(data.update_phone_otp=='yes'){
	 setTimeout("location.href ='" + WPURLS.home_url +  "/user-register-done';",100);
	 }
 
	 
	
    });  
	};
   
});
