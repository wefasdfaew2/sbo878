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
<!--sbobet url check access from isp-->
	<div class="carousel">
			<h3 class="frontTitle"><div class="latest">sbobet_links</div></h3>
<div class="excerpt">

			 <div class="featured-thumbnail">
										<img height="140" width="130" src="http://sbogroup.t-wifi.co.th/screenshot/screenshot.php?url=www.livescore.com&clipw=800&cliph=600" class="attachment-featured wp-post-image" alt="ทางเข้า sbobet3">
									</div>
						<a href="http://www.livescore.com" title="sbobet 3bb" rel="nofollow" id="footer-thumbnail">

							<p class="footer-title">
								<span class="featured-title">sbobet 3bb</span>
							</p>
						</a>
					</div><!--.post excerpt-->
<div class="excerpt">
			 <div class="featured-thumbnail">
										<img height="140" width="130" src="http://sbogroup.t-wifi.co.th/screenshot/screenshot.php?url=www.kapook.com&clipw=800&cliph=600" class="attachment-featured wp-post-image" alt="ทางเข้า sbobet3">
									</div>
						<a href="http://www.kapook.com" title="sbobet tot" rel="nofollow" id="footer-thumbnail">

							<p class="footer-title">
								<span class="featured-title">sbobet tot</span>
							</p>
						</a>
					</div><!--.post excerpt-->




	</div>
<?php mts_copyrights_credit(); ?>
<?php wp_footer(); ?>
</div><!-- main-container -->

</body>
</html>
