<?php
/**
 * Stats: row of big numbers with labels.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$items = get_field( 'items' );
?>
<section <?php echo R::wrapper( array( 'nt-stats' ) ); ?>>
	<div class="<?php echo R::container(); ?>">
		<?php echo R::head( '', get_field( 'title' ), get_field( 'intro' ) ); ?>
		<?php if ( $items ) : ?>
			<div class="nt-grid nt-grid--cols-<?php echo R::choice( get_field( 'columns' ), '4' ); ?>">
				<?php foreach ( $items as $item ) : ?>
					<div class="nt-stat">
						<div class="nt-stat__value"><?php echo esc_html( ( $item['prefix'] ?? '' ) . ( $item['number'] ?? '' ) . ( $item['suffix'] ?? '' ) ); ?></div>
						<div class="nt-stat__label"><?php echo esc_html( $item['label'] ?? '' ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
