var app = angular.module('MyWithdrawCheck', ['ngMaterial', 'ngMessages', 'smart-table']);

app.controller('WithdrawCheck', function($scope, $http, $filter, $interval) {

  function hide_bank_number(bank_number){
    var twofont = bank_number.substring(0, 2);
    var threelast = bank_number.substring(bank_number.length-3);
    var hide_bank_number = twofont + 'xxxxx' + threelast;
    return hide_bank_number;
  }

  function hide_username(username){

    var first = username.substring(0, 1);
    var forhide = username.substring(1, 7);
    var last = username.substring(7);
    var hide_username = first + '------' + last;
    return hide_username;

  }
  var request_withdraw_state = $http({
    method: "get",
    url: WPURLS.templateurl + "/php/get-withdraw-state.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  request_withdraw_state.success(function(withdraw_state) {
    $scope.withdraw_state = withdraw_state;

    for(x in $scope.withdraw_state){
      $scope.withdraw_state[x].withdraw_bank_account = hide_bank_number($scope.withdraw_state[x].withdraw_bank_account);
      $scope.withdraw_state[x].withdraw_account = hide_username($scope.withdraw_state[x].withdraw_account);
    }

  });



  $interval(function() {
    console.log('interval');
    var request_withdraw_state = $http({
      method: "get",
      url: WPURLS.templateurl + "/php/get-withdraw-state.php",
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request_withdraw_state.success(function(withdraw_state) {
      $scope.withdraw_state = withdraw_state;
      for(x in $scope.withdraw_state){
        $scope.withdraw_state[x].withdraw_bank_account = hide_bank_number($scope.withdraw_state[x].withdraw_bank_account);
        $scope.withdraw_state[x].withdraw_account = hide_username($scope.withdraw_state[x].withdraw_account);
      }
    });
  }, 10000);


});

/**angular.module('MyDepositCheck')
  .directive('pageSelect', function() {
    return {
      restrict: 'E',
      template: '<input type="text" class="select-page" ng-model="inputPage" ng-change="selectPage(inputPage)">',
      link: function(scope, element, attrs) {
        scope.$watch('currentPage', function(c) {
          scope.inputPage = c;
        });
      }
    }
  });**/
