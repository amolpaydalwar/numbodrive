<?php
/**
 * The template for displaying all single posts.
 *
 * @package 7up-framework
 */
?>
<?php get_header();?>
    <div id="main-content"  class="main-wrapper">
        <div id="tp-blog-page" class="tp-blog-page"><!-- blog-single -->
            <?php 
                s7upf_header_image();
                s7upf_display_breadcrumb();
            ?>
            <div class="content-pages">
                <div class="container">
                    <div class="row">
                        <?php s7upf_output_sidebar('left')?>
                        <div class="<?php echo esc_attr(s7upf_get_main_class()); ?>">
                            <div class="blog-list-view content-blog-detail">
                                <?php
                                while ( have_posts() ) : the_post();

                                    /*
                                    * Include the post format-specific template for the content. If you want to
                                    * use this in a child theme, then include a file called called content-___.php
                                    * (where ___ is the post format) and that will be used instead.
                                    */
                                    get_template_part( 's7upf_templates/single-content/content',get_post_format() );
                                    wp_link_pages( array(
                                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'micar' ),
                                        'after'  => '</div>',
                                        'link_before' => '<span>',
                                        'link_after'  => '</span>',
                                    ) );
                                    //echo s7upf_share_box();
                                    s7upf_author_box();
                                    ?>
                                    <?php
                                        $previous_post = get_previous_post();
                                        $next_post = get_next_post();
                                    ?>
                                    <div class="post-control">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <?php if(!empty( $previous_post )):?>
                                                <h3 class="title14 text-left"><a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>" class="navi prev-post"><i class="icon ion-ios-arrow-left"></i> <span><?php echo esc_html($previous_post->post_title)?></span></a></h3>
                                                <?php endif;?>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <?php if(!empty( $next_post )):?>
                                                <h3 class="title14 text-right"><a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>" class="navi next-post"> <span><?php echo esc_html($next_post->post_title)?></span><i class="icon ion-ios-arrow-right"></i> </a></h3>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ( comments_open() || get_comments_number() ) { comments_template(); }
                                   
                                endwhile; ?>
                            </div>
                        </div>
                        <?php s7upf_output_sidebar('right')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();?>