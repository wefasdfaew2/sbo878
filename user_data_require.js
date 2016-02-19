var app = angular.module('max_MyApp', ['ngMaterial', 'ngMessages','ng.deviceDetector','ipCookie']);

app.controller('max_user_detail', function($scope, $http,deviceDetector,ipCookie) {

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
	 $scope.message_bt_otp1 ='true';

  // social register create a blank object to handle form data.
        $scope.user = {};
		      // calling our submit function.
        $scope.submitForm = function(id,ip) {
	 
	 	 $scope.user_wp.REGIS_FROM = 'social';
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
		
		// otp create a blank object to handle form data.
		 
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
			    
			 // setTimeout("location.href = ' http://sbogroup.t-wifi.co.th/wordpress/index.php/user-register-done';",500);
		 
          });
        };	

	//call select bet_link_url_all
	$scope.ispname_bet_link_url = {};
	  $scope.bet_link_url = function(isp_name) {
	 
        $scope.ispname_bet_link_url.isp_name = isp_name;
    var request = $http({
      method: 'POST',
      url: "http://sbogroup.t-wifi.co.th/wordpress/index.php/bet_link_url",
      data: $scope.ispname_bet_link_url,	
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request.success(function(link_url) {
      $scope.json_bet_link_url = link_url;

    });  
	};
		
	  

});
