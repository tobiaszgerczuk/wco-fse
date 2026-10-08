<?php
namespace NowaTemplatka\Core;

defined( 'ABSPATH' ) || exit;

final class Theme {

	public static function boot(): void {
		add_action( 'after_setup_theme', array( self::class, 'setup' ) );
		Assets::boot();
		\NowaTemplatka\Blocks\Registry::boot();
	}

	public static function setup(): void {
		load_theme_textdomain( 'nowa-templatka', NT_DIR . '/languages' );

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'title-tag' );
	}
}
