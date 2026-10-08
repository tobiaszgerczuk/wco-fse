<?php
/**
 * Text and image: two-column block, image on either side.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$classes = array(
	'nt-text-image',
	'nt-text-image--image-' . R::choice( get_field( 'image_position' ), 'right' ),
	'nt-text-image--size-' . R::choice( get_field( 'image_size' ), 'half' ),
	'nt-text-image--align-' . R::choice( get_field( 'vertical_align' ), 'center' ),
);
if ( get_field( 'reverse_mobile' ) ) {
	$classes[] = 'nt-text-image--image-first-mobile';
}
$content = get_field( 'content' );
$image   = get_field( 'image' );
?>
<section <?php echo R::wrapper( $classes ); ?>>
	<div class="<?php echo R::container( 'nt-text-image__inner' ); ?>">
		<div class="nt-text-image__text">
			<?php echo R::head( get_field( 'eyebrow' ), get_field( 'title' ), '', (string) get_field( 'level' ), 'left' ); ?>
			<?php if ( $content ) : ?>
				<div class="nt-prose"><?php echo wp_kses_post( $content ); ?></div>
			<?php endif; ?>
			<?php echo R::buttons( get_field( 'buttons' ) ); ?>
		</div>
		<?php if ( $image ) : ?>
			<div class="nt-text-image__media nt-ratio nt-ratio--<?php echo R::choice( get_field( 'image_ratio' ), 'auto' ); ?>">
				<?php echo R::image( $image, 'large' ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
