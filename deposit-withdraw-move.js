var app = angular.module('MyDepositWithdrawMove', ['ngMaterial', 'ngMessages', 'ui.router', 'smart-table', 'angularSlideables']);

app.run(['$anchorScroll', function($anchorScroll) {
    $anchorScroll.yOffset = 150;   // always scroll by 50 extra pixels
  }]);

app.controller('DepositWithdrawMove', function($scope, $http, $filter, $state) {

  ////console.log("Deposit !!!");
  $state.go("step0");


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
    .state('step0', {
      url: '/step0',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/step0.html',
      controller: function($scope, $state, $window, $anchorScroll, $location, $http) {
        $location.hash('form_section');
        $anchorScroll();
      }
    })
    .state('step1', {
      url: '/step1',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/step1.html',
      controller: function($scope, $state, $window, $anchorScroll, $location, $http) {
        $scope.step1_option = '1';
        $scope.template_directory_uri = WPURLS.templateurl;
        $location.hash('form_section');
        $anchorScroll();
        $scope.dep_auto_text = '';
        $scope.dep_man_text = '';
        $scope.wid_auto_text = '';
        $scope.regis_page = WPURLS.home_url + '/user_inform_transfer';
        console.log($scope.regis_page);
        var check_wid_dep = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/check-deposit-auto-withdraw-enable.php",
          data: {},
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        check_wid_dep.success(function(enable_status) {
          //console.log(enable_status);
        /*  if(enable_status.deposit_auto_enable == 'Yes'){
            $scope.dep_auto_status = false;
          }else {
            $scope.step1_option = null;
            $scope.dep_auto_status = true;
            $scope.dep_auto_text = '--- ระบบอัตโนมัติขัดข้อง'
          }*/

          if(enable_status.sbobet_depositCC_enable == 'Yes'){
            $scope.dep_man_status = false;
          }else {
            $scope.dep_man_status = true;
            $scope.dep_man_text = ' --- ระบบฝากขัดข้องชั่วคราว';
          }

          if(enable_status.sbobet_withdraw_enable_by_cc == 'Yes'){
            $scope.withdraw_enable_status = false;
          }else {
            $scope.withdraw_enable_status = true;
            $scope.wid_auto_text = ' --- ระบบถอนขัดข้องชั่วคราว ทีมงานกำลังดำเนินการแก้ไข';
          }
        });

        $scope.nextTo = function(){
          var params = {
            'direct_access': false
          };

          if($scope.step1_option == '1'){
            $state.go("step2_deposit_auto", params);
          }else if ($scope.step1_option == '2') {
            $state.go("step2_deposit_man", params);
          }else if($scope.step1_option == '3'){
            $state.go("step2_withdraw", params);
          }else if ($scope.step1_option == '4') {
            $state.go("credit_move");
          }else if ($scope.step1_option == '5') {
            $window.location.href = WPURLS.home_url + '/user_inform_transfer';
          }
        }

      }
    })
    .state('method_5', {
      url: '/method_5',
      abstract: false,
      params: {
        direct_access: false,
      },
      templateUrl: WPURLS.templateurl + '/sub_page/method_5.html',
      controller: function($scope, $state, $stateParams, $anchorScroll, $location, $http) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
      }
    })
    .state('step2_withdraw', {
      url: '/step2_withdraw',
      abstract: false,
      params: {
        direct_access: null,
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step2_withdraw.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog, $anchorScroll, $location, $mdMedia) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.showSpin = false;
        $scope.user = {};
        $scope.user.username = '';//;
        $scope.user.tel = '';//'';
        $scope.user.status_ok = true;
        $scope.check_username_tel = function (ev) {
          $scope.user.username = $scope.user.username.toLowerCase();
          if($scope.user.username.length == 0 || $scope.user.tel.length == 0){
            $mdDialog.show(
              $mdDialog.alert()
                .parent(angular.element(document.querySelector('#di')))
                .clickOutsideToClose(true)
                .title('ข้อมูลไม่สมบูรณ์')
                .textContent('กรุณากรอกข้อมูลให้ครบ')
                .ariaLabel('Alert Dialog')
                .ok('OK')
                //.targetEvent(angular.element(document.querySelector('#form_section')))
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
            ////console.log(check_req_data);
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
                  .parent(angular.element(document.querySelector('#di')))
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
                  //.parent(angular.element(document.querySelector('#page')))
                  .clickOutsideToClose(true)
                  .title('ข้อมูลไม่ถูกต้อง')
                  .textContent('Username หรือ เบอร์โทรศัพท์ ไม่ถูกต้อง')
                  .ariaLabel('Alert Dialog')
                  .ok('OK')
                  .targetEvent(ev)
              );
            }else if (check_req_data.check_status == '4') {
              $scope.user.status_ok = false;
              $scope.alert_img = WPURLS.templateurl + '/images/alert_member_status_4.jpg';
            }else if (check_req_data.check_status == '5') {
              $scope.user.status_ok = false;
              $scope.alert_img = WPURLS.templateurl + '/images/alert_member_status_5.jpg';
            }else if (check_req_data.check_status == 'less_than_24_hours') {
              $scope.user.status_ok = false;
              $scope.alert_img = WPURLS.templateurl + '/images/withdraw24hr.jpg';
            }else if (check_req_data.check_status == 'not_enable') {
              $mdDialog.show(
                $mdDialog.alert()
                  //.parent(angular.element(document.querySelector('#page')))
                  .clickOutsideToClose(true)
                  .title('ระบบขัดข้อง')
                  .textContent('ระบบถอนเงินของเว็บต้นทาง (Sbobet.Com) ขัดข้องชั่วคราวกรุณาลองใหม่ภายหลัง')
                  .ariaLabel('Alert Dialog')
                  .ok('OK')
                  .targetEvent(ev)
              );
            }else{

              $mdDialog.show({
                  clickOutsideToClose: true,
                  scope: $scope,
                  preserveScope: true,
                  clickOutsideToClose:true,
                  templateUrl: WPURLS.templateurl + '/sub_page/withdraw_dialog.html',
                  parent: angular.element(document.querySelector('#form_section')),
                  controller: function DialogController($scope, $mdDialog) {

                    $scope.w_id = check_req_data.w_id;
                    $scope.check_status = check_req_data.check_status;
                     $scope.closeDialog = function() {
                        $mdDialog.hide();
                     }

                     $scope.answer = function(answer) {
                       var set_cancel = $http({
                         method: "post",
                         url: WPURLS.templateurl + "/php/withdraw-cancel.php",
                         data: {
                           username: $scope.user.username,
                           tel: $scope.user.tel,
                           w_id: check_req_data.w_id
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
                           ////console.log('cancel failed');
                           alert('cancel failed');
                         }
                       });
                     };
                  }
               });
              ////////
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
      controller: function($scope, $state, $stateParams, $http, $mdDialog, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.showSpin = true;
        $scope.user = {};
        var get_otp_ref = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/withdraw-sms-otp.php",
          data: {
            username: $stateParams.withdraw_username,
            check_otp: 'false',
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
            //console.log("sms sended");
          }else {
            //console.log('otp error');
            alert('error');
          }


        });

        $scope.check_otp = function(ev){
          $scope.showSpin = true;
          //console.log($scope.user.user_otp);
          var check_otp = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/withdraw-sms-otp.php",
            data: {
              username: $stateParams.withdraw_username,
              check_otp: 'true',
              otp_ref: $scope.otp_ref,
              otp: $scope.user.user_otp
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          check_otp.success(function(check_otp_data) {

            //console.log(check_otp_data);
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
                ////console.log(res_data);
                ////console.log(res_data.set_status);
                if(res_data.set_status == 'success'){
                  var params = {
                    'withdraw_username': $stateParams.withdraw_username,
                    'tel': $stateParams.tel,
                    'insert_id': res_data.insert_id,
                    'direct_access': false,
                  };
                  $state.go("step4_withdraw", params);
                }else{
                  //console.log('insert not success');
                  alert('error');
                }
              });
            }else{
              $scope.showSpin = false
              $mdDialog.show(
                $mdDialog.alert()
                  .parent(angular.element(document.querySelector('#form_section')))
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
            //console.log(sms_status_data);
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
        insert_id: null,
        direct_access: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_withdraw.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog, $interval, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        console.log($stateParams.insert_id);
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.home_url = WPURLS.home_url;
        $scope.withdraw_wait = true;
        $scope.withdraw_add = false;
        $scope.withdraw_req_complete = false;
        $scope.disable_ok = true;
        $scope.show_withdraw_error = false;
        $scope.show_button = true;
        $scope.withdraw = {};
        $scope.showLoading = false;
        check_withdraw_status();

        var interval = $interval(function(){
          check_withdraw_status();
        }, 5000);

        $scope.send_withdraw_req = function(withdraw_money, ev){
          var r = confirm('คุณต้องการถอนเงินเป็นจำนวน ' + withdraw_money + ' บาท ?');
          if (r == true) {
            $scope.showLoading = true;
            $scope.disable_ok = true;
            var send_req = $http({
              method: "post",
              url: WPURLS.templateurl + "/php/withdraw-update-amount.php",
              data: {
                username: $stateParams.withdraw_username,
                amount: withdraw_money,
                insert_id: $stateParams.insert_id
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
                $scope.showLoading = false;
              }else{
                $scope.showLoading = false;
                $mdDialog.show(
                  $mdDialog.alert()
                    .parent(angular.element(document.querySelector('#form_section')))
                    .clickOutsideToClose(true)
                    .title('เกิดความผิดพลาด')
                    .textContent('ระบบขัดข้องบางประการ')
                    .ariaLabel('Alert Dialog')
                    .ok('OK')
                    .targetEvent(ev)
                );
              }

            });
          } else {
              //txt = "You pressed Cancel!";
          }
        /**  var confirm = $mdDialog.confirm()
          .parent(angular.element(document.querySelector('#form_section')))
          .title('ยืนยันการถอนเงิน ?')
          .textContent('คุณต้องการถอนเงินเป็นจำนวน ' + withdraw_money + ' บาท')
          .ariaLabel('Lucky day')
          .targetEvent(ev)
          .ok('ยืนยัน')
          .cancel('ยกเลิก');
          $mdDialog.show(confirm).then(function() {
            $scope.showLoading = true;
            $scope.disable_ok = true;
            var send_req = $http({
              method: "post",
              url: WPURLS.templateurl + "/php/withdraw-update-amount.php",
              data: {
                username: $stateParams.withdraw_username,
                amount: withdraw_money,
                insert_id: $stateParams.insert_id
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
                $scope.showLoading = false;
              }else{
                $scope.showLoading = false;
                $mdDialog.show(
                  $mdDialog.alert()
                    .parent(angular.element(document.querySelector('#form_section')))
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
            //console.log('cancel');
          });**/

        }

        $scope.check_input_money = function(){

          //console.log($scope.current_amount);
          if(angular.isUndefined($scope.current_amount)){
            $scope.show_withdraw_error = true;
            $scope.error_text = 'ไม่พบยอดที่สามารถถอนได้';
            $scope.disable_ok = true;
          }else if(angular.isNumber($scope.withdraw.withdraw_money)){
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
              tel: $stateParams.tel,
              insert_id: $stateParams.insert_id
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          check_withdraw_money.success(function(res_data) {
            ////console.log(res_data);
            console.log(res_data);
            $scope.account = $stateParams.withdraw_username;
            $scope.bank_account = res_data[0].withdraw_bank_account;
            $scope.bank_name = res_data[0].withdraw_bank_name;
            $scope.nickname = res_data[0].withdraw_nickname;
            $scope.bonus_charge_back = res_data[0].bonus_charge_back;
            ////console.log(res_data[0].withdraw_status_id);
            if(res_data[0].withdraw_status_id == 9){
              $interval.cancel(interval);
              interval = undefined;
              if(res_data[0].bonus_charge_back >= 0){
                $scope.charge_back_status = true;
              }
              $scope.current_amount = res_data[0].max_withdraw_amount;
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
      controller: function($scope, $state, $stateParams, $http, $mdDialog, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $scope.direct_access = false;
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.home_url = WPURLS.home_url;
        $scope.user = {};
        $scope.user.tel = '';
        $scope.user.tel_1 = '';
        $scope.user.tel_2 = '';
        $scope.user.username = '';
        $scope.user.priority = '';
        $scope.cancel_text = '';
        $scope.is_logo_type = false;
        $scope.isDisable = true;
        $scope.dep_text = '--- ปิดปรับปรุงชั่วคราว';


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
            ////console.log(res_data);
            ////console.log(res_data.get_account_type);
            if(res_data.get_account_type == 'no_account'){
              $scope.wait_cancel = false;
              $scope.show_wait_text = false;
              $scope.show_deposit_option = false;
              $scope.show_cancel_button = false;
              $scope.account_type = 'Username หรือ เบอร์โทรศัพท์ไม่ถูกต้อง';

              if($scope.user.username.length == 0 && $scope.user.tel.length == 0){
                $scope.is_valid_account = false;
              }else {
                $scope.is_valid_account = true;
              }

              $scope.is_logo_type = false;
              $scope.isDisable = true;
            }else {
              //$scope.account_type = res_data.get_account_type;
              $scope.user.priority = res_data.user_priority;
              $scope.is_valid_account = false;
              $scope.logo_type = WPURLS.templateurl + res_data.get_logo_type;
              $scope.is_logo_type = true;
              $scope.isDisable = false;
              $scope.user.tel_1 = res_data.tel_1;
              $scope.user.tel_2 = res_data.tel_2;


              if(res_data.deposit_enable == 'Yes'){
                if(res_data.check_deposit_q == 'must_wait'){
                  $scope.wait_text = 'ท่านมีรายการฝากแบบอัตโนมัติค้างอยู่กรุณารอ ' + (5 - res_data.wait_time) + ' นาทีก่อนทำรายการใหม่';
                  $scope.show_wait_text = true;
                  $scope.show_cancel_button = false;
                }else if (res_data.check_deposit_q == 'must_cancel_before') {
                  $scope.wait_text = 'ท่านมีรายการฝากแบบอัตโนมัติค้างอยู่ หากต้องการเริ่มรายการใหม่กรุณายกเลิกรายการฝากก่อนหน้านี้';
                  $scope.show_cancel_button = true;
                  $scope.show_wait_text = true;
                  $scope.d_id = res_data.d_id;
                }else {
                  $scope.show_wait_text = false;
                  $scope.show_cancel_button = false;
                  $scope.show_deposit_option = true;
                }
              }else {
                $scope.wait_text = 'ระบบฝากเงินแบบอัตโนมัติของ Sbobet ขัดข้องชั่วคราวกรุณาใช้ระบบฝากเงินแบบแจ้ง CallCenter หลังโอนเงินเสร็จแทน';
                $scope.show_wait_text = true;
              }

            }

          });
        }

        $scope.cancel_deposit = function(){

          $scope.wait_cancel = true;
          $scope.cancel_text = 'กรุณารอสักครู่';
          var set_cancel_deposit = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/deposit-cancel.php",
            data: {
              d_id: $scope.d_id
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          set_cancel_deposit.success(function(res_data) {
            if(res_data.cancel_status == 'complete'){
              $scope.show_wait_text = false;
              $scope.show_cancel_button = false;
              $scope.show_deposit_option = true;
              $scope.cancel_text = 'ยกเลิกรายการฝากเรียบร้อยแล้ว';
            }else {
              $scope.cancel_text = 'ยกเลิกรายการฝากไม่สำเร็จ';
            }
          });
        }

        $scope.nextStep = function(ev){

          if(angular.isUndefined($scope.user.auto_type_option)){
            $mdDialog.show(
              $mdDialog.alert()
                .parent(angular.element(document.querySelector('#form_section')))
                .clickOutsideToClose(true)
                .title('ช่องทางการเติมเครดิต')
                .textContent('ท่านยังไม่ได้เลือกช่องทางการเติมเครดิต')
                .ariaLabel('Alert Dialog')
                .ok('OK')
                .targetEvent(ev)
            );
            return;
          }

          if($scope.user.auto_type_option == 46 || $scope.user.auto_type_option == 48){
            var get_first_cc_pp = $http({
              method: "post",
              url: WPURLS.templateurl + "/php/deposit-check-first-cc-pp.php",
              data: {
                username: $scope.user.username
              },
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              }
            });
            get_first_cc_pp.success(function(res_data) {
              if(res_data.first_cc_pp == 'Yes'){
                var params = {
                  'deposit_username': $scope.user.username,
                  'auto_type_option': $scope.user.auto_type_option,
                  'deposit_telephone': $scope.user.tel,
                  'user_priority': $scope.user.priority,
                  'direct_access': false
                };
                $state.go("additional_step_for_cc_pp", params);
              }else {
                var params = {
                  'deposit_username': $scope.user.username,
                  'auto_type_option': $scope.user.auto_type_option,
                  'deposit_telephone': $scope.user.tel,
                  'user_priority': $scope.user.priority,
                  'direct_access': false
                };
                $state.go("step3_deposit_auto", params);
              }
            });
          }else {
            var params = {
              'deposit_username': $scope.user.username,
              'auto_type_option': $scope.user.auto_type_option,
              'deposit_telephone': $scope.user.tel,
              'user_priority': $scope.user.priority,
              'direct_access': false
            };
            $state.go("step3_deposit_auto", params);
          }

          /**var params = {
            'deposit_username': $scope.user.username,
            'auto_type_option': $scope.user.auto_type_option,
            'deposit_telephone': $scope.user.tel,
            'user_priority': $scope.user.priority,
            'direct_access': false
          };
          $state.go("step3_deposit_auto", params);**/
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
          ////console.log(res_data);
          ////console.log(res_data[0].deposit_type_name);
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
                          res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 22:30 - 24:00)';
                        }else if (value.deposit_type_id == 29) {
                          res_data[key].access_way = 'https://www.kasikornbank.com/';
                          res_data[key].pri_color = '#0e8f33';
                          res_data[key].sec_color = '#cee8d6';
                          res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 21:30 – 23:00)';
                        }else if (value.deposit_type_id == 37) {
                          res_data[key].access_way = 'https://ibanking.bangkokbank.com';
                          res_data[key].pri_color = '#003399';
                          res_data[key].sec_color = '#b2c1e0';
                          res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 22:30 – 01:00)';
                        }else if (value.deposit_type_id == 45) {
                          res_data[key].access_way = 'https://www.ktbnetbank.com';
                          res_data[key].pri_color = '#00A4E4';
                          res_data[key].sec_color = '#99daf4';
                          res_data[key].close_time = '';
                        }else if (value.deposit_type_id == 41) {
                          res_data[key].access_way = 'https://www.krungsrionline.com';
                          res_data[key].pri_color = '#c1a000';
                          res_data[key].sec_color = '#fbeeb2';
                          res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 22:30 – 01:00)';
                        }else if (value.deposit_type_id == 52) {
                          res_data[key].access_way = 'https://www.tmbdirect.com';
                          res_data[key].pri_color = '#006cb7';
                          res_data[key].sec_color = '#b2d2e9';
                          res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 22:30 – 01:00)';
                        }
                        $scope.internet_bank.push(res_data[key]);

            }else if (value.deposit_type_id == 28 || value.deposit_type_id == 44 || value.deposit_type_id == 40 ||
                      value.deposit_type_id == 51 ) {

                        if(value.deposit_type_id == 28){
                          res_data[key].access_way = 'k-mobile banking plus';
                          res_data[key].pri_color = '#0e8f33';
                          res_data[key].sec_color = '#cee8d6';
                          res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 21:30 – 23:00)';
                        }else if (value.deposit_type_id == 44) {
                          res_data[key].access_way = 'KTB netbank';
                          res_data[key].pri_color = '#00A4E4';
                          res_data[key].sec_color = '#99daf4';
                          res_data[key].close_time = '';
                        }else if (value.deposit_type_id == 40) {
                          res_data[key].access_way = 'Krungsri';
                          res_data[key].pri_color = '#c1a000';
                          res_data[key].sec_color = '#fbeeb2';
                          res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 22:30 – 01:00)';
                        }else if (value.deposit_type_id == 51) {
                          res_data[key].access_way = 'TMB touch';
                          res_data[key].pri_color = '#006cb7';
                          res_data[key].sec_color = '#b2d2e9';
                          res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 22:30 – 01:00)';
                        }
                        $scope.mobile_bank.push(res_data[key]);

            }else if (value.deposit_type_id == 38 || value.deposit_type_id == 26 || value.deposit_type_id == 34 ||
                      value.deposit_type_id == 49) {
              if(value.deposit_type_id == 38){
                res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 22:30 – 01:00)';
              }else if (value.deposit_type_id == 26) {
                res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 21:30 – 23:00)';
              }else if (value.deposit_type_id == 34) {
                res_data[key].close_time = '';
              }else if (value.deposit_type_id == 49) {
                res_data[key].close_time = '(ไม่สามารถใช้ช่องทางนี้ได้ใช่ช่วงเวลา 02:30 – 05:00 และ 22:30 – 01:00)';
              }
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
                res_data[key].link_site = ' https://wallet.truemoney.com/register#/consumer';
                res_data[key].link_manual_1 = WPURLS.home_url + '/true-money-manual#/truemoney-regis#form_section';
                res_data[key].link_manual_2 = WPURLS.home_url + '/true-money-manual';
                res_data[key].link_manual_img_1 = WPURLS.templateurl + '/images/truewallet-regis-button.png';
                res_data[key].link_manual_img_2 = WPURLS.templateurl + '/images/truewallet-manual-button.png';
              }else if (value.deposit_type_id == 59) {
                res_data[key].name_for_show = 'แจ๋ววอลเล็ต';
                //res_data[key].link_site = 'http://www.truemoney.com/wallet/';
                //res_data[key].link_manual = WPURLS.home_url + '/true-money-manual';
              }else if (value.deposit_type_id == 60) {
                res_data[key].name_for_show = 'เอ็มเพย์วอลเล็ต';
                res_data[key].link_site = 'http://www.ais.co.th/mpay/';
                res_data[key].link_manual_1 = WPURLS.home_url + '/ais-mpay-manual#/mpay-regis#form_section';
                res_data[key].link_manual_2 = WPURLS.home_url + '/ais-mpay-manual';
                res_data[key].link_manual_img_1 = WPURLS.templateurl + '/images/mpay-regis-button.png';
                res_data[key].link_manual_img_2 = WPURLS.templateurl + '/images/mpay-manual-button.png';
              }
              $scope.e_wallet.push(res_data[key]);
            }
          });
          //console.log($scope.internet_bank);

        $scope.auto_type_change = function(auto_type_value){
          //console.log(auto_type_value);
          if(auto_type_value == 58){
            var target = document.querySelector('#e_wallet');
            target.style.height = 'auto';
            $scope.wallet_style = {
              'border-radius':'7px',
              'padding':'10px',
              'margin':'20px',
              'width':'85%',
              'border': '2px solid #f54600',
              'background-color':'#f58300',
              'color':'white'
            };
            $scope.e_wallet_selected_58 = true;
            $scope.e_wallet_selected_59 = false;
            $scope.e_wallet_selected_60 = false;
          }else if (auto_type_value == 59) {
            var target = document.querySelector('#e_wallet');
            target.style.height = 'auto';
            $scope.wallet_style = {
              'border-radius':'7px',
              'padding':'10px',
              'margin':'20px',
              'width':'75%',
              'border': '2px solid #0099ce',
              'background-color':'#00ace7',
              'color':'white'
            };
            $scope.e_wallet_selected_58 = false;
            $scope.e_wallet_selected_59 = true;
            $scope.e_wallet_selected_60 = false;
          }else if (auto_type_value == 60) {
            var target = document.querySelector('#e_wallet');
            target.style.height = 'auto';
            $scope.wallet_style = {
              'border-radius':'7px',
              'padding':'10px',
              'margin':'20px',
              'width':'75%',
              'border': '2px solid #5f8900',
              'background-color':'#93af53',
              'color':'white'
            };
            $scope.e_wallet_selected_58 = false;
            $scope.e_wallet_selected_59 = false;
            $scope.e_wallet_selected_60 = true;
          }else {
            /**var target = document.querySelector('#e_wallet');
            target.style.height = 'auto';**/
            $scope.e_wallet_selected_58 = false;
            $scope.e_wallet_selected_59 = false;
            $scope.e_wallet_selected_60 = false;
          }
        }

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
        deposit_telephone: null,
        user_priority: null,
        direct_access: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step3_deposit_auto.html',
      controller: function($scope, $state, $stateParams, $http, $filter, $mdDialog, $location, $anchorScroll) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $scope.showLoading = false;
        $scope.template_directory_uri = WPURLS.templateurl;
        $location.hash('form_section');
        $anchorScroll();
        $scope.user = {};
        $scope.user.credit_result = 0;
        $scope.invalid_number = true;
        if($stateParams.auto_type_option == '46' || $stateParams.auto_type_option == '48'){
          $scope.show_money_input = false;
          $scope.invalid_number = false;
        }else if ($stateParams.auto_type_option == '58' || $stateParams.auto_type_option == '59' || $stateParams.auto_type_option == '60') {
          $scope.max_money = 10000;
          $scope.show_money_input = true;
          $scope.money_placeholder = 'สูงสุดที่ 10,000 บาท';
        }else {
          $scope.show_money_input = true;
          $scope.money_placeholder = 'กรุณากรอกยอดที่ท่านต้องการเติมเครดิต';
        }

        ////console.log(timeStamp);
        ////console.log(date);
        ////console.log(time);
        //var randomStang = Math.random().toString();
        //var stang = randomStang.substr(randomStang.length-2, randomStang.length);

        $scope.cal_credit_money = function(credit_money,e){
            var credit_money = parseInt(credit_money);
            $scope.user.credit_money = Math.floor(credit_money);
            ////console.log($scope.user.credit_money);
            if($scope.user.credit_money == 0){
              $scope.user.credit_money = '';
            }else if ($scope.user.credit_money < 5000 && $scope.user.bonus_type == 'get_10_per') {
              $scope.user.bonus_type = 'no_bonus';
            }
            if($scope.user.bonus_type == 'get_200_per'){
              $scope.user.credit_result = credit_money * 2;
              if(credit_money >= 1500){
                $scope.user.credit_result = credit_money + 1500;
                $scope.user.credit_result = Math.floor($scope.user.credit_result);
              }else{
                //$scope.user.credit_result = $scope.user.credit_result + credit_money;
                $scope.user.credit_result = Math.floor($scope.user.credit_result);
              }
            }else if ($scope.user.bonus_type == 'get_10_per') {
              if(credit_money >= 10000){
                $scope.user.credit_result =  credit_money + (credit_money * 10 / 100);
                $scope.user.credit_result = Math.floor($scope.user.credit_result);
              } else if(credit_money >= 5000){
                $scope.user.credit_result =  credit_money + (credit_money * 5 / 100);
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
          $scope.invalid_number = true;
          $scope.showLoading = true;
          var timeStamp = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss', '+0700');
          var date = timeStamp.split(" ")[0];
          var time = timeStamp.split(" ")[1];

          var set_account_req = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/deposit-set-account.php",
            data: {
              username: $stateParams.deposit_username,
              auto_type_option: $stateParams.auto_type_option,
              deposit_amount: $scope.user.credit_money,
              deposit_telephone: $stateParams.deposit_telephone,
              timeStamp: timeStamp,
              date: date,
              time: time,
              bonus_type: $scope.user.bonus_type,
              user_priority: $stateParams.user_priority
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          set_account_req.success(function(res_data) {
            //console.log(res_data);
            if(res_data.set_status == 'success'){
              var params = {
                'deposit_username': $stateParams.deposit_username,
                'auto_type_option': $stateParams.auto_type_option,
                'deposit_telephone': $stateParams.deposit_telephone,
                'direct_access': false
              };
              if($stateParams.auto_type_option == 46 || $stateParams.auto_type_option == 48){
                params.insert_id = res_data.insert_id;
                $state.go("step4_deposit_auto_credit_paypal", params);
              }else if ($stateParams.auto_type_option == 33 || $stateParams.auto_type_option == 29 ||
                  $stateParams.auto_type_option == 37 || $stateParams.auto_type_option == 45 ||
                  $stateParams.auto_type_option == 41 || $stateParams.auto_type_option == 52 ) {
                params.deposit_regis = timeStamp;
                params.amount = res_data.amount;
                $state.go("step4_deposit_auto_interner_banking", params);
              }else if ($stateParams.auto_type_option == 28 || $stateParams.auto_type_option == 44 ||
                  $stateParams.auto_type_option == 40 || $stateParams.auto_type_option == 51) {
                params.deposit_regis = timeStamp;
                params.amount = res_data.amount;
                $state.go("step4_deposit_auto_interner_banking", params); //app
              }else if ($stateParams.auto_type_option == 58 || $stateParams.auto_type_option == 59 || $stateParams.auto_type_option == 60){
                params.wallet_number = res_data.wallet_number;
                params.amount = res_data.amount;
                $state.go("step4_deposit_auto_e_wallet", params);
              }else if ($stateParams.auto_type_option == 26 || $stateParams.auto_type_option == 30 || $stateParams.auto_type_option == 34 ||
                        $stateParams.auto_type_option == 38 || $stateParams.auto_type_option == 42 || $stateParams.auto_type_option == 49 ||
                        $stateParams.auto_type_option == 53 || $stateParams.auto_type_option == 54){
                params.deposit_regis = timeStamp;
                params.amount = res_data.amount;
                $state.go("step4_deposit_auto_atm_normal", params);
              }

            }else {
              $mdDialog.show(
                $mdDialog.alert()
                  .parent(angular.element(document.querySelector('#form_section')))
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
          ////console.log(res_data);
          if(res_data.account_is_deposited == '0'){
            $scope.big_bonun_text = 'ขอแสดงความยินดีคุณได้รับโบนัส 100% จากยอดเงินฝากครั้งแรก';
            $scope.small_bonun_text = 'ต้องการรับโบนัสหรือไม่ ? (หากรับคุณจะต้องมียอด Turnover เกิน 8 เท่าก่อนจึงจะถอนเงินได้ หากถอนก่อนจะถูกยึดโบนัสคืน)';
            $scope.bonus_option_1 = 'รับโบนัส (สูงสุดไม่เกิน 100% จากยอดเงินฝาก สูงสุดไม่เกิน 1500 บาท)';
            $scope.bonus_option_2 = 'ไม่รับโบนัสนี้ (ไม่ต้องการติดเงื่อนไข Turnover สามารถถอนได้ตลอดเวลา)';
            $scope.option_1_value = 'get_200_per'
            $scope.option_2_value = 'no_bonus'
            $scope.user.bonus_type = 'get_200_per';
          }else{
            $scope.big_bonun_text = 'คุณได้รับโบนัส 10% จากยอดเงินฝาก กรณีฝากเกิน 10,000 บาทขึ้นไป หรือหากฝาก 5,000-9,999 บาทจะได้รับโบนัส 5%';
            $scope.small_bonun_text = 'ต้องการรับโบนัสหรือไม่ ? (หากรับคุณจะต้องมียอด Turnover เกิน 5 เท่าก่อนจึงจะถอนเงินได้ หากถอนก่อนจะถูกยึดโบนัสคืน)';
            $scope.bonus_option_1 = 'รับโบนัส (เฉพาะยอดเงินฝากเกิน 10000 หรือ 5000 บาทเท่านั้น)';
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
        insert_id: null,
        direct_access: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_deposit_auto_credit_paypal.html',
      controller: function($scope, $state, $stateParams, $http, $filter, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
        ////console.log($stateParams.auto_type_option);
        $scope.user = {};
        $scope.user.id_username = $stateParams.insert_id + '-' + $stateParams.deposit_username;
        $scope.user.username = $stateParams.deposit_username;

        if($stateParams.auto_type_option == 46){
          $scope.payType = WPURLS.templateurl + '/images/paywithcreditcard.jpg';
          $scope.manualType = WPURLS.templateurl + '/images/paywithcreditcardmanual.jpg';
        }else if ($stateParams.auto_type_option == 48) {
          $scope.payType = WPURLS.templateurl + '/images/paywithpaypal.jpg';
          $scope.manualType = WPURLS.templateurl + '/images/paywithpaypalmanual.jpg';
        }
      }
    })
    .state('step4_deposit_auto_interner_banking', {
      url: '/step4_deposit_auto_interner_banking',
      abstract: false,
      params: {
        deposit_username: null,
        auto_type_option: null,
        direct_access: null,
        deposit_regis: null,
        amount: null,
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_deposit_auto_interner_banking.html',
      controller: function($scope, $state, $stateParams, $http, $filter, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
        //console.log($stateParams.deposit_username);
        //console.log($stateParams.amount);
        //console.log($stateParams.deposit_regis);
        $scope.img_r = WPURLS.templateurl + '/images/d-amount.gif';
        if($stateParams.auto_type_option == 33 || $stateParams.auto_type_option == 45 ||
            $stateParams.auto_type_option == 44 || $stateParams.auto_type_option == 40 ){
          $scope.notify_us1 = 'ระบุที่อยู่ Email ผู้รับ';//'เป็นไปอย่างอัตโนมัติกรุณาระบุอีเมล';
          $scope.notify_us2 = $stateParams.deposit_username + '@pay.sbobet878.com';
          $scope.notify_us3 = WPURLS.templateurl + '/images/d-email.gif';
          $scope.notify_us4 = $stateParams.deposit_username;
          $scope.warning_message1 = 'ระบุอีเมลตามที่ระบบแจ้งทางซ้ายมือ';
          $scope.warning_message2 = 'ลงในช่อง "บริการแจ้งผู้รับเงินปลายทาง" เพื่อให้ระบบตรวจสอบอัตโนมัติของเราตรวจสอบยอดของท่านได้รวดเร็วยิ้งชึ้น';
        }else if ($stateParams.auto_type_option == 29 || $stateParams.auto_type_option == 28) {
          $scope.notify_us1 = 'ระบุเบอร์ sms ผู้รับ';//'เป็นไปอย่างอัตโนมัติกรุณาแจ้งผู้รับโอนผ่าน SMS ส่งมาที่เบอร์';
          $scope.notify_us2 = '0952353577';
          $scope.notify_us3 = WPURLS.templateurl + '/images/d-SMS.gif';//'โดยระบุชื่อผู้ส่งเป็น';
          $scope.notify_us4 = $stateParams.deposit_username;
          $scope.warning_message1 = 'ส่ง SMS ตามที่ระบบแจ้งทางซ้ายมือ';
          $scope.warning_message2 = 'เพื่อให้ระบบตรวจสอบอัตโนมัติของเราตรวจสอบยอดของท่านได้รวดเร็วยิ้งชึ้น';
        }else if ($stateParams.auto_type_option == 37 || $stateParams.auto_type_option == 41 ||
            $stateParams.auto_type_option == 52 ||
            $stateParams.auto_type_option == 51) {
          $scope.notify_us1 = 'ระบุที่อยู่ Email ผู้รับ';//'เป็นไปอย่างอัตโนมัติกรุณาระบุอีเมลเป็น';
          $scope.notify_us2 = $stateParams.deposit_username + '@pay.sbobet878.com';
          $scope.notify_us3 = WPURLS.templateurl + '/images/d-email.gif';//'ระบุชื่อผู้โอนเป็น';
          $scope.notify_us4 = $stateParams.deposit_username;
          $scope.warning_message1 = 'ระบุอีเมลและชื่อผู้โอนตามที่ระบบแจ้งทางซ้ายมือ';
          $scope.warning_message2 = 'เพื่อให้ระบบตรวจสอบอัตโนมัติของเราตรวจสอบยอดของท่านได้รวดเร็วยิ้งชึ้น';
        }

        var option = '';
        if($stateParams.auto_type_option == 28 || $stateParams.auto_type_option == 44 ||
          $stateParams.auto_type_option ==  40 || $stateParams.auto_type_option ==  51){
          option = 'มือถือ';
        }else {
          option = 'Internet Banking';
        }
        var get_pay_info = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/deposit-get-payInfo-internet-banking.php",
          data: {
            username: $stateParams.deposit_username,
            deposit_amount: $stateParams.amount,
            timeStamp: $stateParams.deposit_regis,
            auto_type_option: $stateParams.auto_type_option,
            set_option: option
          },
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        get_pay_info.success(function(res_data) {
          //console.log(res_data);
          //$scope.bank_wellknown_name = res_data[0].deposit_type_wellknown_name;
          $scope.bank_wellknown_name = res_data[0].selected_bank_wellknown_name;
          $scope.money_amount = $stateParams.amount;
          $scope.bank_number = res_data[0].deposit_bank_account;
          $scope.bank_name = res_data[0].deposit_bank_name;
          //$scope.nickname = res_data[0].deposit_nickname;
          $scope.bank_owner = res_data[0].bank_owner;
          //$scope.bank_logo = WPURLS.templateurl + res_data[0].deposit_type_logo_large;
          $scope.bank_logo = WPURLS.templateurl + res_data[0].selected_bank_logo
          //$scope.how_to_email = WPURLS.templateurl + res_data[0].deposit_type_emailnotify_image;
          $scope.how_to_email = WPURLS.templateurl + res_data[0].selected_bank_emailnotify_image;

        });
      }
    })
    .state('step4_deposit_auto_e_wallet', {
      url: '/step4_deposit_auto_e_wallet',
      abstract: false,
      params: {
        deposit_username: null,
        auto_type_option: null,
        direct_access: null,
        deposit_regis: null,
        deposit_telephone: null,
        amount: null,
        wallet_number: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_deposit_auto_e_wallet.html',
      controller: function($scope, $state, $stateParams, $http, $filter, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.amount_wallet = $stateParams.amount;
        $scope.from_wallet_tel = $stateParams.deposit_telephone;
        $scope.img_r = WPURLS.templateurl + '/images/d-amount.gif';
        var get_pay_info = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/deposit-get-payInfo-e-wallet.php",
          data: {
            username: $stateParams.deposit_username,
            deposit_amount: $stateParams.amount,
            timeStamp: $stateParams.deposit_regis,
            auto_type_option: $stateParams.auto_type_option,
            wallet_number: $stateParams.wallet_number
          },
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        get_pay_info.success(function(res_data) {
          //console.log(res_data);
          $scope.from_wallet_img = WPURLS.templateurl + res_data[0].deposit_type_emailnotify_image;
          $scope.arrow = WPURLS.templateurl + "/images/arrow_BW_thick_right_T.png";
          $scope.to_wallet_img = WPURLS.templateurl + res_data[1].deposit_type_emailnotify_image;
          $scope.to_wallet_tel = $stateParams.wallet_number;//res_data[0].wallet_number;
          $scope.wellknown_name = res_data[0].deposit_type_wellknown_name;

        });

      }
    })
    .state('step4_deposit_auto_atm_normal', {
      url: '/step4_deposit_auto_atm_normal',
      abstract: false,
      params: {
        deposit_username: null,
        auto_type_option: null,
        direct_access: null,
        deposit_regis: null,
        deposit_telephone: null,
        amount: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_deposit_auto_atm_normal.html',
      controller: function($scope, $state, $stateParams, $http, $filter, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.amount_atm = $stateParams.amount;
        $scope.tel = $stateParams.deposit_telephone;
        $scope.img_r = WPURLS.templateurl + '/images/d-amount.gif';
        $scope.notify_us3 = WPURLS.templateurl + '/images/d-SMS.gif';
        $scope.notify_us1 = 'ระบุเบอร์มือถือของผู้รับ';
        $scope.notify_us2 = '0957327076';
        var get_pay_info = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/deposit-get-payInfo-atm-normal.php",
          data: {
            username: $stateParams.deposit_username,
            deposit_amount: $stateParams.amount,
            timeStamp: $stateParams.deposit_regis,
            auto_type_option: $stateParams.auto_type_option
          },
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        get_pay_info.success(function(res_data) {
          //console.log(res_data);
          $scope.from_bank_name = res_data[0].from_bank_name;
          $scope.to_bank_name = res_data[0].deposit_bank_name;
          $scope.to_bank_number = res_data[0].deposit_bank_account;
          $scope.how_to = WPURLS.templateurl + res_data[0].how_to_img;
          $scope.bank_owner = res_data[0].bank_owner;
          $scope.bank_logo = WPURLS.templateurl + res_data[0].deposit_type_logo;
          var message = 'กรุณาโอนยอดจำนวน%0A' + $scope.amount_atm + '%20บาท%0A%0Aไปยังเลขบัญชีที่%0A' +
          $scope.to_bank_number + '%0A(ธนาคาร'+$scope.to_bank_name+')%0A%0Aหลังจากโอนเงินเสร็จ%0A'+
          'แล้วกรุณาใช้บริการ%20SMS%20แจ้งผู้รับโดยระบุเบอร์มือถือของผู้ส่งเป็นหมายเลข%20'+$scope.tel;
          send_sms($scope.tel, message);

        });


        function send_sms(tel_num, message){
          var sms_send = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/deposit-send-sms.php",
            data: {
              tel: tel_num,
              message: message
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          sms_send.success(function(sms_status_data) {
            //console.log(sms_status_data);
          });
        }
      }
    })
    .state('step2_deposit_man', {
      url: '/step2_deposit_man',
      abstract: false,
      params: {
        deposit_username: null,
        auto_type_option: null,
        direct_access: null,
        deposit_regis: null,
        deposit_telephone: null,
        amount: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step2_deposit_man.html',
      controller: function($scope, $state, $stateParams, $http, $filter, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.user = {};
        $scope.user.priority = '';
        $scope.user.username = '';
        $scope.user.tel = '';
        $scope.account_corect = false;
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.check_input = function(){
          if($scope.user.accepp == true && $scope.account_corect == true){
            $scope.show_button = true;
          }else {
            $scope.show_button = false;
          }
        }

        $scope.nextStep = function () {

          var params = {};
          params.deposit_username = $scope.user.username;
          params.user_priority = $scope.user.priority;
          params.direct_access = false;
          for(var x in $scope.bank_info){
            if(x == 0){
              params.bank_number = $scope.bank_info[x].bank_number;
              params.bank_name = $scope.bank_info[x].bank_name;
            }else if (x == 1) {
              params.bank_number_2 = $scope.bank_info[x].bank_number;
              params.bank_name_2 = $scope.bank_info[x].bank_name;
            }else if (x == 2) {
              params.bank_number_3 = $scope.bank_info[x].bank_number;
              params.bank_name_3 = $scope.bank_info[x].bank_name;
            }
          }
          //console.log(params);
          $state.go("step3_deposit_man", params);
        }

        $scope.check_account_type = function(){

          var get_account_type = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/deposit-man-get-account-type.php",
            data: {
              username: $scope.user.username,
              tel: $scope.user.tel
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          get_account_type.success(function(res_data) {
            //console.log(res_data);
            ////console.log(res_data.get_account_type);
            if(res_data.get_account_type == 'no_account'){
              $scope.account_corect = false;
              $scope.account_type = 'Username หรือ เบอร์โทรศัพท์ไม่ถูกต้อง';


              if($scope.user.username.length == 0 && $scope.user.tel.length == 0){
                $scope.is_valid_account = false;
              }else {
                $scope.is_valid_account = true;
              }

              $scope.is_logo_type = false;
              $scope.isDisable = true;
            }else {

              //$scope.account_type = res_data.get_account_type;
              $scope.user.priority = res_data.user_priority;
              $scope.is_valid_account = false;
              $scope.logo_type = WPURLS.templateurl + res_data.get_logo_type;
              $scope.is_logo_type = true;
              $scope.isDisable = false;

              var get_bank = $http({
                method: "post",
                url: WPURLS.templateurl + "/php/get-set-bank.php",
                data: {
                  username: $scope.user.username,
                  option: 'get_bank'
                },
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                }
              });
              get_bank.success(function(res_data) {
                //console.log(res_data);
                $scope.bank_info = [];
                $scope.bank_info.push({
                  'bank_number': res_data[0].member_bank_account,
                  'account_name': res_data[0].member_nickname,
                  'bank_name': res_data[0].member_bank_name
                });

                if(res_data[0].member_bank_account_2 != ''){
                  $scope.bank_info.push({
                    'bank_number': res_data[0].member_bank_account_2,
                    'account_name': res_data[0].member_nickname,
                    'bank_name': res_data[0].member_bank_name_2
                  });
                }
                if(res_data[0].member_bank_account_3 != ''){
                  $scope.bank_info.push({
                    'bank_number': res_data[0].member_bank_account_3,
                    'account_name': res_data[0].member_nickname,
                    'bank_name': res_data[0].member_bank_name_3
                  });
                }
                //console.log($scope.bank_info);
                $scope.account_corect = true;
              });
            }

          });
        };

      }
    })
    .state('add_bank', {
      url: '/add_bank',
      abstract: false,
      params: {
        direct_access: null,
        deposit_username: null,
      },
      templateUrl: WPURLS.templateurl + '/sub_page/add_bank.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog, $interval, $window) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $scope.show_ok = true;
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.user = {};
        $scope.user.bank_number_2 = '';
        $scope.user.bank_number_3 = '';
        $scope.show_otp = false;
        $scope.show_success = false;
        $scope.list_bank_name = [null,
          'กสิกรไทย', 'ไทยพาณิชย์', 'กรุงเทพ', 'กรุงศรีอยุธยา',
          'กรุงไทย', 'เกียรตินาคิน', 'ซีไอเอ็มบี ไทย', 'ทหารไทย',
          'ทิสโก้', 'ธนชาต', 'ยูโอบี', 'แลนด์ แอนด์ เฮ้าส์', 'สแตนดาร์ดชาร์เตอร์ด',
          'เพื่อการเกษตรและสหกรณ์การเกษตร', 'ออมสิน', 'อาคารสงเคราะห์', 'ไทยเครดิต เพื่อรายย่อย'
        ];

        $scope.verify_otp = function(otp){

          var check_otp = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/get-set-bank.php",
            data: {
              username: $stateParams.deposit_username,
              option: 'check_otp',
              otp: $scope.user.otp,
              otp_ref_num: $scope.otp_ref
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          check_otp.success(function(res_data) {
            //console.log(res_data);

            if(res_data.check_otp_status == 'pass'){
              var save_bank = $http({
                method: "post",
                url: WPURLS.templateurl + "/php/get-set-bank.php",
                data: {
                  username: $stateParams.deposit_username,
                  option: 'set',
                  bank_number_2: $scope.user.bank_number_2,
                  bank_number_3: $scope.user.bank_number_3,
                  bank_name_2: $scope.user.bank_name_2,
                  bank_name_3: $scope.user.bank_name_3
                },
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                }
              });
              save_bank.success(function(res_data) {
                //console.log(res_data);
                if(res_data.update_bank == 'success'){
                  $scope.show_success = true;
                  $scope.show_otp = false;
                  $interval(function(){
                    $window.location.href = WPURLS.home_url + '/deposit-withdraw-move';
                  }, 2000, 1);
                }else {
                  $mdDialog.show(
                    $mdDialog.alert()
                      .parent(angular.element(document.querySelector('#otp_div')))
                      .clickOutsideToClose(true)
                      .title('Error')
                      .textContent('บันทึกข้อมูลไม่สำเร็จ')
                      .ariaLabel('Alert Dialog')
                      .ok('OK')
                      //.targetEvent(ev)
                  );
                }
              });
            }else {
              $mdDialog.show(
                $mdDialog.alert()
                  .parent(angular.element(document.querySelector('#otp_div')))
                  .clickOutsideToClose(true)
                  .title('OTP Code Invalid')
                  .textContent('หมายเลข OTP ไม่ถูกต้อง')
                  .ariaLabel('Alert Dialog')
                  .ok('OK')
                  //.targetEvent(ev)
              );
            }
          });


        }

        $scope.bank_save = function(){
          //console.log($scope.user.bank_name_3);
          if($scope.user.bank_name_3 == ''){
            $scope.user.bank_name_3 = null;
          }

          if($scope.user.bank_name_2 == ''){
            $scope.user.bank_name_2 = null;
          }
          if(($scope.user.bank_number_3 == '') && ($scope.user.bank_name_3 == null)){
            $scope.form_error = false;
            //console.log(1);
          }else if (($scope.user.bank_number_3 == '' || typeof $scope.user.bank_number_3 == "undefined") && ($scope.user.bank_name_3 == null)) {
            $scope.form_error = true;
            //console.log(2);
          }else if (($scope.user.bank_number_3 == '' || typeof $scope.user.bank_number_3 == "undefined") && ($scope.user.bank_name_3 != null)) {
            $scope.form_error = true;
            //console.log(3);
          }else if ($scope.user.bank_number_3 != '' && ($scope.user.bank_name_3 != null)) {
            $scope.form_error = false;
            //console.log(4);
          }else if ($scope.user.bank_number_3 != '' && ($scope.user.bank_name_3 == null)) {
            $scope.form_error = true;
            //console.log(5);
          }

          if(($scope.user.bank_number_2 == '') && ($scope.user.bank_name_2 == null)){
            $scope.form_error2 = false;
          }else if (($scope.user.bank_number_2 == '' || typeof $scope.user.bank_number_2 == "undefined") && ($scope.user.bank_name_2 == null)) {
            $scope.form_error2 = true;
          }else if (($scope.user.bank_number_2 == '' || typeof $scope.user.bank_number_2 == "undefined") && ($scope.user.bank_name_2 != null )) {
            $scope.form_error2 = true;
          }else if ($scope.user.bank_number_2 != '' && ($scope.user.bank_name_2 != null)) {
            $scope.form_error2 = false;
          }else if ($scope.user.bank_number_2 != '' && ($scope.user.bank_name_2 == null)) {
            $scope.form_error2 = true;
          }

          if($scope.form_error2 == false && $scope.form_error == false){
            $scope.form_error3 = true;
            var gen_otp = $http({
              method: "post",
              url: WPURLS.templateurl + "/php/get-set-bank.php",
              data: {
                username: $stateParams.deposit_username,
                option: 'gen_otp',
                tel: $scope.tel
              },
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              }
            });
            gen_otp.success(function(res_data) {
              //console.log(res_data);
              $scope.form_error3 = false;
              if(res_data.otp_ref != 'error'){
                $scope.show_otp = true;
                $scope.show_ok = false;
                $scope.otp_ref = res_data.otp_ref;
              }

            });
          }
        }

        var get_bank = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/get-set-bank.php",
          data: {
            username: $stateParams.deposit_username,
            option: 'get'
          },
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        get_bank.success(function(res_data) {
          //console.log(res_data);

          $scope.tel = res_data[0].member_telephone_1;

          $scope.user.bank_number = res_data[0].member_bank_account;
          $scope.user.account_name = res_data[0].member_nickname;
          $scope.user.bank_name = res_data[0].member_bank_name;

          $scope.user.bank_number_2 = res_data[0].member_bank_account_2;
          $scope.user.account_name_2 = res_data[0].member_nickname;
          $scope.user.bank_name_2 = res_data[0].member_bank_name_2;

          $scope.user.bank_number_3 = res_data[0].member_bank_account_3;
          $scope.user.account_name_3 = res_data[0].member_nickname;
          $scope.user.bank_name_3 = res_data[0].member_bank_name_3;

          if($scope.user.bank_number_2 == null){
            $scope.user.bank_number_2 = '';
          }
          if($scope.user.bank_number_3 == null){
            $scope.user.bank_number_3 = '';
          }
        });

      }
    })
    .state('step3_deposit_man', {
      url: '/step3_deposit_man',
      abstract: false,
      params: {
        deposit_username: null,
        bank_number: null,
        bank_name: null,
        bank_number_2: null,
        bank_name_2: null,
        bank_number_3: null,
        bank_name_3: null,
        user_priority: null,
        direct_access: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step3_deposit_man.html',
      controller: function($scope, $state, $stateParams, $http, $filter, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.user = {};
        $scope.invalid_number = true;
        $scope.showLoading = false;

        $scope.set_account_to_deposit = function(ev){
          $scope.invalid_number = true;
          $scope.showLoading = true;
          var set_account_req = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/deposit-man-set-account.php",
            data: {
              username: $stateParams.deposit_username,
              deposit_amount: $scope.user.credit_money,
              bank_number: $stateParams.bank_number,
              bank_name: $stateParams.bank_name,
              bank_number_2: $stateParams.bank_number_2,
              bank_name_2: $stateParams.bank_name_2,
              bank_number_3: $stateParams.bank_number_3,
              bank_name_3: $stateParams.bank_name_3,
              bonus_type: $scope.user.bonus_type,
              user_priority: $stateParams.user_priority,
              notify_transfer_url: 'http://goo.gl/1KpPqn' //WPURLS.home_url + '/user_inform_transfer'
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          set_account_req.success(function(res_data) {
            //console.log(res_data);
            if(res_data.set_status == 'success'){
              var params = {
                'deposit_username': $stateParams.deposit_username,
                'amount': res_data.amount,
                'bank_number': res_data.bank_number,
                'bank_name': res_data.bank_name,
                'direct_access': false
              };
              $state.go("step4_deposit_man", params);

            }else {
              $mdDialog.show(
                $mdDialog.alert()
                  .parent(angular.element(document.querySelector('#form_section')))
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

        $scope.cal_credit_money = function(credit_money,e){

          var credit_money = parseInt(credit_money);
          $scope.user.credit_money = Math.floor(credit_money);
          ////console.log($scope.user.credit_money);
          if($scope.user.credit_money == 0){
            $scope.user.credit_money = '';
          }else if ($scope.user.credit_money < 5000 && $scope.user.bonus_type == 'get_10_per') {
            $scope.user.bonus_type = 'no_bonus';
          }
          if($scope.user.bonus_type == 'get_200_per'){
            $scope.user.credit_result = credit_money * 2;
            //console.log('a');
          //  console.log($scope.user.credit_result);
            if(credit_money >= 1500){
            //  console.log('b');
              //console.log($scope.user.credit_result);
              $scope.user.credit_result = credit_money + 1500;
              $scope.user.credit_result = Math.floor($scope.user.credit_result);
            }else{
              console.log($scope.user.credit_result);
              //$scope.user.credit_result = $scope.user.credit_result + credit_money;
              $scope.user.credit_result = Math.floor($scope.user.credit_result);
            }
          }else if ($scope.user.bonus_type == 'get_10_per') {
            if(credit_money >= 10000){
              $scope.user.credit_result =  credit_money + (credit_money * 10 / 100);
              $scope.user.credit_result = Math.floor($scope.user.credit_result);
            } else if(credit_money >= 5000){
              $scope.user.credit_result =  credit_money + (credit_money * 5 / 100);
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

          }else {
            $scope.invalid_number = false;
          }
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
          ////console.log(res_data);
          if(res_data.account_is_deposited == '0'){
            $scope.big_bonun_text = 'ขอแสดงความยินดีคุณได้รับโบนัส 100% จากยอดเงินฝากครั้งแรก';
            $scope.small_bonun_text = 'ต้องการรับโบนัสหรือไม่ ? (หากรับคุณจะต้องมียอด Turnover เกิน 8 เท่าก่อนจึงจะถอนเงินได้ หากถอนก่อนจะถูกยึดโบนัสคืน)';
            $scope.bonus_option_1 = 'รับโบนัส (สูงสุดไม่เกิน 100% จากยอดเงินฝาก สูงสุดไม่เกิน 1500 บาท)';
            $scope.bonus_option_2 = 'ไม่รับโบนัสนี้ (ไม่ต้องการติดเงื่อนไข Turnover สามารถถอนได้ตลอดเวลา)';
            $scope.option_1_value = 'get_200_per'
            $scope.option_2_value = 'no_bonus'
            $scope.user.bonus_type = 'get_200_per';
          }else{
            $scope.big_bonun_text = 'คุณได้รับโบนัส 10% จากยอดเงินฝาก กรณีฝากเกิน 10,000 บาทขึ้นไป หรือหากฝาก 5,000-9,999 บาทจะได้รับโบนัส 5%';
            $scope.small_bonun_text = 'ต้องการรับโบนัสหรือไม่ ? (หากรับคุณจะต้องมียอด Turnover เกิน 5 เท่าก่อนจึงจะถอนเงินได้ หากถอนก่อนจะถูกยึดโบนัสคืน)';
            $scope.bonus_option_1 = 'รับโบนัส (เฉพาะยอดเงินฝากเกิน 10,000 หรือ 5,000 บาทเท่านั้น)';
            $scope.bonus_option_2 = 'ไม่รับโบนัสนี้ (ไม่ต้องการติดเงื่อนไข Turnover สามารถถอนได้ตลอดเวลา)';
            $scope.option_1_value = 'get_10_per'
            $scope.option_2_value = 'no_bonus'
            $scope.user.bonus_type = 'get_10_per';
          }

        });

      }
    })
    .state('step4_deposit_man', {
      url: '/step4_deposit_man',
      abstract: false,
      params: {
        deposit_username: null,
        amount: null,
        bank_number: null,
        bank_name: null,
        direct_access: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/step4_deposit_man.html',
      controller: function($scope, $state, $stateParams, $http, $filter, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }
        $location.hash('form_section');
        $anchorScroll();
        $scope.img_r = WPURLS.templateurl + '/images/d-amount.gif';
        $scope.notify_transfer = 'http://goo.gl/1KpPqn'; //WPURLS.home_url + '/user_inform_transfer';
        $scope.template_directory_uri = WPURLS.templateurl;
        $scope.amount = $stateParams.amount;
        $scope.bank_number = $stateParams.bank_number;
        $scope.bank_name = $stateParams.bank_name;

        var get_bank_owner = $http({
          method: "post",
          url: WPURLS.templateurl + "/php/deposit-man-get-bank-owner.php",
          data: {
            bank_number: $stateParams.bank_number,
          },
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        get_bank_owner.success(function(res_data) {
          console.log(res_data);
          $scope.bank_owner = res_data.bank_owner;
        });

      }
    })
    .state('additional_step_for_cc_pp', {
      url: '/additional_step_for_cc_pp',
      abstract: false,
      params: {
        deposit_username: null,
        auto_type_option: null,
        deposit_telephone: null,
        user_priority: null,
        direct_access: null
      },
      templateUrl: WPURLS.templateurl + '/sub_page/additional_step_for_cc_pp.html',
      controller: function($scope, $state, $stateParams, $http, $mdDialog, $anchorScroll, $location) {
        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("step1");
          return;
        }

        $scope.direct_access = false;
        $location.hash('form_section');
        $anchorScroll();
        $scope.user = {};
        $scope.user.papay_country = 'Thailand';
        $scope.user.paypal_account = '';
        $scope.user.paypal_verified = '';
        $scope.user.paypal_own = '';
        $scope.user.accept = false;
        $scope.user.credit_bank = '';
        $scope.user.credit_type = '';
        $scope.user.credit_payback = '';
        $scope.user.credit_own = '';
        $scope.ok_disabled = false;
        $scope.country = {
          "countries": [
            {
              "code": "+7 840",
              "name": "Abkhazia"
            },
            {
              "code": "+93",
              "name": "Afghanistan"
            },
            {
              "code": "+355",
              "name": "Albania"
            },
            {
              "code": "+213",
              "name": "Algeria"
            },
            {
              "code": "+1 684",
              "name": "American Samoa"
            },
            {
              "code": "+376",
              "name": "Andorra"
            },
            {
              "code": "+244",
              "name": "Angola"
            },
            {
              "code": "+1 264",
              "name": "Anguilla"
            },
            {
              "code": "+1 268",
              "name": "Antigua and Barbuda"
            },
            {
              "code": "+54",
              "name": "Argentina"
            },
            {
              "code": "+374",
              "name": "Armenia"
            },
            {
              "code": "+297",
              "name": "Aruba"
            },
            {
              "code": "+247",
              "name": "Ascension"
            },
            {
              "code": "+61",
              "name": "Australia"
            },
            {
              "code": "+672",
              "name": "Australian External Territories"
            },
            {
              "code": "+43",
              "name": "Austria"
            },
            {
              "code": "+994",
              "name": "Azerbaijan"
            },
            {
              "code": "+1 242",
              "name": "Bahamas"
            },
            {
              "code": "+973",
              "name": "Bahrain"
            },
            {
              "code": "+880",
              "name": "Bangladesh"
            },
            {
              "code": "+1 246",
              "name": "Barbados"
            },
            {
              "code": "+1 268",
              "name": "Barbuda"
            },
            {
              "code": "+375",
              "name": "Belarus"
            },
            {
              "code": "+32",
              "name": "Belgium"
            },
            {
              "code": "+501",
              "name": "Belize"
            },
            {
              "code": "+229",
              "name": "Benin"
            },
            {
              "code": "+1 441",
              "name": "Bermuda"
            },
            {
              "code": "+975",
              "name": "Bhutan"
            },
            {
              "code": "+591",
              "name": "Bolivia"
            },
            {
              "code": "+387",
              "name": "Bosnia and Herzegovina"
            },
            {
              "code": "+267",
              "name": "Botswana"
            },
            {
              "code": "+55",
              "name": "Brazil"
            },
            {
              "code": "+246",
              "name": "British Indian Ocean Territory"
            },
            {
              "code": "+1 284",
              "name": "British Virgin Islands"
            },
            {
              "code": "+673",
              "name": "Brunei"
            },
            {
              "code": "+359",
              "name": "Bulgaria"
            },
            {
              "code": "+226",
              "name": "Burkina Faso"
            },
            {
              "code": "+257",
              "name": "Burundi"
            },
            {
              "code": "+855",
              "name": "Cambodia"
            },
            {
              "code": "+237",
              "name": "Cameroon"
            },
            {
              "code": "+1",
              "name": "Canada"
            },
            {
              "code": "+238",
              "name": "Cape Verde"
            },
            {
              "code": "+ 345",
              "name": "Cayman Islands"
            },
            {
              "code": "+236",
              "name": "Central African Republic"
            },
            {
              "code": "+235",
              "name": "Chad"
            },
            {
              "code": "+56",
              "name": "Chile"
            },
            {
              "code": "+86",
              "name": "China"
            },
            {
              "code": "+61",
              "name": "Christmas Island"
            },
            {
              "code": "+61",
              "name": "Cocos-Keeling Islands"
            },
            {
              "code": "+57",
              "name": "Colombia"
            },
            {
              "code": "+269",
              "name": "Comoros"
            },
            {
              "code": "+242",
              "name": "Congo"
            },
            {
              "code": "+243",
              "name": "Congo, Dem. Rep. of (Zaire)"
            },
            {
              "code": "+682",
              "name": "Cook Islands"
            },
            {
              "code": "+506",
              "name": "Costa Rica"
            },
            {
              "code": "+385",
              "name": "Croatia"
            },
            {
              "code": "+53",
              "name": "Cuba"
            },
            {
              "code": "+599",
              "name": "Curacao"
            },
            {
              "code": "+537",
              "name": "Cyprus"
            },
            {
              "code": "+420",
              "name": "Czech Republic"
            },
            {
              "code": "+45",
              "name": "Denmark"
            },
            {
              "code": "+246",
              "name": "Diego Garcia"
            },
            {
              "code": "+253",
              "name": "Djibouti"
            },
            {
              "code": "+1 767",
              "name": "Dominica"
            },
            {
              "code": "+1 809",
              "name": "Dominican Republic"
            },
            {
              "code": "+670",
              "name": "East Timor"
            },
            {
              "code": "+56",
              "name": "Easter Island"
            },
            {
              "code": "+593",
              "name": "Ecuador"
            },
            {
              "code": "+20",
              "name": "Egypt"
            },
            {
              "code": "+503",
              "name": "El Salvador"
            },
            {
              "code": "+240",
              "name": "Equatorial Guinea"
            },
            {
              "code": "+291",
              "name": "Eritrea"
            },
            {
              "code": "+372",
              "name": "Estonia"
            },
            {
              "code": "+251",
              "name": "Ethiopia"
            },
            {
              "code": "+500",
              "name": "Falkland Islands"
            },
            {
              "code": "+298",
              "name": "Faroe Islands"
            },
            {
              "code": "+679",
              "name": "Fiji"
            },
            {
              "code": "+358",
              "name": "Finland"
            },
            {
              "code": "+33",
              "name": "France"
            },
            {
              "code": "+596",
              "name": "French Antilles"
            },
            {
              "code": "+594",
              "name": "French Guiana"
            },
            {
              "code": "+689",
              "name": "French Polynesia"
            },
            {
              "code": "+241",
              "name": "Gabon"
            },
            {
              "code": "+220",
              "name": "Gambia"
            },
            {
              "code": "+995",
              "name": "Georgia"
            },
            {
              "code": "+49",
              "name": "Germany"
            },
            {
              "code": "+233",
              "name": "Ghana"
            },
            {
              "code": "+350",
              "name": "Gibraltar"
            },
            {
              "code": "+30",
              "name": "Greece"
            },
            {
              "code": "+299",
              "name": "Greenland"
            },
            {
              "code": "+1 473",
              "name": "Grenada"
            },
            {
              "code": "+590",
              "name": "Guadeloupe"
            },
            {
              "code": "+1 671",
              "name": "Guam"
            },
            {
              "code": "+502",
              "name": "Guatemala"
            },
            {
              "code": "+224",
              "name": "Guinea"
            },
            {
              "code": "+245",
              "name": "Guinea-Bissau"
            },
            {
              "code": "+595",
              "name": "Guyana"
            },
            {
              "code": "+509",
              "name": "Haiti"
            },
            {
              "code": "+504",
              "name": "Honduras"
            },
            {
              "code": "+852",
              "name": "Hong Kong SAR China"
            },
            {
              "code": "+36",
              "name": "Hungary"
            },
            {
              "code": "+354",
              "name": "Iceland"
            },
            {
              "code": "+91",
              "name": "India"
            },
            {
              "code": "+62",
              "name": "Indonesia"
            },
            {
              "code": "+98",
              "name": "Iran"
            },
            {
              "code": "+964",
              "name": "Iraq"
            },
            {
              "code": "+353",
              "name": "Ireland"
            },
            {
              "code": "+972",
              "name": "Israel"
            },
            {
              "code": "+39",
              "name": "Italy"
            },
            {
              "code": "+225",
              "name": "Ivory Coast"
            },
            {
              "code": "+1 876",
              "name": "Jamaica"
            },
            {
              "code": "+81",
              "name": "Japan"
            },
            {
              "code": "+962",
              "name": "Jordan"
            },
            {
              "code": "+7 7",
              "name": "Kazakhstan"
            },
            {
              "code": "+254",
              "name": "Kenya"
            },
            {
              "code": "+686",
              "name": "Kiribati"
            },
            {
              "code": "+965",
              "name": "Kuwait"
            },
            {
              "code": "+996",
              "name": "Kyrgyzstan"
            },
            {
              "code": "+856",
              "name": "Laos"
            },
            {
              "code": "+371",
              "name": "Latvia"
            },
            {
              "code": "+961",
              "name": "Lebanon"
            },
            {
              "code": "+266",
              "name": "Lesotho"
            },
            {
              "code": "+231",
              "name": "Liberia"
            },
            {
              "code": "+218",
              "name": "Libya"
            },
            {
              "code": "+423",
              "name": "Liechtenstein"
            },
            {
              "code": "+370",
              "name": "Lithuania"
            },
            {
              "code": "+352",
              "name": "Luxembourg"
            },
            {
              "code": "+853",
              "name": "Macau SAR China"
            },
            {
              "code": "+389",
              "name": "Macedonia"
            },
            {
              "code": "+261",
              "name": "Madagascar"
            },
            {
              "code": "+265",
              "name": "Malawi"
            },
            {
              "code": "+60",
              "name": "Malaysia"
            },
            {
              "code": "+960",
              "name": "Maldives"
            },
            {
              "code": "+223",
              "name": "Mali"
            },
            {
              "code": "+356",
              "name": "Malta"
            },
            {
              "code": "+692",
              "name": "Marshall Islands"
            },
            {
              "code": "+596",
              "name": "Martinique"
            },
            {
              "code": "+222",
              "name": "Mauritania"
            },
            {
              "code": "+230",
              "name": "Mauritius"
            },
            {
              "code": "+262",
              "name": "Mayotte"
            },
            {
              "code": "+52",
              "name": "Mexico"
            },
            {
              "code": "+691",
              "name": "Micronesia"
            },
            {
              "code": "+1 808",
              "name": "Midway Island"
            },
            {
              "code": "+373",
              "name": "Moldova"
            },
            {
              "code": "+377",
              "name": "Monaco"
            },
            {
              "code": "+976",
              "name": "Mongolia"
            },
            {
              "code": "+382",
              "name": "Montenegro"
            },
            {
              "code": "+1664",
              "name": "Montserrat"
            },
            {
              "code": "+212",
              "name": "Morocco"
            },
            {
              "code": "+95",
              "name": "Myanmar"
            },
            {
              "code": "+264",
              "name": "Namibia"
            },
            {
              "code": "+674",
              "name": "Nauru"
            },
            {
              "code": "+977",
              "name": "Nepal"
            },
            {
              "code": "+31",
              "name": "Netherlands"
            },
            {
              "code": "+599",
              "name": "Netherlands Antilles"
            },
            {
              "code": "+1 869",
              "name": "Nevis"
            },
            {
              "code": "+687",
              "name": "New Caledonia"
            },
            {
              "code": "+64",
              "name": "New Zealand"
            },
            {
              "code": "+505",
              "name": "Nicaragua"
            },
            {
              "code": "+227",
              "name": "Niger"
            },
            {
              "code": "+234",
              "name": "Nigeria"
            },
            {
              "code": "+683",
              "name": "Niue"
            },
            {
              "code": "+672",
              "name": "Norfolk Island"
            },
            {
              "code": "+850",
              "name": "North Korea"
            },
            {
              "code": "+1 670",
              "name": "Northern Mariana Islands"
            },
            {
              "code": "+47",
              "name": "Norway"
            },
            {
              "code": "+968",
              "name": "Oman"
            },
            {
              "code": "+92",
              "name": "Pakistan"
            },
            {
              "code": "+680",
              "name": "Palau"
            },
            {
              "code": "+970",
              "name": "Palestinian Territory"
            },
            {
              "code": "+507",
              "name": "Panama"
            },
            {
              "code": "+675",
              "name": "Papua New Guinea"
            },
            {
              "code": "+595",
              "name": "Paraguay"
            },
            {
              "code": "+51",
              "name": "Peru"
            },
            {
              "code": "+63",
              "name": "Philippines"
            },
            {
              "code": "+48",
              "name": "Poland"
            },
            {
              "code": "+351",
              "name": "Portugal"
            },
            {
              "code": "+1 787",
              "name": "Puerto Rico"
            },
            {
              "code": "+974",
              "name": "Qatar"
            },
            {
              "code": "+262",
              "name": "Reunion"
            },
            {
              "code": "+40",
              "name": "Romania"
            },
            {
              "code": "+7",
              "name": "Russia"
            },
            {
              "code": "+250",
              "name": "Rwanda"
            },
            {
              "code": "+685",
              "name": "Samoa"
            },
            {
              "code": "+378",
              "name": "San Marino"
            },
            {
              "code": "+966",
              "name": "Saudi Arabia"
            },
            {
              "code": "+221",
              "name": "Senegal"
            },
            {
              "code": "+381",
              "name": "Serbia"
            },
            {
              "code": "+248",
              "name": "Seychelles"
            },
            {
              "code": "+232",
              "name": "Sierra Leone"
            },
            {
              "code": "+65",
              "name": "Singapore"
            },
            {
              "code": "+421",
              "name": "Slovakia"
            },
            {
              "code": "+386",
              "name": "Slovenia"
            },
            {
              "code": "+677",
              "name": "Solomon Islands"
            },
            {
              "code": "+27",
              "name": "South Africa"
            },
            {
              "code": "+500",
              "name": "South Georgia and the South Sandwich Islands"
            },
            {
              "code": "+82",
              "name": "South Korea"
            },
            {
              "code": "+34",
              "name": "Spain"
            },
            {
              "code": "+94",
              "name": "Sri Lanka"
            },
            {
              "code": "+249",
              "name": "Sudan"
            },
            {
              "code": "+597",
              "name": "Suriname"
            },
            {
              "code": "+268",
              "name": "Swaziland"
            },
            {
              "code": "+46",
              "name": "Sweden"
            },
            {
              "code": "+41",
              "name": "Switzerland"
            },
            {
              "code": "+963",
              "name": "Syria"
            },
            {
              "code": "+886",
              "name": "Taiwan"
            },
            {
              "code": "+992",
              "name": "Tajikistan"
            },
            {
              "code": "+255",
              "name": "Tanzania"
            },
            {
              "code": "+66",
              "name": "Thailand"
            },
            {
              "code": "+670",
              "name": "Timor Leste"
            },
            {
              "code": "+228",
              "name": "Togo"
            },
            {
              "code": "+690",
              "name": "Tokelau"
            },
            {
              "code": "+676",
              "name": "Tonga"
            },
            {
              "code": "+1 868",
              "name": "Trinidad and Tobago"
            },
            {
              "code": "+216",
              "name": "Tunisia"
            },
            {
              "code": "+90",
              "name": "Turkey"
            },
            {
              "code": "+993",
              "name": "Turkmenistan"
            },
            {
              "code": "+1 649",
              "name": "Turks and Caicos Islands"
            },
            {
              "code": "+688",
              "name": "Tuvalu"
            },
            {
              "code": "+1 340",
              "name": "U.S. Virgin Islands"
            },
            {
              "code": "+256",
              "name": "Uganda"
            },
            {
              "code": "+380",
              "name": "Ukraine"
            },
            {
              "code": "+971",
              "name": "United Arab Emirates"
            },
            {
              "code": "+44",
              "name": "United Kingdom"
            },
            {
              "code": "+1",
              "name": "United States"
            },
            {
              "code": "+598",
              "name": "Uruguay"
            },
            {
              "code": "+998",
              "name": "Uzbekistan"
            },
            {
              "code": "+678",
              "name": "Vanuatu"
            },
            {
              "code": "+58",
              "name": "Venezuela"
            },
            {
              "code": "+84",
              "name": "Vietnam"
            },
            {
              "code": "+1 808",
              "name": "Wake Island"
            },
            {
              "code": "+681",
              "name": "Wallis and Futuna"
            },
            {
              "code": "+967",
              "name": "Yemen"
            },
            {
              "code": "+260",
              "name": "Zambia"
            },
            {
              "code": "+255",
              "name": "Zanzibar"
            },
            {
              "code": "+263",
              "name": "Zimbabwe"
            }
          ]
        };
        $scope.thai_bank = {"bank": [
            {'name': 'กรุงเทพ'},
            {'name': 'กรุงศรีอยุธยา'},
            {'name': 'กสิกรไทย'},
            {'name': 'เกียรตินาคิน'},
            {'name': 'ซีไอเอ็มบีไทย'},
            {'name': 'ทหารไทย'},
            {'name': 'ทิสโก้'},
            {'name': 'ไทยพาณิชย์'},
            {'name': 'ธนชาต'},
            {'name': 'ยูโอบี'},
            {'name': 'กรุงไทย'},
            {'name': 'ออมสิน'},
            {'name': 'อาคารสงเคราะห์'},
            {'name': 'อิสลามแห่งประเทศไทย'}
          ]
        };
        $scope.isPaypal = false;
        $scope.isPaypal = false;
        if($stateParams.auto_type_option == '46'){
          $scope.isCredit = true;
        }else if ($stateParams.auto_type_option == '48') {
          $scope.isPaypal = true;
        }
        $scope.nextStepPaypal = function(event){

          if($scope.user.paypal_account == ''){
            form_alert('กรุณากรอกบัญชี PayPal ของคุณ',event);
            return;
          }else if(validateEmail($scope.user.paypal_account) == false){
            form_alert('Email ไม่ถูกต้อง',event);
            return;
          }
          if($scope.user.paypal_verified == '' || $scope.user.paypal_own == ''){
            form_alert('กรุณาเลือกสถานะ PayPal ของคุณ',event);
            return;
          }
          if($scope.user.accept == false){
            form_alert('กรุณาเลือกการยอมรับเงื่อนไข',event);
            return;
          }

          $scope.ok_disabled = true;
          var set_paypal_info = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/set_paypal_info.php",
            data: {
              username: $stateParams.deposit_username,
              paypal_account: $scope.user.paypal_account,
              paypal_verified: $scope.user.paypal_verified,
              paypal_country: $scope.user.papay_country,
              paypal_own: $scope.user.paypal_own,
              paypal_accpet: $scope.user.accept
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          set_paypal_info.success(function(res_data) {
            console.log(res_data);
            if(res_data.set_status == 'success'){
              var params = {
                'deposit_username': $stateParams.deposit_username,
                'auto_type_option': $stateParams.auto_type_option,
                'deposit_telephone': $stateParams.deposit_telephone,
                'user_priority': $stateParams.user_priority,
                'direct_access': false
              };
              $state.go("step3_deposit_auto", params);
            }else {
              $scope.ok_disabled = false;
              $mdDialog.show(
                $mdDialog.alert()
                  .clickOutsideToClose(true)
                  .title('Error')
                  .textContent('บันทึกข้อมูลไม่สำเร็จ')
                  .ariaLabel('Alert Dialog')
                  .ok('OK')
                  .targetEvent(event)
              );
            }
          });

        }

        $scope.nextStepCredit = function(){
          console.log('sssss');
          if($scope.user.credit_bank == ''){
            form_alert('กรุณาเลือกธนาคารของคุณ',event);
            return;
          }
          if($scope.user.credit_type == ''){
            form_alert('กรุณาเลือกประเภทบัตรของคุณ',event);
            return;
          }
          if($scope.user.credit_payback == ''){
            form_alert('กรุณาเลือกประวัติการขอเงินคืนจากธนาคาร',event);
            return;
          }
          if($scope.user.credit_own == ''){
            form_alert('กรุณาเลือกสถานะเจ้าของบัตรเครดิต',event);
            return;
          }
          if($scope.user.accept == false){
            form_alert('กรุณาเลือกการยอมรับเงื่อนไข',event);
            return;
          }

          $scope.ok_disabled = true;
          var set_credit_info = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/set_credit_info.php",
            data: {
              username: $stateParams.deposit_username,
              creditcards_bank: $scope.user.credit_bank,
              creditcards_type: $scope.user.credit_type,
              creditcards_stolen: $scope.user.credit_payback,
              creditcards_own: $scope.user.credit_own,
              creditcards_accpet: $scope.user.accept
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          set_credit_info.success(function(res_data) {
            if(res_data.set_status == 'success'){
              var params = {
                'deposit_username': $stateParams.deposit_username,
                'auto_type_option': $stateParams.auto_type_option,
                'deposit_telephone': $stateParams.deposit_telephone,
                'user_priority': $stateParams.user_priority,
                'direct_access': false
              };
              $state.go("step3_deposit_auto", params);
            }else {
              $scope.ok_disabled = false;
              $mdDialog.show(
                $mdDialog.alert()
                  .clickOutsideToClose(true)
                  .title('Error')
                  .textContent('บันทึกข้อมูลไม่สำเร็จ')
                  .ariaLabel('Alert Dialog')
                  .ok('OK')
                  .targetEvent(event)
              );
            }
          });
        }

        function validateEmail(email) {
          var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
        }

        function form_alert(text,event){
          $mdDialog.show(
            $mdDialog.alert()
              //.parent(angular.element(document.querySelector('#form_section')))
              .clickOutsideToClose(true)
              .title('ข้อมูลไม่ครบ')
              .textContent(text)
              .ariaLabel('Alert Dialog')
              .ok('OK')
              .targetEvent(event)
          );
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
