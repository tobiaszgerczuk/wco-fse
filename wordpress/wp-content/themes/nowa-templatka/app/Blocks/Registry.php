<?php
namespace NowaTemplatka\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Registers every block found in views/blocks/<slug>/block.json and keeps each
 * block's ACF field group (group_<slug>.json) next to the block.
 */
final class Registry {

	private const DIR = NT_DIR . '/views/blocks';

	public static function boot(): void {
		add_action( 'init', array( self::class, 'register' ) );
		add_filter( 'block_categories_all', array( self::class, 'category' ) );
		add_filter( 'acf/settings/load_json', array( self::class, 'load_json' ) );
		add_filter( 'acf/json/save_paths', array( self::class, 'save_paths' ), 10, 2 );
	}

	public static function register(): void {
		foreach ( glob( self::DIR . '/*/block.json' ) ?: array() as $file ) {
			register_block_type( dirname( $file ) );
		}
	}

	public static function category( array $categories ): array {
		array_unshift(
			$categories,
			array(
				'slug'  => 'nowa-templatka',
				'title' => __( 'Theme blocks', 'nowa-templatka' ),
			)
		);
		return $categories;
	}

	/** @param string[] $paths */
	public static function load_json( array $paths ): array {
		foreach ( glob( self::DIR . '/*', GLOB_ONLYDIR ) ?: array() as $dir ) {
			$paths[] = $dir;
		}
		return $paths;
	}

	/**
	 * Saves a block's field group into its block directory; other groups use the default path.
	 *
	 * @param string[] $paths
	 * @param array    $post  ACF field group.
	 */
	public static function save_paths( array $paths, array $post ): array {
		foreach ( $post['location'] ?? array() as $rules ) {
			foreach ( $rules as $rule ) {
				if ( 'block' === ( $rule['param'] ?? '' ) && 0 === strpos( (string) $rule['value'], 'acf/' ) ) {
					$dir = self::DIR . '/' . substr( $rule['value'], 4 );
					if ( is_dir( $dir ) ) {
						return array( $dir );
					}
				}
			}
		}
		return $paths;
	}
}
