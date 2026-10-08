<?php
namespace NowaTemplatka\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Markup helpers shared by block render templates. Every method returns
 * already-escaped HTML (or an attributes string), ready to echo.
 */
final class Render {

	private const LEVELS = array( 'h1', 'h2', 'h3', 'h4' );

	/**
	 * Wrapper attributes for a section: background and vertical spacing from the
	 * shared "Section settings" ACF group (section_background, section_space_*).
	 *
	 * @param string[] $classes Extra classes for the wrapper.
	 */
	public static function wrapper( array $classes = array() ): string {
		$bg     = self::choice( get_field( 'section_background' ), 'none' );
		$top    = self::choice( get_field( 'section_space_top' ), 'lg' );
		$bottom = self::choice( get_field( 'section_space_bottom' ), 'lg' );

		$classes   = array_merge( array( 'nt-section', "nt-bg-{$bg}", "nt-pt-{$top}", "nt-pb-{$bottom}" ), $classes );
		return get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );
	}

	/** Class list for the inner width container (content / wide / full). */
	public static function container( string $extra = '' ): string {
		$width = self::choice( get_field( 'section_width' ), 'content' );
		return esc_attr( trim( "nt-container nt-container--{$width} {$extra}" ) );
	}

	/** Eyebrow + title + intro text block. */
	public static function head( ?string $eyebrow, ?string $title, ?string $text = '', string $level = 'h2', string $align = 'center' ): string {
		if ( ! $eyebrow && ! $title && ! $text ) {
			return '';
		}
		$level = in_array( $level, self::LEVELS, true ) ? $level : 'h2';
		$align = self::choice( $align, 'center' );

		$html = '<header class="nt-head nt-head--' . esc_attr( $align ) . '">';
		if ( $eyebrow ) {
			$html .= '<p class="nt-eyebrow">' . esc_html( $eyebrow ) . '</p>';
		}
		if ( $title ) {
			$html .= "<{$level} class=\"nt-head__title\">" . esc_html( $title ) . "</{$level}>";
		}
		if ( $text ) {
			$html .= '<p class="nt-head__text">' . nl2br( esc_html( $text ) ) . '</p>';
		}
		return $html . '</header>';
	}

	/** One button from an ACF link array. */
	public static function button( $link, string $style = 'primary' ): string {
		if ( empty( $link['url'] ) ) {
			return '';
		}
		$style  = self::choice( $style, 'primary' );
		$target = ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : '';
		$title  = ! empty( $link['title'] ) ? $link['title'] : $link['url'];

		return '<a class="nt-btn nt-btn--' . esc_attr( $style ) . '" href="' . esc_url( $link['url'] ) . '"' . $target . '>' . esc_html( $title ) . '</a>';
	}

	/**
	 * A row of buttons from a repeater with sub fields "link" and "style".
	 *
	 * @param array<int, array{link?: array, style?: string}>|false|null $rows
	 */
	public static function buttons( $rows, string $align = 'left' ): string {
		if ( empty( $rows ) || ! is_array( $rows ) ) {
			return '';
		}
		$html = '';
		foreach ( $rows as $row ) {
			$html .= self::button( $row['link'] ?? null, $row['style'] ?? 'primary' );
		}
		return $html ? '<div class="nt-buttons nt-buttons--' . esc_attr( self::choice( $align, 'left' ) ) . '">' . $html . '</div>' : '';
	}

	/** Responsive <img> for an attachment ID. */
	public static function image( $id, string $size = 'large', array $attr = array() ): string {
		return $id ? wp_get_attachment_image( (int) $id, $size, false, $attr ) : '';
	}

	/** Restrict a value to [a-z0-9-] so it is safe inside a class name. */
	public static function choice( $value, string $default ): string {
		$value = is_scalar( $value ) ? sanitize_html_class( (string) $value ) : '';
		return '' !== $value ? $value : $default;
	}
}
