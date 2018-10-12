<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 content-pages not-found">
				<div class="container">
					<header class="page-header">
						<h1 class="page-title anton-font"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'micar' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'micar' ); ?></p>

						<?php get_search_form(); ?>
					</div><!-- .page-content -->
				</div>
			</section><!-- .error-404 -->

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
