<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 13/08/15
 * Time: 10:20 AM
 */
$main_color = s7upf_get_value_by_id('main_color');
$main_color2 = s7upf_get_value_by_id('main_color2');
$body_bg = s7upf_get_value_by_id('body_bg');
?>
<?php
$style = '';

if(!empty($body_bg)){
    $style .= 'body
    {background-color:'.$body_bg.'}'."\n";
}
/*****BEGIN MAIN COLOR*****/
if(!empty($main_color)){
	$style .= '.main-color,a:hover,a:focus,.color,.desc.color,.main-nav > ul > li > a:hover,.product-title a:hover,.popup-icon,.main-nav > ul > li:hover > a,.car-local .desc .icon ,.tab-control .shop-button:hover,.title-tab3 li .shop-button:hover,.item-video-highlight .adv-thumb-link:hover::after,.item-ads4.style2 .banner-info .link-circle.color .icon,.banner-bottom-info .btn-banner:hover,.pagi-nav a:hover,.widget_product_categories .product-categories > li.current-cat > a,.product-price>span.pagi-nav .current-page ,.list-category-toggle .item-toggle-tab.active .toggle-tab-title,.title-tab-detail li.active a,.main-nav > ul > li .sub-menu > li:hover > a,.item-cat-pro1 a:hover h3,.product-price ins,.content-product-detail  .add_to_wishlist::before,.post-comment-like a.sv-post-like:hover,.product-price>span,.content-product-detail .detail-extra-link .compare-link .icon,.content-product-detail  .detail-extra-link .compare-link:hover,.current-cat > a,.load-more-dark .item-product.style1:hover .product-info-top a.silver ,.load-more-dark .item-product.style1:hover .product-info-top h3.title18 a,.cat-product-light .item-cat-pro1:hover a h3,.list-adv1.bg-light .info-adv1 h3 a:hover
    {color: '.$main_color.' }'."\n"; 
    
    $style .= '.main-background,.bg-color,.currency-language .dropdown-list li a:hover,.preload #loading,.shop-button:hover,.shop-button.bg-color,.main-nav1 > ul > li.current-menu-item > a,.title-tab1 li.active a,.item-product.style1 .product-info-top .quickview-link,.item-product-list .quickview-link,.item-happend:hover .banner-info,.shop-button.bg-color2:hover,.profile-box .dropdown-list a:hover,.sort-pagi-bar .dropdown-list a:hover,.owl-theme .owl-controls .owl-page.active span,.owl-theme .owl-controls .owl-buttons div,.bx-controls .bx-controls-direction a,.banner-slick .slick-arrow,.item-product.style2 .wishlist-link,.item-product.style2 .compare-link,.bx-style .bx-pager a.active,.tab-control .shop-button.active,.owl-theme.rect-navi .owl-controls .owl-buttons div:hover,.item-policy3 .shop-button:hover,.title-tab3 li.active .shop-button,.item-service3:hover ,.item-ads4.style2 .banner-info .link-circle.color:hover,a.btn-banner:hover,.product-extra-link.style3 a:hover,.tab-title6 li.active a,.bread-crumb::before,.view-type a.active,.range-filter .ui-slider-range,.detail-tab-color .bx-pager a.active,.title-tab-detail li.active a::before,.content-about .blockquote::after,.form-newsletter:hover::after,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,.woocommerce .widget_price_filter .price_slider_amount .button,.detail-info .detail-extralink .single_add_to_cart_button.wc-variation-is-unavailable,.woocommerce #review_form #respond .form-submit input,.woocommerce table.shop_table td.actions input[type="submit"],.cart_totals.calculated_shipping a.checkout-button.button.alt.wc-forward,.form-row.place-order input[type="submit"],.main-nav .toggle-mobile-menu span, .main-nav .toggle-mobile-menu::before, .main-nav .toggle-mobile-menu::after,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce-MyAccount-navigation ul li a:hover,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,table.compare-list .add-to-cart td a:hover,.choose-main-color .dm-button,.cat-product-light .title-tab1 li.active a
    {background-color: '.$main_color.' }'."\n";

    $style .= '.main-border,.banner-collection .owl-theme .owl-controls .owl-page.active,a.btn-banner:hover,.product-extra-link.style3 a:hover,.owl-theme.border-pagi .owl-controls .owl-page.active span,.pagi-nav .current-page ,.pagi-nav a:hover,.range-filter .ui-slider-handle.ui-state-default.ui-corner-all,.content-about .blockquote,.block-quote,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.cat-product-light .title-tab1 li.active a
    {border-color: '.$main_color.' }'."\n";
	
	$style .= '.detail-extralink .single_add_to_cart_button
	{background-color: '.$main_color.' !important;}'."\n";
	
	list($r, $g, $b) = sscanf($main_color, "#%02x%02x%02x");

    $style .= '.item-happend .banner-info
    {background: rgba( '.$r.', '.$g.', '.$b.' , 0.5)}'."\n";

    $style .= '.item-ads4 .banner-info,.item-blog-adv4.overlay-image .adv-thumb-link::after 
    {background: rgba( '.$r.', '.$g.', '.$b.' , 0.9)}'."\n";

    $style .= '.range-filter .slider-range .ui-widget-header
    {background: rgba( '.$r.', '.$g.', '.$b.' , 0.8)}'."\n";
    $style .= '.text-gradient
    {background: -webkit-linear-gradient(rgba( '.$r.', '.$g.', '.$b.' , 0.5), rgba( '.$r.', '.$g.', '.$b.' , 1));-webkit-background-clip: text;}'."\n";
}
/*****END MAIN COLOR*****/

