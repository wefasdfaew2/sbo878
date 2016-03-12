<?php
/*
Template Name: how-to-play
*/
?>
<?php get_header();?>

<?php

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
var app = angular.module('MyHowToPlay', ['ngMaterial', 'ngMessages', 'ui.router', 'ngSanitize', 'bootstrapLightbox']);

app.controller('HowToPlay', function($scope, $http, $filter, $state, Lightbox) {

  console.log("How to play !!!");


});


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
    .state('desktop', {
      url: '/desktop',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/how-to-play-desktop.html',
      controller: function($scope, $state, Lightbox) {
        //$scope.img_link = WPURLS.templateurl;

        $scope.openLightboxModal = function (index) {
          Lightbox.openModal($scope.images, index);
        };

        $scope.images = [
          {
            'url': WPURLS.templateurl + '/images/Login-Page-(1).jpg',
            'title': '1. หน้าล็อกอินเข้าแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/Main-Page-(2).jpg',
            'title': '2. อธิบายหน้าหลักแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/Favorite-Page-(3).jpg',
            'title': '3. หน้ารายการโปรด'
          },
          {
            'url': WPURLS.templateurl + '/images/Sports-Menu-(4).jpg',
            'title': '4. อธิบายเมนูเลือกรูปแบบแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/Betting-Page-(5).jpg',
            'title': '5. อธิบายหน้าแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/Betting-Ex1-(6).jpg',
            'title': '6. การแทงบอลเดี่ยวตัวอย่างที่ 1'
          },
          {
            'url': WPURLS.templateurl + '/images/Betting-Ex2-(7).jpg',
            'title': '7. การแทงบอลเดี่ยวตัวอย่างที่ 2'
          },
          {
            'url': WPURLS.templateurl + '/images/Line-Patt-Page-(8).jpg',
            'title': '8. รูปแบบการแสดงผลหน้าแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/Live-Bet1-(9).jpg',
            'title': '9. อธิบายการแทงบอลสด'
          },
          {
            'url': WPURLS.templateurl + '/images/Live-Bet2-(10).jpg',
            'title': '10. อธิบายการแทงบอลสด'
          },
          {
            'url': WPURLS.templateurl + '/images/Live-Bet3-(11).jpg',
            'title': '11. อธิบายการแทงบอลสด'
          },
          {
            'url': WPURLS.templateurl + '/images/Betting-Parlay-(12).jpg',
            'title': '12. ตัวอย่างการแทงบอล Step'
          }
        ];

      }
    })
    .state('desktop-en', {
      url: '/desktop-en',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/how-to-play-desktop.html',
      controller: function($scope, $state, Lightbox) {
        //$scope.img_link = WPURLS.templateurl;

        $scope.openLightboxModal = function (index) {
          Lightbox.openModal($scope.images, index);
        };

        $scope.images = [
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(1).jpg',
            'title': '1. หน้าล็อกอินเข้าแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(2).jpg',
            'title': '2. อธิบายหน้าหลักแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(3).jpg',
            'title': '3. หน้ารายการโปรด'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(4).jpg',
            'title': '4. อธิบายเมนูเลือกรูปแบบแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(5).jpg',
            'title': '5. อธิบายหน้าแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(6).jpg',
            'title': '6. การแทงบอลเดี่ยวตัวอย่างที่ 1'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(7).jpg',
            'title': '7. การแทงบอลเดี่ยวตัวอย่างที่ 2'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(8).jpg',
            'title': '8. รูปแบบการแสดงผลหน้าแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(9).jpg',
            'title': '9. อธิบายการแทงบอลสด'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(10).jpg',
            'title': '10. อธิบายการแทงบอลสด'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(11).jpg',
            'title': '11. อธิบายการแทงบอลสด'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-pc-en(12).jpg',
            'title': '12. ตัวอย่างการแทงบอล Step'
          }
        ];

      }
    })
    .state('mobile', {
      url: '/mobile',
      abstract: false,
      templateUrl: WPURLS.templateurl + '/sub_page/how-to-play-mobile.html',
      controller: function($scope, $state, Lightbox) {

        //$scope.img_link = WPURLS.templateurl;
        $scope.openLightboxModal = function (index) {
          Lightbox.openModal($scope.images, index);
        };

        $scope.images = [
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(1).jpg',
            'title': '1. หน้าแรก SBOBET เลือกแทงบอลผ่านมือถือ'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(2).jpg',
            'title': '2. หน้าล็อกอินเข้าแทงบอล'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(3).jpg',
            'title': '3. หน้าแทงบอลหลังจากล็อกอินเข้ามา'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(4).jpg',
            'title': '4. หน้าหมวดหมู่กีฬา'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(5).jpg',
            'title': '5. หน้าแทงบอล หมวดหมู่แทงบอลวันนี้'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(6).jpg',
            'title': '6. หน้าเลือกเล่นลีกต่างๆ'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(7).jpg',
            'title': '7. หน้าตัวอย่างการแทงบอลเดี่ยว'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(8).jpg',
            'title': '8. หน้าใส่จำนวนเงินที่ต้องการแทงบอลเดี่ยว'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(9).jpg',
            'title': '9. หน้ายืนยันการพนันบอลเดี่ยว'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(10).jpg',
            'title': '10. หน้าพนันบอลเดี่ยวเสร็จสมบูรณ์แล้ว'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(11).jpg',
            'title': '11. หน้าพนันของฉัน'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(12).jpg',
            'title': '12. หน้าปุ่มการทำงานอื่นๆ'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(13).jpg',
            'title': '13. หน้าสำหรับเลือกแทงบอลเสต็ป'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(14).jpg',
            'title': '14. หน้าแทงบอลเสต็ป (มิกซ์ พาเลย์)'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(15).jpg',
            'title': '15. หน้าแสดงตัวเลขจำนวนทีมที่แทงไว้ ของบอลเสต็ป'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(16).jpg',
            'title': '16. หน้าแสดงรายการทีมที่ท่านเลือกแทงบอลเสต็ป'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(17).jpg',
            'title': '17. หน้าใส่จำนวนเงินที่ต้องการแทงบอลเสต็ป'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(18).jpg',
            'title': '18. หน้ายืนยันการพนันบอลเสต็ป'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(19).jpg',
            'title': '19. หน้าพนันบอลเสต็ปเสร็จสมบูรณ์แล้ว'
          },
          {
            'url': WPURLS.templateurl + '/images/how-to-play-mobile(20).jpg',
            'title': '20. หน้าพนันของฉัน'
          }
        ];

      }
    })
  });
