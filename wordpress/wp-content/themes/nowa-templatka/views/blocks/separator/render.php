<?php
/**
 * Separator: horizontal line with style, width, colour and spacing options.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$thickness = min( 12, max( 1, (int) get_field( 'line_thickness' ) ) );
$classes   = array(
	'nt-separator',
	'nt-separator--space-' . R::choice( get_field( 'space' ), 'md' ),
	'nt-separator--' . R::choice( get_field( 'line_width' ), 'content' ),
);
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) ); ?>>
	<hr class="nt-separator__line nt-separator__line--<?php echo R::choice( get_field( 'line_style' ), 'solid' ); ?> nt-separator__line--<?php echo R::choice( get_field( 'line_color' ), 'gray' ); ?>" style="--nt-line:<?php echo $thickness; ?>px">
</div>
