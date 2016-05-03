<?php
/*
Template Name: link-for-friend
*/
?>
<?php get_header();?>

<?php
  wp_register_script('link-for-friend', get_template_directory_uri() . '/js/link-for-friend.js', true);
  wp_enqueue_script('link-for-friend');
  $url_link = $_GET['url_link'];
?>

 <div id="page" class="single">
   <div class="content">
     <div ng-app="MyLinkForFriend" ng-controller="LinkForFriend" ng-cloak="" style="margin-top:10px;">
      <h2 class="page-title text-center">
        <?php if(is_user_logged_in()){ ?>
          <div style="width: 80%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">
            ท่านสามารถนำ Link หรือสื่อโฆษณาด้านล่างนี้ไปแนะนำเพื่อนได้ทันที
          </div>
        <?php } else {?>
          <div style="width: 80%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">
            เริ่มต้นหารายได้แบบง่าย ๆ เพียง Login เข้าสู่ระบบ
          </div>
        <?php } ?>
      </h2>
      <br>
      <div layout="row">
        <div flex="20">Link แนะนำเพื่อนของคุณคือ:</div>
        <div style="color:red;"><?php echo $url_link; ?></div>        
      </div>
      <br>
      <div layout="row">
        <div flex="20">รูปป้าย Banner สำหรับการแนะนำเพื่อนของคุณ</div>
        <div flex="80">
          <div layout="row">
            <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner1.png" width="728" height="90"/>
          </div>
          <br>
          <div layout="row">
            <div flex="40">
              <div layout="row" layout-wrap>
                <div flex="none">
                  <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner3.png" width="120" height="600"/>
                </div>
                <div flex="none" style="width:160px;height:600px;">
                  <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner4.png" width="160" height="600"/>
                </div>
              </div>
            </div>
            <div flex="60">
              <div layout="row" layout-wrap>
                <div flex="none">
                  <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner5.png" width="125" height="125"/>
                </div>
                <div flex="none">
                  <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner7.png" width="120" height="60"/>
                </div>
                <div flex="none">
                  <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner6.png" width="120" height="90"/>
                </div>
              </div>
              <br>
              <div layout="row">
                <div flex="none">
                  <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner8.png" width="120" height="240"/>
                </div>
                <div flex="none">
                  <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner9.png" width="234" height="60"/>
                </div>
              </div>
              <br>
              <div layout="row">
                <div flex="none">
                  <img ng-src="<?php echo get_template_directory_uri(); ?>/images/banner2.png" width="468" height="60"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

<?php get_footer(); ?>
