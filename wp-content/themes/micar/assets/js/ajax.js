(function($){
    "use strict";
    $(document).ready(function() {
		//Update cart
        $('.button[name="update_cart"],.product-remove a.remove').live('click', function(e){   
            $( document ).ajaxComplete(function( event, xhr, settings ) {
                if(settings.url.indexOf('?wc-ajax=get_refreshed_fragments') != -1){
                    $.ajax({
                        type: 'POST',
                        url: ajax_process.ajaxurl,                
                        crossDomain: true,
                        data: { 
                            action: 'update_mini_cart',
                        },
                        success: function(data){
                            // Load html
                            var cart_content = data.fragments['div.widget_shopping_cart_content'];
                            $('.mini-cart-main-content').html(cart_content);
                            $('.widget_shopping_cart_content').html(cart_content);
                            // set count
                            var count_item = cart_content.split("item-info-cart").length;
                            $('.set-cart-number').html(count_item-1);
                            // set Price
                            var price = $('.mini-cart-main-content').find('.get-cart-price').html();
                            console.log(price);
                            if(price) $('.set-cart-price').html(price);
                            else $('.set-cart-price').html($('.total-default').html());
                        },
                        error: function(MLHttpRequest, textStatus, errorThrown){  
                            console.log(errorThrown);  
                        }
                    });
                }
            });        
            
        });
		//Live search
		$('.live-search-on input[name="s"]').on('click',function(event){
            event.preventDefault();
            event.stopPropagation();
            $(this).parents('.live-search-on').addClass('active');
        })
        $('body').on('click',function(event){
            $('.live-search-on.active').removeClass('active');
        })
        $('.live-search-on input[name="s"]').on('keyup',function(){
            var key = $(this).val();
            var trim_key = key.trim();
		    var cat = $(this).parents('.live-search-on').find('.cat-value').val();
		    var post_type = $(this).parents('.live-search-on').find('input[name="post_type"]').val();
		    var self = $(this);
		    var content = self.parent().find('.list-product-search');
		    content.html('<i class="fa fa-spinner fa-spin"></i>');
		    content.addClass('ajax-loading');
		    $.ajax({
				type : "post",
				url : ajax_process.ajaxurl,
				crossDomain: true,
				data: {
					action: "live_search",
					key: key,
					cat: cat,
					post_type: post_type,
				},
				success: function(data){
					content.removeClass('ajax-loading');
					if(data[data.length-1] == '0' ){
						data = data.split('');
						data[data.length-1] = '';
						data = data.join('');
					}
					content.html(data);
				},
				error: function(MLHttpRequest, textStatus, errorThrown){                    
					console.log(errorThrown);  
				}
			});
        })
        // Wishlist ajax
        $('.wishlist-close').on('click',function(){
            $('.wishlist-mask').fadeOut();
        })
        $('.add_to_wishlist').live('click',function(){
            $('.wishlist-countdown').html('5');
            $(this).addClass('added');
            var product_id = $(this).attr("data-product-id");
            var product_title = $(this).attr("data-product-title");
            $('.wishlist-title').html(product_title);
            $('.wishlist-mask').fadeIn();
            var counter = 5;
            var popup;
            popup = setInterval(function() {
                counter--;
                if(counter < 0) {
                    clearInterval(popup);
                    $('.wishlist-mask').hide();
                } else {
                    $(".wishlist-countdown").text(counter.toString());
                }
            }, 1000);
        })
        
        // Woocommerce Ajax
        $("body").on("click",".add_to_cart_button:not(.product_type_variable)",function(e){
            e.preventDefault();
            var product_id = $(this).attr("data-product_id");
            var self = $(this);
            self.append('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type : "post",
                url : ajax_process.ajaxurl,
                crossDomain: true,
                data: {
                    action: "add_to_cart",
                    product_id: product_id
                },
                success: function(data){
                    self.find('.fa-spinner').remove();
                    var cart_content = data.fragments['div.widget_shopping_cart_content'];
                    $('.mini-cart-main-content').html(cart_content);
                    $('.widget_shopping_cart_content').html(cart_content);
                    var count_item = cart_content.split("<li").length;
                    $('.cart-item-count').html(count_item-1);
                    var price = $('.mini-cart-content').find('.mini-cart-total').find('.total-price').html();
                    $('.total-mini-cart-price').html(price);
                },
                error: function(MLHttpRequest, textStatus, errorThrown){                    
                    console.log(errorThrown);  
                }
            });
        });

        $('body').on('click', '.btn-remove', function(e){
            e.preventDefault();
            var cart_item_key = $(this).parents('.item-info-cart').attr("data-key");
            var element = $(this).parents('.item-info-cart');
            var currency = ["د.إ","лв.","kr.","Kr.","Rs.","руб."];
            var decimal = $(".num-decimal").val();
            function get_currency(pricehtml){
                var check,index,price,i;
                for(i = 0;i<6;i++){
                    if(pricehtml.search(currency[i]) != -1)  {
                        check = true;
                        index = i;
                    }
                }
                if(check) price =  pricehtml.replace(currency[index],"");
                else price = pricehtml.replace(/[^0-9\.]+/g,"");
                return price;
            }
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'product_remove',
                    cart_item_key: cart_item_key
                },
                success: function(data){
                    var price_html = element.find('span.amount').html();
                    var price = get_currency(price_html);
                    var qty = element.find('.qty-product').find('span.qty-num').html();
                    var price_remove = price*qty;
                    var current_total_html = $(".total-price").find(".amount").html();
                    var current_total = get_currency(current_total_html);
                    var new_total = current_total-price_remove;
                    new_total = parseFloat(new_total).toFixed(Number(decimal));
                    current_total_html = current_total_html.replace(',','');
                    var new_total_html = current_total_html.replace(current_total,new_total);
                    element.slideUp().remove();
                    $(".total-price").find(".amount").html(new_total_html);
                    $(".total-mini-cart-price").html(new_total_html);
                    var current_html = $('.cart-item-count').html();
                    $('.cart-item-count').html(current_html-1);
                    $('.item-info-cart[data-key="'+cart_item_key+'"]').remove();
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });
        $('body').on('click','.product-quick-view', function(e){
            e.preventDefault;
            $('body').addClass('on-hover-thumb');
            $.fancybox.showLoading();
            var product_id = $(this).attr('data-product-id');
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'product_popup_content',
                    product_id: product_id
                },
                success: function(res){
                    if(res[res.length-1] == '0' ){
                        res = res.split('');
                        res[res.length-1] = '';
                        res = res.join('');
                    }
                    $.fancybox.hideLoading();
                    $.fancybox(res, {
                        width: 1000,
                        height: 600,
                        autoSize: false,
                        onStart: function(opener) {                            
                            if ($(opener).attr('id') == 'login') {
                                $.get('/hicommon/authenticated', function(res) { 
                                    if ('yes' == res) {
                                      console.log('this user must have already authenticated in another browser tab, SO I want to avoid opening the fancybox.');
                                      return false;
                                    } else {
                                      console.log('the user is not authenticated');
                                      return true;
                                    }
                                }); 
                            }
                        },
                    });
                    /*!
 * Variations Plugin
 */
!function(a,b,c,d){a.fn.wc_variation_form=function(){var c=this,f=c.closest(".product"),g=parseInt(c.data("product_id"),10),h=c.data("product_variations"),i=h===!1,j=!1,k=c.find(".reset_variations");return c.unbind("check_variations update_variation_values found_variation"),c.find(".reset_variations").unbind("click"),c.find(".variations select").unbind("change focusin"),c.on("click",".reset_variations",function(){return c.find(".variations select").val("").change(),c.trigger("reset_data"),!1}).on("reload_product_variations",function(){h=c.data("product_variations"),i=h===!1}).on("reset_data",function(){var b={".sku":"o_sku",".product_weight":"o_weight",".product_dimensions":"o_dimensions"};a.each(b,function(a,b){var c=f.find(a);c.attr("data-"+b)&&c.text(c.attr("data-"+b))}),c.wc_variations_description_update(""),c.trigger("reset_image"),c.find(".single_variation_wrap").slideUp(200).trigger("hide_variation")}).on("reset_image",function(){var a=f.find("div.images img:eq(0)"),b=f.find("div.images a.zoom:eq(0)"),c=a.attr("data-o_src"),e=a.attr("data-o_title"),g=a.attr("data-o_title"),h=b.attr("data-o_href");c!==d&&a.attr("src",c),h!==d&&b.attr("href",h),e!==d&&(a.attr("title",e),b.attr("title",e)),g!==d&&a.attr("alt",g)}).on("change",".variations select",function(){if(c.find('input[name="variation_id"], input.variation_id').val("").change(),c.find(".wc-no-matching-variations").remove(),i){j&&j.abort();var b=!0,d=!1,e={};c.find(".variations select").each(function(){var c=a(this).data("attribute_name")||a(this).attr("name");0===a(this).val().length?b=!1:d=!0,e[c]=a(this).val()}),b?(e.product_id=g,j=a.ajax({url:wc_cart_fragments_params.wc_ajax_url.toString().replace("%%endpoint%%","get_variation"),type:"POST",data:e,success:function(a){a?(c.find('input[name="variation_id"], input.variation_id').val(a.variation_id).change(),c.trigger("found_variation",[a])):(c.trigger("reset_data"),c.find(".single_variation_wrap").after('<p class="wc-no-matching-variations woocommerce-info">'+wc_add_to_cart_variation_params.i18n_no_matching_variations_text+"</p>"),c.find(".wc-no-matching-variations").slideDown(200))}})):c.trigger("reset_data"),d?"hidden"===k.css("visibility")&&k.css("visibility","visible").hide().fadeIn():k.css("visibility","hidden")}else c.trigger("woocommerce_variation_select_change"),c.trigger("check_variations",["",!1]),a(this).blur();c.trigger("woocommerce_variation_has_changed")}).on("focusin touchstart",".variations select",function(){i||(c.trigger("woocommerce_variation_select_focusin"),c.trigger("check_variations",[a(this).data("attribute_name")||a(this).attr("name"),!0]))}).on("found_variation",function(a,b){var e=f.find("div.images img:eq(0)"),g=f.find("div.images a.zoom:eq(0)"),h=e.attr("data-o_src"),i=e.attr("data-o_title"),j=e.attr("data-o_alt"),k=g.attr("data-o_href"),l=b.image_src,m=b.image_link,n=b.image_caption,o=b.image_title;c.find(".single_variation").html(b.price_html+b.availability_html),h===d&&(h=e.attr("src")?e.attr("src"):"",e.attr("data-o_src",h)),k===d&&(k=g.attr("href")?g.attr("href"):"",g.attr("data-o_href",k)),i===d&&(i=e.attr("title")?e.attr("title"):"",e.attr("data-o_title",i)),j===d&&(j=e.attr("alt")?e.attr("alt"):"",e.attr("data-o_alt",j)),l&&l.length>1?(e.attr("src",l).attr("alt",o).attr("title",o),g.attr("href",m).attr("title",n)):(e.attr("src",h).attr("alt",j).attr("title",i),g.attr("href",k).attr("title",i));var p=c.find(".single_variation_wrap"),q=f.find(".product_meta").find(".sku"),r=f.find(".product_weight"),s=f.find(".product_dimensions");q.attr("data-o_sku")||q.attr("data-o_sku",q.text()),r.attr("data-o_weight")||r.attr("data-o_weight",r.text()),s.attr("data-o_dimensions")||s.attr("data-o_dimensions",s.text()),b.sku?q.text(b.sku):q.text(q.attr("data-o_sku")),b.weight?r.text(b.weight):r.text(r.attr("data-o_weight")),b.dimensions?s.text(b.dimensions):s.text(s.attr("data-o_dimensions"));var t=!1,u=!1;b.is_purchasable&&b.is_in_stock&&b.variation_is_visible||(u=!0),b.variation_is_visible||c.find(".single_variation").html("<p>"+wc_add_to_cart_variation_params.i18n_unavailable_text+"</p>"),""!==b.min_qty?p.find(".quantity input.qty").attr("min",b.min_qty).val(b.min_qty):p.find(".quantity input.qty").removeAttr("min"),""!==b.max_qty?p.find(".quantity input.qty").attr("max",b.max_qty):p.find(".quantity input.qty").removeAttr("max"),"yes"===b.is_sold_individually&&(p.find(".quantity input.qty").val("1"),t=!0),t?p.find(".quantity").hide():u||p.find(".quantity").show(),u?p.is(":visible")?c.find(".variations_button").slideUp(200):c.find(".variations_button").hide():p.is(":visible")?c.find(".variations_button").slideDown(200):c.find(".variations_button").show(),c.wc_variations_description_update(b.variation_description),p.slideDown(200).trigger("show_variation",[b])}).on("check_variations",function(c,d,f){if(!i){var g=!0,j=!1,k={},l=a(this),m=l.find(".reset_variations");l.find(".variations select").each(function(){var b=a(this).data("attribute_name")||a(this).attr("name");0===a(this).val().length?g=!1:j=!0,d&&b===d?(g=!1,k[b]=""):k[b]=a(this).val()});var n=e.find_matching_variations(h,k);if(g){var o=n.shift();o?(l.find('input[name="variation_id"], input.variation_id').val(o.variation_id).change(),l.trigger("found_variation",[o])):(l.find(".variations select").val(""),f||l.trigger("reset_data"),b.alert(wc_add_to_cart_variation_params.i18n_no_matching_variations_text))}else l.trigger("update_variation_values",[n]),f||l.trigger("reset_data"),d||l.find(".single_variation_wrap").slideUp(200).trigger("hide_variation");j?"hidden"===m.css("visibility")&&m.css("visibility","visible").hide().fadeIn():m.css("visibility","hidden")}}).on("update_variation_values",function(b,d){i||(c.find(".variations select").each(function(b,c){var e,f=a(c);f.data("attribute_options")||f.data("attribute_options",f.find("option:gt(0)").get()),f.find("option:gt(0)").remove(),f.append(f.data("attribute_options")),f.find("option:gt(0)").removeClass("attached"),f.find("option:gt(0)").removeClass("enabled"),f.find("option:gt(0)").removeAttr("disabled"),e="undefined"!=typeof f.data("attribute_name")?f.data("attribute_name"):f.attr("name");for(var g in d)if("undefined"!=typeof d[g]){var h=d[g].attributes;for(var i in h)if(h.hasOwnProperty(i)){var j=h[i];if(i===e){var k="";d[g].variation_is_active&&(k="enabled"),j?(j=a("<div/>").html(j).text(),j=j.replace(/'/g,"\\'"),j=j.replace(/"/g,'\\"'),f.find('option[value="'+j+'"]').addClass("attached "+k)):f.find("option:gt(0)").addClass("attached "+k)}}}f.find("option:gt(0):not(.attached)").remove(),f.find("option:gt(0):not(.enabled)").attr("disabled","disabled")}),c.trigger("woocommerce_update_variation_values"))}),c.trigger("wc_variation_form"),c};var e={find_matching_variations:function(a,b){for(var c=[],d=0;d<a.length;d++){var f=a[d];e.variations_match(f.attributes,b)&&c.push(f)}return c},variations_match:function(a,b){var c=!0;for(var e in a)if(a.hasOwnProperty(e)){var f=a[e],g=b[e];f!==d&&g!==d&&0!==f.length&&0!==g.length&&f!==g&&(c=!1)}return c}};a.fn.wc_variations_description_update=function(b){var c=this,d=c.find(".woocommerce-variation-description");if(0===d.length)b&&(c.find(".single_variation_wrap").prepend(a('<div class="woocommerce-variation-description" style="border:1px solid transparent;">'+b+"</div>").hide()),c.find(".woocommerce-variation-description").slideDown(200));else{var e=d.outerHeight(!0),f=0,g=!1;d.css("height",e),d.html(b),d.css("height","auto"),f=d.outerHeight(!0),Math.abs(f-e)>1&&(g=!0,d.css("height",e)),g&&d.animate({height:f},{duration:200,queue:!1,always:function(){d.css({height:"auto"})}})}},a(function(){"undefined"!=typeof wc_add_to_cart_variation_params&&a(".variations_form").each(function(){a(this).wc_variation_form().find(".variations select:eq(0)").change()})})}(jQuery,window,document);
                    
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

                    //Fix product variable thumb        
                    $('body .variations_form select').live('change',function(){
                        var id = $('input[name="variation_id"]').val();
                        if(id){
                            console.log(id);
                            $('.gallery-control').find('li[data-variation_id="'+id+'"] a').trigger( 'click' );
                        }
                    });

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
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });        
            return false;
        })

        // end

        //Product Load More
        $('body').on('click', '.btn-load-more-ajax', function(event){
            event.preventDefault();
			var btn = $(this);
			$('.current-maxpage').remove();
			//Tax
			var select_tax = btn.parents('.product-box-filter').prev().find('select.select-taxonomy');
			var filter_tax = new Array();
			select_tax.each(function(){
				var val = $(this).val();
				var name = $(this).attr('name');
				var tax = name+':'+val;
				filter_tax.push(tax);
			});
			//Attr
			var select_attr = btn.parents('.product-box-filter').prev().find('select.select-attribute');
			var filter_attr = new Array();
			select_attr.each(function(){
				var val = $(this).val();
				var name = $(this).attr('name');
				var attr = name+':'+val;
				filter_attr.push(attr);
			});
            var content = btn.parents('.product-box-filter').find('.ajax-product-filter');
            btn.append('<div class="ajax-loading"><i class="fa fa-spinner fa-spin"></i></div>');
			
            var maxpage = parseInt(btn.attr('data-maxpage'),10);
            var number = parseInt(btn.attr('data-number'),10);
            var paged = parseInt(btn.attr('data-paged'),10);
			
            var order = btn.attr('data-order');
            var orderby = btn.attr('data-orderby');
            var product_type = btn.attr('data-type');
			var data_tax = filter_tax;
            var data_attr = filter_attr;
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'load_more_product',
                    order: order,
                    orderby: orderby,
                    number: number,
                    paged: paged,
					tax: data_tax,
					attr: data_attr,
                    product_type: product_type,
					check_filter:false
                },
                success: function(data){
                    content.find('.row').append(data);  
                    btn.find(".ajax-loading").remove();
					if(paged < maxpage){
						paged = paged + 1;
					}
					btn.attr('data-paged',paged);
					if(paged == maxpage){
						btn.parent().hide();
					}
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });
        //End Product Load More
		
        //Begin Car Filter
		$('body').on('click', '.btn-car-filter', function(event){
            event.preventDefault();
			var btn = $(this);
			$('.current-maxpage').remove();
			//Tax
			var select_tax = btn.parents('.car-filter-form').find('select.select-taxonomy');
			var filter_tax = new Array();
			select_tax.each(function(){
				var val = $(this).val();
				var name = $(this).attr('name');
				var tax = name+':'+val;
				filter_tax.push(tax);
			});
			//Attr
			var select_attr = btn.parents('.car-filter-form').find('select.select-attribute');
			var filter_attr = new Array();
			select_attr.each(function(){
				var val = $(this).val();
				var name = $(this).attr('name');
				var attr = name+':'+val;
				filter_attr.push(attr);
			});
            var content = btn.parents('.car-filter-form').next().find('.ajax-product-filter');
            content.addClass('loadding');
			content.append('<div class="ajax-loading"><i class="fa fa-spinner fa-spin"></i></div>');
            var number = parseInt(btn.parents('.car-filter-form').next().find('.btn-load-more-ajax').attr('data-number'),10);
            var maxpage = parseInt(btn.parents('.car-filter-form').next().find('.btn-load-more-ajax').attr('data-maxpage'),10);
			var paged = 1;
            var order = btn.parents('.car-filter-form').next().find('.btn-load-more-ajax').attr('data-order');
            var orderby = btn.parents('.car-filter-form').next().find('.btn-load-more-ajax').attr('data-orderby');
            var product_type = btn.parents('.car-filter-form').next().find('.btn-load-more-ajax').attr('data-type');
            var data_tax = filter_tax;
            var data_attr = filter_attr;
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'load_more_product',
					tax: data_tax,
					attr: data_attr,
					number: number,
                    paged: paged,
                    order: order,
                    orderby: orderby,
                    product_type: product_type,
					check_filter:true
                },
                success: function(data){
                    content.removeClass('loadding');
					content.find(".ajax-loading").remove();
                    content.find('.row').html(data);
					var current_maxpage = parseInt(content.find('.current-maxpage').val(),10);
					if(current_maxpage){
						maxpage=current_maxpage;
					}
					
					if(maxpage < 2){
						btn.parents('.car-filter-form').next().find('.btn-load-more-ajax').parent().hide();
					}else{
						btn.parents('.car-filter-form').next().find('.btn-load-more-ajax').parent().show();
						if(paged<maxpage){
							btn.parents('.car-filter-form').next().find('.btn-load-more-ajax').attr('data-paged',paged);
							btn.parents('.car-filter-form').next().find('.btn-load-more-ajax').attr('data-maxpage',maxpage);
						}
					}
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });	
        //End Car Filter
		
        //Begin Product Ajax Filter
		$('body').on('click', '.btn-filter-ajax', function(event){
            event.preventDefault();
			var btn = $(this);
			var select_item = btn.parents('.form-find-car').find('select');
			var filter = new Array();
			select_item.each(function(){
				var val = $(this).val();
				var name = $(this).attr('name');
				var fil = name+':'+val;
				filter.push(fil);
			});
            var content = btn.parents('.car-find').next().find('.wrap-item');
            content.parent().addClass('loadding');
			content.parent().append('<div class="ajax-loading"><i class="fa fa-spinner fa-spin"></i></div>');
            var order = btn.attr('data-order');
            var orderby = btn.attr('data-orderby');
            var product_type = btn.attr('data-type');
            var itemscustom = btn.attr('data-items');
            var limit = btn.attr('data-number');
            var data_filter = filter;
			
            $.ajax({
                type: 'POST',
                url: ajax_process.ajaxurl,                
                crossDomain: true,
                data: { 
                    action: 'filter_product_tax',
					filter: data_filter,
					limit: limit,
                    order: order,
                    orderby: orderby,
                    product_type: product_type,
                },
                success: function(data){
					content.data('owlCarousel').destroy();
                    content.html(data);
					//Owl Carousel
					var data1 = content.data();
					console.log(data1.itemscustom);
					var itemres = content.attr('data-itemscustom');
					itemres = itemres.split('],[');
					var i;
					for (i = 0; i < itemres.length; i++) {
						itemres[i] =  itemres[i].replace('[[','');
						itemres[i] =  itemres[i].replace(']]','');
						itemres[i] = itemres[i].split(',');
					}
					content.owlCarousel({
						addClassActive:true,
						stopOnHover:true,
						lazyLoad:true,
						navigation:true,
						pagination:false,
						itemsCustom:itemres,
						navigationText:['<i class="icon ion-android-arrow-back"></i>','<i class="icon ion-android-arrow-forward"></i>'],
					});
                    content.parent().removeClass('loadding');
					content.parent().find(".ajax-loading").remove();
                },
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    console.log(errorThrown);  
                }
            });
            return false;
        });	
        //End Product Ajax Filter
    });

})(jQuery);