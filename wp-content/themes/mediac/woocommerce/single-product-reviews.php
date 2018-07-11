<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version       3.3.1
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}
$count =  $product->get_review_count() ;

$counts = mediac_fnc_get_review_counting();

$average      = $product->get_average_rating();

?>

<div id="reviews"  class="widget-primary widget-reviews">


<h3><span><span><?php esc_html_e('Reviews', 'mediac'); ?></span></span></h3>

<div class="comments-content">
	<div class="reviews-summary">
		<div class="row">
			<div class="col-md-6 media">
				<h5><?php esc_html_e('Customers review', 'mediac'); ?></h5>
				<div class="review-summary-total pull-left">
					<div class="review-summary-result">
						<strong><?php echo floatval($average); ?></strong>
					</div>
					<?php printf( esc_html__( '%s ratings','mediac'),$count )  ; ?>
				</div>
				<div class="media-body"><div class="review-summary-detal ">
					<?php foreach( $counts as $key => $value ):  $pc = ($count == 0 ? 0: ( ($value/$count)*100  ) ); ?>
						<div class="review-summery-item row">
							<div class="col-lg-1"></div>
							<div class="review-label col-lg-3"> <?php echo trim($key); ?> <?php esc_html_e('Star','mediac'); ?></div>
							<div class="col-lg-7">
								<div class="progress">
								  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($pc);?>%;">
								    <?php echo round($pc,2);?>%
								  </div>
								</div>
							</div>


						</div>
					<?php endforeach; ?>
				</div></div>
			</div>
			<div class="col-md-6">
				<h5><?php esc_html_e('Rate it!','mediac'); ?></h5>
				<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'mediac' ); ?></p>
				<a href="#review_form_wrapper" class="btn btn-primary" rel="nofollow"><?php esc_html_e('Write A Review','mediac'); ?></a>



			</div>
		</div>
	</div>

	<div id="comments" class="comments">
		<h5><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
				printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'mediac' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
			else
				esc_html_e( 'Reviews', 'mediac' );
		?></h5>

		<?php if ( have_comments() ) : ?>

			<ul class="commentlist list-unstyled">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ul>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'mediac' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div id="review_form_wrapper" class="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'mediac' ) : esc_html__( 'Be the first to review', 'mediac' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
						'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'mediac' ),
						'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
						'title_reply_after'    => '</span>',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author form-group">' . '<label for="author" class="control-label">' . esc_html__( 'Name', 'mediac' ) . ' <span class="required">*</span></label> ' .
							            '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required/></p>',
							'email'  => '<p class="comment-form-email form-group"><label for="email" class="control-label">' . esc_html__( 'Email', 'mediac' ) . ' <span class="required">*</span></label> ' .
							            '<input id="email" class="form-control" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required/></p>',
						),
						'label_submit'  => esc_html__( 'Submit', 'mediac' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'mediac' ), esc_url( $account_page_url ) ) . '</p>';
					}

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<p class="comment-form-rating form-group clearfix">
						<label for="rating" class="control-label">' . esc_html__( 'Your Rating', 'mediac' ) .'</label>
						<select name="rating" id="rating">
						<option value="">' . esc_html__( 'Rate&hellip;', 'mediac' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'mediac' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'mediac' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'mediac' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'mediac' ) . '</option>
						<option value="1">' . esc_html__( 'Very Poor', 'mediac' ) . '</option>
						</select></p>';
					}


					$comment_form['comment_field'] .= '<p class="comment-form-comment form-group"><label class="control-label" for="comment">' . esc_html__( 'Your Review', 'mediac' ) . '</label><textarea id="comment"  class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'mediac' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
</div>