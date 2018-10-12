<?php
/**
 * The template for displaying all single posts.
 *
 * @package 7up-framework
 */

get_header();
?>
	<?php
		$header_image = s7upf_get_value_by_id('s7upf_show_header_image');
		if($header_image == 'yes'){ 
			s7upf_header_image();
		}
		$breadcrumb = s7upf_get_value_by_id('s7upf_show_breadrumb');
		if($breadcrumb == 'yes'){ 
			s7upf_display_breadcrumb();
		}
	?>
    <div id="main-content" class="st-default content-pages">
        <div class="container">
            <div class="row">
                <?php s7upf_output_sidebar('left')?>
                <div class="<?php echo esc_attr(s7upf_get_main_class()); ?>">
                    <?php
                    while ( have_posts() ) : the_post();

                        /*
                        * Include the post format-specific template for the content. If you want to
                        * use this in a child theme, then include a file called called content-___.php
                        * (where ___ is the post format) and that will be used instead.
                        */
                        ?>
                        	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php
									$check = s7upf_get_value_by_id('show_title_page');
									if($check != 'off'):
								?>
								<h2 class="title30 anton-font text-uppercase titlte-page-default"><?php the_title();?></h2>
								<?php endif;?>
								<div class="entry-content">
									<?php the_content(); ?>
									<div class="clear"></div>
									<?php
										wp_link_pages( array(
											'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'micar' ),
											'after'  => '</div>',
										) );
									?>
								</div><!-- .entry-content -->
							</article><!-- #post-## -->
                        <?php

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number()) :
                            comments_template();
                        endif;

                        // End the loop.
                    endwhile; ?>
                    
                </div> 
                <?php s7upf_output_sidebar('right')?>
            </div>

        </div>

    </div>
<?php
get_footer();