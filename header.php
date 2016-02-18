<?php
/**
 * The template for displaying the header.
 *
 * Displays everything from the doctype declaration down to the navigation.
 */
?>
<!DOCTYPE html>
<html  <?php language_attributes(); ?> >
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body id="blog" <?php body_class(); ?>>
<?php
	$point_button_section = get_theme_mod('point_button_section', '1');
	$point_button_bg_color = get_theme_mod('point_button_bg_color');
	$point_button_text = get_theme_mod('point_button_text', 'Download!');
	$point_button_url = get_theme_mod('point_button_url');
	$point_bottom_text = get_theme_mod('point_bottom_text','Download Point responsive WP Theme for FREE!');
	$point_header_ad_code = get_theme_mod('point_header_ad_code');
	$trending_section = get_theme_mod('point_trending_section', '1');
	$trending_cat_names = get_theme_mod('point_trending_cat', '1');
	$featured_section = get_theme_mod('point_feature_setting', '1');
	$feature_cat_names = get_theme_mod('point_feature_cat', '1');


?>

<div  class="main-container">

	<?php if( $trending_section == 1 && isset($trending_cat_names) ) { ?>

		<div class="trending-articles">


			<div id="sticky-anchor"></div>
			<!--<div class="sticky-text" >ยอดสมาชิกแทงได้วันนี้</div>-->
			<div id="sticky" class="box2" >
				<div class="row text-center" style="">

					<div class="col-md-5 col-xs-5 text-right" style="padding:0px;padding-top:5px;margin-left:15px;">
						<!--<div>ยอดสมาชิกแทงได้วันนี้</div>-->
						<img class="image-responsive" src="<?php echo get_template_directory_uri(); ?>/images/VeryHeader1.png"/>
					</div>
					<div class="col-md-4 col-xs-4 text-center" style="padding:0px;padding-top:3px;">
						<div id="odometer" class="odometer">0</div>
					</div>
					<div class="col-md-1 col-xs-1 text-left" style="padding:0px;padding-top:5px;">
						<!--<div>บาท</div>-->
						<img class="image-responsive" src="<?php echo get_template_directory_uri(); ?>/images/VeryHeader2.png"/>
					</div>
				</div>
				<div class="row" style="padding:0px;">
					<div class="col-md-12 col-xs-12">
						<marquee style="color:#FFFF00;font-size:70%;font-weight: bold" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" scrolldelay="120">
							Sbobet878.com ตัวแทนโดยตรงจาก sbobet มั่นคง ปลอดภัย ระบบอัตโนมัติทั้งเว็บ ไม่ต้องรอ Call center, รีบสร้างความมั่นคงให้กับชีวิตของคุณเดี๋ยวนี้ กดสมัครได้เลย
						</marquee>
					</div>
				</div>
				<!--<table style="border:0px;margin:auto;" class="table-responsive">
					<tr style="border:0px;overflow: visible;">
						<td style="border:0px;" class="text-right">
							<div>ยอดสมาชิกแทงได้วันนี้</div>
						</td>
						<td style="border:0px;overflow: visible;" class="text-right">
							<center>
							<div class="counter-wrapper" style="margin-top:0px;">
								<ul class="flip-counter small" id="c1"></ul>
							</div>
						</center>
						<div id="odometer" class="odometer">123000</div>
						</td>
						<td style="border:0px;overflow: visible;" class="text-left">
							<div>บาท</div>
						</td>
					</tr>
				</table>-->




			</div>
			<!--<div class="sticky-text2">บาท</div>-->

				<!--<center><div id="sticky-anchor"></div></center>
				<center><div id="sticky" style="width:100px;height:50px;background-color:red;"></div></center>-->

			<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12" style="float:left;padding:20px;padding-left:40px;">
					<img src="<?php echo get_template_directory_uri()?>/images/Header.gif">
				</div>
			<!--<h3 style="color:white;float:left;margin-left:25px;padding-top:5px;">สมัครสมาชิกใหม่วันนี้รับทันทีโบนัส 200%</h2>-->

			<div class="col-md-6 col-sm-6 col-xs-12" style="padding-top:20px;">
					<div class="row">
						<?php if(is_user_logged_in()){ ?>
							<table style="border:0px;float:right;">
				        <tr style="border:0px;white-space:nowrap;">
									<td align="right" style="float:right;border:0px;margin-right:40px;white-space:nowrap;" width="90">
										<a href="<?php echo wp_logout_url( home_url() ); ?>">
											<button type="button" class="btn btn-danger">ออกจากระบบ</button>
										</a>
								</td>
				            <td align="right" style="float:right;border:0px;padding-right:5px;white-space:nowrap;">
											<a href="<?php echo  get_permalink(29); ?>?cmd=update">
												<button type="button" class="btn btn-success">แก้ไข้ข้อมูลส่วนตัว</button>
											</a>
									</td>
				            <td align="right" style="float:right;border:0px;padding-right:5px;white-space:nowrap;">
											<a href="<?php echo  get_permalink(121); ?>">
												<button type="button" class="btn btn-primary" >ทดลองเล่น</button>
											</a>
										</td>


				        </tr>
							</table>
						<!--	<div class="col-md-1 col-sm-1 col-lg-1 col-xs-1"></div>

							<div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 text-right" style="padding:0px;">
								<a href="<?php echo ""; ?>">
									<button type="button" class="btn btn-primary" >ทดลองเล่น</button>
								</a>
							</div>
							<div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 text-right" style="padding:0px;">
								<a href="<?php echo ""; ?>">
									<button type="button" class="btn btn-success">แก้ไข้ข้อมูลส่วนตัว</button>
								</a>
							</div>
							<div class="col-md-3 col-sm-3 col-lg-3 col-xs-4 text-right" style="padding:0px;">
								<a href="<?php echo wp_logout_url( home_url() ); ?>">
									<button type="button" class="btn btn-danger">ออกจากระบบ</button>
								</a>
							</div>-->
						<?php }else{ ?>

							<table style="border:0px;float:right;">
								<tr style="border:0px;white-space:nowrap;">
									<td style="border:0px;float:right;padding-right:25px;white-space:nowrap;">
										<a href="<?php echo  get_permalink(121); ?>">
											<button type="button" class="btn btn-primary" >ทดลองเล่น</button>
										</a>
									</td>
										<td style="border:0px;float:right;padding-right:5px;white-space:nowrap;">
											<a href="<?php echo  get_permalink(129); ?>">
												<button type="button" class="btn btn-danger">สมัครสมาชิก</button>
											</a>
									</td>
								</tr>
							</table>

						<!--	<div class="col-md-6 col-sm-6 col-xs-6" style=""></div>
							<div class="col-md-3 col-sm-3 col-xs-3 text-right" style="">
								<a href="<?php echo  get_permalink(129); ?>">
									<button type="button" class="btn btn-danger">สมัครสมาชิก</button>
								</a>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 text-right" style="padding-left:0px;">
								<a href="<?php echo  get_permalink(121); ?>">
									<button type="button" class="btn btn-primary">ทดลองเล่น</button>
								</a>
							</div>-->

						<?php } ?>
					</div>
				</div>
	</div>
		</div>
	<?php } ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php $header_image = get_header_image();
			if ( !empty($header_image) ) { ?>
				<?php if( is_front_page() || is_home() || is_404() ) { ?>
					<h1 id="logo" class="image-logo" itemprop="headline">
						<a href="<?php echo esc_url(home_url()); ?>"><img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
					</h1><!-- END #logo -->
				<?php } else { ?>
					<h2 id="logo" class="image-logo" itemprop="headline">
						<a href="<?php echo esc_url(home_url()); ?>"><img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
					</h2><!-- END #logo -->
				<?php } ?>
			<?php } else { ?>
				<?php if( is_front_page() || is_home() || is_404() ) { ?>
					<h1 id="logo" class="text-logo" itemprop="headline">
						<a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo( 'name' ); ?></a>
					</h1><!-- END #logo -->
				<?php } else { ?>
					<h2 id="logo" class="text-logo" itemprop="headline">
						<a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo( 'name' ); ?></a>
					</h2><!-- END #logo -->
				<?php } ?>
			<?php } ?>

			<a href="#" id="pull" class="toggle-mobile-menu"><?php _e('Menu', 'point'); ?></a>
			<div class="primary-navigation">
				<nav id="navigation" class="mobile-menu-wrapper" role="navigation">
					<?php if ( has_nav_menu( 'primary' ) ) { ?>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_Walker ) ); ?>
					<?php } else { ?>
						<ul class="menu clearfix">
							<?php wp_list_categories('title_li='); ?>
						</ul>
					<?php } ?>
				</nav><!-- #navigation -->
			</div><!-- .primary-navigation -->
		</div><!-- .site-branding -->

	</header><!-- #masthead -->

