<?php
/*
Template Name: ais-mpay-manual
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

  //wp_register_style( 'fancybox', get_template_directory_uri() . '/css/jquery.fancybox-1.3.4.css' );
  //wp_enqueue_style( 'fancybox' );
  wp_register_style( 'angular-lightbox-css', get_template_directory_uri() . '/css/angular-bootstrap-lightbox.min.css' );
  wp_enqueue_style( 'angular-lightbox-css' );
?>


<script type="text/javascript">
var app = angular.module('MyHowToPlay', ['ngMaterial', 'ngMessages', 'ui.bootstrap', 'bootstrapLightbox', 'ui.router']);


app.config(function($mdThemingProvider, $stateProvider, $urlRouterProvider) {

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
    .state('mpay-regis', {
      url: '/mpay-regis',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/how-to-play-desktop.html',
      controller: function($scope, $state, Lightbox, $anchorScroll, $location) {
        //$scope.img_link = WPURLS.templateurl;
        $location.hash('form_section');
        $anchorScroll();

        $scope.openLightboxModal = function (index) {
          Lightbox.openModal($scope.images, index);
        };

        $scope.images = [
          {
            'url': WPURLS.templateurl + '/images/mpay-regis-1.jpg',
            'title': '1. เข้าสู่เว็บไซต์'
          },
          {
            'url': WPURLS.templateurl + '/images/mpay-regis-2.jpg',
            'title': '2. กรอกข้อมูล'
          },
          {
            'url': WPURLS.templateurl + '/images/mpay-regis-3.jpg',
            'title': '3. กรอกรหัส OTP'
          },
          {
            'url': WPURLS.templateurl + '/images/mpay-regis-4.jpg',
            'title': '4. คลิกเริ่มต้นใช้งาน'
          },
          {
            'url': WPURLS.templateurl + '/images/mpay-regis-5.jpg',
            'title': '5. เริ่มต้นใช้งาน'
          }
        ];

      }
    })
    .state('add-money-1', {
      url: '/add-money-1',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/how-to-play-desktop.html',
      controller: function($scope, $state, Lightbox, $anchorScroll, $location) {
        //$scope.img_link = WPURLS.templateurl;
        $location.hash('form_section');
        $anchorScroll();

        $scope.openLightboxModal = function (index) {
          Lightbox.openModal($scope.images, index);
        };

        $scope.images = [
          {
            'url': WPURLS.templateurl + '/images/mpay-add-1.jpg',
            'title': 'วิธีเติมเงินผ่าน ATM ธนาคาร กสิกรไทยและกรุงเทพ'
          }
        ];

      }
    })
    .state('add-money-2', {
      url: '/add-money-2',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/how-to-play-desktop.html',
      controller: function($scope, $state, Lightbox, $anchorScroll, $location) {

        //$scope.img_link = WPURLS.templateurl;
        $location.hash('form_section');
        $anchorScroll();

        $scope.openLightboxModal = function (index) {
          Lightbox.openModal($scope.images, index);
        };

        $scope.images = [
          {
            'url': WPURLS.templateurl + '/images/mpay-add-2.jpg',
            'title': 'วิธีเติมเงินผ่าน ATM ธนาคารกรุงศรีและไทยพาณิชย์'
          }
        ];

      }
    })
    .state('add-money-3', {
      url: '/add-money-3',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/how-to-play-desktop.html',
      controller: function($scope, $state, Lightbox, $anchorScroll, $location) {

        $location.hash('form_section');
        $anchorScroll();

        $scope.openLightboxModal = function (index) {
          Lightbox.openModal($scope.images, index);
        };

        $scope.images = [
          {
            'url': WPURLS.templateurl + '/images/mpay-add-3.jpg',
            'title': 'วิธีเติมเงินผ่าน ATM ธนาคาร UOB และ ทหารไทย'
          }
        ];

      }
    })
  });


  app.run(['$anchorScroll', function($anchorScroll) {
      $anchorScroll.yOffset = 100;   // always scroll by 50 extra pixels
    }]);

  app.controller('HowToPlay', function($scope, $http, $filter, $state, Lightbox) {

    //console.log("How to play !!!");


  });
</script>
 <div id="page" class="single">
   <div class="content">
     <div  style="margin-top:0px;" ng-app="MyHowToPlay" ng-controller="HowToPlay" ng-cloak="" style="margin-top:10px;">
       <center>
         <h2 class="page-title">
           <div style="text-transform: none;width: 80%;margin: 0 auto;padding: 0.25em 0.625em;font-size:25px;">คู่มือ วิธีสมัครสมาชิกและเติมเงินของ AIS mPAY</div>
         </h2>
         <br>
         <div layout="row" layout-align="center center" layout-wrap>

           <a ui-sref="mpay-regis">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีสมัครสมาชิก</md-button>
           </a>

           <a ui-sref="add-money-1">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน ATM ธนาคาร กสิกรไทยและกรุงเทพ</md-button>
           </a>

           <a ui-sref="add-money-2">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน ATM ธนาคารกรุงศรีและไทยพาณิชย์</md-button>
           </a>

           <a ui-sref="add-money-3">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน ATM ธนาคาร UOB และ ทหารไทย</md-button>
           </a>

         </div>
         <br>
         <br>
       </center>

      <div ui-view></div>

     </div>

<?php get_footer(); ?>
