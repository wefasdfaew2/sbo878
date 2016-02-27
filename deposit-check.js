var app = angular.module('MyDepositCheck', ['ngMaterial', 'ngMessages', 'smart-table']);

app.controller('DepositCheck', function($scope, $http, $filter, $interval) {

  function hide_username(username){

    var first = username.substring(0, 1);
    var forhide = username.substring(1, 7);
    var last = username.substring(7);
    var hide_username = first + '------' + last;
    return hide_username;

  }

  var request_deposit_state = $http({
    method: "get",
    url: WPURLS.templateurl + "/php/get-deposit-state.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  request_deposit_state.success(function(deposit_state) {
    $scope.deposit_state = deposit_state;

    for(x in $scope.deposit_state){
      $scope.deposit_state[x].deposit_account = hide_username($scope.deposit_state[x].deposit_account);
    }

  });

  $scope.classja = "nonActive";
  $scope.changeClass = function() {
    if ($scope.classja == "active") {
      console.log('aaaa');
      $scope.classja = "nonActive";
    } else {
      console.log('qqq');
      $scope.classja = "active";
    }
  };

  function createItem(item) {

    return {
      deposit_id: item.deposit_id,
      deposit_account: item.deposit_account,
      deposit_type_name: item.deposit_type_name,
      deposit_regis: item.deposit_regis,
      deposit_note: item.deposit_note,
      deposit_status_id: item.deposit_status_id
    };
  }

  $interval(function() {
    console.log('interval');
    var request_deposit_state = $http({
      method: "get",
      url: WPURLS.templateurl + "/php/get-deposit-state.php",
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request_deposit_state.success(function(deposit_state) {
      $scope.deposit_state = deposit_state;
      for(x in $scope.deposit_state){
        $scope.deposit_state[x].deposit_account = hide_username($scope.deposit_state[x].deposit_account);
      }

    });
  }, 10000);


});

angular.module('MyDepositCheck')
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
  });
