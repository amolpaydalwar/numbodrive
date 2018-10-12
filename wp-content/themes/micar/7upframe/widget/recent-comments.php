<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('S7upf_RecentCommentWidget'))
{
    class S7upf_RecentCommentWidget extends WP_Widget {


        protected $default=array();

        static function _init()
        {
            add_action( 'widgets_init', array(__CLASS__,'_add_widget') );
        }

        static function _add_widget()
        {
            register_widget( 'S7upf_RecentCommentWidget' );
        }
		function __construct() {
            // Instantiate the parent object
            parent::__construct( false, esc_html__('SV Recent Comments','micar'),
                array( 'description' => esc_html__( 'Lists Recent Comments', 'micar' ), ));
        }
		public function widget( $args, $instance ) {
			if ( ! isset( $args['widget_id'] ) )
				$args['widget_id'] = $this->id;

			$output = '';

			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'SV Recent Comments','micar' );
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

			$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
			if ( ! $number )
				$number = 5;

			$comments = get_comments( apply_filters( 'widget_comments_args', array(
				'number'      => $number,
				'status'      => 'approve',
				'post_status' => 'publish'
			) ) );

			$output .= $args['before_widget'];
			if ( $title ) {
				$output .= $args['before_title'] . $title . $args['after_title'];
			}

			$output .= '<ul id="recentcomments" class="list-none">';
			if ( is_array( $comments ) && $comments ) {
				foreach ( (array) $comments as $comment ) {
					$output .= '<li class="recentcomments">
									<div class="item-wg-comment table">
										<div class="post-comment-count">
											<a href="' . get_comment_author_link( $comment ) . '" class="post-comment-link border color"><i class="icon ion-chatboxes"></i><span class="navi">'.esc_html($comment->comment_count).'</span></a>
										</div>
										<div class="post-info">
											<h3 class="font-bold title14"><a href="' . esc_url( get_comment_link( $comment ) ) . '" class="navi">' . get_the_title( $comment->comment_post_ID ) . '</a></h3>
											<span class="color">'.get_the_date('M d, Y',$comment->comment_post_ID).'</span>
										</div>
									</div>
					            </li>';
				}
			}
			$output .= '</ul>';
			$output .= $args['after_widget'];

			echo apply_filters('s7upf_output_content',$output);
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
			$instance['number'] = absint( $new_instance['number'] );
			return $instance;
		}

		public function form( $instance ) {
			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
			?>
			<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','micar' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

			<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of comments to show:','micar' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" /></p>
			<?php
		}
	}

    S7upf_RecentCommentWidget::_init();

}