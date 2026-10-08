<?php
/**
 * Testimonials: quote cards with author, photo and optional star rating.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$items = get_field( 'items' );
?>
<section <?php echo R::wrapper( array( 'nt-testimonials' ) ); ?>>
	<div class="<?php echo R::container(); ?>">
		<?php echo R::head( get_field( 'eyebrow' ), get_field( 'title' ) ); ?>
		<?php if ( $items ) : ?>
			<div class="nt-grid nt-grid--cols-<?php echo R::choice( get_field( 'columns' ), '3' ); ?>">
				<?php foreach ( $items as $item ) : ?>
					<?php $rating = min( 5, max( 0, (int) ( $item['rating'] ?? 0 ) ) ); ?>
					<figure class="nt-testimonial">
						<?php if ( $rating ) : ?>
							<div class="nt-testimonial__rating" role="img" aria-label="<?php echo esc_attr( sprintf( '%d/5', $rating ) ); ?>"><?php echo str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ); ?></div>
						<?php endif; ?>
						<blockquote class="nt-testimonial__quote"><?php echo nl2br( esc_html( $item['quote'] ?? '' ) ); ?></blockquote>
						<figcaption class="nt-testimonial__author">
							<?php if ( ! empty( $item['photo'] ) ) : ?>
								<span class="nt-testimonial__photo"><?php echo R::image( $item['photo'], 'thumbnail' ); ?></span>
							<?php endif; ?>
							<span>
								<strong class="nt-testimonial__name"><?php echo esc_html( $item['name'] ?? '' ); ?></strong>
								<span class="nt-testimonial__role"><?php echo esc_html( $item['role'] ?? '' ); ?></span>
							</span>
						</figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
