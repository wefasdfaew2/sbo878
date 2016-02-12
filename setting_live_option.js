app.config(function($mdThemingProvider) {
  $mdThemingProvider.theme('default')
    .primaryPalette('blue', {
      // by default use shade 400 from the pink palette for primary intentions
      'hue-1': '50', // use shade 100 for the <code>md-hue-1</code> class
      'hue-2': '600', // use shade 600 for the <code>md-hue-2</code> class
      'hue-3': 'A100' // use shade A100 for the <code>md-hue-3</code> class
    })
    .accentPalette('green');
});
app.controller('ChannelCtrl', function($scope, $http) {
  ///////////////
  //$scope.lang = language;


  var request = $http({
    method: "get",
    url: "../php/get-lang.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  request.success(function(lang) {
    $scope.lang = lang.lang;
    //alert($scope.lang);
  });

  var request = $http({
    method: "get",
    url: "../php/get-match_category.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  request.success(function(live_stream_url) {
    $scope.json_live_stream_url = live_stream_url;
    $scope.load = 1;
  });

  $scope.live_stream_list = function(live_stream_category) {
    $scope.load = 0;
    var request = $http({
      method: "get",
      url: "../php/get-match_category_list.php?l_cat_name=" + live_stream_category,
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request.success(function(live_stream_category) {
      $scope.json_live_stream_list = live_stream_category;
      if ($scope.json_live_stream_list[0].stream_live == "no_match") {
        $scope.json_live_stream_list = "";
        $scope.load = 1;
      } else {
        $scope.json_live_stream_list = live_stream_category;
        $scope.load = 1;
      }
    });
  };
  /////////////////


  $scope.load = 0;
  var request = $http({
    method: "get",
    url: "../php/get-match_live.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  request.success(function(live_match) {
    $scope.json_live_match = live_match;
    $scope.load = 1;
  });

  $scope.match_list = function(league_name) {
    $scope.load = 0;
    var request = $http({
      method: "get",
      url: "../php/get-live-match_league_name.php?l_name=" + league_name,
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request.success(function(league_name) {
      $scope.json_match_list = league_name;

      if ($scope.json_match_list[0].sbolive_url == "no_match") {
        $scope.json_match_list = "";
	 
        $scope.load = 1;
      } else {
        $scope.json_match_list = league_name;
        $scope.load = 1;
      }
	   
    });
//////////////
    var request = $http({
      method: "get",
      url: "../php/get-team_name_th.php?l_name=" + league_name,
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request.success(function(team_name) {
      $scope.team_th = team_name;
     console.log($scope.team_th);

    });
 
  
  };

  var request = $http({
    method: "get",
    url: "../php/get-match_live_ads.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  request.success(function(live_match_ads) {
    $scope.json_live_match_ads = live_match_ads;
    $scope.load = 1;
  });

  $scope.mySplit = function(string, nb) {

    var array = string.split('+');

    return array[nb];


  }
 
  
    //แล้วก็เอา {{showLink.xx}} ไปใส่ในฝั่ง html

  $scope.selected = [];
  $scope.toggle = function(item, list) {
    var idx = list.indexOf(item);
    if (idx > -1) {
      list.splice(idx, 1);
    } else {
      list.push(item);
    }
  };
  $scope.exists = function(item, list) {
    return list.indexOf(item) > -1;
  };


});
