var app = angular.module('max_MyApp', ['ngMaterial', 'ngMessages']);

app.controller('max_user_detail', function($scope, $http) {

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
   //
   $scope.user_init = {
  
      bname: 'ธนาคารกรุงเทพ',
      mtype: 'sbobet'
    };
   
   
  // create a blank object to handle form data.
        $scope.user = {};
      // calling our submit function.
        $scope.submitForm = function() {
 
        // Posting data to php file
        $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/insert_user_data/',
       
		  data    : $scope.user, $scope.id,//forms user object
		  
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
          .success(function(data) {
            if (data.errors) {
              // Showing errors.
			 
              $scope.error_bank_name = data.errors.bank_name;
              $scope.error_bank_number = data.errors.bank_number;
              $scope.error_member_type = data.errors.member_type;
			  $scope.error_phone_number = data.errors.phone_number;
            } else {
              $scope.message = data.message;
			  
            }
          });
        };	  
	  

});
