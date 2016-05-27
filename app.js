var app = angular.module('MyApp', ['ngMaterial', 'ngMessages', 'ipCookie', 'ng.deviceDetector', 'ngSanitize']);

app.config(function($mdThemingProvider) {
  $mdThemingProvider.theme('default')
    .primaryPalette('blue', {
      // by default use shade 400 from the pink palette for primary intentions
      'hue-1': '50', // use shade 100 for the <code>md-hue-1</code> class
      'hue-2': '100', // use shade 600 for the <code>md-hue-2</code> class
      'hue-3': 'A700' // use shade A100 for the <code>md-hue-3</code> class
    })
    .accentPalette('green');

    //scrollableTabsetConfigProvider.setShowTooltips (false);

});

app.controller('Player', function($scope, $sce, $http, ipCookie, $filter, $compile, $mdDialog, $window, deviceDetector) {

  $scope.deviceDetector = deviceDetector.os;
  $scope.siteurl = WPURLS.templateurl;
  $scope.youtube_id = false;
  $scope.youtube_display = 'none';
  $scope.from_promote_link = false;
  $scope.fastTabs = '';

  var internet_isp;
  $scope.get_internet_isp = function(isp){
    internet_isp = isp;
  }

  $scope.gen_token = function(userIP) {

      var full_ts = $filter('date')(Date.now(), 'yyyy-MM-dd HH:mm:ss', '+0700');
      var ts = full_ts.split(" ").join("");
      ts = ts.split("-").join("");
      ts = ts.split(":").join("");

      var ip = userIP.split(".").join("");
      $scope.random_string = (Math.random() + 1).toString(36).substring(2);
      var user_md5 = 'guest' + md5('guest' + ip + ts);
      $scope.token = md5($scope.random_string);

      /*//console.log(full_ts);
      //console.log(ts);
      //console.log('guest' + ip + ts);
      //console.log(user_md5);
      //console.log($scope.random_string);
      //console.log($scope.token);*/

      var data = {};
      data.user = user_md5;
      data.timestamp = full_ts;
      data.ip = userIP;
      data.token = $scope.token;
      ////console.log(data);
      $http.post(WPURLS.templateurl + "/php/insert-user-token.php", data)
        .success(function(result) {
          ////console.log('result = ' + result);
        });
    }
    //player();
    //function player(player_link, channel_title) {
    ////console.log(channel_title);
  $scope.channel_id = null;
  //WPURLS.templateurl + "/images/
  //if(deviceDetector.os == 'android'){
  //  var playerTag = angular.element(document.querySelector('#playerKXSDPIwKERSva'));
  //  playerTag.html('<a>');
  //}
  if (deviceDetector.os != 'ios' && deviceDetector.os != 'android' && $scope.youtube_id == false) {

    var play_stream = jwplayer('playerKXSDPIwKERSva').setup({
      androidhls: true,
      stretching: "exactfit",
      rtmp: {
        bufferlength: 3
      },
      file: "https://youtu.be/kbJGfZguoOw", //www.youtube.com/v/ylLzyHk54Z0
      title: "SBOBET878.COM PLAYER",
      fallback: true,
      width: "848",
      height: "480",
      autostart: "false",
      aspectratio: "16:9",
    });
  } else {

  }
  //  }
  $scope.promote_play = function(id, server, bitrate, mode) {
      //console.log("id = " + id + server);
      //console.log(bitrate);
      //console.log(mode);


      if (server == 'no-promote') {
        return;
      }
      if(internet_isp == 'dtac' || internet_isp == 'ais'){
        server = '99';
      }
      $scope.from_promote_link = true;
      $scope.youtube_display = 'none';
      if (mode == 'flash') {
        mode = 'rtmp';
      } else {
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

        var channel_name = $filter('filter')($scope.channel_data, {id: id})[0].channel_name;
        var app_stream = $filter('filter')($scope.channel_data, {id: id})[0].app_stream;
        var simname = $filter('filter')($scope.channel_data, {id: id})[0].simname;
        var tem_youtube_id = $filter('filter')($scope.channel_data, {id: id})[0].youtube_id;
        var add_dotstream = $filter('filter')($scope.channel_data, {id: id})[0].add_dotstream;
        if(add_dotstream == 'Yes'){
          add_dotstream = '.stream';
        }else {
          add_dotstream = '';
        }
        $scope.channel_title_html = 'ดูบอลฟรีช่อง ' + channel_name;

        if (tem_youtube_id != null && tem_youtube_id != '') {
          tem_youtube_id = 'http://www.youtube.com/embed/' + tem_youtube_id;
          $scope.youtube_id = true;
          $scope.jwplayer_display = 'none';
          $scope.youtube_display = 'none';
          if (deviceDetector.os == 'android'){
            $scope.ios_android_display = 'none';
            $scope.link_promote_player = '<a href="' +  tem_youtube_id + '">' +
            '<img src="' + WPURLS.templateurl + '/images/android-player.jpg"/>' +
            '</a>';
          }else if (deviceDetector.os == 'ios') {
            $scope.ios_android_display = 'none';
            $scope.link_promote_player = '<a href="' +  tem_youtube_id + '">' +
            '<img src="' + WPURLS.templateurl + '/images/Safari-player.jpg.jpg"/>' +
            '</a>';
          }else {
            $scope.ios_android_display = 'block';
            $scope.youtube_display = 'block';
            $scope.youtube_link = $sce.trustAsResourceUrl(tem_youtube_id);
          }
          return;

        } else {
          $scope.youtube_id = false;
          $scope.jwplayer_display = 'block';
          $scope.youtube_display = 'none';
        }

        if (deviceDetector.os == 'ios' || deviceDetector.os == 'android') {
          mode = 'http';
          $scope.player_protocol = mode;
        }

        if (server == 'auto') {
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

            if (mode == 'rtmp') {
              $scope.link_player = mode + '://' +
                $scope.serverMinLoad[0].server_url.trim() + '/' +
                app_stream.trim() + '/' +
                "?token=" + $scope.random_string + '/' +
                simname.trim() + '_' + bitrate + 'p' + add_dotstream;
            }

            if (mode == 'http') {
              $scope.link_player = mode + '://' +
                $scope.serverMinLoad[0].server_url.trim() + '/' +
                app_stream.trim() + '/' +
                simname.trim() + '_' + bitrate + 'p' + add_dotstream;

              $scope.link_player += "/playlist.m3u8?token=" + $scope.random_string;
            }

            if (deviceDetector.os == 'android') {
              //console.log("promote goto app");
              $scope.link_promote_player = '<a href="' +  $scope.link_player + '">' +
              '<img src="' + WPURLS.templateurl + '/images/android-player.jpg"/>' +
              '</a>';
            } else if (deviceDetector.os == 'ios') {
              $scope.link_promote_player = '<a href="' +  $scope.link_player + '">' +
              '<img src="' + WPURLS.templateurl + '/images/ios-player.jpg"/>' +
              '</a>';
            }else {
              play_stream.load([{
                file: $scope.link_player
              }]).play();
            }
            //console.log($scope.link_player);
          });
        } else {
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

            if (mode == 'rtmp') {
              $scope.link_player = mode + '://' +
                $scope.server_info[0].server_url.trim() + '/' +
                app_stream.trim() + '/' +
                "?token=" + $scope.random_string + '/' +
                simname.trim() + '_' + bitrate + 'p' + add_dotstream;
            }

            if (mode == 'http') {
              $scope.link_player = mode + '://' +
                $scope.server_info[0].server_url.trim() + '/' +
                app_stream.trim() + '/' +
                simname.trim() + '_' + bitrate + 'p' + add_dotstream;

              $scope.link_player += "/playlist.m3u8?token=" + $scope.random_string;
            }

            if (deviceDetector.os == 'android') {
              //console.log("promote goto app");
              $scope.link_promote_player = '<a href="' +  $scope.link_player + '">' +
              '<img src="' + WPURLS.templateurl + '/images/android-player.jpg"/>' +
              '</a>';
            } else if (deviceDetector.os == 'ios') {
              $scope.link_promote_player = '<a href="' +  $scope.link_player + '">' +
              '<img src="' + WPURLS.templateurl + '/images/ios-player.jpg"/>' +
              '</a>';
            }else {
              play_stream.load([{
                file: $scope.link_player
              }]).play();
            }

            //console.log($scope.link_player);
          });
        }
      });


    }
    //WPURLS.templateurl from function.php
