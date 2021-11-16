<?php
/**
 *
 * @package HyperVid_Theme
 *
 */
get_header(); 

if(is_front_page() || is_home()):
	include get_theme_file_path('template_parts/module_twpslide.php');
endif;

get_footer(); 

?>