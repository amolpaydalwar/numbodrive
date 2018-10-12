<?php
/**
 * The template for displaying search results pages.
 *
 * @package 7up-framework
 */

get_header(); ?>
	<div class="main-wrapper tp-blog-page"> 
		
	    <div class="container">
	        <div class="row">
		        <?php s7upf_output_sidebar('left')?>
		        <div class="<?php echo esc_attr(s7upf_get_main_class()); ?>">
		        	<header class="page-header">
						<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'micar' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header><!-- .page-header -->
					<?php if ( have_posts() ) : ?>						

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part('s7upf_templates/blog-content/content');
							?>
							
						<?php endwhile; ?>
						<?php s7upf_paging_nav();?><!-- Display navigation-->
					<?php else : ?>

						<h2 class="title18"><?php esc_html_e("Sorry, but nothing matched your search terms. Please try again with some different keywords.","micar")?></h2>

					<?php endif; ?>
				</div>
	            <?php s7upf_output_sidebar('right')?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
