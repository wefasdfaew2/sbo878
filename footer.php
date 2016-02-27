<?php
/**
 * The template for displaying the footer.
 */
?>
	</div><!-- .content -->
</div><!-- #page -->
<?php
	$carousel_section = get_theme_mod('point_carousel_section', '1');
	$carousel_cats = get_theme_mod('point_carousel_cat');
?>
<footer>
	<?php if( $carousel_section == 1 && isset($carousel_cats) ) { ?>
		<div class="carousel">
			<h3 class="frontTitle"><div class="latest"><?php echo $carousel_cats[0]; ?></div></h3>
			<?php
				// prevent implode error
                if (empty($carousel_cats) || !is_array($carousel_cats)) {
                    $carousel_cats = array('0');
                }
				$carousel_cat = implode(",", $carousel_cats);
				$i = 1; $my_query = new wp_query( 'category_name='.$carousel_cat.'&posts_per_page=6&ignore_sticky_posts=1' );
				while ($my_query->have_posts()) : $my_query->the_post(); ?>
					<div class="excerpt">
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="footer-thumbnail">
							<div>
								<div class="hover"><i class="point-icon icon-zoom-in"></i></div>
								<?php if ( has_post_thumbnail() ) { ?>
									<?php the_post_thumbnail('carousel',array('title' => '')); ?>
								<?php } else { ?>
									<div class="featured-thumbnail">
										<img src="<?php echo get_template_directory_uri(); ?>/images/footerthumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
									</div>
								<?php } ?>
							</div>
							<p class="footer-title">
								<span class="featured-title"><?php the_title(); ?></span>
							</p>
						</a>
					</div><!--.post excerpt-->
			<?php endwhile; wp_reset_query(); ?>
		</div>
	<?php } ?>
</footer><!--footer-->

<?php $postid = get_the_ID(); if($postid=='46') {?>
	<div class="carousel" style="height:40px;margin-bottom:10px;">
			<h3 class="frontTitle">ตารางคะแนน (อัพเดทอัตโนมัติ)</h3>
	</div>
	<div style="text-align:center;">
		<script language='javascript'> var timeZone ='%2B0700'; var dstbox =''; var cpageBgColor = 'FFFFFF'; var wordAd='  Sbobet878.Com'; var wadurl='https://www.sboobet878.com'; var width='100%'; var tableFontSize='12'; var cborderColor='333333'; var ctdColor1='EEEEEE'; var ctdColor2='FFFFFF'; var clinkColor='0044DD'; var cdateFontColor='FFFFFF'; var cdateBgColor='333333'; var scoreFontSize='12'; var cteamFontColor='000000'; var cgoalFontColor='FF0000'; var cgoalBgColor='FFFF99'; var cremarkFontColor='000000'; var mark ='en'; var cremarkBgColor='F7F8F3'; var Skins='2'; var teamWeight='400'; var scoreWeight='700'; var goalWeight='700'; var fontWeight='700'; document.write("<iframe align='center' src='http://freelive.7m.cn/live.aspx?mark="+ mark +"&TimeZone=" + timeZone + "&wordAd=" + wordAd + "&cpageBgColor="+ cpageBgColor +"&wadurl=" + wadurl + "&width=" + width + "&tableFontSize=" + tableFontSize + "&cborderColor=" + cborderColor + "&ctdColor1=" + ctdColor1 + "&ctdColor2=" + ctdColor2 + "&clinkColor=" + clinkColor + "&cdateFontColor="+ cdateFontColor +"&cdateBgColor=" + cdateBgColor + "&scoreFontSize=" + scoreFontSize + "&cteamFontColor=" + cteamFontColor + "&cgoalFontColor=" + cgoalFontColor + "&cgoalBgColor=" + cgoalBgColor + "&cremarkFontColor=" + cremarkFontColor + "&cremarkBgColor=" + cremarkBgColor + "&Skins=" + Skins + "&teamWeight=" + teamWeight + "&scoreWeight=" + scoreWeight + "&goalWeight=" + goalWeight +"&fontWeight="+ fontWeight +"&DSTbox="+ dstbox +"'  height='470' width='95%' scrolling='yes' border='0' frameborder='0'></iframe>")</script>
	</div>
	<br>
<?php } ?>
<!--sbobet url check access from isp-->
	<div class="carousel">
			<h3 class="frontTitle">ทางเข้าเว็บพนัน (อัพเดทลิ้งค์ใหม่อัตโนมัติหากโดนบล๊อค)</h3>
	</div>


