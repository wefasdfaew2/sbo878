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
<meta name="viewport" content="width=device-width, initial-scale=1">
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

			<div class="row">
				<div class="col-md-9" style="float:left;padding:20px;padding-left:40px;">
					<img src="<?php echo get_template_directory_uri()?>/images/Header.gif">
				</div>
			<!--<h3 style="color:white;float:left;margin-left:25px;padding-top:5px;">สมัครสมาชิกใหม่วันนี้รับทันทีโบนัส 200%</h2>-->
				<div class="col-md-2" style="float:right;padding:20px;">
			<button type="button" class="btn btn-danger">สมัครสมาชิก</button>
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
		<div class="button_example container" style="width:100%;margin:5px;display: table;">
			<div class="row" style="display: table-cell;vertical-align: middle;">
				<div class="col-md-2 col-md-offset-1" style="">
      			<img style="float: right;" src="http://upic.me/i/eg/flexible-top-up_icon.png" alt="เติมเครดิตเพื่อแทงบอลได้ที่นี่" title="เติมเครดิตแทงบอล"/>
  			</div>
				<div class="col-md-9" style="padding-left:0px;padding-top:12px;font-size:140%;">
					<div style="float: left;">เติมเครดิตผ่านระบบอัตโนมัติง่าย ๆ 4 ช่องทาง (อย่าลืมสมัครสมาชิกก่อนเติมเครดิต)</div>
				</div>
			</div>
		 </div>

		<div layout="row" layout-align="space-around center" style="">
		<span flex></span>
		<a class="button_tm" href="" target="_blank" style="text-decoration: none;"><center><img src="http://upic.me/i/a8/kbank.png" alt="" title="">&nbsp;<img src="http://upic.me/i/on/logo-scb.png" alt="" title="">&nbsp;<img src="http://upic.me/i/2x/ushj1.png" alt="" title="">&nbsp;<img src="http://upic.me/i/fi/krungsri_logo_icon.png" alt="" title="">&nbsp;<img src="http://upic.me/i/ok/ktb-logo-1024x1024.jpg" alt="" title=""><br/>ผ่านธนาคารทางอินเตอร์เน็ต<br/>(Ebank,ATM,Mobile App)</center></a>
		<span flex></span>
		<a class="button_sms" href="" target="_blank" style="text-decoration: none;"><center><img src="http://upic.me/i/s9/logo-7-eleven.png" alt="" title=""><br/>ผ่านเซเว่น<br/>ทุกสาขาใกล้บ้านคุณ</center></a>
		<span flex></span>
		<a class="button_cc" href="" target="_blank" style="text-decoration: none;"><center><img src="http://upic.me/i/vv/visa-mastercard-logo11.png" alt="" title=""><br/>ผ่านบัตรเครดิต<br/>(VISA,MasterCard,JCB)</center></a>
		<span flex></span>
		<a class="button_pp" href="" target="_blank" style="text-decoration: none;"><center><img src="http://upic.me/i/4i/paypal_2014_logo.png" alt="" title=""><br/>ผ่าน Paypal<br/>(เพย์พาลวอลเล็ต)</center></a>
		<span flex></span>
	</div>
</center>




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
