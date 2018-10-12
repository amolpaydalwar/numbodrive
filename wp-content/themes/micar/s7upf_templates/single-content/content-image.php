<?php
$data = $st_link_post= $s_class = '';
global $post;
$s7upf_image_blog = get_post_meta(get_the_ID(), 'format_image', true);
if(!empty($s7upf_image_blog)){
    $data .='<div class="banner-adv zoom-image fade-out-in">
                <div class="adv-thumb-link">
                    <img alt="'.$post->post_name.'" title="'.$post->post_name.'" src="' . esc_url($s7upf_image_blog) . '"/>
                </div>
            </div>';
}
else{
    if (has_post_thumbnail()) {
        $data .=    '<div class="banner-adv zoom-image fade-out-in">
                        <div class="adv-thumb-link">
                            '.get_the_post_thumbnail(get_the_ID(),'full').'                
                        </div>
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