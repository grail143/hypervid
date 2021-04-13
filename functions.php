<?php
/**
 * The functions for our theme.
 *
 * @package HyperVid_Theme
 *
 */
function hv_scripts() {
    wp_enqueue_style( 'hv-style', get_stylesheet_uri() );
    wp_enqueue_style( 'hv-sass-style', get_template_directory_uri() . '/css/style.css' );
    wp_enqueue_style( 'hv-font1', "https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" );
    wp_enqueue_style( 'hv-font2', "https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" );
	add_theme_support( 'post-thumbnails' );
	wp_enqueue_script('jquery');
    wp_enqueue_script( 'hv-webpack', get_template_directory_uri() . '/dist/main.js' ,'jQuery');
}    

add_action( 'wp_enqueue_scripts', 'hv_scripts' );
?>