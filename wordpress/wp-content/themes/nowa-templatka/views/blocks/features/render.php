<?php
/**
 * Features: grid of icon/image, title, text and optional link.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$items = get_field( 'items' );
$grid  = array(
	'nt-grid',
	'nt-grid--cols-' . R::choice( get_field( 'columns' ), '3' ),
	'nt-features__grid',
	'nt-features__grid--' . R::choice( get_field( 'card_style' ), 'card' ),
	'nt-features__grid--' . R::choice( get_field( 'item_align' ), 'left' ),
);
?>
<section <?php echo R::wrapper( array( 'nt-features' ) ); ?>>
	<div class="<?php echo R::container(); ?>">
		<?php echo R::head( get_field( 'eyebrow' ), get_field( 'title' ), get_field( 'intro' ) ); ?>
		<?php if ( $items ) : ?>
			<div class="<?php echo esc_attr( implode( ' ', $grid ) ); ?>">
				<?php foreach ( $items as $item ) : ?>
					<article class="nt-feature">
						<?php if ( ! empty( $item['icon'] ) ) : ?>
							<div class="nt-feature__icon"><?php echo R::image( $item['icon'], 'medium' ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $item['title'] ) ) : ?>
							<h3 class="nt-feature__title"><?php echo esc_html( $item['title'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $item['text'] ) ) : ?>
							<p class="nt-feature__text"><?php echo nl2br( esc_html( $item['text'] ) ); ?></p>
						<?php endif; ?>
						<?php echo R::button( $item['link'] ?? null, 'link' ); ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
