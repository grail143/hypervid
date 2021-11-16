<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @package WordPress
 * @subpackage HyperVid
 * @since HyperVid 0.1
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 *
	 * @since HyperVid 0.1
	 *
	 * @return void
	 */
	function hypervid__register_block_styles() {
		// Columns: Overlap.
		register_block_style(
			'core/columns',
			array(
				'name'  => 'hypervid-columns-overlap',
				'label' => esc_html__( 'Overlap', 'hypervid' ),
			)
		);

		// Cover: Borders.
		register_block_style(
			'core/cover',
			array(
				'name'  => 'hypervid-border',
				'label' => esc_html__( 'Borders', 'hypervid' ),
			)
		);

		// Group: Borders.
		register_block_style(
			'core/group',
			array(
				'name'  => 'hypervid-border',
				'label' => esc_html__( 'Borders', 'hypervid' ),
			)
		);

		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'hypervid-border',
				'label' => esc_html__( 'Borders', 'hypervid' ),
			)
		);

		// Image: Frame.
		register_block_style(
			'core/image',
			array(
				'name'  => 'hypervid-image-frame',
				'label' => esc_html__( 'Frame', 'hypervid' ),
			)
		);

		// Latest Posts: Dividers.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'hypervid-latest-posts-dividers',
				'label' => esc_html__( 'Dividers', 'hypervid' ),
			)
		);

		// Latest Posts: Borders.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'hypervid-latest-posts-borders',
				'label' => esc_html__( 'Borders', 'hypervid' ),
			)
		);

		// Media & Text: Borders.
		register_block_style(
			'core/media-text',
			array(
				'name'  => 'hypervid-border',
				'label' => esc_html__( 'Borders', 'hypervid' ),
			)
		);

		// Separator: Thick.
		register_block_style(
			'core/separator',
			array(
				'name'  => 'hypervid-separator-thick',
				'label' => esc_html__( 'Thick', 'hypervid' ),
			)
		);

		// Social icons: Dark gray color.
		register_block_style(
			'core/social-links',
			array(
				'name'  => 'hypervid-social-icons-color',
				'label' => esc_html__( 'Dark gray', 'hypervid' ),
			)
		);
	}
	add_action( 'init', 'hypervid__register_block_styles' );
}
