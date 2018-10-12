(function($){
    "use strict"; // Start of use strict  

    /************** FUNCTION ****************/ 
	// fix append css
    function fix_css_append(){
		var css_data = $('#s7upf-theme-style-inline-css').html();
		$('#s7upf-theme-style-inline-css').remove();
	    if(css_data) $('head').append('<'+'style id="s7upf-theme-style-inline-css">'+css_data+'</style>');
    }
    function auto_width_megamenu(){
    	if($(window).width()>767){
	        if($('.main-nav').length > 0){
		        var main_menu_width = parseInt($('.main-nav').innerWidth());
		        var main_menu_left = parseInt($('.main-nav').offset().left);
		        $('.main-nav > ul > li.has-mega-menu').each(function(){
		        	if($(this).find('.mega-menu').length > 0){
				        var mega_menu_width = parseInt($(this).find('.mega-menu').innerWidth());
				        var li_width = parseInt($(this).innerWidth());
				        var mega_menu_left = $(this).find('.mega-menu').offset().left;
				        var li_left = $(this).offset().left;
				        var pos = li_left - mega_menu_left - mega_menu_width/2 + li_width/2;
				        var pos2 = pos + mega_menu_left + mega_menu_width - main_menu_left - main_menu_width;
				        if(pos2 > 0 ) pos = pos - pos2;
				        if(pos > 0) $(this).find('.mega-menu').css('left',pos);
				    }
		        })
		    }
	    }
    }
    // Letter popup
    function letter_popup(){
    	//Popup letter
		var content = $('#boxes-content').html();
		$('#boxes-content').html('');
		if(content) $('body').append('<div id="boxes">'+content+'</div>');
		if($('#boxes').html() != ''){
			var id = '#dialog';	
			//Get the screen height and width
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
		
			//Set heigth and width to mask to fill up the whole screen
			$('#mask').css({'width':maskWidth,'height':maskHeight});
			
			//transition effect		
			$('#mask').fadeIn(500);	
			$('#mask').fadeTo("slow",0.9);	
		
			//Get the window height and width
			var winH = $(window).height();
			var winW = $(window).width();
	              
			//Set the popup window to center
			$(id).css('top',  winH/2-$(id).height()/2);
			$(id).css('left', winW/2-$(id).width()/2);
		
			//transition effect
			$(id).fadeIn(2000); 	
		
			//if close button is clicked
			$('.window .close-popup').on('click',function (e) {
				//Cancel the link behavior
				e.preventDefault();
				
				$('#mask').hide();
				$('.window').hide();
			});		
			
			//if mask is clicked
			$('#mask').on('click',function () {
				$(this).hide();
				$('.window').hide();
			});
		}
		//End popup letter
    }
    function s7upf_qty_click(){
    	//QUANTITY CLICK
		$("body").on("click",".quantity .qty-up",function(){
            var min = $(this).prev().attr("min");
            var max = $(this).prev().attr("max");
            var step = $(this).prev().attr("step");
            if(step === undefined) step = 1;
            if(max !==undefined && Number($(this).prev().val())< Number(max) || max === undefined || max === ''){ 
                if(step!='') $(this).prev().val(Number($(this).prev().val())+Number(step));
            }
            $( 'div.woocommerce > form .button[name="update_cart"]' ).prop( 'disabled', false );
            return false;
        })
        $("body").on("click",".quantity .qty-down",function(){
            var min = $(this).next().attr("min");
            var max = $(this).next().attr("max");
            var step = $(this).next().attr("step");
            if(step === undefined) step = 1;
            if(Number($(this).next().val()) > 1){
	            if(min !==undefined && $(this).next().val()>min || min === undefined || min === ''){
	                if(step!='') $(this).next().val(Number($(this).next().val())-Number(step));
	            }
	        }
	        $( 'div.woocommerce > form .button[name="update_cart"]' ).prop( 'disabled', false );
	        return false;
        })
        $("body").on("keyup change","input.qty-val",function(){
        	$( 'div.woocommerce > form .button[name="update_cart"]' ).prop( 'disabled', false );
        })
		//END
    }
	//Begin Tool_panel_color
    function createCookie(name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else var expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
    }
    function switchStylestyle(styleName,color_rgb_new) {
        var color_old = $('.list-main-color li:first-child .styleswitch').attr("data-color");
        var color_rgb = $('.list-main-color li:first-child .styleswitch').css("background-color");
        var color=styleName;
        var new_css=st_demo_css.color;
        var re = new RegExp(color_old, 'g');
        new_css = new_css.replace(re, color);
        color_rgb = color_rgb.replace(')', '');
        color_rgb = color_rgb.replace('rgb(', '');
        var re2 = new RegExp(color_rgb, 'g');
        new_css = new_css.replace(re2, color_rgb_new);
        $('#s7upf-theme-style-inline-css').html(new_css);

        //createCookie('style', styleName, 365);
    }
    function tool_panel_color(){
        $('.dm-open-color').on('click',function(){
            $('#widget_indexdm_color').toggleClass('active');
            return false;
        })
        $('.styleswitch').on('click',function () {
            var color = $(this).attr("data-color");
			console.log(color);
            var color_rgb_new = $(this).css("background-color");
			// console.log(color_rgb_new);
            switchStylestyle(color,color_rgb_new);
            $(this).parents('.list-main-color').find('li').removeClass('active');
            $(this).parent().toggleClass('active');
            return false;
        })
    }
    // End Tool_panel_color

    /************ END FUNCTION **************/  
	$(document).ready(function(){
		$('.add-review').on('click',function(event){
			event.preventDefault();
			if($("#sv-reviews").length > 0){
	        	$('a[href="#sv-reviews"]').trigger('click');
	        	$('html, body').animate({scrollTop:$("#review_form").offset().top-50}, 'slow');
	        }
		});
		$('.custom-price-filter').on('click',function(event){
			event.preventDefault();
			$('input[name="min_price"]').val($(this).attr('data-min'));
			$('input[name="max_price"]').val($(this).attr('data-max'));
			$('.range-filter form').submit();
		})
		// price percent
		$('.price-percent').each(function(){
			var sale_html = $(this).find('.sale-content').html();
			$(this).find('.sale-content').remove();
			$(sale_html).insertAfter( $(this).find('.product-price').find('ins'));
		})
		//Menu Responsive 
		letter_popup();
		s7upf_qty_click();
		tool_panel_color();
		//Fix mailchimp
        $('.sv-mailchimp-form').each(function(){
            var placeholder = $(this).attr('data-placeholder');
            var submit = $(this).attr('data-submit');
            if(placeholder) $(this).find('input[name="EMAIL"]').attr('placeholder',placeholder);
            if(submit) $(this).find('input[type="submit"]').val(submit);
        })
		//Count item cart
        if($("#count-cart-item").length){
            var count_cart_item = $("#count-cart-item").val();
            $(".cart-item-count").html(count_cart_item);
        }        
		
	});

	$(window).on('load',function(){ 
		fix_css_append();
		auto_width_megamenu();
		//Filter Price
		if($('.range-filter').length>0){
			var min = Number($( ".range-filter .slider-range" ).attr('data-min'));
			var max = Number($( ".range-filter .slider-range" ).attr('data-max'));
			var current_min = Number($( ".range-filter .slider-range" ).attr('data-current_min'));
			var current_max = Number($( ".range-filter .slider-range" ).attr('data-current_max'));
			$( ".range-filter .slider-range" ).slider({
				range: true,
				min: min,
				max: max,
				values: [ current_min, current_max ],
				slide: function( event, ui ) {
					$( ".range-filter .amount" ).html( "<span class='number'>" + ui.values[ 0 ] + "</span>" + "<span class='separate'> - </span>" + "<span class='number'>" + ui.values[ 1 ] + "</span>" );
					$('.price-min-filter').val(ui.values[ 0 ]);
					$('.price-max-filter').val(ui.values[ 1 ]);
				}
			});
			$( ".range-filter .amount" ).html( "<span class='number'>" + $( ".range-filter .slider-range" ).slider( "values", 0 )+ "</span>" + " <span class='separate'> - </span> " + "<span class='number'>" + $( ".range-filter .slider-range" ).slider( "values", 1 ) + "</span>" );
		}
		
         //rtl-enable
        if($('.rtl-enable').length > 0){
            $('*[data-vc-full-width="true"]').each(function(){
            	var pleft = $(this).css('padding-left');
            	pleft = parseFloat(pleft) - 15;
            	$(this).css('padding-left',pleft);
            })
        }
		//menu fix
		if($(window).width() >= 768){
			var c_width = $(window).width();
			$('.main-nav ul ul ul.sub-menu').each(function(){
				var left = $(this).offset().left;
				if(c_width - left < 180){
					$(this).css({"left": "-100%"})
				}
				if(left < 180){
					$(this).css({"left": "100%"})
				}
			})
		}
	});  
	// End Load
	/* ---------------------------------------------
     Scripts resize
     --------------------------------------------- */
    var w_width = $(window).width();
    $(window).resize(function(){
    	auto_width_megamenu();
    	if($('#dialog').length > 0){
	    	// popup resize
			var id = '#dialog';	
			//Get the screen height and width
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
		
			//Set heigth and width to mask to fill up the whole screen
			$('#mask').css({'width':maskWidth,'height':maskHeight});
		
			//Get the window height and width
			var winH = $(window).height();
			var winW = $(window).width();
	              
			//Set the popup window to center
			$(id).css('top',  winH/2-$(id).height()/2);
			$(id).css('left', winW/2-$(id).width()/2);
		}
        $("#header").css('min-height','');
        var c_width = $(window).width();
        setTimeout(function() {
            if($('.rtl-enable').length > 0 && c_width != w_width){
                $('*[data-vc-full-width="true"]').each(function(){
                	var pleft = $(this).css('padding-left');
	            	pleft = parseFloat(pleft) - 15;
	            	$(this).css('padding-left',pleft);
                })
                w_width = c_width;
            }
        }, 2000);
    });

})(jQuery);