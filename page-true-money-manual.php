<?php
/*
Template Name: true-money-manual
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
    .state('truemoney-regis', {
      url: '/truemoney-regis',
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
            'url': WPURLS.templateurl + '/images/truemoney-regis-1.jpg',
            'title': '1. เข้าสู่เว็บไซต์'
          },
          {
            'url': WPURLS.templateurl + '/images/truemoney-regis-2.jpg',
            'title': '2. กรอกข้อมูล'
          },
          {
            'url': WPURLS.templateurl + '/images/truemoney-regis-3.jpg',
            'title': '3. กรอกข้อมูล'
          },
          {
            'url': WPURLS.templateurl + '/images/truemoney-regis-4.jpg',
            'title': '4. กรอกรหัส OTP'
          },
          {
            'url': WPURLS.templateurl + '/images/truemoney-regis-5.jpg',
            'title': '5. เสร็จสิ้น'
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
            'url': WPURLS.templateurl + '/images/truemoney-add-1.jpg',
            'title': 'วิธีเติมเงินผ่าน 7/11 และ Familymart'
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
            'url': WPURLS.templateurl + '/images/truemoney-add-2.jpg',
            'title': 'วิธีเติมเงินผ่าน ATM ธนาคารกรุงเทพ'
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
            'url': WPURLS.templateurl + '/images/truemoney-add-3.jpg',
            'title': 'วิธีเติมเงินผ่าน ATM และ Online ธนาคารกรุงศรี'
          }
        ];

      }
    })
    .state('add-money-4', {
      url: '/add-money-4',
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
            'url': WPURLS.templateurl + '/images/truemoney-add-4.jpg',
            'title': 'วิธีเติมเงินผ่าน ATM ธนาคารกสิกรไทยและทหารไทย'
          }
        ];

      }
    })
    .state('add-money-5', {
      url: '/add-money-5',
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
            'url': WPURLS.templateurl + '/images/truemoney-add-5.jpg',
            'title': 'วิธีเติมเงินผ่าน ATM และ Online ธนาคารกรุงไทย'
          }
        ];

      }
    })
    .state('add-money-6', {
      url: '/add-money-6',
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
            'url': WPURLS.templateurl + '/images/truemoney-add-6.jpg',
            'title': 'วิธีเติมเงินผ่าน ATM และ Online ธนาคารไทยพาณิชย์'
          }
        ];

      }
    })
    .state('add-money-7', {
      url: '/add-money-7',
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
            'url': WPURLS.templateurl + '/images/truemoney-add-7.jpg',
            'title': 'วิธีเติมเงินผ่าน Tops market และ True Shop'
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
           <div style="text-transform: none;width: 80%;margin: 0 auto;padding: 0.25em 0.625em;font-size:25px;">คู่มือ วิธีสมัครสมาชิก และเติมเงินของ TrueMoney Wallet</div>
         </h2>
         <br>
         <div layout="row" layout-align="center center" layout-wrap>

           <a ui-sref="truemoney-regis">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีสมัครสมาชิก</md-button>
           </a>

           <a ui-sref="add-money-1">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน 7/11 และ Familymart</md-button>
           </a>

           <a ui-sref="add-money-2">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน ATM ธนาคารกรุงเทพ</md-button>
           </a>

           <a ui-sref="add-money-3">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน ATM และ Online ธนาคารกรุงศรี</md-button>
           </a>

           <a ui-sref="add-money-4">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน ATM ธนาคารกสิกรไทยและทหารไทย</md-button>
           </a>

           <a ui-sref="add-money-5">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน ATM และ Online ธนาคารกรุงไทย</md-button>
           </a>

           <a ui-sref="add-money-6">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน ATM และ Online ธนาคารไทยพาณิชย์</md-button>
           </a>

           <a ui-sref="add-money-7">
             <md-button style="width:350px;" md-no-ink="true" flex="nogrow" class="md-raised md-primary">วิธีเติมเงินผ่าน Tops market และ True Shop</md-button>
           </a>
         </div>
         <br>
         <br>
       </center>

      <div ui-view></div>

     </div>

     <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
     <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
     <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.pack.min.js"></script>
     <script type="text/javascript">
         $(function($){
             var addToAll = false;
             var gallery = true;
             var titlePosition = 'inside';
             $(addToAll ? 'img' : 'img.fancybox').each(function(){
                 var $this = $(this);
                 var title = $this.attr('title');
                 var src = $this.attr('data-big') || $this.attr('src');
                 var a = $('<a href="#" class="fancybox"></a>').attr('href', src).attr('title', title);
                 $this.wrap(a);
             });
             if (gallery)
                 $('a.fancybox').attr('rel', 'fancyboxgallery');
             $('a.fancybox').fancybox({
                 titlePosition: titlePosition
             });
         });
         $.noConflict();
     </script>-->
<?php get_footer(); ?>
