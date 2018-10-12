<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package 7up-framework
 */

get_header();
?>
<div id="main-content" class="main-wrapper">
    <?php do_action('s7upf_before_main_content')?>
    <div id="tp-blog-page" class="tp-blog-page">
        <?php 
            s7upf_header_image();
            s7upf_display_breadcrumb();
        ?>
        <div class="container">
            <div class="content-pages">
                <div class="row">
                    <?php s7upf_output_sidebar('left')?>
                    <div class="<?php echo esc_attr(s7upf_get_main_class()); ?>">
                    	<div class="blog-list-view">
                            <?php if(have_posts()):?>    
        					    <?php while (have_posts()) :the_post();?>

        							<?php get_template_part('s7upf_templates/blog-content/content');?>

        					    <?php endwhile;?>
        					    <?php wp_reset_postdata();?>

        					<?php else : ?>
        					    <?php get_template_part( 's7upf_templates/blog-content/content', 'none' ); ?>
        					<?php endif;?>
                        </div>
                        <?php s7upf_paging_nav();?>
                    </div>
                    <?php s7upf_output_sidebar('right')?>
                </div>
            </div>
        </div>
    </div>
    <?php do_action('s7upf_affter_main_content')?>
</div>
<?php get_footer(); ?>
