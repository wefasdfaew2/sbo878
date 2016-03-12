<?php
/*
Template Name: deposit-withdraw-move
*/
?>
<?php get_header();?>
<?php

  wp_register_script('angular-ui-router', get_template_directory_uri() . '/js/angular-ui-router.min.js', true);
  wp_enqueue_script('angular-ui-router');

  wp_register_script('angularSlideables', get_template_directory_uri() . '/js/angularSlideables.js', true);
  wp_enqueue_script('angularSlideables');

  wp_register_script('deposit-withdraw-move', get_template_directory_uri() . '/js/deposit-withdraw-move.js', true);
  wp_enqueue_script('deposit-withdraw-move');
?>

 <div id="page" class="single">
   <div class="content">
     <div ng-app="MyDepositWithdrawMove" ng-controller="DepositWithdrawMove" ng-cloak="" style="margin-top:10px;">

       <!--<center>
         <h2 class="page-title" style="margin-top:0px;margin-bottom:0px;">
           <div style="width: 80%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">ฝาก-ถอน-ย้าย</div>
         </h2>
         <br>
       </center>-->
       <div ui-view></div>

     </div>


<?php get_footer(); ?>
