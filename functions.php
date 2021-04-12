<?php
/**
 * The functions for our theme.
 *
 * @package HyperVid_Theme
 *
 */
function hv_scripts() {
    wp_enqueue_style( 'hv-style', get_stylesheet_uri() );
    wp_enqueue_style( 'hv-starter', get_template_directory_uri() . '/assets/css/starter.css' );
    wp_enqueue_style( 'hv-font1', "https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" );
    wp_enqueue_style( 'hv-font2', "https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" );

    wp_enqueue_script( 'hv-starter', get_template_directory_uri() . '/assets/js/starter.js');
}    

add_action( 'wp_enqueue_scripts', 'hv_scripts' );
?>