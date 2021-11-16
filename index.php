<?php
/**
 *
 * @package HyperVid_Theme
 *
 */
get_header(); 


				$hv_front_twpslider_switch      		= get_option( 'hv_front_twpslider_switch' );
				$hv_front_twpslider_num		 			= get_option( 'hv_front_twpslider_num' );
				$hv_front_twpslider_post_types_posts 	= get_option( 'hv_front_twpslider_post_types_posts' );
				$hv_front_twpslider_post_types_pages 	= get_option( 'hv_front_twpslider_post_types_pages' );
				$hv_front_twpslider_post_types_videos	= get_option( 'hv_front_twpslider_post_types_videos' );
				$hv_front_twpslider_img_inc     		= get_option( 'hv_front_twpslider_img_inc' );
				$hv_front_twpslider_dft_img     		= get_option( 'hv_front_twpslider_dft_img' );
				 
				 
				$hv_blog_twpslider_switch      			= get_option( 'hv_blog_twpslider_switch' );
				$hv_blog_twpslider_num		 			= get_option( 'hv_blog_twpslider_num' );
				$hv_blog_twpslider_post_types_posts 	= get_option( 'hv_blog_twpslider_post_types_posts' );
				$hv_blog_twpslider_post_types_pages 	= get_option( 'hv_blog_twpslider_post_types_pages' );
				$hv_blog_twpslider_post_types_videos	= get_option( 'hv_blog_twpslider_post_types_videos' );
				$hv_blog_twpslider_img_inc     			= get_option( 'hv_blog_twpslider_img_inc' );
				$hv_blog_twpslider_dft_img     			= get_option( 'hv_blog_twpslider_dft_img' );
				
				
if((is_front_page() && $hv_front_twpslider_switch) ||
		(is_home() && $hv_blog_twpslider_switch)) :
	include get_theme_file_path('template_parts/module_twpslide.php');
else:
	?>
	<br />
	<?php
		echo ($hv_front_twpslider_switch ? 'front' : 'not front');
	?>       
	<br />   
	<?php    
		echo (is_front_page() ? 'front page' : 'not front page');
	?>
	<br />   
	<?php    
		echo ($hv_blog_twpslider_switch ? 'blog' : 'not blog');
	?>
	<br />   
	<?php    
		echo (is_home() ? 'blog page' : 'not blog page');
	?>
	<br />
	<div>done</div>
	<?php
endif;

echo '1\n' . get_option('hv_front_twpslider_switch'      		);
echo '1\n' . get_option('hv_front_twpslider_num'		 		);
echo '1\n' . get_option('hv_front_twpslider_post_types_posts' 	);
echo '1\n' . get_option('hv_front_twpslider_post_types_pages' 	);
echo '1\n' . get_option('hv_front_twpslider_post_types_videos'	);
echo '1\n' . get_option('hv_front_twpslider_img_inc'     		);
echo '1\n' . get_option('hv_front_twpslider_dft_img'     		); 
echo '1\n' . get_option('hv_blog_twpslider_switch'      		);
echo '1\n' . get_option('hv_blog_twpslider_num'		 			);
echo '1\n' . get_option('hv_blog_twpslider_post_types_posts' 	);
echo '1\n' . get_option('hv_blog_twpslider_post_types_pages' 	);
echo '1\n' . get_option('hv_blog_twpslider_post_types_videos'	);
echo '1\n' . get_option('hv_blog_twpslider_dft_img'     		);
echo '1\n' . get_option('hv_blog_twpslider_img_inc'    			);


get_footer();


?>

