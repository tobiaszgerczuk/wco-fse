<?php
/**
 * Spacer: vertical gap with separate desktop and mobile heights.
 */

defined( 'ABSPATH' ) || exit;

$desktop = max( 0, (int) get_field( 'height_desktop' ) );
$mobile  = max( 0, (int) get_field( 'height_mobile' ) );
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'nt-spacer', 'style' => "--nt-spacer-d:{$desktop}px;--nt-spacer-m:{$mobile}px", 'aria-hidden' => 'true' ) ); ?>></div>
