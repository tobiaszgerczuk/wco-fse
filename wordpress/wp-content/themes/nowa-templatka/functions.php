<?php
/**
 * Theme bootstrap.
 *
 * @package NowaTemplatka
 */

defined( 'ABSPATH' ) || exit;

define( 'NT_VERSION', '0.1.0' );
define( 'NT_DIR', get_template_directory() );
define( 'NT_URI', get_template_directory_uri() );

// Minimal PSR-4 autoloader: NowaTemplatka\Foo\Bar => app/Foo/Bar.php.
spl_autoload_register(
	static function ( string $class ): void {
		$prefix = 'NowaTemplatka\\';
		if ( strpos( $class, $prefix ) !== 0 ) {
			return;
		}
		$file = NT_DIR . '/app/' . str_replace( '\\', '/', substr( $class, strlen( $prefix ) ) ) . '.php';
		if ( is_readable( $file ) ) {
			require $file;
		}
	}
);

NowaTemplatka\Core\Theme::boot();
