<?php
/**
 * Latest posts: card grid from the newest posts, optionally by category.
 */

use NowaTemplatka\Blocks\Render as R;

defined( 'ABSPATH' ) || exit;

$args = array(
	'post_type'           => 'post',
	'posts_per_page'      => min( 12, max( 1, (int) get_field( 'count' ) ?: 3 ) ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);
if ( get_field( 'category' ) ) {
	$args['cat'] = (int) get_field( 'category' );
}
$query = new WP_Query( $args );
$image = get_field( 'show_image' );
$date  = get_field( 'show_date' );
$exc   = get_field( 'show_excerpt' );
?>
<section <?php echo R::wrapper( array( 'nt-latest-posts' ) ); ?>>
	<div class="<?php echo R::container(); ?>">
		<?php echo R::head( get_field( 'eyebrow' ), get_field( 'title' ) ); ?>
		<?php if ( $query->have_posts() ) : ?>
			<div class="nt-grid nt-grid--cols-<?php echo R::choice( get_field( 'columns' ), '3' ); ?>">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<article class="nt-post-card">
						<?php if ( $image && has_post_thumbnail() ) : ?>
							<a class="nt-post-card__image nt-ratio nt-ratio--16-9" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail( 'large' ); ?></a>
						<?php endif; ?>
						<?php if ( $date ) : ?>
							<time class="nt-post-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						<?php endif; ?>
						<h3 class="nt-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<?php if ( $exc ) : ?>
							<p class="nt-post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>
					</article>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
		<?php $all = R::button( get_field( 'all_link' ), 'outline' ); ?>
		<?php if ( $all ) : ?>
			<div class="nt-buttons nt-buttons--center"><?php echo $all; ?></div>
		<?php endif; ?>
	</div>
</section>
