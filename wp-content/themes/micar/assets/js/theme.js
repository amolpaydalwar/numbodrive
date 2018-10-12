(function($){
"use strict"; // Start of use strict
//Variations
$.fn.tawcvs_variation_swatches_form = function () {
	return this.each( function() {
		var $form = $( this ),
			clicked = null,
			selected = [];

		$form
			.addClass( 'swatches-support' )
			.on( 'click', '.swatch', function ( e ) {
				e.preventDefault();
				var $el = $( this ),
					$select = $el.closest( '.value' ).find( 'select' ),
					attribute_name = $select.data( 'attribute_name' ) || $select.attr( 'name' ),
					value = $el.data( 'value' );

				$select.trigger( 'focusin' );

				// Check if this combination is available
				if ( ! $select.find( 'option[value="' + value + '"]' ).length ) {
					$el.siblings( '.swatch' ).removeClass( 'selected' );
					$select.val( '' ).change();
					$form.trigger( 'tawcvs_no_matching_variations', [$el] );
					return;
				}

				clicked = attribute_name;

				if ( selected.indexOf( attribute_name ) === -1 ) {
					selected.push(attribute_name);
				}

				if ( $el.hasClass( 'selected' ) ) {
					$select.val( '' );
					$el.removeClass( 'selected' );

					delete selected[selected.indexOf(attribute_name)];
				} else {
					$el.addClass( 'selected' ).siblings( '.selected' ).removeClass( 'selected' );
					$select.val( value );
				}

				$select.change();
			} )
			.on( 'click', '.reset_variations', function () {
				$( this ).closest( '.variations_form' ).find( '.swatch.selected' ).removeClass( 'selected' );
				selected = [];
			} )
			
	} );
};

// fix append css
function fix_css_append(){
	var css_data = $('#s7upf-theme-style-inline-css').html();
	$('#s7upf-theme-style-inline-css').remove();
	if(css_data) $('head').append('<style id="s7upf-theme-style-inline-css" type="text/css">'+css_data+'</style>');
}
$( function () {
	$( '.variations_form' ).tawcvs_variation_swatches_form();
	$( document.body ).trigger( 'tawcvs_initialized' );
	$('.swatches-support .variations .tawcvs-swatches .swatch').live('click',function(event) {
		event.preventDefault();
		$(this).parents('.content-product-detail').find(".carousel a").removeClass('active');
		var z_url =  $(this).parents('.content-product-detail').find('.mid img').attr("src");
		$('.zoomLens').css('background-image','url("'+z_url+'")');
	});
} );
$(function() {	
	//Product Inner Zoom
	if($('.inner-zoom').length>0){
		$('.inner-zoom').on('mouseover',function(){
			$(this).find('img').elevateZoom({
				zoomType: "lens",
				lensShape: "square",
				lensSize: 100,
				borderSize:1,
				containLensZoom:true,
				responsive:true
			});
		})
	}
	//Check RTL
	if($('body').attr('dir')=="rtl"){
		$('body').addClass("right-to-left");
	}else{
		$('body').removeClass("right-to-left");
	}
	//Full Mega Menu
	if($('.full-mega-menu').length>0){
		$('.main-nav').each(function(){
			if($('body').attr('dir')=="rtl"){
				var nav_os = ($(window).width() - ($(this).offset().left + $(this).outerWidth()));
				var par_os = ($(window).width() - ($(this).parents('.container,.container-fluid').offset().left + $(this).parents('.container,.container-fluid').outerWidth()));
				var nav_right = nav_os - par_os - 15;
				$(this).find('.full-mega-menu').css('margin-right','-' + nav_right + 'px');
			}else{
				var nav_os = $(this).offset().left;
				var par_os = $(this).parents('.container,.container-fluid').offset().left;
				var nav_left = nav_os - par_os - 15;
				$(this).find('.full-mega-menu').css('margin-left','-' + nav_left + 'px');
			}
		});
	}
	//Menu Responsive
	$('.toggle-mobile-menu').on('click',function(event){
		event.preventDefault();
		$(this).parents('.main-nav').toggleClass('active');
	});
	//Toggle Class
	if($('.list-attr').length>0){
		$('.list-attr a').on('click',function(event){
			event.preventDefault();
			$(this).toggleClass('active');
		});
	}
	//Tag Toggle
	if($('.toggle-tab').length>0){
		$('.toggle-tab').each(function(){
			$(this).find('.item-toggle-tab').first().find('.toggle-tab-content').show();
			$(this).find('.toggle-tab-title').on('click',function(event){
				if($(this).next().length>0){
					event.preventDefault();
					$(this).parent().siblings().removeClass('active');
					$(this).parent().addClass('active');
					$(this).parents('.toggle-tab').find('.toggle-tab-content').slideUp();
					$(this).next().stop(true,false).slideDown();
				}
			});
		});
	}
	//Hover Active
	if($('.box-hover-active').length>0){
		$('.box-hover-active').each(function(){
			$(this).find('.item-hover-active').on('mouseover',function(){
				$(this).parents('.box-hover-active').find('.item-hover-active').removeClass('active');
				$(this).addClass('active');
			});
			$(this).on('mouseout',function(){
				$(this).find('.item-hover-active').removeClass('active');
				$(this).find('.item-active').addClass('active');
			});
		});
	}	
	//Custom ScrollBar
	if($('.custom-scroll').length>0){
		$('.custom-scroll').each(function(){
			$(this).mCustomScrollbar({
				advanced:{
					autoScrollOnFocus: false,
				}  
			});
		});
	}
	//Horizontal Custom ScrollBar
	if($('.hoz-custom-scroll').length>0){
		$('.hoz-custom-scroll').each(function(){
			$(this).mCustomScrollbar({
				horizontalScroll:true,
			});
		});
	}
	//Animate
	if($('.wow').length>0){
		new WOW().init();
	}
	//Light Box
	if($('.fancybox').length>0){
		$('.fancybox').fancybox();	
	}
	if($('.fancybox-media').length>0){
		$('.fancybox-media').fancybox({
			openEffect : 'none',
			closeEffect : 'none',
			prevEffect : 'none',
			nextEffect : 'none',
			arrows : false,
			helpers : {
				media : {},
				buttons : {}
			}
		});
	}
	//Back To Top
	$('.scroll-top').on('click',function(event){
		event.preventDefault();
		$('html, body').animate({scrollTop:0}, 'slow');
	});
	//Box Hover Dir
	$('.box-hover-dir').each( function() {
		$(this).hoverdir(); 
	});
	//Background Image
	if($('.banner-background').length>0){
		$('.banner-background').each(function(){
			var b_url = $(this).attr("data-image");
			$(this).css('background-image','url("'+b_url+'")');	
		});
	}
	//Box Parallax	
	if($('.parallax').length>0){
		$('.parallax').each(function(){
			var p_url = $(this).attr("data-image");
			$(this).css('background-image','url("'+p_url+'")');	
		});
	}
	//Fancybox
	if($('.fancybox-buttons').length>0){
		$('.fancybox-buttons').fancybox({
			openEffect  : 'none',
			closeEffect : 'none',

			prevEffect : 'none',
			nextEffect : 'none',

			closeBtn  : false,

			helpers : {
				title : {
					type : 'inside'
				},
				buttons	: {}
			},

			afterLoad : function() {
				this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
			}
		});
	}
});
//Offset Menu
function offset_menu(){
	if($(window).width()>767){
		$('.main-nav .sub-menu').each(function(){
			var wdm = $(window).width();
			var wde = $(this).width();
			var offset = $(this).offset().left;
			var tw = offset+wde;
			if(tw>wdm){
				$(this).addClass('offset-right');
			}
		});
	}else{
		return false;
	}
}
//Fixed Header
function fixed_header(){
	if($('.header-ontop').length>0){
		if($(window).width()>1023){
			var ht = $('#header').height();
			var st = $(window).scrollTop();
			if(st>ht){
				$('.header-ontop').addClass('fixed-ontop');
			}else{
				$('.header-ontop').removeClass('fixed-ontop');
			}
		}else{
			$('.header-ontop').removeClass('fixed-ontop');
		}
	}
} 
//Slider Background
function background(){
	$('.bg-slider .item-slider').each(function(){
		var src=$(this).find('.banner-thumb a img').attr('src');
		$(this).css('background-image','url("'+src+'")');
	});	
}
//After Action
function afterAction(){
	
	$('.banner-slider .owl-item').each(function(){
		var check = $(this).hasClass('active');
		if(check==true){
			$(this).find('.animated').each(function(){
				var anime = $(this).attr('data-animated');
				$(this).addClass(anime);
			});
		}else{
			$(this).find('.animated').each(function(){
				var anime = $(this).attr('data-animated');
				$(this).removeClass(anime);
			});
		}
	});
	
	var owl = this;
	var visible = this.owl.visibleItems;
	var first_item = visible[0];
	var last_item = visible[visible.length-1];
	this.$elem.find('.owl-item').removeClass('first-item');
	this.$elem.find('.owl-item').removeClass('last-item');
	this.$elem.find('.owl-item').eq(first_item).addClass('first-item');
	this.$elem.find('.owl-item').eq(last_item).addClass('last-item');	
}
function slick_animated(){
	$('.banner-slick .item-slider').each(function(){
		var check = $(this).hasClass('slick-active');
		if(check==true){
			$(this).find('.animated').each(function(){
				var anime = $(this).attr('data-animated');
				$(this).addClass(anime);
			});
		}else{
			$(this).find('.animated').each(function(){
				var anime = $(this).attr('data-animated');
				$(this).removeClass(anime);
			});
		}
	});
}
//Detail Gallery
function detail_gallery(){
	if($('.detail-gallery').length>0){
		$('.detail-gallery').each(function(){
			var data=$(this).find(".carousel").data();
			$(this).find(".carousel").jCarouselLite({
				btnNext: $(this).find(".gallery-control .next"),
				btnPrev: $(this).find(".gallery-control .prev"),
				speed: 800,
				visible:data.visible,
				vertical:data.vertical,
			});
			//Remove zoom instance from image
			$.removeData($('.detail-gallery .mid img'), 'elevateZoom');
			$('.zoomContainer').remove();
			//Elevate Zoom
			$(this).find('.mid img').elevateZoom({
				zoomType: "lens",
				lensShape: "square",
				lensSize: 100,
				borderSize:1,
				containLensZoom:true
			});
			
			$(this).find(".carousel a").on('click',function(event) {
				event.preventDefault();
				$(this).parents('.detail-gallery').find(".carousel a").removeClass('active');
				$(this).addClass('active');
				$(this).parents('.content-product-detail').find('.swatches-support .variations .tawcvs-swatches .swatch').removeClass('selected');
				var z_url =  $(this).find('img').attr("src");
				var srcset =  $(this).find('img').attr("srcset");
				$(this).parents('.detail-gallery').find(".mid img").attr("src", z_url);
				$(this).parents('.detail-gallery').find(".mid img").attr("srcset", srcset);
				$('.zoomLens').css('background-image','url("'+z_url+'")');
			});
		});
	}
}
//Fix Detail Info
function detail_fixed(){
	if($(window).width()>767){
		if($('.detail-float').length>0){
			var seff = $('.detail-float').parents('.fixed-detail-info > .row');
			var ot = seff.offset().top;
			var sh = seff.height();
			var height = $('.detail-float').map(function (){
				return $(this).height();
			}).get();
			var dh = Math.max.apply(null, height);
			var st = $(window).scrollTop();
			var top = $(window).scrollTop() - ot + $('#wpadminbar').height();
			if(st>ot&&st<ot+sh-dh){
				seff.addClass('onscroll');
				$('.onscroll .detail-float').css('top',top+'px');
			}
			else if(st<ot) $('.detail-float').css('top',0);
			else seff.removeClass('onscroll');
		}
	}else{
		$('.detail-float').css('top',0);
	}
}
//Menu Responsive
function menu_responsive(){
	if($(window).width()<768){
		if($('.btn-toggle-mobile-menu').length>0){
			return false;
		}else{
			$('.main-nav li.menu-item-has-children,.main-nav li.has-mega-menu').append('<span class="btn-toggle-mobile-menu"></span>');
			$('.main-nav .btn-toggle-mobile-menu').on('click',function(event){
				$(this).toggleClass('active');
				$(this).prev().stop(true,false).slideToggle();
			});
		}
	}else{
		$('.btn-toggle-mobile-menu').remove();
		$('.main-nav .sub-menu,.main-nav .mega-menu').slideDown();
	}
}
//Document Ready
jQuery(document).ready(function(){
	//Featured Product Tab
	if($('.featured-product2').length>0){
		$('.inner-tab-control a').on('click',function(event){
			event.preventDefault();
			var control = $(this).attr('data-control');
			$('.inner-tab-control a').removeClass('active');
			$(this).addClass('active');
			$('.featured-tab2 .bx-slider').each(function(){
				if($(this).attr('id')==control){
					$(this).addClass('active');
				}else{
					$(this).removeClass('active');
				}
			});
		});
	}
	//Toggle Filter
	if($('.car-filter').length>0){
		$('.car-filter').each(function(){
			$(this).find('.title-car-filter').on('click',function(){
				$(this).toggleClass('active');
				$(this).next().slideToggle();
			});
		});
	}
	//Detail Gallery
	detail_gallery();
	detail_fixed();
	//Offset Menu
	offset_menu();
	menu_responsive();
});
//Window Load
jQuery(window).on('load',function(){ 
	fix_css_append();
	//Pre Load
	$('body').removeClass('preload'); 
	//Owl Carousel
	if($('.wrap-item').length>0){
		$('.wrap-item').each(function(){
			var data = $(this).data();
			$(this).owlCarousel({
				addClassActive:true,
				stopOnHover:true,
				lazyLoad:true,
				itemsCustom:data.itemscustom,
				autoPlay:data.autoplay,
				transitionStyle:data.transition, 
				paginationNumbers:data.paginumber,
				beforeInit:background,
				afterAction:afterAction,
				navigationText:['<i class="icon ion-android-arrow-back"></i>','<i class="icon ion-android-arrow-forward"></i>'],
			});
		});
	}
	//Parallax Slider
	if($('.parallax-slider').length>0){
		$(window).scroll(function() {
			var ot = $('.parallax-slider').offset().top;
			var sh = $('.parallax-slider').height();
			var st = $(window).scrollTop();
			var top = (($(window).scrollTop() - ot) * 0.5) + 'px';
			if(st>ot&&st<ot+sh){
				$('.parallax-slider .item-slider').css({
					'background-position': 'center ' + top
				});
			}else{
				$('.parallax-slider .item-slider').css({
					'background-position': 'center 0'
				});
			}
		});
	}
	//Slick Slider
	if($('.banner-slick .slick').length>0){
		$('.banner-slick .slick').each(function(){
			slick_animated();
			$(this).slick({
				centerMode: true,
				centerPadding: '60px',
				slidesToShow: 1,
				autoplay:true,
				prevArrow:'<span class="slick-prev"><i class="icon ion-android-arrow-back"></i></span>',
				nextArrow:'<span class="slick-next"><i class="icon ion-android-arrow-forward"></i></span>',
				responsive: [
					{
					  breakpoint: 767,
					  settings: {
						centerPadding: '0px',
					  }
					}
				  ]
			});
			$('.slick').on('afterChange', function(event){
				slick_animated();
			});
		});
	}
	//Bx Slider
	if($('.bx-slider').length>0){
		$('.bx-slider').each(function(){
			$(this).find('.bxslider').bxSlider({
				prevText:'<i class="icon ion-android-arrow-back"></i>',
				nextText:'<i class="icon ion-android-arrow-forward"></i>',
				pagerCustom: $(this).find('.bx-pager'),
			});
		});
	}
	//Time Countdown
	if($('.time-countdown').length>0){
		$(".time-countdown").each(function(){
			var data = $(this).data(); 
			$(this).TimeCircles({
				fg_width: data.width,
				bg_width: 0,
				text_size: 0,
				circle_bg_color: data.bg,
				time: {
					Days: {
						show: data.day,
						text: data.text[0],
						color: data.color,
					},
					Hours: {
						show: data.hou,
						text: data.text[1],
						color: data.color,
					},
					Minutes: {
						show: data.min,
						text: data.text[2],
						color: data.color,
					},
					Seconds: {
						show: data.sec,
						text: data.text[3],
						color: data.color,
					}
				}
			}); 
		});
	}
	//Count Down Master
	if($('.countdown-master').length>0){
		$('.countdown-master').each(function(){
			var seconds = Number($(this).attr('data-time'));
			$(this).FlipClock(seconds,{
				clockFace: 'DailyCounter',
				countdown: true,
				autoStart: true,
			});
		});
	}
	//List Item Masonry 
	if($('.list-item-masonry').length>0){
		$('.list-item-masonry').masonry({
			itemSelector: '.item-masonry',
		});
	}
	//Percentage
	$('.percentage').each(function(){
		var data = $(this).data();
		$(this).circularloader({
			backgroundColor: "#ffffff",//background colour of inner circle
			fontColor: "#000000",//font color of progress text
			fontSize: "40px",//font size of progress text
			radius: 90,//radius of circle
			progressBarBackground: "#e9e9e9",//background colour of circular progress Bar
			progressBarColor: data.color,//colour of circular progress bar
			progressBarWidth: 10,//progress bar width
			progressPercent: data.value,//progress percentage out of 100
			progressValue:0,//diplay this value instead of percentage
			showText: false,//show progress text or not
			title: "",//show header title for the progress bar
		});
	});
	//Twenty Compare
	if($('.twentytwenty-container').length>0){
		$('.twentytwenty-container').each(function(){
			var data = $(this).data();
			$(this).twentytwenty({
				orientation: data.orient,//horizontal,vertical
				default_offset_pct:data.offset,//Default:0.5
				before_label: data.before,//Default:Before
				after_label: data.after,//Default:After
			});
		});
	}
});
//Window Resize
jQuery(window).on('resize',function(){
	offset_menu();
	fixed_header();
	detail_fixed();
	menu_responsive();
});
//Window Scroll
jQuery(window).on('scroll',function(){
	//Scroll Top
	if($(this).scrollTop()>$(this).height()){
		$('.scroll-top').addClass('active');
	}else{
		$('.scroll-top').removeClass('active');
	}
	//Fixed Header
	fixed_header();
	detail_fixed();
});

})(jQuery); // End of use strict