/**  var request_channel_cat = $http({
    method: "get",
    url: WPURLS.templateurl + "/php/get-channel-cat.php",
    data: {},
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  });
  request_channel_cat.success(function(channel_cat) {
    $scope.channel_cat = channel_cat;
  });**/

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
    //console.log(typeof($scope.server_list));
    if(internet_isp == 'dtac' || internet_isp == 'ais'){
      $scope.server_list = $filter('filter')($scope.server_list, {
        id: 99
      });
      $scope.serverurl = $scope.server_list[0].server_url;
    }
  });

  $scope.get_channel_list = function(cat_id) {
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
      $scope.channel_list2 = channel_list;
      //console.log( $filter('filter')(channel_list, {category_id: '14'}) );
      //alert(channel_list.ip);
    });
  }


  $scope.get_fast_tabs = function() {
    var request_channel_cat = $http({
      method: "get",
      url: WPURLS.templateurl + "/php/get-channel-cat.php",
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request_channel_cat.success(function(channel_cat) {
      var request_channel_list = $http({
        method: "get",
        url: WPURLS.templateurl + "/php/get-channel-list.php?cat_id=" + '0',
        data: {},
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });
      request_channel_list.success(function(channel_list) {
        ////console.log(channel_list);
          var tabs = '<md-tabs md-swipe-content md-no-ink md-border-bottom md-dynamic-height>';

        angular.forEach(channel_cat, function(value, key) {
          if(value.id == '0' && value.enable == 'true'){
            ////console.log('asdf');
            tabs += '<md-tab label="' + value.cat_name + '">';
            tabs += '<md-content layout="row" layout-wrap layout-align="center center" style="background-color: #ECEFF1;padding-bottom:16px;">';
            tabs += '<div layout="row" layout-wrap layout-align="center center" style="padding-top:5px;padding-bottom:5px;">';
            angular.forEach(channel_list, function(value2, key2) {

                tabs += '<div style="padding:5px;">';
                tabs += '<a ng-click="get_player_link(' + value2.id +')" style="cursor: pointer;">';
                tabs += '<img ng-src="' + WPURLS.templateurl + '/images' + value2.channel_logo_ssl + '" class="md-avatar" class="img-responsive center-block" style="padding-top:10px;" width="117" height="60"/>';
                tabs += '</a>';
                tabs += '</div>';

            });
            tabs += '</div>';
            tabs += '</md-content>';
            tabs += '</md-tab>';
          }
          else if(value.id != '0' && value.id != '10000' && value.enable == 'true'){
            tabs += '<md-tab label="' + value.cat_name + '">';
            tabs += '<md-content layout="row" layout-wrap layout-align="center center" style="background-color: #ECEFF1;padding-bottom:16px;">';
            tabs += '<div layout="row" layout-wrap layout-align="center center" style="padding-top:5px;padding-bottom:5px;">';
            angular.forEach(channel_list, function(value2, key2) {
              if(value2.category_id == value.id){
                tabs += '<div style="padding:5px;">';
                tabs += '<a ng-click="get_player_link(' + value2.id +')" style="cursor: pointer;">';
                tabs += '<img ng-src="' + WPURLS.templateurl + '/images' + value2.channel_logo_ssl + '" class="md-avatar" class="img-responsive center-block" style="padding-top:10px;" width="117" height="60"/>';
                tabs += '</a>';
                tabs += '</div>';
              }
            });
            tabs += '</div>';
            tabs += '</md-content>';
            tabs += '</md-tab>';
          }
        });
        tabs += '</md-tabs>';
        ////console.log(tabs);
        var fastTabs = angular.element(document.querySelector('#fastTabs'));
        var newElement = $compile( tabs )( $scope );
        fastTabs.append( newElement );
      });
    });
  }

  $scope.get_player_link = function(channel_id) {
    ////console.log(channel_id);

    if(internet_isp == 'dtac' || internet_isp == 'ais'){
      //console.log($scope.serverurl);
      $scope.serverurl = $filter('filter')($scope.server_list, {
        id: 99
      })[0].server_url;
      //console.log($scope.serverurl);

    }
    //console.log('get_player_link');
    var request_channel_info = $http({
      method: "get",
      url: WPURLS.templateurl + "/php/get-channel-by-id.php?id=" + channel_id,
      data: {},
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
    request_channel_info.success(function(channel_info) {
      $scope.channel_info = channel_info;

      $scope.channel_id = channel_id;
      var app_stream = $filter('filter')($scope.channel_info, {
        id: channel_id
      })[0].app_stream;
      var simname = $filter('filter')($scope.channel_info, {
        id: channel_id
      })[0].simname;
      var channel_name = $filter('filter')($scope.channel_info, {
        id: channel_id
      })[0].channel_name;
      var tem_youtube_id = $filter('filter')($scope.channel_info, {
        id: channel_id
      })[0].youtube_id;

      var add_dotstream = $filter('filter')($scope.channel_info, {
        id: channel_id
      })[0].add_dotstream;
      if(add_dotstream == 'Yes'){
        add_dotstream = '.stream';
      }else {
        add_dotstream = '';
      }

      var channel_bitrate_720 = $filter('filter')($scope.channel_info, {
        id: channel_id
      })[0]['720p'];
      var channel_bitrate_480 = $filter('filter')($scope.channel_info, {
        id: channel_id
      })[0]['480p'];
      var channel_bitrate_360 = $filter('filter')($scope.channel_info, {
        id: channel_id
      })[0]['360p'];
      var channel_bitrate_3g = $filter('filter')($scope.channel_info, {
        id: channel_id
      })[0]['3g'];

      var bitrate_info = {
        "bitrate_info":[
          {"bname":"channel_bitrate_720", "enable":channel_bitrate_720, bitrate: '720p'},
          {"bname":"channel_bitrate_480",	"enable":channel_bitrate_480, bitrate: '480p'},
          {"bname":"channel_bitrate_360", "enable":channel_bitrate_360, bitrate: '360p'},
          {"bname":"channel_bitrate_3g", "enable":channel_bitrate_3g, bitrate: '3g'}
        ]
      };

      var num_enable = 0;
      angular.forEach(bitrate_info.bitrate_info, function(value, key) {
        if(value.enable == 'true'){
          num_enable += 1;
        }
      });

      if(num_enable == 4){

      }else if (num_enable == 1) {
        var keepGoing = true;
        angular.forEach(bitrate_info.bitrate_info, function(value, key) {
          if(keepGoing){
            if(value.enable == 'true' && $scope.bitrate == value.bitrate){
              keepGoing = false;
            }else if(value.enable == 'true'){
              $scope.bitrate = value.bitrate;
            }
          }
        });
      }else if (num_enable > 1) {
        if(channel_bitrate_720 == 'false' && $scope.bitrate == '720p'){
          $scope.bitrate = '480p';
        }
        if(channel_bitrate_480 == 'false' && $scope.bitrate == '480p'){
          $scope.bitrate = '360p';
        }
        if(channel_bitrate_360 == 'false' && $scope.bitrate == '360p'){
          $scope.bitrate = '3g';
        }
        if(channel_bitrate_3g == 'false' && $scope.bitrate == '3g'){
          var keepGoing = true;
          angular.forEach(bitrate_info.bitrate_info, function(value, key) {
            if(keepGoing){
              if(value.enable == 'true'){
                $scope.bitrate = value.bitrate;
              }
            }
          });
        }
      }else if (num_enable == 0) {
        alert('bitrate not available');
      }

      //console.log($scope.bitrate);
      /**if(channel_bitrate_720 == 'false' && $scope.bitrate == '720p'){
        $scope.bitrate = '480p';
      }
      if(channel_bitrate_480 == 'false' && $scope.bitrate == '480p'){
        $scope.bitrate = '360p';
      }**/




      //var channel_title = angular.element(document.querySelector('#channel_title'));
      //channel_title.text('ดูบอลฟรีช่อง ' + channel_name);
      $scope.channel_title_html = 'ดูบอลฟรีช่อง ' + channel_name;

      ////console.log(tem_youtube_id);
      if (tem_youtube_id != null && tem_youtube_id != '') {

        tem_youtube_id = 'http://www.youtube.com/embed/' + tem_youtube_id;
        $scope.youtube_id = true;
        $scope.jwplayer_display = 'none';
        if (deviceDetector.os == 'ios' || deviceDetector.os == 'android'){
          $window.location.href = tem_youtube_id;
        }else {
          $scope.youtube_link = $sce.trustAsResourceUrl(tem_youtube_id);
        }
        $scope.youtube_display = 'block';
        $scope.ios_android_display = 'none';
        return;

      } else {
        $scope.youtube_id = false;
        $scope.jwplayer_display = 'block';
        $scope.youtube_display = 'none';
        $scope.ios_android_display = 'block';

      }

      if (deviceDetector.os == 'ios' || deviceDetector.os == 'android') {
        $scope.player_protocol = 'http';
      }
      if ($scope.serverurl == 'auto') {

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

          if ($scope.player_protocol.trim() == 'rtmp') {
            $scope.link_player = $scope.player_protocol.trim() + '://' +
              $scope.serverMinLoad[0].server_url.trim() + '/' +
              app_stream.trim() + '/' +
              "?token=" + $scope.random_string + '/' +
              simname.trim() + '_' + $scope.bitrate.trim() + add_dotstream;
          }

          if ($scope.player_protocol.trim() == 'http') {
            $scope.link_player = $scope.player_protocol.trim() + '://' +
              $scope.serverMinLoad[0].server_url.trim() + '/' +
              app_stream.trim() + '/' +
              simname.trim() + '_' + $scope.bitrate.trim() + add_dotstream;

            $scope.link_player += "/playlist.m3u8?token=" + $scope.random_string;
          }

          if (deviceDetector.os == 'ios' || deviceDetector.os == 'android') {
            //console.log("goto app");
            $window.location.href = $scope.link_player;
          } else {
            play_stream.load([{
              file: $scope.link_player
            }]).play();
          }

          //console.log($scope.link_player);
        });
      } else {

        if ($scope.player_protocol.trim() == 'rtmp') {
          $scope.link_player = $scope.player_protocol.trim() + '://' +
            $scope.serverurl.trim() + '/' +
            app_stream + '/' +
            "?token=" + $scope.random_string + '/' +
            simname + '_' + $scope.bitrate.trim() + add_dotstream;
        }


        if ($scope.player_protocol.trim() == 'http') {
          $scope.link_player = $scope.player_protocol.trim() + '://' +
            $scope.serverurl.trim() + '/' +
            app_stream + '/' +
            simname + '_' + $scope.bitrate.trim() + add_dotstream;
          $scope.link_player += "/playlist.m3u8?token=" + $scope.random_string;
        }
        //console.log($scope.link_player);

        if (deviceDetector.os == 'ios' || deviceDetector.os == 'android') {
          //console.log("goto app");
          $window.location.href = $scope.link_player;
        } else {
          play_stream.load([{
            file: $scope.link_player
          }]).play();
        }

        //player($scope.link_player, channel_name);

      }
    });

  }

  $scope.set_cookies = function(cookies_id, cookies_value) {
    ipCookie(cookies_id, cookies_value);

    ////console.log($scope.channel_id);
    if ($scope.channel_id != null) {
      if (deviceDetector.os == 'ios' || deviceDetector.os == 'android') {

      } else {
        $scope.get_player_link($scope.channel_id);
      }
    }

  }
  $scope.get_cookies = function(cookies_id, cookies_value) {
    $scope.serverurl = ipCookie('serverurl');
    $scope.bitrate = ipCookie('bitrate');
    $scope.player_protocol = ipCookie('player_protocol');
  }

  function set_default_option() {
    $scope.serverurl = 'auto';
    $scope.bitrate = '360p';
    $scope.player_protocol = 'rtmp';
    ipCookie('serverurl', 'auto');
    ipCookie('bitrate', '360p');
    ipCookie('player_protocol', 'rtmp');
  }

  if (angular.isUndefined(ipCookie('serverurl')) && angular.isUndefined(ipCookie('bitrate')) && angular.isUndefined(ipCookie('player_protocol'))) {
    set_default_option();
  } else {
    $scope.get_cookies();
  }


});
