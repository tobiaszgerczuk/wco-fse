<?php
/**
 * Gallery: image grid with ratio, gap and optional link to the full image.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$images = get_field( 'images' );
$link   = (bool) get_field( 'link_to_full' );
$grid   = 'nt-grid nt-gallery__grid nt-grid--cols-' . R::choice( get_field( 'columns' ), '3' ) . ' nt-gallery__grid--gap-' . R::choice( get_field( 'gap' ), 'md' );
?>
<section <?php echo R::wrapper( array( 'nt-gallery' ) ); ?>>
	<div class="<?php echo R::container(); ?>">
		<?php echo R::head( '', get_field( 'title' ) ); ?>
		<?php if ( $images ) : ?>
			<div class="<?php echo esc_attr( $grid ); ?>">
				<?php foreach ( $images as $id ) : ?>
					<figure class="nt-gallery__item nt-ratio nt-ratio--<?php echo R::choice( get_field( 'ratio' ), '4-3' ); ?>">
						<?php if ( $link ) : ?>
							<a href="<?php echo esc_url( wp_get_attachment_image_url( (int) $id, 'full' ) ); ?>"><?php echo R::image( $id, 'large' ); ?></a>
						<?php else : ?>
							<?php echo R::image( $id, 'large' ); ?>
						<?php endif; ?>
					</figure>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
