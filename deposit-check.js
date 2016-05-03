var app = angular.module('MyDepositCheck', ['ngMaterial', 'ngMessages', 'smart-table']);

app.filter('dayFilter', function() {
    return function(input, last_number_day) {
        var filterFunction = function (item) {
          var d = new Date();
          d.setDate(d.getDate()-last_number_day);
          var timestamp = new Date(item.deposit_regis);
          return timestamp >= d;
        };
    	return input.filter(filterFunction);
    };
});

app.controller('DepositCheck', ['Resource', '$interval', '$filter', function (service, $interval, $filter) {
  //console.log(WPURLS.current_pageurl);
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
    //console.log('callServer');
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
      url: WPURLS.templateurl + "/php/get-deposit-state.php",
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request_deposit_state.success(function(deposit_state) {
      //console.log(deposit_state);
      randomsItems = deposit_state;

      for(x in randomsItems){
        if(randomsItems[x].deposit_type_name == null){
          randomsItems[x].deposit_type_name = '/images/WaitTransfer.gif';
        }
        //randomsItems[x].deposit_account = hide_username(randomsItems[x].deposit_account);
        randomsItems[x].hide_deposit_account = hide_username(randomsItems[x].deposit_account);
      }

      var randomsItems2 = randomsItems;

      randomsItems = $filter('dayFilter')(randomsItems, 3);

      //var filtered = params.search.predicateObject ? $filter('filter')(randomsItems2, params.search.predicateObject) : randomsItems;

      //console.log(params.search.predicateObject);
      var filtered;
      if(angular.isUndefined(params.search.predicateObject)){
        params.search.predicateObject = {};
      }
      //console.log(Object.keys(params.search.predicateObject).length);
      if(Object.keys(params.search.predicateObject).length != 0){
        filtered = $filter('filter')(randomsItems2, params.search.predicateObject);
      }else {
        filtered = randomsItems;

      }

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
/**app.controller('DepositCheck', function($scope, $http, $filter, $interval) {

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
**/
