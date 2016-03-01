var app = angular.module('MyDepositWithdrawMove', ['ngMaterial', 'ngMessages', 'ui.router']);

app.controller('DepositWithdrawMove', function($scope, $http, $filter, $state) {

  console.log("state.go");
  $state.go("step1");


});

app.config(function($mdThemingProvider, $stateProvider, $urlRouterProvider) {

  $mdThemingProvider.theme('default')
    .primaryPalette('blue', {
      // by default use shade 400 from the pink palette for primary intentions
      'hue-1': '50', // use shade 100 for the <code>md-hue-1</code> class
      'hue-2': '100', // use shade 600 for the <code>md-hue-2</code> class
      'hue-3': 'A700' // use shade A100 for the <code>md-hue-3</code> class
    })
    .accentPalette('green');

  //$urlRouterProvider.otherwise("/state1");

  $stateProvider
    .state('step1', {
      url: '/step1',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/step1.html',
      controller: function($scope, $state) {
        $scope.step1_option = '1';
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.nextTo = function(){
          if($scope.step1_option == '1'){
            $state.go("deposit");
          }else if($scope.step1_option == '2'){
            $state.go("step2_withdraw");
          }else if ($scope.step1_option == '3') {
            $state.go("credit_move");
          }
        }

      }
    })
    .state('step2_withdraw', {
      url: '/step2_withdraw',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/step2_withdraw.html',
      controller: function($scope, $state, $http, $mdDialog) {
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.showSpin = false;
        $scope.user = {};
        $scope.user.username = 'zkc8685002';
        $scope.user.tel = '0897908961';
        $scope.check_username_tel = function (ev) {
          $scope.showSpin = true;
          var check_req = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/withdraw-check-username-tel.php",
            data: {
              username: $scope.user.username,
              tel: $scope.user.tel
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          check_req.success(function(check_req_data) {
            console.log(check_req_data.check_status);
            $scope.showSpin = false;
            if(check_req_data.check_status == 'pass'){

              var params = {
                'withdraw_username': $scope.user.username,
                'tel': $scope.user.tel
              };
              $state.go("step3_withdraw", params);
            }else if (check_req_data.check_status == 'wait_another_withdraw') {
              $mdDialog.show(
                $mdDialog.alert()
                  .parent(angular.element(document.querySelector('body')))
                  .clickOutsideToClose(true)
                  .title('พบรายการสั่งถอน')
                  .textContent('username ที่ท่านสมาชิกสั่งถอนมีรายการสั่งถอนที่ดำเนินการถอนอยู่ ระบบไม่อนุญาตให้ทำการสั่งถอนซ้ำ จนกว่ารายการเก่าจะเสร็จสิ้น')
                  .ariaLabel('Alert Dialog')
                  .ok('OK')
                  .targetEvent(ev)
              );
            }else if(check_req_data.check_status == 'not pass'){
              $mdDialog.show(
                $mdDialog.alert()
                  .parent(angular.element(document.querySelector('body')))
                  .clickOutsideToClose(true)
                  .title('ข้อมูลไม่ถูกต้อง')
                  .textContent('Username หรือ เบอร์โทรศัพท์ ไม่ถูกต้อง')
                  .ariaLabel('Alert Dialog')
                  .ok('OK')
                  .targetEvent(ev)
              );
            }else{
              var confirm = $mdDialog.confirm()
              .parent(angular.element(document.querySelector('body')))
              .title('พบรายการถอนที่ดำเนินการถอนอยู่')
              .textContent('ขณะนี้รายการถอนอยู่ในขั้นตอน ' + check_req_data.check_status + ' ท่านต้องการยกเลิกรายการถอนนี้หรือไม่')
              .ariaLabel('Lucky day')
              .targetEvent(ev)
              .ok('ต้องการ')
              .cancel('ไม่ต้องการ');
              $mdDialog.show(confirm).then(function() {
                var set_cancel = $http({
                  method: "post",
                  url: WPURLS.templateurl + "/php/withdraw-cancel.php",
                  data: {
                    username: $scope.user.username,
                    tel: $scope.user.tel
                  },
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                  }
                });
                set_cancel.success(function(set_cancel_data) {
                  if(set_cancel_data.withdraw_status == 'successfully'){
                    var params = {
                      'withdraw_username': $scope.user.username,
                      'tel': $scope.user.tel
                    };
                    $state.go("step3_withdraw", params);
                  }else {
                    console.log('cancel failed');
                  }
                });
              }, function() {
                console.log('cancel');
              });
            }
          });

        }

      }
    })
    .state('step3_withdraw', {
      url: '/step3_withdraw',
      abstract: false,
      params: {
        withdraw_username: null,
        tel: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step3_withdraw.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog) {
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.showSpin = true;

        var get_otp_ref = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/withdraw-sms-otp.php",
          data: {
            username: $stateParams.withdraw_username,
            check_otp: false
          },
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        get_otp_ref.success(function(otp_ref_data) {
          $scope.showSpin = false;
          if(otp_ref_data.otp_ref != 'error'){
            $scope.otp_ref = otp_ref_data.otp_ref;
            send_sms($stateParams.tel, $scope.otp_ref);
            console.log("sms sended");
          }else {
            console.log('otp error');
          }


        });

        $scope.check_otp = function(ev){
          $scope.showSpin = true;

          var check_otp = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/withdraw-sms-otp.php",
            data: {
              username: $stateParams.withdraw_username,
              check_otp: true,
              otp_ref: $scope.otp_ref,
              otp: $scope.user_otp
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          check_otp.success(function(check_otp_data) {

            console.log(check_otp_data);
            if(check_otp_data.check_otp_status == 'pass'){
              var set_withdraw_money = $http({
                method: "post",
                url: WPURLS.templateurl + "/php/withdraw-otp-passed.php",
                data: {
                  username: $stateParams.withdraw_username,
                  tel: $stateParams.tel
                },
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                }
              });
              set_withdraw_money.success(function(res_data) {
                $scope.showSpin = false;
                console.log(res_data);
                console.log(res_data.set_status);
                if(res_data.set_status == 'success'){
                  var params = {
                    'withdraw_username': $stateParams.withdraw_username,
                    'tel': $stateParams.tel
                  };
                  $state.go("step4_withdraw", params);
                }else{
                  console.log('insert not success');
                }
              });
            }else{
              $scope.showSpin = false
              $mdDialog.show(
                $mdDialog.alert()
                  .parent(angular.element(document.querySelector('body')))
                  .clickOutsideToClose(true)
                  .title('ข้อมูลไม่ถูกต้อง')
                  .textContent('เลข OTP ไม่ถูกต้อง')
                  .ariaLabel('Alert Dialog')
                  .ok('OK')
                  .targetEvent(ev)
              );
            }

          });
        }

        function send_sms(tel_num, otp_ref_num){
          var sms_send = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/withdraw-send-sms.php",
            data: {
              username: $stateParams.withdraw_username,
              tel: tel_num,
              otp_ref: otp_ref_num
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          sms_send.success(function(sms_status_data) {
            console.log(sms_status_data);
          });
        }
      }
    })
    .state('step4_withdraw', {
      url: '/step4_withdraw',
      abstract: false,
      params: {
        withdraw_username: null,
        tel: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_withdraw.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog, $interval) {
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.withdraw_wait = true;
        $scope.withdraw_add = false;
        $scope.withdraw_req_complete = false;
        $scope.disable_ok = true;
        $scope.show_withdraw_error = false;
        $scope.show_button = true;
        $scope.withdraw = {};
        check_withdraw_status();

        var interval = $interval(function(){
          check_withdraw_status();
        }, 5000);

        $scope.send_withdraw_req = function(withdraw_money, ev){
          var confirm = $mdDialog.confirm()
          .parent(angular.element(document.querySelector('body')))
          .title('ยืนยันการถอนเงิน ?')
          .textContent('คุณต้องการถอนเงินเป็นจำนวน ' + withdraw_money + ' บาท')
          .ariaLabel('Lucky day')
          .targetEvent(ev)
          .ok('ยืนยัน')
          .cancel('ยกเลิก');
          $mdDialog.show(confirm).then(function() {
            var send_req = $http({
              method: "post",
              url: WPURLS.templateurl + "/php/withdraw-update-amount.php",
              data: {
                username: $stateParams.withdraw_username,
                amount: withdraw_money
              },
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              }
            });
            send_req.success(function(res_data) {
              if(res_data.withdraw_status == 'successfully'){
                $scope.withdraw_add = false;
                $scope.withdraw_req_complete = true;
                $scope.show_button = false;
              }else{
                $mdDialog.show(
                  $mdDialog.alert()
                    .parent(angular.element(document.querySelector('body')))
                    .clickOutsideToClose(true)
                    .title('เกิดความผิดพลาด')
                    .textContent('ระบบขัดข้องบางประการ')
                    .ariaLabel('Alert Dialog')
                    .ok('OK')
                    .targetEvent(ev)
                );
              }

            });
          }, function() {
            console.log('cancel');
          });

        }

        $scope.check_input_money = function(){

          if(angular.isNumber($scope.withdraw.withdraw_money)){
            if($scope.withdraw.withdraw_money > Number($scope.current_amount)){
              $scope.show_withdraw_error = true;
              $scope.error_text = 'ยอดเงินที่ท่านระบุ มากกว่าจำนวนเงินที่ถอนได้';
              $scope.disable_ok = true;
            }else if ($scope.withdraw.withdraw_money <= 0) {
              $scope.show_withdraw_error = true;
              $scope.error_text = 'ยอดเงินที่ท่านระบุ น้อยกว่าหรือเท่าศูนย์';
              $scope.disable_ok = true;
            }else{
              $scope.show_withdraw_error = false;
              $scope.disable_ok = false;
            }
          }else {
            $scope.show_withdraw_error = true;
            $scope.error_text = 'กรุณากรอกตัวเลขที่มากกว่า 0';
            $scope.disable_ok = true;
          }

        }

        function check_withdraw_status(){
          var check_withdraw_money = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/withdraw-check-status.php",
            data: {
              username: $stateParams.withdraw_username,
              tel: $stateParams.tel
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          check_withdraw_money.success(function(res_data) {
            console.log(res_data);
            $scope.account = $stateParams.withdraw_username;
            $scope.bank_account = res_data[0].withdraw_bank_account;
            $scope.bank_name = res_data[0].withdraw_bank_name;
            $scope.nickname = res_data[0].withdraw_nickname;
            console.log(res_data[0].withdraw_status_id);
            if(res_data[0].withdraw_status_id == 9){
              $interval.cancel(interval);
              interval = undefined;
              $scope.current_amount = res_data[0].withdraw_current_amount;
              $scope.withdraw_wait = false;
              $scope.withdraw_add = true;
            }
          });
        }
      }
    })
});

      /**  var otp_age = 300000;
        var setTime = $interval(function(){
          otp_age -= 1000;

          var x = otp_age / 1000;
          $scope.seconds = x % 60;
          x /= 60;
          $scope.minutes = x % 60;
          $scope.minutes = $scope.minutes.toString().substring(0,1);

          if(otp_age == 0){
            $interval.cancel(setTime);
            setTime = undefined;
          }
          //$scope.seconds = (otp_age/1000)%60
          //$scope.minutes = (otp_age/(1000*60))%60
          //$scope.hours = (otp_age/(1000*60*60))%24
        }, 1000, 300);**/
