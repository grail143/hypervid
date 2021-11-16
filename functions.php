<?php
/**
 * The functions for our theme.
 *
 * @package HyperVid_Theme
 *
 */
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

/*includes*/
include( get_stylesheet_directory() . '/inc/customizer.php' );

/**
 * https://enriquechavez.co/how-to-remove-query-string-version-number-from-static-files-in-wordpress/
 * Remove the ver query argument from the source path
 * @param $src  Script loader source path.
 *
 * @return string
 */
function tm_remove_query_string_version( $src ){
	return remove_query_arg( 'ver', $src );
}
add_filter( 'script_loader_src', 'tm_remove_query_string_version' );
add_filter( 'style_loader_src', 'tm_remove_query_string_version' );

/**register scripts**/
function hv_scripts() {
    wp_enqueue_style( 'hv-style', get_stylesheet_uri() );
    wp_enqueue_style( 'hv-sass-style', get_template_directory_uri() . '/dist/css/style.css' );
    wp_enqueue_style( 'hv-font1', "https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" );
    wp_enqueue_style( 'hv-font2', "https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" );
	wp_enqueue_script('jquery');
    wp_enqueue_script( 'hv-webpack', get_template_directory_uri() . '/dist/js/script.js' ,'jQuery');
}    

add_action( 'wp_enqueue_scripts', 'hv_scripts' );
add_image_size( 'scroller-size', 530, 9999 );

/*register custom image size for twpslide*/
function hv_post_thumbnails() {
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'hv_post_thumbnails' );


// Add the Page Meta Box
function hypervid_add_custom_meta_box() {
    add_meta_box(
		'hypervid_meta_box', // $id
		'HyperVid Page Options', // $title 
		'hypervid_show_custom_meta_box', // $callback
		'page', // $page
		'normal', // $context
		'high', // $priority
	); 
}

add_action('add_meta_boxes', 'hypervid_add_custom_meta_box');

// Add the Post Meta Box
function hypervid_add_custom_post_meta_box() {
    add_meta_box(
		'', // $id
		'HyperVid Page Options', // $title 
		'hypervid_show_custom_post_meta_box', // $callback
		'post', // $post
		'normal', // $context
		'high', // $priority
	);
}

add_action('add_meta_boxes', 'hypervid_add_custom_post_meta_box');

// Field Array (Posts Meta)
$hypervid_post_meta_fields = array(
    array(
        'label' => 'Featured Video Embed Code',
        'desc' => 'Paste your video code here to show a video instead of a featured image.',
        'id' => 'hypervid_video_embed',
        'type' => 'textarea'
    )
);

// The Callback for page meta box
function hypervid_show_custom_meta_box() {
    global $hypervid_post_meta_fields;
    hypervid_show_page_meta_box($hypervid_post_meta_fields);
}

// The Callback for post meta box
function hypervid_show_custom_post_meta_box() {
    global $hypervid_post_meta_fields;
    hypervid_show_page_meta_box($hypervid_post_meta_fields);
}

// The Callback
function hypervid_show_page_meta_box($meta_fields) {

    global $post;
    echo '<input type="hidden" name="hypervid_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
        <th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
        <td>';
        switch ($field['type']) {

            // text
            case 'text':
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" style="width:100%" />
                                                    <br /><span class="description">' . $field['desc'] . '</span>';
                break;

            // textarea
            case 'textarea':
                echo '<textarea style="width:100%" rows="2" id="' . $field['id'] . '" name="' . $field['id'] . '">' . $meta . '</textarea>
                                                    <br /><span class="description">' . $field['desc'] . '</span>';
                break;

            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" ', $meta ? ' checked="checked"' : '', '/>
                                                    <label for="' . $field['id'] . '">' . $field['desc'] . '</label>';
                break;

            // select
            case 'select':
                echo '<select name="' . $field['id'] . '" id="' . $field['id'] . '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
                }
                echo '</select><br /><span class="description">' . $field['desc'] . '</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function hypervid_save_custom_meta($post_id) {
    global $hypervid_post_meta_fields;

    // verify nonce
    if (!wp_verify_nonce($_POST['hypervid_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    //either post or page fields we'll be working with
    $fields;

    // Check permissions (pages or posts)
        $fields = $hypervid_post_meta_fields;

    // loop through fields and save the data
    foreach ($fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}

add_action('save_post', 'hypervid_save_custom_meta');

// Add Video Post Type
function create_video_posttype() {
 
    register_post_type( 'videos',
        array(
            'labels' => array(
                'name' => __( 'Videos' ),
                'singular_name' => __( 'Video' )
            ),
			'supports' => array(
				'title', 
				'editor', 
				'excerpt', 
				'author', 
				'thumbnail', 
				'comments', 
				'revisions', 
				'custom-fields',
			),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'videos'),
            'show_in_rest' => true,
 
        )
    );
}

add_action( 'init', 'create_video_posttype' );


if ( ! function_exists( 'hypervid_setup' ) ) {
	function hypervid_setup() {
		add_theme_support( 'title-tag' );

		/**
		 * Add post-formats support.
		 */
		add_theme_support(
			'post-formats',
			array(
				'link',
				'aside',
				'gallery',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			)
		);
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		}
	}
add_action( 'after_setup_theme', 'hypervid_setup' );




?>




























