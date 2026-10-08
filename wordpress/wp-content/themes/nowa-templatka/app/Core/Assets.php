<?php
namespace NowaTemplatka\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Loads webpack output from public/. The editor stylesheet is loaded inside the
 * editor iframe, so the editor sees the same styles as the front end.
 */
final class Assets {

	public static function boot(): void {
		add_action( 'wp_enqueue_scripts', array( self::class, 'front' ) );
		add_action( 'after_setup_theme', array( self::class, 'editor_styles' ) );
	}

	public static function front(): void {
		if ( self::exists( 'main.css' ) ) {
			wp_enqueue_style( 'nt-main', NT_URI . '/public/main.css', array(), self::version( 'main.css' ) );
		}
	}

	public static function editor_styles(): void {
		add_theme_support( 'editor-styles' );
		if ( self::exists( 'editor.css' ) ) {
			add_editor_style( 'public/editor.css' );
		}
	}

	private static function exists( string $file ): bool {
		return is_readable( NT_DIR . '/public/' . $file );
	}

	private static function version( string $file ): string {
		return (string) filemtime( NT_DIR . '/public/' . $file );
	}
}
