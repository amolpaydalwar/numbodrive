<?php
$data = $st_link_post= $s_class = '';
$thumb = get_the_post_thumbnail(get_the_ID(),'full');
if (has_post_thumbnail() && !empty($thumb)) {
    $data .=    '<div class="banner-adv">
                    <a href="'. esc_url(get_the_permalink()) .'">'.get_the_post_thumbnail(get_the_ID(),'full').'</a>                
                </div>';
}else{
	$s_class = 'post-none-thumbnail';
}
?>
<div class="item-news-blog style3">
    <?php if(!empty($data)) echo apply_filters('s7upf_output_content',$data);?>
    <div class="news-blog-info">
        <h3 class="title18 rale-font text-uppercase font-bold">
            <a href="<?php echo esc_url(get_the_permalink()); ?>" class="navi">
                <?php the_title()?>
                <?php echo (is_sticky()) ? '<i class="fa fa-thumb-tack"></i>':''?>
            </a>
        </h3>
		<?php if(has_excerpt()){?>
        <div class="desc opaci navi"><?php echo get_the_excerpt(); ?></div>
		<?php }?>
        <?php s7upf_display_metabox();?>
		<div class="text-left">
			<a href="<?php echo esc_url(get_the_permalink()); ?>" class="shop-button"><?php echo esc_html('Read more','micar');?></a>
		</div>	
    </div>
</div>