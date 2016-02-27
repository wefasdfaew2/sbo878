var app = angular.module('MyDepositWithdrawMove', ['ngMaterial', 'ngMessages', 'ui.router']);

app.controller('DepositWithdrawMove', function($scope, $http, $filter, $state) {

  console.log("state.go");
  $state.go("state1");


});

app.config(function($mdThemingProvider, $stateProvider, $urlRouterProvider) {

  $urlRouterProvider.otherwise("/state1");

  $stateProvider
    .state('state1', {
      url: '/state1',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/withdraw_state_1.html',
      controller: function($scope, $state) {
        console.log('Im in.');
      }
    })
});
