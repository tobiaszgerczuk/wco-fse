<?php
/**
 * Logos: client / partner logo grid.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$items = get_field( 'items' );
$class = get_field( 'grayscale' ) ? 'nt-logos nt-logos--grayscale' : 'nt-logos';
?>
<section <?php echo R::wrapper( array( $class ) ); ?>>
	<div class="<?php echo R::container(); ?>">
		<?php echo R::head( '', get_field( 'title' ) ); ?>
		<?php if ( $items ) : ?>
			<div class="nt-grid nt-grid--cols-<?php echo R::choice( get_field( 'columns' ), '5' ); ?> nt-logos__grid">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$logo = R::image( $item['logo'] ?? 0, 'medium' );
					if ( ! $logo ) {
						continue;
					}
					$url = $item['link']['url'] ?? '';
					?>
					<div class="nt-logos__item">
						<?php if ( $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>"<?php echo ! empty( $item['link']['target'] ) ? ' target="_blank" rel="noopener"' : ''; ?> aria-label="<?php echo esc_attr( $item['link']['title'] ?? '' ); ?>"><?php echo $logo; ?></a>
						<?php else : ?>
							<?php echo $logo; ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
