<?php
/**
 * Section heading: eyebrow, title, text and buttons.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$align = get_field( 'align' ) ?: 'center';
?>
<section <?php echo R::wrapper(); ?>>
	<div class="<?php echo R::container(); ?>">
		<?php echo R::head( get_field( 'eyebrow' ), get_field( 'title' ), get_field( 'text' ), (string) get_field( 'level' ), $align ); ?>
		<?php echo R::buttons( get_field( 'buttons' ), $align ); ?>
	</div>
</section>
