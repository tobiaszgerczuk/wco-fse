<?php
/**
 * Hero: split, centered or background-image layout.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$layout     = R::choice( get_field( 'layout' ), 'split-left' );
$min_height = R::choice( get_field( 'min_height' ), 'auto' );
$image      = get_field( 'image' );
$overlay    = min( 90, max( 0, (int) get_field( 'overlay' ) ) );
$align      = in_array( $layout, array( 'centered', 'background' ), true ) ? 'center' : 'left';
$is_bg      = 'background' === $layout;
?>
<section <?php echo R::wrapper( array( 'nt-hero', "nt-hero--{$layout}", "nt-hero--h-{$min_height}" ) ); ?>>
	<?php if ( $is_bg && $image ) : ?>
		<div class="nt-hero__bg">
			<?php echo R::image( $image, 'full' ); ?>
			<span class="nt-hero__overlay" style="opacity:<?php echo $overlay / 100; ?>"></span>
		</div>
	<?php endif; ?>
	<div class="<?php echo R::container( 'nt-hero__inner' ); ?>">
		<div class="nt-hero__content">
			<?php echo R::head( get_field( 'eyebrow' ), get_field( 'title' ), get_field( 'text' ), (string) get_field( 'level' ), $align ); ?>
			<?php echo R::buttons( get_field( 'buttons' ), $align ); ?>
		</div>
		<?php if ( ! $is_bg && 'centered' !== $layout && $image ) : ?>
			<div class="nt-hero__media"><?php echo R::image( $image, 'large' ); ?></div>
		<?php endif; ?>
	</div>
</section>
