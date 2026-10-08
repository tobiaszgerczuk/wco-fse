<?php
/**
 * FAQ: accordion built on <details>, with optional FAQPage structured data.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$items      = get_field( 'items' );
$open_first = (bool) get_field( 'open_first' );
?>
<section <?php echo R::wrapper( array( 'nt-faq' ) ); ?>>
	<div class="<?php echo R::container( 'nt-faq__inner' ); ?>">
		<?php echo R::head( get_field( 'eyebrow' ), get_field( 'title' ), get_field( 'intro' ) ); ?>
		<?php if ( $items ) : ?>
			<div class="nt-faq__list">
				<?php foreach ( $items as $i => $item ) : ?>
					<details class="nt-faq__item"<?php echo ( 0 === $i && $open_first ) ? ' open' : ''; ?>>
						<summary class="nt-faq__question"><?php echo esc_html( $item['question'] ?? '' ); ?></summary>
						<div class="nt-faq__answer nt-prose"><?php echo wp_kses_post( $item['answer'] ?? '' ); ?></div>
					</details>
				<?php endforeach; ?>
			</div>
			<?php
			if ( get_field( 'schema' ) && empty( $is_preview ) ) {
				$entities = array();
				foreach ( $items as $item ) {
					$entities[] = array(
						'@type'          => 'Question',
						'name'           => wp_strip_all_tags( $item['question'] ?? '' ),
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => wp_kses_post( $item['answer'] ?? '' ),
						),
					);
				}
				echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $entities ), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG ) . '</script>';
			}
			?>
		<?php endif; ?>
	</div>
</section>