/*****BEGIN MAIN COLOR 2*****/
if(!empty($main_color2)){
	$style .= '.color2,.desc.color2
    {color:'.$main_color2.'}'."\n";
	
    $style .= '.bg-color2,.shop-button.bg-color2,.shop-button.bg-color:hover,.smart-search-form .submit-form:hover,.adv-slider1.line-white::after,.owl-theme .owl-controls .owl-buttons div:hover,.bx-controls .bx-controls-direction a:hover,.banner-slick .slick-arrow:hover,.item-product.style2 .wishlist-link:hover,.item-product.style2 .compare-link:hover,.item-service3:hover .shop-button,.item-product.style1 .product-info-top .quickview-link:hover,.item-product-list .quickview-link:hover,a.btn-banner.bg-color:hover,.tab-detail .item-toggle-tab.active .toggle-tab-title
    {background-color: '.$main_color2.'}'."\n";

    $style .= '.tab-detail .item-toggle-tab.active .toggle-tab-title
    {border-color: '.$main_color2.'}'."\n";
}
/*****END MAIN COLOR 2*****/

/*****BEGIN CUSTOM CSS*****/
$custom_css = s7upf_get_option('custom_css');
if(!empty($custom_css)){
    $style .= $custom_css."\n";
}

/*****END CUSTOM CSS*****/

/*****BEGIN MENU COLOR*****/
$menu_color = s7upf_get_option('s7upf_menu_color');
$menu_hover = s7upf_get_option('s7upf_menu_color_hover');
$menu_active = s7upf_get_option('s7upf_menu_color_active');
if(is_array($menu_color) && !empty($menu_color)){
    $style .= 'nav>li>a{';
    if(!empty($menu_color['font-color'])) $style .= 'color:'.$menu_color['font-color'].';';
    if(!empty($menu_color['font-family'])) $style .= 'font-family:'.$menu_color['font-family'].';';
    if(!empty($menu_color['font-size'])) $style .= 'font-size:'.$menu_color['font-size'].';';
    if(!empty($menu_color['font-style'])) $style .= 'font-style:'.$menu_color['font-style'].';';
    if(!empty($menu_color['font-variant'])) $style .= 'font-variant:'.$menu_color['font-variant'].';';
    if(!empty($menu_color['font-weight'])) $style .= 'font-weight:'.$menu_color['font-weight'].';';
    if(!empty($menu_color['letter-spacing'])) $style .= 'letter-spacing:'.$menu_color['letter-spacing'].';';
    if(!empty($menu_color['line-height'])) $style .= 'line-height:'.$menu_color['line-height'].';';
    if(!empty($menu_color['text-decoration'])) $style .= 'text-decoration:'.$menu_color['text-decoration'].';';
    if(!empty($menu_color['text-transform'])) $style .= 'text-transform:'.$menu_color['text-transform'].';';
    $style .= '}'."\n";
}
if(!empty($menu_hover)){
    $style .= 'nav>li>a:hover{color:'.$menu_hover.'}'."\n";
    $style .= 'nav>li>a:hover{background-color:'.$menu_hover.'}'."\n";
}
if(!empty($menu_active)){
    $style .= 'nav li.parent-current-menu-item>a{color:'.$menu_active.'}'."\n";
    $style .= 'nav li.current-menu-item >a{background-color:'.$menu_active.'}'."\n";
}

/*****END MENU COLOR*****/

/*****BEGIN TYPOGRAPHY*****/
$typo_data = s7upf_get_option('s7upf_custom_typography');
if(is_array($typo_data) && !empty($typo_data)){
    foreach ($typo_data as $value) {
        switch ($value['typo_area']) {
            case 'header':
                $style_class = '.site-header';
                break;

            case 'footer':
                $style_class = '.site-footer';
                break;

            case 'widget':
                $style_class = '.widget';
                break;
            
            default:
                $style_class = '#main-content';
                break;
        }
        $class_array = explode(',', $style_class);
        $new_class = '';
        if(is_array($class_array)){
            foreach ($class_array as $prefix) {
                $new_class .= $prefix.' '.$value['typo_heading'].',';
            }
        }
        if(!empty($new_class)) $style .= $new_class.' .nocss{';
        if(!empty($value['typography_style']['font-color'])) $style .= 'color:'.$value['typography_style']['font-color'].';';
        if(!empty($value['typography_style']['font-family'])) $style .= 'font-family:'.$value['typography_style']['font-family'].';';
        if(!empty($value['typography_style']['font-size'])) $style .= 'font-size:'.$value['typography_style']['font-size'].';';
        if(!empty($value['typography_style']['font-style'])) $style .= 'font-style:'.$value['typography_style']['font-style'].';';
        if(!empty($value['typography_style']['font-variant'])) $style .= 'font-variant:'.$value['typography_style']['font-variant'].';';
        if(!empty($value['typography_style']['font-weight'])) $style .= 'font-weight:'.$value['typography_style']['font-weight'].';';
        if(!empty($value['typography_style']['letter-spacing'])) $style .= 'letter-spacing:'.$value['typography_style']['letter-spacing'].';';
        if(!empty($value['typography_style']['line-height'])) $style .= 'line-height:'.$value['typography_style']['line-height'].';';
        if(!empty($value['typography_style']['text-decoration'])) $style .= 'text-decoration:'.$value['typography_style']['text-decoration'].';';
        if(!empty($value['typography_style']['text-transform'])) $style .= 'text-transform:'.$value['typography_style']['text-transform'].';';
        $style .= '}';
        $style .= "\n";
    }
}

/*****END TYPOGRAPHY*****/

$custom_css = s7upf_get_option('custom_css');
if(!empty($custom_css)){
    $style .= $custom_css."\n";
}
if(!empty($style)) print $style;
?>