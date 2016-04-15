var app = angular.module('app_user_inform_transfer', ['ngMaterial', 'ngMessages', 'ui.bootstrap']);

app.controller('cont_user_inform_transfer', function($scope,$http,$filter) {
	 
		$scope.radio1_user = {};
		$scope.radio1_user.channel_transf = '1';
		$scope.radio2_user = {};
		$scope.u = {};
		 
		 

//datetime picker

$scope.today = function() {
    $scope.u.dt = new Date();
  };
  $scope.today();

  $scope.clear = function() {
    $scope.u.dt = null;
  };

  $scope.inlineOptions = {
    customClass: getDayClass,
    minDate: new Date(),
    showWeeks: true
  };
  
  
  
 function getDayClass(data) {
    var date = data.date,
      mode = data.mode;
    if (mode === 'day') {
      var dayToCheck = new Date(date).setHours(0,0,0,0);

      for (var i = 0; i < $scope.events.length; i++) {
        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

        if (dayToCheck === currentDay) {
          return $scope.events[i].status;
        }
      }
    }

    return '';
  }
 ////time
 $scope.u.mytime = new Date();
 
  $scope.hstep = 1;
  $scope.mstep = 1;
 
 
 
//$scope.u_inform_state='1';
	  // wp register create a blank object to handle form data.
        $scope.user_inform_transfer = {};
		      // calling our submit function.
        $scope.submit_user_inform_transfer_Form = function() {

		$scope.user_inform_transfer.CMD_FROM = 'check_user_pass';//step1
        $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/inform_transfer',
		   data    : $scope.user_inform_transfer,
          headers : {'Content-Type': 'application/x-www-form-urlencoded'}

         })
          .success(function(data) {
              $scope.message = data.message;
			  $scope.message_err = data.message_err;
				uname=data.u_name;
			// console.log(data.u_name);

				if(data.success==true){//go step2

						    p_url="location.href = 'http://sbogroup.t-wifi.co.th/wordpress/index.php/user_inform_transfer2?data=";
						    send_url=p_url.concat(uname);
							send_url=send_url.concat("';");
							setTimeout(send_url,500);

				}else{
				//error do nothing

				}
		    });

        };
//////////////////////
//call user_waiting_list

   	//call select data
		$scope.user_data = {};
		$scope.user_waiting_list= function(user_name) {
		 $scope.user_data.username = user_name;
		$scope.user_data.CMD_FROM = 'check_user_pass2';//step1

        $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/inform_transfer',
		  data    : $scope.user_data,				//------------------------------------------------------------forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'}

         })
          .success(function(data) {
          //console.log('xxx',db_waiting_inform_list);
              $scope.json_user_waiting_list = data.db_waiting_inform_list;
			 $scope.num_row = data.num_row;
			 
			$scope.u_ba=data.u_ba;
			$scope.u_bn=data.u_bn;
			$scope.u_ba2=data.u_ba2;
			$scope.u_bn2=data.u_bn2
			$scope.u_ba3=data.u_ba3;
			$scope.u_bn3=data.u_bn3;
			$scope.u_nn=data.u_nn;
		 $scope.radio2_user.from_bank_transf =$scope.u_ba;
			 
          });
        };

//span form if click
//confirm click

  //$scope.confirm_form = ' '; //cancle
     $scope.bt_cancle_tg = false;
    $scope.bt_cancle_toggle = function() {
        $scope.bt_cancle_tg = !$scope.bt_cancle_tg;
    };

		$scope.cancle_trans = function(deposit_id) {
		 $scope.confirm_form = '2'; //cancle
		 $scope.trans_id_num = deposit_id;
		 $scope.bt_cancle_toggle();

		};

		//call
		$scope.user_data_cancle = {};
			$scope.apply_cancle_trans = function(deposit_id,user_name) {
		 $scope.user_data_cancle.trans_id_num = deposit_id;
		 $scope.user_data_cancle.CMD_FROM = 'user_cancle_id';//step1
	     //console.log('apply cancle ',deposit_id);
		  $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/inform_transfer',
		  data    : $scope.user_data_cancle,				//------------------------------------------------------------forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'}

         })
          .success(function(data) {
          if(data.user_cancle_id_success==true){
			   $scope.user_waiting_list(user_name);

		  }
          });

		};

		  //$scope.confirm_form = ' '; //confirm
		   $scope.bt_confirm_tg = false;
    $scope.bt_confirm_toggle = function() {
        $scope.bt_confirm_tg = !$scope.bt_confirm_tg;
    };

		$scope.confirm_trans = function(deposit_id) {
		 $scope.confirm_form = '1'; //cancle
		 $scope.trans_id_num = deposit_id;
		 $scope.bt_confirm_toggle();

		};
 
		//call
		$scope.user_data_confirm = {};
			$scope.apply_confirm_trans = function(deposit_id,user_name) {
		 $scope.user_data_confirm.trans_id_num = deposit_id;
		 $scope.user_data_confirm.CMD_FROM = 'user_confirm_id';//step1
		 
		  console.log($scope.radio1_user.channel_transf,$scope.radio2_user.from_bank_transf,$scope.u.dt,$scope.u.mytime);
		 
	     //console.log('apply cancle ',deposit_id);
		 /*
		  $http({
          method  : 'POST',
         url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/inform_transfer',
		  data    : $scope.user_data_confirm,				//------------------------------------------------------------forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'}

         })
          .success(function(data) {
          if(data.user_confirm_id_success==true){
			   $scope.user_waiting_list(user_name);

		  }
          });
		  */

		};




});//end app.controller

/*

				  	$scope.user_inform_transfer.CMD_FROM = 'check_user_pass2';//step1

					$http({
					  method  : 'POST',
					 url     : 'http://sbogroup.t-wifi.co.th/wordpress/index.php/inform_transfer',
					  data    : $scope.user_inform_transfer,
					  headers : {'Content-Type': 'application/x-www-form-urlencoded'}

						})
					  .success(function(data) {
						  //$scope.message = data.message;
						  //$scope.message_err = data.message_err;
						    p_url="location.href = 'http://sbogroup.t-wifi.co.th/wordpress/index.php/user_inform_transfer2?data=";
						    send_url=p_url.concat(uname);
							send_url=send_url.concat("';");
							setTimeout(send_url,500);

							 });
*/
