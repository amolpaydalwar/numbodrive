<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package 7up-framework
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}
if(!function_exists('s7upf_comments_list'))
{ 
    function s7upf_comments_list($comment, $args, $depth) {

        $GLOBALS['comment'] = $comment;
        /* override default avatar size */
        $parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );
        $args['avatar_size'] = 70;
        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) :
            ?>
            <span id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>></span>
            <div class="comment-body">
                <?php esc_html_e('Pingback:', 'micar'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(esc_html__('Edit', 'micar'), '<span class="edit-link"><i class="ion-edit"></i>', '</span>'); ?>
            </div>
        <?php else : ?>
            <li <?php comment_class( $parent_class ); ?>>
                <div id="comment-<?php comment_ID() ?>" class="comment-body">
                    <div class="item-comment table">
                        <div class="commnent-thumb"><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?></a></div>
                        <div class="comment-info">                        
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="font-bold navi "><?php printf(esc_html__('%s', 'micar'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?></a><span class="navi "><?php esc_html_e("says:","micar")?></span>
                            <div class="desc  navi"><?php comment_text();?></div>
                            <span class="color"><?php echo get_comment_time('M d, Y')?></span>
                            <div class="comment-button">
                                <?php if (is_super_admin()): ?>
                                    <a href="<?php echo esc_url(get_edit_comment_link ( get_comment_ID() )) ?>" class="btn-reply"><i class="ion-compose"></i> <?php esc_html_e(' Edit ','micar');?></a>
                                <?php endif; ?>
                                <?php if (comments_open()): ?>
                                    <?php echo str_replace('comment-reply-link', 'btn-reply', get_comment_reply_link(array_merge( $args, array('reply_text' =>'<i class="ion-reply"></i> '.esc_html__('Reply','micar'),'depth' => $depth, 'max_depth' => $args['max_depth'])))) ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
        endif;
    }
}
?>
	<div class="blog-comment-detail">
		<div id="comments" class="comments-area comments blog-comment-detail">

			<?php // You can start editing here -- including this comment! ?>

			<?php if ( have_comments() ) : ?>
				<h2 class="title18 text-uppercase font-bold rale-font navi"><?php echo esc_html__('Comments', 'micar'); ?></h2>
		        <ol class="comment-list list-none">
		            <?php
		            wp_list_comments(array(
		                'style' => '',
		                'short_ping' => true,
		                'avatar_size' => 70,
		                'max_depth' => '5',
		                'callback' => 's7upf_comments_list',
		                // 'walker' => new s7upf_custom_comment()
		            ));
		            ?>
		        </ol>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
				<nav id="comment-nav-below" class="comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'micar' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'micar' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'micar' ) ); ?></div>
				</nav><!-- #comment-nav-below -->
				<?php endif; // check for comment navigation ?>

			<?php endif; // have_comments() ?>

			<?php
				// If comments are closed and there are comments, let's leave a little note, shall we?
				if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'micar' ); ?></p>
			<?php endif; ?>

		</div><!-- #comments -->
	</div>
	<div class="reply-comment">
		<?php
		$comment_form = array(
            'title_reply' => esc_html__('Leave a comments', 'micar'),
            'fields' => apply_filters( 'comment_form_default_fields', array(
                    'author' =>'<p class="contact-name">
                                    <input class="navi border" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .'" placeholder="'.esc_html__( 'Name*', 'micar' ).'" />
                                </p>',
                    'email' =>	'<p class="contact-email">
                                    <input class="navi border" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .'" placeholder="'.esc_html__( 'Email*', 'micar' ).'" />
                                </p>',
                )
            ),
            'comment_field' =>  '<p class="contact-message">
                                    <textarea id="comment" class="navi border" rows="5" name="comment" aria-required="true" placeholder="'.esc_html__( 'Your comment*', 'micar' ).'"></textarea>
                                </p>',
            'must_log_in' => '<div class="must-log-in control-group"><div class="controls">' .sprintf(wp_kses_post(__( 'You must be <a href="%s">logged in</a> to post a comment.','micar' )),wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )) . '</div></div >',
            'logged_in_as' => '<div class="logged-in-as control-group"><div class="controls">' .sprintf(wp_kses_post(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','micar' )),admin_url( 'profile.php' ),$user_identity,wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )) . '</div></div>',
            'comment_notes_before' => '',
            'comment_notes_after' => '',
            'id_form'              => 'commentform',
            'class_form'              => 'contact-form',
            'id_submit'            => 'submit',
            'title_reply'          => esc_html__( 'Leave Comments','micar' ),
            'title_reply_to'       => esc_html__( 'Leave a Reply %s','micar' ),
            'cancel_reply_link'    => esc_html__( 'Cancel reply','micar' ),
            'label_submit'         => esc_html__( 'Post Comment','micar' ),
            'class_submit'         => 'shop-button white bg-color',
        );
		?>
		<?php comment_form($comment_form); ?>
	</div>
<?php

class s7upf_custom_comment extends Walker_Comment {
     
    /** START_LVL 
     * Starts the list before the CHILD elements are added. */
    function start_lvl( &$output, $depth = 0, $args = array() ) {       
        $GLOBALS['comment_depth'] = $depth + 1;

           $output .= '<div class="children">';
        }
 
    /** END_LVL 
     * Ends the children list of after the elements are added. */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;
        $output .= '</div>';
    }
    function end_el( &$output, $object, $depth = 0, $args = array() ) {
    	$output .= '';
    }
}
?>