</script>
 <div id="page" class="single">
   <div class="content">
     <div  style="margin-top:0px;" ng-app="MyHowToPlay" ng-controller="HowToPlay" ng-cloak="" style="margin-top:10px;">
       <center>
         <h2 class="page-title">
           <div style="width: 80%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">วิธีแทงบอล</div>
         </h2>
         <br>
         <div layout="row" layout-align="center center" layout-wrap>
         <a ui-sref="desktop">
           <md-button md-no-ink="true" flex="nogrow" class="md-raised md-primary">แทงบอลผ่านคอมพิวเตอร์ (เมนูไทย)</md-button>
         </a>

         <a ui-sref="desktop-en">
           <md-button md-no-ink="true" flex="nogrow" class="md-raised md-primary">แทงบอลผ่านคอมพิวเตอร์ (เมนู Eng)</md-button>
         </a>

         <a ui-sref="mobile">
           <md-button md-no-ink="true" flex="nogrow" class="md-raised md-primary">แทงบอลผ่านโทรศัพท์ (เมนูไทย)</md-button>
         </a>

         <a ui-sref="mobile-en">
           <md-button md-no-ink="true" flex="nogrow" class="md-raised md-primary">แทงบอลผ่านโทรศัพท์ (เมนู Eng)</md-button>
         </a>
       </div>
         <br>
         <br>
       </center>

      <div ui-view></div>

     </div>

     <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
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
     </script>
<?php get_footer(); ?>