<table style="width:100%"  >
<tr align="center">
    <td>
		<img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/3BB.jpg" alt="sbobet878">
	 </td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</td>
		<!--x -->
	<td>
		<img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/True.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
	</td>
</tr>
<tr align="center">
  <td>
	<a href="http://sbogroup.t-wifi.co.th/wordpress/index.php/page_link_3bb">ทางเข้าทั้งหมดผ่าน3bb</a>
  </td>
  <td>
	sbobet link1
  </td>
  <td>
	Royal Gclub link1
  </td>
  <!--x -->
  <td>
	<a href="http://sbogroup.t-wifi.co.th/wordpress/index.php/page_link_trueonline">ทางเข้าทั้งหมดผ่านทรู</a>
  </td>
  <td>
	sbobet link1
  </td>
  <td>
	Royal Gclub link1
  </td>
  </tr>
</table>

<table style="width:100%"  >
<tr align="center">
    <td>
		<img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/TOT.jpg" alt="sbobet878">
	 </td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</td>
		<!--x -->
	<td>
		<img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/CAT.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
	</td>
</tr>
<tr align="center">
  <td>
	<a href="http://sbogroup.t-wifi.co.th/wordpress/index.php/page_link_tot">ทางเข้าทั้งหมดผ่านทีโอที</a>
  </td>
  <td>
	sbobet link1
  </td>
  <td>
	Royal Gclub link1
  </td>
  <!--x -->
  <td>
	<a href="http://sbogroup.t-wifi.co.th/wordpress/index.php/page_link_cat">ทางเข้าทั้งหมดผ่านแคท</a>
  </td>
  <td>
	sbobet link1
  </td>
  <td>
	Royal Gclub link1
  </td>
  </tr>
</table>

<table style="width:100%"  >
<tr align="center">
    <td>
		<img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/AIS.jpg" alt="sbobet878">
	 </td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</td>
		<!--x -->
	<td>
		<img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/Dtac.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
	</td>
</tr>
<tr align="center">
  <td>
	<a href="http://sbogroup.t-wifi.co.th/wordpress/index.php/page_link_ais">ทางเข้าทั้งหมดผ่านเอไอเอส</a>
  </td>
  <td>
	sbobet link1
  </td>
  <td>
	Royal Gclub link1
  </td>
  <!--x -->
  <td>
	<a href="http://sbogroup.t-wifi.co.th/wordpress/index.php/page_link_dtac">ทางเข้าทั้งหมดผ่านดีแทค</a>
  </td>
  <td>
	sbobet link1
  </td>
  <td>
	Royal Gclub link1
  </td>
  </tr>
</table>

<table style="width:100%" >
<tr align="center">
    <td>
		<img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/TrueH.jpg" alt="sbobet878">
	 </td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
	</td>
    <td>
		<img height="84" width="117" src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</td>
		<!--x -->
	<td>

	</td>
    <td>
		 <a href="http://sbogroup.t-wifi.co.th/wordpress/index.php/page_link_all">
      <img   src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/LinkEntry.png" alt="sbobet878"  hspace="10">
     </a>
	</td>
    <td>

	</td>

</tr>
<tr align="center">
  <td>
	<a href="http://sbogroup.t-wifi.co.th/wordpress/index.php/page_link_truemove">ทางเข้าทั้งหมดผ่านทรูมูฟเฮช</a>
  </td>
  <td>
	sbobet link1
  </td>
  <td>
	Royal Gclub link1
  </td>
  <!--x -->
   <td>
   </td>
  </tr>
</table>



<?php mts_copyrights_credit(); ?>
<?php wp_footer(); ?>

</div><!-- main-container -->

</body>
</html>
