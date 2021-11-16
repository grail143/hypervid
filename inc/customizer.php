<?php
/**
 *
 * @package HyperVid_Theme
 *
 */
function hv_customize_register( $wp_customize ) {
	/*register custom controls*/
	class Custom_Text_Control extends WP_Customize_Control {
        public $type = 'customtext';
        public $extra = '';
        public function render_content() {
        ?>
        <label>
			<span class="customize-control-title"><?php echo esc_html ( $this->label );?></span>
            <span><?php echo esc_html( $this->extra ); ?></span>
        </label>
        <?php
        }
    }
	/**
	 * Customize Image Reloaded Class
	 *
	 * Extend WP_Customize_Image_Control allowing access to uploads made within
	 * the same context
	 *
	 * https://gist.github.com/eduardozulian/4739075
	 */
	class My_Customize_Image_Reloaded_Control extends WP_Customize_Image_Control {
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );
		}
		public function tab_uploaded() {
			$my_context_uploads = get_posts( array(
				'post_type'  => 'attachment',
				'meta_key'   => '_wp_attachment_context',
				'meta_value' => $this->context,
				'orderby'    => 'post_date',
				'nopaging'   => true,
			) );
			?>
		
			<div class="uploaded-target"></div>
			
			<?php
			if ( empty( $my_context_uploads ) )
				return;
			
			foreach ( (array) $my_context_uploads as $my_context_upload ) {
				$this->print_tab_image( esc_url_raw( $my_context_upload->guid ) );
			}
		}
	}

	function hv_sanitize_number( $number ) {
	  $number = absint( $number );
	  return ( is_numeric($number) ? $number : 20 );
	}
	/*set helper vars*/
	$ignore_post_types = array(
		'attachment',
		'revision',
		'nav_menu_item',
		'custom_css',
		'customize_changeset',
		'oembed_cache',
		'user_request',
		'wp_block',
	);
	$args = array(
	   'public'   => true,
	   '_builtin' => true
	);
	  
	$output = 'names';
	$operator = 'or'; 
	  
	$post_types = get_post_types( $args, $output, $operator );
	foreach( $post_types as $val ) {
		if (in_array($val,$ignore_post_types,false)) {
			unset( $post_types[$val] );
		}
	}
	$hv_twpslider_defaults = array(
		'show_hide' => array (
			'true' => __('Show'),
			'false' => __('Hide')
		),
		'post_types' => $post_types,
	);
	
	/* begin duplicated front & blog page options 
			register option section in customizer
				_twpslider_switch
				_twpslider_num
				_twpslider_post_types_
				_twpslider_img_inc
				_twpslider_dft_img
	*/
	foreach( ['front','blog'] as $section ) {
		$wp_customize->add_section( 'hv_' . $section . '_page' , 
			array(
				'title' => __( ucfirst($section) . ' Page Options', 'hv')
			)
		);
			
		$wp_customize->add_setting( 'hv_' . $section . '_twpslider_switch', 
			array (
				'capability' => 'edit_theme_options',
				'default' => __( 'true', 'hv' )
			) 
		);
		
		$wp_customize->add_setting( 'hv_' . $section . '_twpslider_num', 
			array(
			  'capability' => 'edit_theme_options',
			  'sanitize_callback' => 'hv_sanitize_number',
			  'default' => 20,
			) 
		);
		  
		$wp_customize->add_setting( 'hv_' . $section . '_twpslider_post_types[customtext]', 
			array(
				'default' => '',
				'type' => 'customtext_control_' . $section,
				'capability' => 'edit_theme_options',
				'transport' => 'refresh',
			)
		);
		
		$wp_customize->add_setting( 'hv_' . $section . '_twpslider_img_inc', 
			array (
				'capability' => 'edit_theme_options',
				'default' => __( 'true', 'hv' )
			) 
		);	

		$wp_customize->add_setting( 'hv_' . $section . '_twpslider_dft_img', 
			array(
				'capability'  => 'edit_theme_options'
			) 
		);
		
		$wp_customize->add_control( 'hv_' . $section . '_twpslider_switch',
			array( 
				'id' => 'hv_' . $section . '_twpslider_switch',
				'label' => __( 'Show Slider on ' . ucfirst($section) . ' Page', 'hv' ),
				'section' => 'hv_' . $section . '_page',
				'type' => 'radio',
				'choices' => $hv_twpslider_defaults['show_hide'],
			)
		);
		
		$wp_customize->add_control( 'hv_' . $section . '_twpslider_num', 
			array(
				'type' => 'number',
				'section' => 'hv_' . $section . '_page',
				'label' => __( '# of Posts to display' ),
				'input_attrs' => array(
					'min' => 1,
					'max' => 100,
					'step' => 1,
				),
			) 
		);
		
		$wp_customize->add_control( 
			new Custom_Text_Control( 
				$wp_customize, 
				'customtext_control_' . $section, 
				array(
					'label' => 'Which post types do you want to show in slider',
					'section' => 'hv_' . $section . '_page',
					'settings' => 'hv_' . $section . '_twpslider_post_types[customtext]',
					'extra' =>''
				)
			) 
		);
		
		foreach($hv_twpslider_defaults['post_types'] as $posttype){
			$wp_customize->add_setting( 'hv_' . $section . '_twpslider_post_types_' . $posttype, 
				array (
					'default' => __( 'true', 'hv' ),
					'capability'  => 'edit_theme_options'
				) 
			);
			$wp_customize->add_control( 'hv_' . $section . '_twpslider_post_types_' . $posttype,
				array( 
					'id' => 'hv_' . $section . '_twpslider_post_types_',
					'label' => __( $posttype, 'hv' ),
					'section' => 'hv_' . $section . '_page',
					'type' => 'checkbox',
				)
			);
		}
		
		$wp_customize->add_control( 'hv_' . $section . '_twpslider_img_inc',
			array( 
				'id' => 'hv_' . $section . '_twpslider_img_inc',
				'label' => __( 'Show Posts without Featured Images on ' . ucfirst($section) . ' Page', 'hv' ),
				'section' => 'hv_' . $section . '_page',
				'type' => 'radio',
				'choices' => $hv_twpslider_defaults['show_hide'],
				'settings' => 'hv_' . $section . '_twpslider_img_inc',
			)
		);   
		
		$wp_customize->add_control( 
			new My_Customize_Image_Reloaded_Control( 
				$wp_customize, 
				'hv_' . $section . '_twpslider_dft_img', 
				array(
					'label'   	=> __( 'Default Img', 'hv' ),
					'section'	=> 'hv_' . $section . '_page',
					'context'	=> 'dft-img'
				) 
			) 
		);
	}
}

add_action( 'customize_register', 'hv_customize_register' );

?>