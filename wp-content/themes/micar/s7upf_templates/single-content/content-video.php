<?php
$data = '';
if (get_post_meta(get_the_ID(), 'format_media', true)) {
    $media_url = get_post_meta(get_the_ID(), 'format_media', true);
    $data .='<div class="post-video banner-adv">';
    $data .= s7upf_remove_w3c(wp_oembed_get($media_url));
    $data .='</div>';
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