var app = angular.module('MyWithdrawCheck', ['ngMaterial', 'ngMessages', 'smart-table']);

app.controller('WithdrawCheck', ['Resource', '$interval', function (service, $interval) {

  var ctrl = this;
  var externaelTableState;
  this.displayed = [];

  this.callServer = function callServer(tableState) {
    externaelTableState = tableState;

    ctrl.isLoading = true;

    var pagination = tableState.pagination;
    //console.log(Math.floor(tableState.pagination.start / tableState.pagination.number) + 1);
    var start = pagination.start || 0;     // This is NOT the page number, but the index of item in the list that you want to use to display the table.
    var number = pagination.number || 10;  // Number of entries showed per page.

    service.getPage(start, number, tableState).then(function (result) {

      ctrl.displayed = result.data;
      tableState.pagination.numberOfPages = result.numberOfPages;//set the number of pages so the pagination can update
      ctrl.isLoading = false;
    });
  };

  $interval(function() {
    console.log('callServer');
    //ctrl.isLoading = true;
    var tableState = externaelTableState;
    var pagination = tableState.pagination;
    //console.log(Math.floor(tableState.pagination.start / tableState.pagination.number) + 1);
    var start = pagination.start || 0;     // This is NOT the page number, but the index of item in the list that you want to use to display the table.
    var number = pagination.number || 10;  // Number of entries showed per page.

    service.getPage(start, number, tableState).then(function (result) {

      ctrl.displayed = result.data;
      tableState.pagination.numberOfPages = result.numberOfPages;//set the number of pages so the pagination can update
      ctrl.isLoading = false;
    });
  }, 10000);

}]);

app.factory('Resource', ['$http', '$q', '$filter', '$timeout', function ($http, $q, $filter, $timeout) {

	//this would be the service to call your server, a standard bridge between your model an $http

	// the database (normally on your server)
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

  var randomsItems = [];



	//fake call to the server, normally this service would serialize table state to send it to the server (with query parameters for example) and parse the response
	//in our case, it actually performs the logic which would happened in the server
	function getPage(start, number, params) {

		var deferred = $q.defer();

    var request_deposit_state = $http({
      method: "get",
      url: WPURLS.templateurl + "/php/get-withdraw-state.php",
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request_deposit_state.success(function(withdraw_state) {

      randomsItems = withdraw_state;

      for(x in randomsItems){
        randomsItems[x].withdraw_bank_account = hide_bank_number(randomsItems[x].withdraw_bank_account);
        //randomsItems[x].withdraw_account = hide_username(randomsItems[x].withdraw_account);
        randomsItems[x].hide_withdraw_account = hide_username(randomsItems[x].withdraw_account);
      }

      var filtered = params.search.predicateObject ? $filter('filter')(randomsItems, params.search.predicateObject) : randomsItems;

  		if (params.sort.predicate) {
  			filtered = $filter('orderBy')(filtered, params.sort.predicate, params.sort.reverse);
  		}

  		var result = filtered.slice(start, start + number);

  		$timeout(function () {
  			//note, the server passes the information about the data set size
  			deferred.resolve({
  				data: result,
  				numberOfPages: Math.ceil(filtered.length / number)
  			});
  		}, 1500);

    });




		return deferred.promise;
	}

	return {
		getPage: getPage
	};

}]);
/**var app = angular.module('MyWithdrawCheck', ['ngMaterial', 'ngMessages', 'smart-table']);

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
**/
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
