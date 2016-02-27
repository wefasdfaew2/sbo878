var app = angular.module('MySuggestFriend', ['ngMaterial', 'ngMessages']);



app.controller('SuggestFriend', function($scope, $sce, $http, $window) {

  $scope.wordpress_login = function(username, password){

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
      console.log(login_call_data);
      if(login_call_data == 'success'){
        $window.location.reload();
      }else {
        alert('invalid username or password');
      }

    });

  }

});
