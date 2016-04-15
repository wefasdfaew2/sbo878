jQuery(document).ready(function($) {

	OneEngine = Backbone.View.extend({		
		el: 'body',
		events: {
			'click .portfolio-list div a' : 'renderPortfolio',
			'click .port-control a' 	  : 'renderPortfolio',
			'click a.et-like-post' 	 	  : 'likePost',
		},
		initialize: function(){
			//console.log('init');
		},
		likePost: function(event){
			event.preventDefault();
			var target = $(event.currentTarget);

			if(!target.hasClass('active')){
				$.ajax({
					url : oe_globals.ajaxURL,
					type : 'post',
					data : {
						action : 'et_like_post',
						content: {
							id : target.attr('data-id')
						}
					},
					beforeSend : function(){
						target.addClass('active');
					},
					error : function(request){

					},
					success : function(response){
						if(response.success){
							target.find('span.count').text(response.count);
							createCookie('et_like_'+target.attr('data-id'),1,365);
						} else {
							target.removeClass('active');
							target.find('span.count').text(response.count);
						}
					}
				});
			}

		},
		renderPortfolio: function(event){
			event.preventDefault();
			var target = $(event.currentTarget);

			if(target.attr('data-id') && ! target.hasClass('loading')){
				$.ajax({
					url : oe_globals.ajaxURL,
					type : 'post',
					data : {
						action : 'et_load_portfolio',
						content: {
							id : target.attr('data-id')
						}
					},
					beforeSend : function(){
						target.addClass('loading');
						$('.mask-color-port').fadeIn('300');
					},
					error : function(request){

					},
					success : function(response){
					
						$('.mask-color-port').fadeOut('300');
						var container = $("#portfolio_content .port-content"),
							control   = $("#portfolio_content .port-control");
						target.removeClass('loading');
						if(response.success){
							
							if(!target.hasClass('next') &&  !target.hasClass('prev')){
								$("#portfolio_content").fadeIn('500', function() {
									$.scrollTo("#portfolio_content", 1000, {easing:'easeOutExpo',offset:-$(".sticky-wrapper").height()});
								});
							}
							
							control.find('a.prev').attr('data-id',response.prev_post);
							control.find('a.next').attr('data-id',response.next_post);
							container.html(response.html);
						} else {
							alert('Error');
						}
					},
					complete : function(){
						$('.su-lightbox-gallery').each(function () {
							var slides = [];
							$(this).find('.su-slider-slide, .su-carousel-slide, .su-custom-gallery-slide').each(function (i) {
								$(this).attr('data-index', i);
								slides.push({
									src: $(this).children('a').attr('href'),
									title: $(this).children('a').attr('title')
								});
							});
							$(this).data('slides', slides);
						});
						// Enable sliders
						$('.su-slider').each(function () {
							// Prepare data
							var $slider = $(this);
							// Apply Swiper
							var $swiper = $slider.swiper({
								wrapperClass: 'su-slider-slides',
								slideClass: 'su-slider-slide',
								slideActiveClass: 'su-slider-slide-active',
								slideVisibleClass: 'su-slider-slide-visible',
								pagination: '#' + $slider.attr('id') + ' .su-slider-pagination',
								autoplay: $slider.data('autoplay'),
								paginationClickable: true,
								grabCursor: true,
								mode: 'horizontal',
								mousewheelControl: $slider.data('mousewheel'),
								speed: $slider.data('speed'),
								calculateHeight: $slider.hasClass('su-slider-responsive-yes'),
								loop: true
							});
							// Prev button
							$slider.find('.su-slider-prev').click(function (e) {
								$swiper.swipeNext();
							});
							// Next button
							$slider.find('.su-slider-next').click(function (e) {
								$swiper.swipePrev();
							});
						});
						// Enable carousels
						$('.su-carousel').each(function () {
							// Prepare data
							var $carousel = $(this),
								$slides = $carousel.find('.su-carousel-slide');
							// Apply Swiper
							var $swiper = $carousel.swiper({
								wrapperClass: 'su-carousel-slides',
								slideClass: 'su-carousel-slide',
								slideActiveClass: 'su-carousel-slide-active',
								slideVisibleClass: 'su-carousel-slide-visible',
								pagination: '#' + $carousel.attr('id') + ' .su-carousel-pagination',
								autoplay: $carousel.data('autoplay'),
								paginationClickable: true,
								grabCursor: true,
								mode: 'horizontal',
								mousewheelControl: $carousel.data('mousewheel'),
								speed: $carousel.data('speed'),
								slidesPerView: ($carousel.data('items') > $slides.length) ? $slides.length : $carousel.data('items'),
								slidesPerGroup: $carousel.data('scroll'),
								calculateHeight: $carousel.hasClass('su-carousel-responsive-yes'),
								loop: true
							});
							// Prev button
							$carousel.find('.su-carousel-prev').click(function (e) {
								$swiper.swipeNext();
							});
							// Next button
							$carousel.find('.su-carousel-next').click(function (e) {
								$swiper.swipePrev();
							});
						});
						// Enable lightbox
						$('.su-lightbox-gallery').on('click', '.su-slider-slide, .su-carousel-slide, .su-custom-gallery-slide', function (e) {
							e.preventDefault();
							var slides = $(this).parents('.su-lightbox-gallery').data('slides');
							$.magnificPopup.open({
								items: slides,
								type: 'image',
								mainClass: 'mfp-img-mobile',
								gallery: {
									enabled: true,
									navigateByImgClick: true,
									preload: [0, 1],
									tPrev: su_magnific_popup.prev,
									tNext: su_magnific_popup.next,
									tCounter: su_magnific_popup.counter
								},
								tClose: su_magnific_popup.close,
								tLoading: su_magnific_popup.loading
							}, $(this).data('index'));
						});
					}
				});
			}
		}
	});
	new OneEngine();
	
	
	
	/**$( document ).on('click', '.su-slider-slide, .su-carousel-slide, .su-custom-gallery-slide', function (e) {
		e.preventDefault();//alert("aa");
		var slides = $(this).parents('.su-lightbox-gallery').data('slides');
		$.magnificPopup.open({
			items: slides,
			type: 'image',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0, 1],
				tPrev: su_magnific_popup.prev,
				tNext: su_magnific_popup.next,
				tCounter: su_magnific_popup.counter
			},
			tClose: su_magnific_popup.close,
			tLoading: su_magnific_popup.loading
		}, $(this).data('index'));
	});**/

});