<center>
		<!--<div class="button_example container" style="width:100%;margin:5px;display: table;">
			<div class="row" style="display: table-cell;vertical-align: middle;">
				<div class="col-md-2 col-md-offset-1" style="">
      			<img style="float: right;" src="http://upic.me/i/eg/flexible-top-up_icon.png" alt="เติมเครดิตเพื่อแทงบอลได้ที่นี่" title="เติมเครดิตแทงบอล"/>
  			</div>
				<div class="col-md-9" style="padding-left:0px;padding-top:15px;font-size:140%;">
					<div style="float: left;">เติมเครดิตผ่านระบบอัตโนมัติง่าย ๆ 4 ช่องทาง (อย่าลืมสมัครสมาชิกก่อนเติมเครดิต)</div>
				</div>
			</div>
		</div>-->
		<table style="border:0px;margin-top:5px;margin-bottom:5px;">
			<tr>
				<td colspan="5">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/BarPayment_01.gif" width="940" height="6" alt=""></td>
			</tr>
			<tr>
				<td rowspan="2">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/BarPayment_02.gif" width="559" height="57" alt=""></td>
				<td>
					<a href="http://www.google.com">
						<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/CreditDeposit.jpg" width="172" height="51" border="0" alt=""></a></td>
				<td rowspan="2">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/BarPayment_04.gif" width="14" height="57" alt=""></td>
				<td>
					<a href="http://www.amazon.com">
						<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/CreditWithdraw.jpg" width="172" height="51" border="0" alt=""></a></td>
				<td rowspan="2">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/BarPayment_06.gif" width="23" height="57" alt=""></td>
			</tr>
			<tr>
				<td>
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/BarPayment_07.gif" width="172" height="6" alt=""></td>
				<td>
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/BarPayment_08.gif" width="172" height="6" alt=""></td>
			</tr>
		</table>

		<!--<div class="row" style="padding:0px;margin:0px">
			<div class="col-md-12">
			<img style="display:inline-block;" width="273" height="117" class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment1.jpg">
			 <img style="display:inline-block;" width="360" height="117" class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment2.jpg">
			 <img style="display:inline-block;" width="186" height="117" class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment3.jpg">
			 <img style="display:inline-block;" width="109" height="117" class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment4.jpg">
		</div>
	</div>-->

		<table style="border:0px;margin:0px;">
			<tr style="border:0px;white-space:nowrap;">
				<td align="right" style="border:0px;margin:4px;padding-right: 4px;">
					<img width="273" height="117"
					class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment1.jpg">
				</td>
				<td align="center" style="border:0px;margin:4px;padding-right: 4px;">
					<img width="360" height="117"
					class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment2.jpg">
				</td>
				<td align="left" style="border:0px;margin:4px;padding-right: 4px;">
					<img width="186" height="117"
					class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment3.jpg">
				</td>
				<td align="left" style="border:0px;margin:4px;">
					<img width="109" height="117"
					class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment4.jpg">
				</td>
			</tr>
		</table>

