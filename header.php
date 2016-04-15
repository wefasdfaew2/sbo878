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
<meta name="referrer" content="origin">
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

			<div style="height:80px;"></div>
			<div id="sticky-anchor"></div>
			<!--<div class="sticky-text" >ยอดสมาชิกแทงได้วันนี้</div>-->
			<div id="sticky" class="stick" style="width:980px;background-color:transparent;padding-top:5px;">

				<div  class="box2" style="display:inline-block;margin-left:10px;width:550px;">
					<div class="row text-center">
						<div class="col-md-5 col-xs-5 text-right" style="padding:0px;padding-top:5px;margin-left:15px;">
							<!--<div>ยอดสมาชิกแทงได้วันนี้</div>-->
							<img src="<?php echo get_template_directory_uri(); ?>/images/VeryHeader1.png" width="197" height="29"/>
						</div>
						<div class="col-md-4 col-xs-4 text-center" style="padding:0px;padding-top:3px;">
							<div id="odometer" class="odometer">0</div>
						</div>
						<div class="col-md-1 col-xs-1 text-left" style="padding:0px;padding-top:5px;">
							<!--<div>บาท</div>-->
							<img src="<?php echo get_template_directory_uri(); ?>/images/VeryHeader2.png" width="38" height="29"/>
						</div>
					</div>
					<div class="row" style="padding:0px;">
						<div class="col-md-12 col-xs-12">
							<marquee style="color:#FFFF00;font-size:12px;font-weight: bold;" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" scrolldelay="120">
								Sbobet878.com ตัวแทนโดยตรงจาก sbobet มั่นคง ปลอดภัย ระบบอัตโนมัติทั้งเว็บ ไม่ต้องรอ Call center, รีบสร้างความมั่นคงให้กับชีวิตของคุณเดี๋ยวนี้ กดสมัครได้เลย
							</marquee>
						</div>
					</div>
				</div>
				<div style="-webkit-box-shadow: -1px 3px 3px rgba(0, 0, 0, 0.4);display:inline-block;float:right;margin-right:10px;background-color:rgba(0, 0, 0, 0.5);border-radius:3px;">
					<img src="<?php echo get_template_directory_uri(); ?>/images/ANDRIOD-store.png" />
					<img src="<?php echo get_template_directory_uri(); ?>/images/IOS-store.png" />
					<center>
						<div style="font-size:50%;">
							ค้นหาชื่อ <span style="color:#f58300;">878Member</span> ใน Store ของท่าน
						</div>
					</center>
				</div>


			</div>

			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12" style="float:left;padding:20px;padding-left:40px;">
					<img src="<?php echo get_template_directory_uri()?>/images/Header.gif">
				</div>

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
						<?php } ?>
					</div>
				</div>
	</div>
		</div>
	<?php } ?>


