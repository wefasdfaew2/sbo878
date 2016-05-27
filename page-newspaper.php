<?php
/*
Template Name: newspaper
*/
?>
<?php get_header();?>

<?php

 wp_register_script('ui-bootstrap', get_template_directory_uri() . '/js/ui-bootstrap-tpls-1.1.2.min.js', true);
 wp_enqueue_script('ui-bootstrap');

  wp_register_script('angular-ui-router', get_template_directory_uri() . '/js/angular-ui-router.min.js', true);
  wp_enqueue_script('angular-ui-router');

  wp_register_script('angular-lightbox', get_template_directory_uri() . '/js/angular-bootstrap-lightbox.min.js', true);
  wp_enqueue_script('angular-lightbox');

  wp_register_style( 'angular-lightbox-css', get_template_directory_uri() . '/css/angular-bootstrap-lightbox.min.css' );
  wp_enqueue_style( 'angular-lightbox-css' );
?>


<script type="text/javascript">
var app = angular.module('MyNewspaper', ['ngMaterial', 'ngMessages', 'ui.bootstrap', 'bootstrapLightbox', 'ui.router']);

app.config(function($mdThemingProvider, $stateProvider, $urlRouterProvider, LightboxProvider) {

  LightboxProvider.templateUrl = WPURLS.templateurl + '/sub_page/newspaper-modal.html';

  $mdThemingProvider.theme('default')
    .primaryPalette('indigo', {
      // by default use shade 400 from the pink palette for primary intentions
      'hue-1': '50', // use shade 100 for the <code>md-hue-1</code> class
      'hue-2': '100', // use shade 600 for the <code>md-hue-2</code> class
      'hue-3': 'A700' // use shade A100 for the <code>md-hue-3</code> class
    })
    .accentPalette('green');
  //$urlRouterProvider.otherwise("/state1");
  $stateProvider
    .state('newspaper-login', {
      url: '/newspaper-login',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/newspaper-login.html',
      controller: function($scope, $state, Lightbox, $mdDialog, $http) {

        $scope.user = {};
        $scope.user.username = '';
        $scope.user.tel = '';
        $scope.account_status = false;
        $scope.login = function(ev){

          if($scope.user.username == ''){
            $mdDialog.show(
              $mdDialog.alert()
                .parent(angular.element(document.querySelector('#page')))
                .clickOutsideToClose(true)
                .title('ข้อมูลไม่ครบ')
                .textContent('กรุณากรอก Username')
                .ariaLabel('Alert Dialog')
                .ok('OK')
                .targetEvent(ev)
            );
          }else if ($scope.user.tel == '') {
            $mdDialog.show(
              $mdDialog.alert()
                .parent(angular.element(document.querySelector('#page')))
                .clickOutsideToClose(true)
                .title('ข้อมูลไม่ครบ')
                .textContent('กรุณากรอกหมายเลขโทรศัพท์')
                .ariaLabel('Alert Dialog')
                .ok('OK')
                .targetEvent(ev)
            );
          }else {
            var get_login = $http({
              method: "post",
              url: WPURLS.templateurl + "/php/newspaper-check-account.php",
              data: {
                username: $scope.user.username ,
                tel: $scope.user.tel
              },
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              }
            });
            get_login.success(function(res_data) {
              if(res_data.account_status == 'not_pass'){
                $scope.account_status = true;
              }else if (res_data.account_status == 'no_account') {
                $mdDialog.show(
                  $mdDialog.alert()
                    .parent(angular.element(document.querySelector('#page')))
                    .clickOutsideToClose(true)
                    .title('ข้อมูลไม่ถูกต้อง')
                    .textContent('username หรือหมายเลขโทรศัพท์ไม่ถูกต้อง')
                    .ariaLabel('Alert Dialog')
                    .ok('OK')
                    .targetEvent(ev)
                );
              }else if (res_data.account_status == 'pass') {
                var params = {
                  'direct_access': false
                };
                $state.go("newspaper-show", params);
              }

            });
          }

        }

      }
    })
    .state('newspaper-show', {
      url: '/newspaper-show',
      abstract: false,
      params: {
        direct_access: null,
      },
      templateUrl: WPURLS.templateurl + '/sub_page/newspaper-show.html',
      controller: function($scope, $state, Lightbox, $http, $stateParams) {

        if($stateParams.direct_access != false){
          $scope.direct_access = true;
          $state.go("newspaper-login");
          return;
        }

        $scope.openLightboxModal = function (newspaper_name) {
          $scope.images = [];
          var get_image = $http({
            method: "post",
            url: WPURLS.templateurl + "/php/newspaper-get-images.php",
            data: {
              newspaper_name: newspaper_name
            },
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          get_image.success(function(res_data) {

            angular.forEach(res_data, function(value, key) {
              for(var i = 1;i <= value.max_page;i++){
                $scope.images.push({
                  'url': 'https://tded.sbobet878.com/real/' + newspaper_name + '/' + i + '.jpg',
                  'title': '1'
                });
              }
            });
            //console.log($scope.images);
            Lightbox.openModal($scope.images,0);
          });

        };


      }
    })

  });

  app.controller('Newspaper', function($scope, $http, $filter, $state, Lightbox) {

    //console.log("newspaper-login");
    $state.go("newspaper-login");

  });
</script>

 <div id="page" class="single">
   <div class="content">
     <div  style="margin-top:0px;" ng-app="MyNewspaper" ng-controller="Newspaper" ng-cloak="" style="margin-top:10px;">
       <center>
         <h2 class="page-title">
           <div style="width: 80%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">อ่านหนังสือพิมพ์</div>
         </h2>
       </center>
      <div ui-view></div>

     </div>

<?php get_footer(); ?>
