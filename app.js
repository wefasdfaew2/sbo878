var app = angular.module('MyApp', ['ngMaterial', 'ngMessages', 'ipCookie']);

app.config(function($mdThemingProvider) {
  $mdThemingProvider.theme('default')
    .primaryPalette('blue', {
      // by default use shade 400 from the pink palette for primary intentions
      'hue-1': '50', // use shade 100 for the <code>md-hue-1</code> class
      'hue-2': '100', // use shade 600 for the <code>md-hue-2</code> class
      'hue-3': 'A700' // use shade A100 for the <code>md-hue-3</code> class
    })
    .accentPalette('green');
});

app.controller('Player', function($scope, $http, ipCookie, $filter) {

  $scope.gen_token = function(userIP) {

    var full_ts = $filter('date')(Date.now() , 'yyyy-MM-dd HH:mm:ss', '+0700');
    var ts = full_ts.split(" ").join("");
    ts = ts.split("-").join("");
    ts = ts.split(":").join("");

    var ip = userIP.split(".").join("");
    $scope.random_string = (Math.random() + 1).toString(36).substring(2);
    var user_md5 = 'guest' + md5('guest' + ip + ts);
    $scope.token = md5($scope.random_string);

    /*console.log(full_ts);
    console.log(ts);
    console.log('guest' + ip + ts);
    console.log(user_md5);
    console.log($scope.random_string);
    console.log($scope.token);*/

    var data = {};
    data.user = user_md5;
    data.timestamp = full_ts;
    data.ip = userIP;
    data.token = $scope.token;
    //console.log(data);
    $http.post(WPURLS.templateurl + "/php/insert-user-token.php", data)
      .success(function(result) {
        console.log('result = ' + result);
      });
  }
  //player();
  //function player(player_link, channel_title) {
    //console.log(channel_title);
    $scope.channel_id = null;
    var play_stream = jwplayer('playerKXSDPIwKERSva').setup({
      androidhls: true,
      stretching: "exactfit",
      rtmp: {
        bufferlength: 3
      },
      file: "http://www.youtube.com/v/01jm8k478ew",//www.youtube.com/v/ylLzyHk54Z0
      title: "",
      fallback: true,
      width: "950",
      height: "534",
      autostart: false,
      aspectratio: "16:9",

    });
//  }
  $scope.promote_play = function(id, server, bitrate, mode) {
    //console.log("id = " + id + server);
    //console.log(bitrate);
    //console.log(mode);

    if(server == 'no-promote'){
      return;
    }
    if(mode == 'flash'){
      mode = 'rtmp';
    }else{
      mode = 'http';
    }
    $scope.channel_id = id;
    $scope.bitrate = bitrate + 'p';
    $scope.player_protocol = mode;

    var channel_info = $http({
      method: "get",
      url: WPURLS.templateurl + "/php/get-channel-by-id.php?id=" + id,
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    channel_info.success(function(channel_data) {
      $scope.channel_data = channel_data;

      var app_stream = $filter('filter')($scope.channel_data, {id: id})[0].app_stream;
      var simname = $filter('filter')($scope.channel_data, {id: id})[0].simname;

      if(server == 'auto'){
        $scope.serverurl = 'auto';
        var server_min_load = $http({
          method: "get",
          url: WPURLS.templateurl + "/php/get-server-min-load.php",
          data: {},
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        server_min_load.success(function(serverMinLoad) {
          $scope.serverMinLoad = serverMinLoad;

          if(mode == 'rtmp'){
            $scope.link_player = mode + '://' +
                                  $scope.serverMinLoad[0].server_url.trim() + '/' +
                                  app_stream.trim() + '/' +
                                  "?token=" + $scope.random_string + '/' +
                                  simname.trim() + '_' + bitrate + 'p';
          }

          if(mode == 'http'){
            $scope.link_player = mode + '://' +
                                  $scope.serverMinLoad[0].server_url.trim() + '/' +
                                  app_stream.trim() + '/' +
                                  simname.trim() + '_' + bitrate + 'p';

            $scope.link_player += "/playlist.m3u8?token=" + $scope.random_string ;
          }

          play_stream.load([{file:$scope.link_player}]).play();
          console.log($scope.link_player);
        });
      }else{
        var server_from_id = $http({
          method: "get",
          url: WPURLS.templateurl + "/php/get-server-by-id.php?id=" + server,
          data: {},
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        server_from_id.success(function(server_info) {
          $scope.server_info = server_info;
          $scope.serverurl = $scope.server_info[0].server_url;

          if(mode == 'rtmp'){
            $scope.link_player = mode + '://' +
                                  $scope.server_info[0].server_url.trim() + '/' +
                                  app_stream.trim() + '/' +
                                  "?token=" + $scope.random_string + '/' +
                                  simname.trim() + '_' + bitrate + 'p';
          }

          if(mode == 'http'){
            $scope.link_player = mode + '://' +
                                  $scope.server_info[0].server_url.trim() + '/' +
                                  app_stream.trim() + '/' +
                                  simname.trim() + '_' + bitrate + 'p';

            $scope.link_player += "/playlist.m3u8?token=" + $scope.random_string ;
          }
          play_stream.load([{file:$scope.link_player}]).play();
          console.log($scope.link_player);
        });
      }
    });


  }
  //WPURLS.templateurl from function.php
  var request_channel_cat = $http({
    method: "get",
    url: WPURLS.templateurl + "/php/get-channel-cat.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  request_channel_cat.success(function(channel_cat) {
    $scope.channel_cat = channel_cat;
  });

  var request_server_list = $http({
    method: "get",
    url: WPURLS.templateurl + "/php/get-server-list.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  request_server_list.success(function(server_list) {
    $scope.server_list = server_list;
  });

  $scope.get_channel_list = function(cat_id, userIP) {
    //var myEl = angular.element(document.querySelector('#content-channel'));
    //myEl.empty();
    var request_channel_list = $http({
      method: "get",
      url: WPURLS.templateurl + "/php/get-channel-list.php?cat_id=" + cat_id,
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request_channel_list.success(function(channel_list) {
      $scope.channel_list = channel_list;
      //alert(channel_list.ip);
    });
  }

  $scope.get_player_link = function(channel_id) {

    $scope.channel_id = channel_id;
    var app_stream = $filter('filter')($scope.channel_list, {id: channel_id})[0].app_stream;
    var simname = $filter('filter')($scope.channel_list, {id: channel_id})[0].simname;
    var channel_name = $filter('filter')($scope.channel_list, {id: channel_id})[0].channel_name;

    if($scope.serverurl == 'auto'){

      var server_min_load = $http({
        method: "get",
        url: WPURLS.templateurl + "/php/get-server-min-load.php",
        data: {},
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });
      server_min_load.success(function(serverMinLoad) {
        $scope.serverMinLoad = serverMinLoad;

        if($scope.player_protocol.trim() == 'rtmp'){
          $scope.link_player = $scope.player_protocol.trim() + '://' +
                                $scope.serverMinLoad[0].server_url.trim() + '/' +
                                app_stream.trim() + '/' +
                                "?token=" + $scope.random_string + '/' +
                                simname.trim() + '_' + $scope.bitrate.trim();
        }

        if($scope.player_protocol.trim() == 'http'){
          $scope.link_player = $scope.player_protocol.trim() + '://' +
                                $scope.serverMinLoad[0].server_url.trim() + '/' +
                                app_stream.trim() + '/' +
                                simname.trim() + '_' + $scope.bitrate.trim();

          $scope.link_player += "/playlist.m3u8?token=" + $scope.random_string ;
        }

        play_stream.load([{file:$scope.link_player}]).play();
        console.log($scope.link_player);
      });
    }else{

      if($scope.player_protocol.trim() == 'rtmp'){
        $scope.link_player = $scope.player_protocol.trim() + '://' +
                              $scope.serverurl.trim() + '/' +
                              app_stream + '/' +
                              "?token=" + $scope.random_string + '/' +
                              simname + '_' + $scope.bitrate.trim();
      }


      if($scope.player_protocol.trim() == 'http'){
        $scope.link_player = $scope.player_protocol.trim() + '://' +
                              $scope.serverurl.trim() + '/' +
                              app_stream + '/' +
                              simname + '_' + $scope.bitrate.trim();
          $scope.link_player += "/playlist.m3u8?token=" + $scope.random_string;
      }
      console.log($scope.link_player);
      play_stream.load([{file:$scope.link_player}]).play();;

      //player($scope.link_player, channel_name);

    }


    /**var get_app_stream = $http({
      method: "get",
      url: WPURLS.templateurl + "/php/get-channel-app-stream.php",
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    get_app_stream.success(function(app_stream) {
      $scope.app_stream = app_stream;
    });**/


  }

  $scope.set_cookies = function(cookies_id, cookies_value) {
    ipCookie(cookies_id, cookies_value);

    //console.log($scope.channel_id);
    if($scope.channel_id != null){
      $scope.get_player_link($scope.channel_id);
    }

  }
  $scope.get_cookies = function(cookies_id, cookies_value) {
    $scope.serverurl = ipCookie('serverurl');
    $scope.bitrate = ipCookie('bitrate');
    $scope.player_protocol = ipCookie('player_protocol');
  }
  function set_default_option(){
    $scope.serverurl = 'auto';
    $scope.bitrate = '360p';
    $scope.player_protocol = 'rtmp';
    ipCookie('serverurl', 'auto');
    ipCookie('bitrate', '360p');
    ipCookie('player_protocol', 'rtmp');
  }

  if(angular.isUndefined(ipCookie('serverurl')) && angular.isUndefined(ipCookie('bitrate')) && angular.isUndefined(ipCookie('player_protocol'))){
    set_default_option();
  }else {
    $scope.get_cookies();
  }


});