</center>
</br>

<?php $postid = get_the_ID();
if($postid=='46'){
//echo "hit";
echo '<center>
<div layout="row" layout-align="center center">
  <img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/Promo1.jpg" alt="" title="">&nbsp;&nbsp;
  <img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/Promo2.jpg" alt="" title="">&nbsp;&nbsp;
  <img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/Promo4.jpg" alt="" title="">&nbsp;&nbsp;
   <img src="http://sbogroup.t-wifi.co.th/wordpress/wp-content/uploads/2016/02/Promo3.jpg" alt="" title="">
</div>
</center>';

}
?>


	<?php
		if( $featured_section == '1' && isset($feature_cat_names) ) {
		if(is_home() && !is_paged()) { ?>
			<div class="featuredBox">
				<?php $i = 1;
					// prevent implode error
                    if (empty($feature_cat_names) || !is_array($feature_cat_names)) {
                        $feature_cat_names = array('0');
                    }
					$feature_cat_name = implode(",", $feature_cat_names);
					$featured_query = new WP_Query('category_name='.$feature_cat_name.'&posts_per_page=4');
					while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
					<?php if($i == 1){ ?>
						<div class="firstpost excerpt">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="first-thumbnail">
								<?php if ( has_post_thumbnail() ) { ?>
									<?php the_post_thumbnail('bigthumb',array('title' => '')); ?>
								<?php } else { ?>
									<div class="featured-thumbnail">
										<img src="<?php echo get_template_directory_uri(); ?>/images/bigthumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
									</div>
								<?php } ?>
								<p class="featured-excerpt">
									<span class="featured-title"><?php the_title(); ?></span>
									<span class="f-excerpt"><?php echo mts_excerpt(10);?></span>
								</p>
							</a>
						</div><!--.post excerpt-->
					<?php } elseif($i == 2) { ?>
						<div class="secondpost excerpt">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="second-thumbnail">
								<?php if ( has_post_thumbnail() ) { ?>
									<?php the_post_thumbnail('mediumthumb',array('title' => '')); ?>
								<?php } else { ?>
									<div class="featured-thumbnail">
										<img src="<?php echo get_template_directory_uri(); ?>/images/mediumthumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
									</div>
								<?php } ?>
								<p class="featured-excerpt">
									<span class="featured-title"><?php the_title(); ?></span>
								</p>
							</a>
						</div><!--.post excerpt-->
					<?php } elseif($i == 3 || $i == 4) { ?>
						<div class="thirdpost excerpt">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="third-thumbnail">
								<?php if ( has_post_thumbnail() ) { ?>
									<?php the_post_thumbnail('smallthumb',array('title' => '')); ?>
								<?php } else { ?>
									<div class="featured-thumbnail">
										<img src="<?php echo get_template_directory_uri(); ?>/images/smallfthumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
									</div>
								<?php } ?>
								<p class="featured-excerpt">
									<span class="featured-title"><?php the_title(); ?></span>
								</p>
							</a>
						</div><!--.post excerpt-->
					<?php } ?>
				<?php $i++; endwhile; wp_reset_postdata(); ?>
			</div>
		<?php } ?>
	<?php } ?>
