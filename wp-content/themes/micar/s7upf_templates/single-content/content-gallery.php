<?php
$data = '';
$gallery = get_post_meta(get_the_ID(), 'format_gallery', true);
if (!empty($gallery)){
    $array = explode(',', $gallery);
    if(is_array($array) && !empty($array)){
        
        $data .=    '<div class="banner-slider">
                        <div class="wrap-item" data-itemscustom="[[0,1]]" data-pagination="false" data-navigation="true">';
        foreach ($array as $key => $item) {
            $thumbnail_url = wp_get_attachment_url($item);
            $data .=        '<div class="image-slider">';
            $data .=            '<img src="' . esc_url($thumbnail_url) . '" alt="image-slider">';           
            $data .=        '</div>';
        }
        $data .=        '</div>
                    </div>';
    }
}
?>
<div class="blog-item">
    <div class="detail-blog-info">
        <h2 class="title30 font-bold rale-font text-uppercase navi">
            <?php the_title()?>
            <?php echo (is_sticky()) ? '<i class="fa fa-thumb-tack"></i>':''?>
        </h2>
        <?php if(has_excerpt()){?>
            <div class="desc title18 navi opaci"><?php the_excerpt()?> </div>
        <?php }?>
        <?php s7upf_display_metabox();?>
    </div>
    <?php if(!empty($data)) echo apply_filters('s7upf_output_content',$data);?>
    <div class="single-content"><?php the_content(); ?></div>
</div>