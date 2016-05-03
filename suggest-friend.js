var app = angular.module('MySuggestFriend', ['ngMaterial', 'ngMessages', 'smart-table', 'angularSlideables', 'ipCookie']);

app.filter('abs', function () {
  return function(val) {
    return Math.abs(val);
  }
});

app.controller('SuggestFriend', function($scope, $filter, $http, $mdDialog, $window) {

  $scope.loged_in = false;
  $scope.login = {};
  $scope.login_button_disable = false;
  $scope.showSpin = false;

  //if(ipCookie('suggest-friend-iscook') == 'zxcv'){
  //  $scope.login_check(ipCookie('suggest-friend-cook-user'), ipCookie('suggest-friend-cook-tel'));
  //}
  $scope.refer_set_deposit = function(username, tel, deposit_amount){
    $scope.disable_ok = true;
    $scope.show_withdraw_success = true;
    $scope.waiting_text = 'กรุณารอสักครู่.....';
    var timeStamp = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss', '+0700');
    var date = timeStamp.split(" ")[0];
    var time = timeStamp.split(" ")[1];
    var refer_set_call = $http({
      method: "post",
      url: WPURLS.templateurl+ "/php/suggest-friend-set-deposit.php",
      data: {
        username: username,
        tel: tel,
        date: date,
        time: time,
        timeStamp: timeStamp,
        deposit_amount: $scope.login.withdraw_money
      },
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    refer_set_call.success(function(refer_set_data) {
      //console.log(refer_set_data);
      if(refer_set_data.insert == 'success'){
        $scope.waiting_text = 'ทำรายการถอนเสร็จสมบูรณ์';
        $window.location.href = '/wordpress/index.php/link-for-friend?url_link=' + $scope.promo_link;
      }
    });


  }

  $scope.login_check = function(username, tel){
    $scope.login_button_disable = true;
    $scope.showSpin = true;
    //console.log('asd');
    //username = 'zkc8688000';
    //tel = '0617305006';
    //$scope.login.username = 'zkc8688000';
    //$scope.login.tel = '0617305006';
    var login_call = $http({
      method: "post",
      url: WPURLS.templateurl+ "/php/suggest-friend-login.php",
      data: {
        username: username,
        tel: tel
      },
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    login_call.success(function(login_call_data, ev) {
      $scope.showSpin = false;

      ////console.log(login_call_data);
      if(login_call_data.check_status == 'pass'){
        //ipCookie('suggest-friend-cook-user', username, { expires: 1 });
        //ipCookie('suggest-friend-cook-tel', tel, { expires: 1 });
        //ipCookie('suggest-friend-iscook', 'zxcv', { expires: 1 });
        $scope.promo_link = login_call_data.short_url;
        $scope.loged_in = true;
        $scope.login.promo_refer_info = login_call_data.promo_refer_info;
        $scope.login.current_amount = parseInt(login_call_data.promo_refer_info[0].current_amount);
        $scope.login.withdrawed = Math.abs(parseInt(login_call_data.promo_refer_info[0].withdrawed));
        $scope.login.data_withdrawed = login_call_data.data_withdrawed;


        $scope.login.can_withdraw = $scope.login.current_amount - $scope.login.withdrawed;

        //console.log($scope.login.can_withdraw);

      }else {
        $scope.login_button_disable = false;
        $mdDialog.show(
          $mdDialog.alert()
            .parent(angular.element(document.querySelector('#login_zone')))
            .clickOutsideToClose(true)
            //.title('Username หรือ หมายเลขโทรศัพท์ไม่ถูกต้อง')
            .textContent('Username หรือ หมายเลขโทรศัพท์ไม่ถูกต้อง')
            .ariaLabel('Alert Dialog Login')
            .ok('ตกลง')
            .targetEvent(ev)
        );
      }

    });
  }




  $scope.disable_ok = true;
  $scope.cal_withdraw_money = function(credit_money){

    //console.log($scope.login.withdraw_money);
    if(angular.isUndefined($scope.login.withdraw_money)){
      $scope.show_withdraw_error = true;
      $scope.error_text = 'ไม่พบยอดที่สามารถถอนได้';
      $scope.disable_ok = true;
    }else if(angular.isNumber($scope.login.withdraw_money)){
      if($scope.login.withdraw_money > Number($scope.login.can_withdraw)){
        $scope.show_withdraw_error = true;
        $scope.error_text = 'ยอดเงินที่ท่านระบุ มากกว่าจำนวนเงินที่ถอนได้';
        $scope.disable_ok = true;
      }else if ($scope.login.withdraw_money <= 0) {
        $scope.show_withdraw_error = true;
        $scope.error_text = 'ยอดเงินที่ท่านระบุต้องมากกว่า 0';
        $scope.disable_ok = true;
      }else if (!Number.isInteger($scope.login.withdraw_money)) {
        $scope.show_withdraw_error = true;
        $scope.error_text = 'ยอดเงินที่ท่านระบุ ไม่เป็นจำนวนเต็ม';
        $scope.disable_ok = true;
      }
      else{
        $scope.show_withdraw_error = false;
        $scope.disable_ok = false;
      }
    }else {
      $scope.show_withdraw_error = true;
      $scope.error_text = 'กรุณากรอกเลขจำนวนเต็มที่มากกว่า 0';
      $scope.disable_ok = true;
    }
  }
  /**$scope.wordpress_login = function(username, password){

    var data = {
      'action': 'my_action',
      'username': username,
      'password': password
    }


    var login_call = $http({
      method: "post",
      url: WPURLS.templateurl+ "/php/test_login.php",
      data: data,
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    login_call.success(function(login_call_data) {
      //console.log(login_call_data);
      if(login_call_data == 'success'){
        $window.location.reload();
      }else {
        alert('invalid username or password');
      }

    });

  }**/

});
