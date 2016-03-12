var app = angular.module('MyDepositWithdrawMove', ['ngMaterial', 'ngMessages', 'ui.router', 'smart-table', 'angularSlideables']);

app.controller('DepositWithdrawMove', function($scope, $http, $filter, $state) {

  console.log("Deposit !!!");
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
          var params = {
            'direct_access': false
          };
          if($scope.step1_option == '1'){
            $state.go("step2_deposit_auto", params);
          }else if ($scope.step1_option == '2') {
            $state.go("credit_move");
          }else if($scope.step1_option == '3'){
            $state.go("step2_withdraw", params);
          }else if ($scope.step1_option == '4') {
            $state.go("credit_move");
          }
        }

      }
    })
    .state('step2_withdraw', {
      url: '/step2_withdraw',
      abstract: false,
      params: {
        direct_access: null,
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step2_withdraw.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          return;
        }
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.showSpin = false;
        $scope.user = {};
        $scope.user.username = '';//'zkc8685002';
        $scope.user.tel = '';//'0897908961';
        $scope.check_username_tel = function (ev) {

          if($scope.user.username.length == 0 || $scope.user.tel.length == 0){
            $mdDialog.show(
              $mdDialog.alert()
                .parent(angular.element(document.querySelector('body')))
                .clickOutsideToClose(true)
                .title('ข้อมูลไม่สมบูรณ์')
                .textContent('กรุณากรอกข้อมูลให้ครบ')
                .ariaLabel('Alert Dialog')
                .ok('OK')
                .targetEvent(ev)
            );
            return;
          }
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
            console.log(check_req_data);
            $scope.showSpin = false;
            if(check_req_data.check_status == 'pass'){

              var params = {
                'withdraw_username': $scope.user.username,
                'tel': $scope.user.tel,
                'direct_access': false,
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
                      'tel': $scope.user.tel,
                      'direct_access': false,
                    };
                    $state.go("step3_withdraw", params);
                  }else {
                    console.log('cancel failed');
                    alert('cancel failed');
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
        tel: null,
        direct_access: null,
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step3_withdraw.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          return;
        }
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.showSpin = true;
        $scope.user = {};
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
            alert('error');
          }


        });

        $scope.check_otp = function(ev){
          $scope.showSpin = true;
          console.log($scope.user.user_otp);
          var check_otp = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/withdraw-sms-otp.php",
            data: {
              username: $stateParams.withdraw_username,
              check_otp: true,
              otp_ref: $scope.otp_ref,
              otp: $scope.user.user_otp
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
                //console.log(res_data);
                //console.log(res_data.set_status);
                if(res_data.set_status == 'success'){
                  var params = {
                    'withdraw_username': $stateParams.withdraw_username,
                    'tel': $stateParams.tel,
                    'direct_access': false,
                  };
                  $state.go("step4_withdraw", params);
                }else{
                  console.log('insert not success');
                  alert('error');
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
        tel: null,
        direct_access: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_withdraw.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog, $interval) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          return;
        }

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
            }else if (!isInteger($scope.withdraw.withdraw_money)) {
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
            //console.log(res_data);
            $scope.account = $stateParams.withdraw_username;
            $scope.bank_account = res_data[0].withdraw_bank_account;
            $scope.bank_name = res_data[0].withdraw_bank_name;
            $scope.nickname = res_data[0].withdraw_nickname;
            //console.log(res_data[0].withdraw_status_id);
            if(res_data[0].withdraw_status_id == 9){
              $interval.cancel(interval);
              interval = undefined;
              $scope.current_amount = res_data[0].withdraw_current_amount;
              $scope.withdraw_wait = false;
              $scope.withdraw_add = true;
            }
          });
        }

        function isInteger(x) {
          return x % 1 === 0;
        }
      }
    })
    .state('step2_deposit_auto', {
      url: '/step2_deposit_auto',
      abstract: false,
      params: {
        direct_access: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step2_deposit_auto.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog) {
        //if($stateParams.direct_access != false){
        //  $scope.direct_access = true;
        //  return;
        //}
        $scope.direct_access = false;

        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.user = {};
        $scope.is_logo_type = false;
        $scope.isDisable = true;
        //$scope.user.auto_type_option = 46;
        $scope.no_option = false;
        $scope.check_account_type = function(){

          var get_account_type = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/deposit-get-account-type.php",
            data: {
              username: $scope.user.username,
              tel: $scope.user.tel
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          get_account_type.success(function(res_data) {
            console.log(res_data);
            //console.log(res_data.get_account_type);
            if(res_data.get_account_type == 'no_account'){
              $scope.account_type = 'Username หรือ เบอร์โทรศัพท์ไม่ถูกต้อง';

              if($scope.user.username.length == 0){
                $scope.is_valid_account = false;
              }else {
                $scope.is_valid_account = true;
              }
              $scope.is_logo_type = false;
              $scope.isDisable = true;
            }else {
              //$scope.account_type = res_data.get_account_type;
              $scope.is_valid_account = false;
              $scope.logo_type = WPURLS.templateurl + res_data.get_logo_type;
              $scope.is_logo_type = true;
              $scope.isDisable = false;
            }

          });
        }

        $scope.nextStep = function(ev){

          if(angular.isUndefined($scope.user.auto_type_option)){
            $mdDialog.show(
              $mdDialog.alert()
                .parent(angular.element(document.querySelector('body')))
                .clickOutsideToClose(true)
                .title('ช่องทางการเติมเครดิต')
                .textContent('ท่านยังไม่ได้เลือกช่องทางการเติมเครดิต')
                .ariaLabel('Alert Dialog')
                .ok('OK')
                .targetEvent(ev)
            );
            return;
          }
          var params = {
            'deposit_username': $scope.user.username,
            'auto_type_option': $scope.user.auto_type_option,
            'direct_access': false
          };
          $state.go("step3_deposit_auto", params);
        }

        var get_auto_type = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/deposit-get-auto-type.php",
          data: {},
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        get_auto_type.success(function(res_data) {
          //console.log(res_data);
          //console.log(res_data[0].deposit_type_name);
          //$scope.auto_type = res_data;
          $scope.internet_bank = [];
          $scope.mobile_bank = [];
          $scope.atm_normal = [];
          $scope.atm_ref_code = [];
          $scope.couterservice = [];
          $scope.credit_paypal = [];
          $scope.e_wallet = [];
          angular.forEach(res_data, function(value, key) {
            if(value.deposit_type_id == 33 || value.deposit_type_id == 29 || value.deposit_type_id == 37 ||
                value.deposit_type_id == 45 || value.deposit_type_id == 41 || value.deposit_type_id == 52){

                        if(value.deposit_type_id == 33){
                          res_data[key].access_way = 'https://www.scbeasy.com';
                          res_data[key].pri_color = '#4F2A81';
                          res_data[key].sec_color = '#E1D7F1';
                        }else if (value.deposit_type_id == 29) {
                          res_data[key].access_way = 'https://www.kasikornbank.com/';
                          res_data[key].pri_color = '#0e8f33';
                          res_data[key].sec_color = '#cee8d6';
                        }else if (value.deposit_type_id == 37) {
                          res_data[key].access_way = 'https://ibanking.bangkokbank.com';
                          res_data[key].pri_color = '#003399';
                          res_data[key].sec_color = '#b2c1e0';
                        }else if (value.deposit_type_id == 45) {
                          res_data[key].access_way = 'https://www.ktbnetbank.com';
                          res_data[key].pri_color = '#00A4E4';
                          res_data[key].sec_color = '#99daf4';
                        }else if (value.deposit_type_id == 41) {
                          res_data[key].access_way = 'https://www.krungsrionline.com';
                          res_data[key].pri_color = '#c1a000';
                          res_data[key].sec_color = '#fbeeb2';
                        }else if (value.deposit_type_id == 52) {
                          res_data[key].access_way = 'https://www.tmbdirect.com';
                          res_data[key].pri_color = '#006cb7';
                          res_data[key].sec_color = '#b2d2e9';
                        }
                        $scope.internet_bank.push(res_data[key]);

            }else if (value.deposit_type_id == 28 || value.deposit_type_id == 44 || value.deposit_type_id == 40 ||
                      value.deposit_type_id == 51 ) {

                        if(value.deposit_type_id == 28){
                          res_data[key].access_way = 'k-mobile banking plus';
                          res_data[key].pri_color = '#0e8f33';
                          res_data[key].sec_color = '#cee8d6';
                        }else if (value.deposit_type_id == 44) {
                          res_data[key].access_way = 'KTB netbank';
                          res_data[key].pri_color = '#00A4E4';
                          res_data[key].sec_color = '#99daf4';
                        }else if (value.deposit_type_id == 40) {
                          res_data[key].access_way = 'Krungsri';
                          res_data[key].pri_color = '#c1a000';
                          res_data[key].sec_color = '#fbeeb2';
                        }else if (value.deposit_type_id == 51) {
                          res_data[key].access_way = 'TMB touch';
                          res_data[key].pri_color = '#006cb7';
                          res_data[key].sec_color = '#b2d2e9';
                        }
                        $scope.mobile_bank.push(res_data[key]);

            }else if (value.deposit_type_id == 38 || value.deposit_type_id == 26 || value.deposit_type_id == 34 ||
                      value.deposit_type_id == 49) {
              $scope.atm_normal.push(res_data[key]);
            }else if (value.deposit_type_id == 61 || value.deposit_type_id == 62 || value.deposit_type_id == 63 ||
                      value.deposit_type_id == 64 || value.deposit_type_id == 65 || value.deposit_type_id == 66 ||
                      value.deposit_type_id == 67 || value.deposit_type_id == 68) {
              $scope.atm_ref_code.push(res_data[key]);
            }else if (value.deposit_type_id == 55 || value.deposit_type_id == 56 || value.deposit_type_id == 57 ||
                      value.deposit_type_id == 47) {

                        if(value.deposit_type_id == 55){
                          res_data[key].note = 'รับชำระสูงสุดครั้งละไม่เกิน 20,000 บาท';
                          res_data[key].name_for_show = 'BigC';
                        }else if (value.deposit_type_id == 56) {
                          res_data[key].note = 'รับชำระสูงสุดครั้งละไม่เกิน 20,000 บาท';
                          res_data[key].name_for_show = 'Tops ซุปเปอร์มาร์เก็ต';
                        }else if (value.deposit_type_id == 57) {
                          res_data[key].note = 'รับชำระสูงสุดครั้งละไม่เกิน 20,000 บาท';
                          res_data[key].name_for_show = 'FamilyMart';
                        }else if (value.deposit_type_id == 47) {
                          res_data[key].note = 'รับชำระสูงสุดครั้งละไม่เกิน 10,000 บาท';
                          res_data[key].name_for_show = '7-11 เซเว่นอีเลเว่น';
                        }
                        $scope.couterservice.push(res_data[key]);

            }else if (value.deposit_type_id == 46 || value.deposit_type_id == 48) {

              if(value.deposit_type_id == 46){
                res_data[key].note = '(รับชำระผ่านบัตรเครดิตโดย PayPal)';
                res_data[key].name_for_show = 'บัตรเครดิต Visa และ MasterCard';
              }else if (value.deposit_type_id == 48) {
                res_data[key].note = '';
                res_data[key].name_for_show = 'PayPal Account';
              }
              $scope.credit_paypal.push(res_data[key]);

            }else if (value.deposit_type_id == 58 || value.deposit_type_id == 59 || value.deposit_type_id == 60) {

              if(value.deposit_type_id == 58){
                res_data[key].name_for_show = 'ทรูมันนี่วอลเล็ต';
              }else if (value.deposit_type_id == 59) {
                res_data[key].name_for_show = 'แจ๋ววอลเล็ต';
              }else if (value.deposit_type_id == 60) {
                res_data[key].name_for_show = 'เอ็มเพย์วอลเล็ต';
              }
              $scope.e_wallet.push(res_data[key]);
            }
          });
          console.log($scope.internet_bank);
        /**

          if(res_data[0].deposit_type_status != 'enable' && res_data[1].deposit_type_status != 'enable'){
            $scope.no_option = true;
          }else if (res_data[0].deposit_type_status != 'enable' && res_data[1].deposit_type_status == 'enable') {
            $scope.auto_type_option = 48;
          }**/
        });
      }
    })
    .state('step3_deposit_auto', {
      url: '/step3_deposit_auto',
      abstract: false,
      params: {
        deposit_username: null,
        auto_type_option: null,
        direct_access: false
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step3_deposit_auto.html',
      controller: function($scope, $state, $stateParams, $http, $filter, $mdDialog) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          return;
        }

        $scope.user = {};
        $scope.user.credit_result = 0;
        $scope.invalid_number = true;
        if($stateParams.auto_type_option == '46' || $stateParams.auto_type_option == '48'){
          $scope.show_money_input = false;
          $scope.invalid_number = false;
        }else {
          $scope.show_money_input = true;
        }
        var timeStamp = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss', '+0700');
        var date = timeStamp.split(" ")[0];
        var time = timeStamp.split(" ")[1];
        //console.log(timeStamp);
        //console.log(date);
        //console.log(time);
        var randomStang = Math.random().toString();
        var stang = randomStang.substr(randomStang.length-2, randomStang.length);

        $scope.cal_credit_money = function(credit_money,e){

            $scope.user.credit_money = Math.floor($scope.user.credit_money);
            //console.log($scope.user.credit_money);
            if($scope.user.credit_money == 0){
              $scope.user.credit_money = '';
            }
            if($scope.user.bonus_type == 'get_200_per'){
              $scope.user.credit_result = credit_money * 2;
              if($scope.user.credit_result >= 1500){
                $scope.user.credit_result = credit_money + 1500;
                $scope.user.credit_result = Math.floor($scope.user.credit_result);
              }else{
                //$scope.user.credit_result = $scope.user.credit_result + credit_money;
                $scope.user.credit_result = Math.floor($scope.user.credit_result);
              }
            }else if ($scope.user.bonus_type == 'get_10_per') {
              if(credit_money >= 5000){
                $scope.user.credit_result =  credit_money + (credit_money * 10 / 100);
                $scope.user.credit_result = Math.floor($scope.user.credit_result);
              }else{
                $scope.user.credit_result = credit_money;
                $scope.user.credit_result = Math.floor($scope.user.credit_result);
              }
            }else{
              $scope.user.credit_result = credit_money;
              $scope.user.credit_result = Math.floor($scope.user.credit_result);
            }

            if(isNaN($scope.user.credit_result) || credit_money == 0 || credit_money == '' || $scope.user.credit_result == 0){
              $scope.user.credit_result = '';
              $scope.invalid_number = true;
              if($stateParams.auto_type_option == '46' || $stateParams.auto_type_option == '48'){
                $scope.show_money_input = false;
                $scope.invalid_number = false;
              }
            }else {
              $scope.invalid_number = false;
            }
        }

        $scope.set_account_to_deposit = function(ev){

          var set_account_req = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/deposit-set-account.php",
            data: {
              username: $stateParams.deposit_username,
              auto_type_option: $stateParams.auto_type_option,
              deposit_amount: $scope.user.credit_money + '.' + stang,
              timeStamp: timeStamp,
              date: date,
              time: time,
              bonus_type: $scope.user.bonus_type
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          set_account_req.success(function(res_data) {
            console.log(res_data);
            if(res_data.set_status == 'success'){
              var params = {
                'deposit_username': $stateParams.deposit_username,
                'auto_type_option': $stateParams.auto_type_option,
                'direct_access': false
              };
              if($stateParams.auto_type_option == 46 || $stateParams.auto_type_option == 48){
                $state.go("step4_deposit_auto_credit_paypal", params);
              }else if ($stateParams.auto_type_option == 33 || $stateParams.auto_type_option == 29 ||
                  $stateParams.auto_type_option == 37 || $stateParams.auto_type_option == 45 ||
                  $stateParams.auto_type_option == 41 || $stateParams.auto_type_option == 52 ) {

                params.deposit_regis = timeStamp;
                params.amount = $scope.user.credit_money + '.' + stang;
                $state.go("step4_deposit_auto_interner_banking", params);
              }

            }else {
              $mdDialog.show(
                $mdDialog.alert()
                  .parent(angular.element(document.querySelector('body')))
                  .clickOutsideToClose(true)
                  .title('เกิดข้อผิดพลาด')
                  .textContent('เกิดข้อผิดพลาด')
                  .ariaLabel('Alert Dialog')
                  .ok('OK')
                  .targetEvent(ev)
              );
            }
          });
        }

        var check_deposit_account = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/deposit-check-account.php",
          data: {
            username: $stateParams.deposit_username
          },
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        check_deposit_account.success(function(res_data) {
          //console.log(res_data);
          if(res_data.account_is_deposited == '0'){
            $scope.big_bonun_text = 'ขอแสดงความยินดีคุณได้รับโบนัส 200% จากยอดเงินฝากครั้งแรก';
            $scope.small_bonun_text = 'ต้องการรับโบนัสหรือไม่ ? (หากรับคุณจะต้องมียอด Turnover เกิน 8 เท่าก่อนจึงจะถอนเงินได้ หากถอนก่อนจะถูกยึดโบนัสคืน)';
            $scope.bonus_option_1 = 'รับโบนัส (สูงสุดไม่เกิน 200% จากยอดเงินฝาก สูงสุดไม่เกิน 1500 บาท)';
            $scope.bonus_option_2 = 'ไม่รับโบนัสนี้ (ไม่ต้องการติดเงื่อนไข Turnover สามารถถอนได้ตลอดเวลา)';
            $scope.option_1_value = 'get_200_per'
            $scope.option_2_value = 'no_bonus'
            $scope.user.bonus_type = 'get_200_per';
          }else{
            $scope.big_bonun_text = 'คุณได้รับโบนัส 10% จากยอดเงินฝาก (กรณีฝากเกิน 5000 บาทขึ้นไป)';
            $scope.small_bonun_text = 'ต้องการรับโบนัสหรือไม่ ? (หากรับคุณจะต้องมียอด Turnover เกิน 5 เท่าก่อนจึงจะถอนเงินได้ หากถอนก่อนจะถูกยึดโบนัสคืน)';
            $scope.bonus_option_1 = 'รับโบนัส (เฉพาะยอดเงินฝากเกิน 5000 บาทเท่านั้น)';
            $scope.bonus_option_2 = 'ไม่รับโบนัสนี้ (ไม่ต้องการติดเงื่อนไข Turnover สามารถถอนได้ตลอดเวลา)';
            $scope.option_1_value = 'get_10_per'
            $scope.option_2_value = 'no_bonus'
            $scope.user.bonus_type = 'get_10_per';
          }

        });

      }
    })
    .state('step4_deposit_auto_credit_paypal', {
      url: '/step4_deposit_auto_credit_paypal',
      abstract: false,
      params: {
        deposit_username: null,
        auto_type_option: null,
        direct_access: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_deposit_auto_credit_paypal.html',
      controller: function($scope, $state, $stateParams, $http, $filter) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          return;
        }
        //console.log($stateParams.auto_type_option);
        $scope.user = {};
        $scope.user.username = $stateParams.deposit_username;

        if($stateParams.auto_type_option == 46){
          $scope.payType = WPURLS.templateurl + '/images/paywithcreditcard.png';
          $scope.manualType = WPURLS.templateurl + '/images/paywithcreditcardmanual.png';
        }else if ($stateParams.auto_type_option == 48) {
          $scope.payType = WPURLS.templateurl + '/images/paywithpaypal.png';
          $scope.manualType = WPURLS.templateurl + '/images/paywithpaypalmanual.png';
        }
      }
    })
    .state('step4_deposit_auto_interner_banking', {
      url: '/step4_deposit_auto_interner_banking',
      abstract: false,
      params: {
        deposit_username: null,//'zkc8688000',
        auto_type_option: null,//'29',
        direct_access: false,
        deposit_regis: null,//'2016-03-12 15:11:46',
        amount: null,//'7500'
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_deposit_auto_interner_banking.html',
      controller: function($scope, $state, $stateParams, $http, $filter) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          return;
        }

        console.log($stateParams.deposit_username);
        console.log($stateParams.amount);
        console.log($stateParams.deposit_regis);
        if($stateParams.auto_type_option == 33 || $stateParams.auto_type_option == 45){
          $scope.notify_us1 = 'เป็นไปอย่างอัตโนมัติกรุณาระบุอีเมล';
          $scope.notify_us2 = $stateParams.deposit_username + '@pay.sbobet878.com';
          $scope.warning_message1 = 'ระบุอีเมลตามที่ระบบแจ้งทางซ้ายมือ';
          $scope.warning_message2 = 'ลงในช่อง "บริการแจ้งผู้รับเงินปลายทาง" เพื่อให้ระบบตรวจสอบอัตโนมัติของเราตรวจสอบยอดของท่านได้รวดเร็วยิ้งชึ้น';
        }else if ($stateParams.auto_type_option == 29) {
          $scope.notify_us1 = 'เป็นไปอย่างอัตโนมัติกรุณาแจ้งผู้รับโอนผ่าน SMS ส่งมาที่เบอร์';
          $scope.notify_us2 = '0952353577';
          $scope.notify_us3 = 'โดยระบุชื่อผู้ส่งเป็น';
          $scope.notify_us4 = $stateParams.deposit_username;
          $scope.warning_message1 = 'ส่ง SMS ตามที่ระบบแจ้งทางซ้ายมือ';
          $scope.warning_message2 = 'เพื่อให้ระบบตรวจสอบอัตโนมัติของเราตรวจสอบยอดของท่านได้รวดเร็วยิ้งชึ้น';
        }else if ($stateParams.auto_type_option == 37 || $stateParams.auto_type_option == 41 || $stateParams.auto_type_option == 52) {
          $scope.notify_us1 = 'เป็นไปอย่างอัตโนมัติกรุณาระบุอีเมลเป็น';
          $scope.notify_us2 = $stateParams.deposit_username + '@pay.sbobet878.com';
          $scope.notify_us3 = 'ระบุชื่อผู้โอนเป็น';
          $scope.notify_us4 = $stateParams.deposit_username;
          $scope.warning_message1 = 'ระบุอีเมลและชื่อผู้โอนตามที่ระบบแจ้งทางซ้ายมือ';
          $scope.warning_message2 = 'เพื่อให้ระบบตรวจสอบอัตโนมัติของเราตรวจสอบยอดของท่านได้รวดเร็วยิ้งชึ้น';
        }

        var get_pay_info = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/deposit-get-payInfo.php",
          data: {
            username: $stateParams.deposit_username,
            deposit_amount: $stateParams.amount,
            timeStamp: $stateParams.deposit_regis
          },
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        get_pay_info.success(function(res_data) {
          console.log(res_data);
          $scope.bank_wellknown_name = res_data[0].deposit_type_wellknown_name;
          $scope.money_amount = $stateParams.amount;
          $scope.bank_number = res_data[0].deposit_bank_account;
          $scope.bank_name = res_data[0].deposit_bank_name;
          $scope.bank_logo = WPURLS.templateurl + res_data[0].deposit_type_logo_large;
          $scope.how_to_email = WPURLS.templateurl + res_data[0].deposit_type_emailnotify_image;

        });
      }
    });
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