<!--<script language = 'javascript'>var wid = 980;var hei = 25;var file = 10;var mark = 3;var title = 'scores';var url = 'http://';var timezone = '%2B0700';var dstbox = '';document.write('<iframe src =http://freelive.7m.cn/U_fLeftRight.aspx?width='+wid+'&height='+hei+'&file='+file+'&mark='+mark+'&title='+title+'&urls='+ url+'&timezone="'+timezone+'"&dstbox='+dstbox+'  height ='+(parseInt(hei)+2) +' width = 100% frameborder = no border = 0 marginwidth = 0 marginheight = 0 scrolling = no allowtransparency = yes></iframe>');</script>
-->
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php $header_image = get_header_image();
			if ( !empty($header_image) ) { ?>
				<?php if( is_front_page() || is_home() || is_404() ) { ?>
					<!--<h1 id="logo" class="image-logo" itemprop="headline">-->
						<!--<a href="<?php echo esc_url(home_url()); ?>"><img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>-->
						<table width="980" height="60" border="0" cellpadding="0" cellspacing="0" style="margin-top:15px;margin-bottom:15px;">
							<tr>
								<td rowspan="2">
									<a href="/">
										<img src="<?php echo get_template_directory_uri()?>/images/Top-878_01.jpg" width="237" height="60" border="0" alt=""></a></td>
								<td colspan="5">
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_02.gif" width="657" height="26" alt=""></td>
								<td rowspan="2">
									<a href=" http://line.me/ti/p/FU7mQUUa_E">
										<img src="<?php echo get_template_directory_uri()?>/images/Top-878_02.png" width="60" height="60" border="0" alt=""></a></td>
								<td rowspan="2">
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_04.gif" width="26" height="60" alt=""></td>
							</tr>
							<tr>
								<td>
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_05.gif" width="313" height="34" alt=""></td>
								<td>
									<a href="tel://0979988238">
										<img src="<?php echo get_template_directory_uri()?>/images/Top-878_03.gif" width="162" height="34" border="0" alt=""></a></td>
								<td>
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_07.gif" width="8" height="34" alt=""></td>
								<td>
									<a href="tel://0979988239">
										<img src="<?php echo get_template_directory_uri()?>/images/Top-878_05-08.gif" width="163" height="34" border="0" alt=""></a></td>
								<td>
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_09.gif" width="11" height="34" alt=""></td>
							</tr>
						</table>


					<!--</h1>--><!-- END #logo -->
				<?php } else { ?>

						<!--<a href="<?php echo esc_url(home_url()); ?>"><img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>-->
						<table width="980" height="60" border="0" cellpadding="0" cellspacing="0" style="margin-top:15px;margin-bottom:15px;">
							<tr>
								<td rowspan="2">
									<a href="/">
										<img src="<?php echo get_template_directory_uri()?>/images/Top-878_01.jpg" width="237" height="60" border="0" alt=""></a></td>
								<td colspan="5">
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_02.gif" width="657" height="26" alt=""></td>
								<td rowspan="2">
									<a href=" http://line.me/ti/p/FU7mQUUa_E">
										<img src="<?php echo get_template_directory_uri()?>/images/Top-878_02.png" width="60" height="60" border="0" alt=""></a></td>
								<td rowspan="2">
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_04.gif" width="26" height="60" alt=""></td>
							</tr>
							<tr>
								<td>
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_05.gif" width="313" height="34" alt=""></td>
								<td>
									<a href="tel://0979988238">
										<img src="<?php echo get_template_directory_uri()?>/images/Top-878_03.gif" width="162" height="34" border="0" alt=""></a></td>
								<td>
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_07.gif" width="8" height="34" alt=""></td>
								<td>
									<a href="tel://0979988239">
										<img src="<?php echo get_template_directory_uri()?>/images/Top-878_05-08.gif" width="163" height="34" border="0" alt=""></a></td>
								<td>
									<img src="<?php echo get_template_directory_uri()?>/images/Top-878_09.gif" width="11" height="34" alt=""></td>
							</tr>
						</table>
					<!-- END #logo -->
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

		<table id="Table_01" style="border:0px;margin-top:5px;margin-bottom:5px;">
			<tr>
				<td colspan="5">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/BarPayment_01.gif" width="940" height="6" alt=""></td>
			</tr>
			<tr>
				<td rowspan="2">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/BarPayment_02.gif" width="559" height="57" alt=""></td>
				<td>
					<a href="<?php echo  get_permalink(246); ?>">
						<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/CreditDeposit.jpg" width="172" height="51" border="0" alt=""></a></td>
				<td rowspan="2">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/BarPayment_04.gif" width="14" height="57" alt=""></td>
				<td>
					<a href="<?php echo  get_permalink(272); ?>">
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

		<table style="border:0px;margin:0px;">
			<tr style="border:0px;white-space:nowrap;" >
				<td align="right" style="border:0px;margin:4px;padding-right: 4px;"  ><!--class="effect-1 effects"-->
					<a href="#">
						<div class="img">
							<img width="273" height="117"
							class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment1.jpg">
						</div>
					</a>
				</td>
				<td align="center" style="border:0px;margin:4px;padding-right: 4px;" >
					<a href="#">
						<div class="img">

							<img width="360" height="117"
							class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment2.jpg">

					</div>
					</a>
				</td>
				<td align="left" style="border:0px;margin:4px;padding-right: 4px;" >
					<a href="#">
						<div class="img">
							<img width="186" height="117"
							class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment3.jpg">

						</div>
					</a>
				</td>
				<td align="left" style="border:0px;margin:4px;" >
					<a href="#">
						<div class="img">
							<img width="109" height="117"
							class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Payment4.jpg">

						</div>
					</a>
				</td>
			</tr>
		</table>

</center>

<?php $postid = get_the_ID(); if($postid=='46') {

	$agent = $_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/Android/',$agent)) $os = 'Android';
	elseif(preg_match('/iPhone/',$agent)) $os = 'mobile';
	elseif(preg_match('/iPad/',$agent)) $os = 'mobile';
	elseif(preg_match('/Linux/',$agent)) $os = 'Linux';
	elseif(preg_match('/Win/',$agent)) $os = 'Windows';
	elseif(preg_match('/Mac/',$agent)) $os = 'Mac';
	else $os = 'UnKnown';
	$promote_class_for_mobile = "zoomin";
	$promote_class_for_pc = "hover08 zoomin";

?>
<center>
	<a href="<?php echo  get_permalink(133); ?>">
		<table style="border:0px;margin:0px;width:100%;margin-top:7px;" class="<?php echo $os == 'mobile' ? $promote_class_for_mobile : $promote_class_for_pc ?>">
			<tr style="border:0px;white-space:nowrap;">
				<td align="center" style="border:0px;">
					<figure>
						<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Promo1.png" alt="" title="">
					</figure>
				</td>
				<td align="center" style="border:0px;">
					<figure>
						<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Promo2.png" alt="" title="">
					</figure>
				</td>
				<td align="center" style="border:0px;">
					<figure>
						<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Promo4.png" alt="" title="">
					</figure>
				</td>
				<td align="center" style="border:0px;">
					<figure>
						<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/Promo3.png" alt="" title="">
					</figure>
				</td>
			</tr>
		</table>
	</a>
</center>
<?php } ?>


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
