<?php
/**
 * Section: generic wrapper with background, spacing and width settings.
 *
 * @var array $block Block settings and attributes.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;
?>
<section <?php echo R::wrapper(); ?>>
	<div class="<?php echo R::container(); ?>">
		<InnerBlocks />
	</div>
</section>
