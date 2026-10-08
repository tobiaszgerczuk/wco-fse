<?php
/**
 * Call to action: title, text and buttons, optionally in a rounded box.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$align   = R::choice( get_field( 'align' ), 'center' );
$classes = array( 'nt-cta', "nt-cta--{$align}" );
if ( get_field( 'boxed' ) ) {
	$classes[] = 'nt-cta--boxed';
}
?>
<section <?php echo R::wrapper( $classes ); ?>>
	<div class="<?php echo R::container( 'nt-cta__inner' ); ?>">
		<?php echo R::head( '', get_field( 'title' ), get_field( 'text' ), 'h2', $align ); ?>
		<?php echo R::buttons( get_field( 'buttons' ), $align ); ?>
	</div>
</section>
