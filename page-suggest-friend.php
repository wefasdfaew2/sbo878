<?php
/*
Template Name: suggest-friend
*/
?>
<?php get_header();?>



 <div id="page" class="single">
   <div class="content">
     <div ng-app="MySuggestFriend" ng-controller="SuggestFriend" ng-cloak="" style="margin-top:10px;">

         <h2 class="page-title text-center">
           <div style="width: 80%;max-width: 24em;margin: 0 auto;padding: 0.25em 0.625em;">แนะนำเพื่อน</div>
         </h2>
         <br>


       <div style="background-color:#f0f0f0;border-radius:10px;">
         <h4 class="page-sub-title" style="border-top-right-radius:10px;border-top-left-radius:10px;">
           <div style="margin: 0 auto;padding: 0.4em 0.625em;">
             แนะนำเพื่อนมาแทงบอล เล่นพนันเว็บนี้รับทันที 10% + 0.25% ตลอดชีพ
           </div>
         </h4>
         <div style="padding:16px;">
           <p style="text-indent: 3em;font-size:120%;">
             เพียงคุณนำ Link, รูปป้ายโฆษณาด้านล่างนี้ไปแนะนำเพื่อนของคุณ หรือนำไปโพสแนะนำในเว็บบรอ์ด Facebook
             หรือช่องทางอื่น ๆ ในมาเล่นพนันกับเว็บ sbobet878.com เพียงเท่านี้คุณก็จะได้ส่วนแบ่งดีงนี้
           </p>
           <div style="padding:16px;">
             <ul style="font-size:120%;">
              <li>
                เมื่อเพื่อนที่คุณแนะนำมาทำการเติมเงินครั้งแรกและมียอด Turn Over 1 เกิน 1 เท่าจากยอดเดิมที่มาครั้งแรก
                คุณจะได้รับ 10% เข้าบัญชีของคุณทันที (คุณได้เฉพาะยอดเงินฝากครั้งแรก)
              </li>
              <li>
                เมื่อเพื่อนของคุณได้เล่นพนัน หรือแทงบอล คุณจะได้รับ 0.25% ไม่ว่าเพื่อนคุณจะเล่นได้หรือเสีย (คุณได้ตลอดไปที่เพื่อนที่คุณแนะนำยังเล่นกับเราอยู่)
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div style="background-color:#f0f0f0;border-radius:10px;">
        <h4 class="page-sub-title" style="border-top-right-radius:10px;border-top-left-radius:10px;">
          <div style="margin: 0 auto;padding: 0.4em 0.625em;">
            ตัวอย่างการคำนวนรายได้
          </div>
        </h4>
        <div style="padding:16px;">
          <p style="text-indent: 3em;font-size:120%;">
            สมมุติว่าคุณแนะนำเพื่อนให้มาเล่นกับ sbobet878.com ได้จำนวน 10 คน และเพิ่มขึ้น 10 คน ทุก ๆ เดือน
          </p>
       </div>
     </div>

     <div style="background-color:#f0f0f0;border-radius:10px;">
       <h4 class="page-sub-title" style="border-top-right-radius:10px;border-top-left-radius:10px;">
         <div style="margin: 0 auto;padding: 0.4em 0.625em;">
           คำถามที่ถามกันบ่อย ๆ
         </div>
       </h4>
       <div style="padding:16px;">
         <p style="text-indent: 3em;font-size:120%;">
            1 2 3
         </p>
      </div>
    </div>

    <div style="background-color:#f0f0f0;border-radius:10px;">
      <h4 class="page-title text-center" style="border-top-right-radius:10px;border-top-left-radius:10px;">
        <?php if(is_user_logged_in()){ ?>
          <div style="margin: 0 auto;padding: 0.5em 0.625em;">
            ท่านสามารถนำ Link หรือสื่อโฆษณาด้านล่างนี้ไปแนะนำเพื่อนได้ทันที
          </div>
        <?php } else {?>
          <div style="margin: 0 auto;padding: 0.5em 0.625em;">
            เริ่มต้นหารายได้แบบง่าย ๆ เพียง Login เข้าสู่ระบบ
          </div>
        <?php } ?>
      </h4>

      <?php if(!is_user_logged_in()){ ?>
      <div style="padding:16px;">
        <form>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2 text-right" style="height:34px;">
              <label style="position: relative;top: 50%;transform: translateY(-50%);">Username:</label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
              <input ng-model="login.username" type="text" class="form-control">
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 text-right" style="height:34px;">
              <label style="position: relative;top: 50%;transform: translateY(-50%);">Password:</label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
              <input ng-model="login.password" type="password" class="form-control">
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
              <button ng-click="wordpress_login(login.username, login.password)" type="button" class="btn btn-primary">เข้าสู่ระบบ</button>
            </div>
          </div>
      </form>
     </div>
    <?php } else {?>
      <div style="padding:16px;">
      <div layout="row">
        <div>Link แนะนำเพื่อนของคุณคือ: {{ xxxx }}</div>
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
    <?php } ?>
   </div>
    </div>
    <script type="text/javascript">
      function login(uname, pname){
        console.log('login function');
          var data = {
          action: 'my_action',
          username: uname,
          passowrd: pname
      };

      //jQuery.post(ajaxurl, data, function(response) {
      //    alert('Got this from the server: ' + response);
      //});
      }
    </script>
<?php get_footer(); ?>
