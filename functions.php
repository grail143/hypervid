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


function hv_scripts() {
    wp_enqueue_style( 'hv-style', get_stylesheet_uri() );
    wp_enqueue_style( 'hv-sass-style', get_template_directory_uri() . '/css/style.css' );
    wp_enqueue_style( 'hv-font1', "https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" );
    wp_enqueue_style( 'hv-font2', "https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" );
	wp_enqueue_script('jquery');
    wp_enqueue_script( 'hv-webpack', get_template_directory_uri() . '/dist/main.js' ,'jQuery');
}    

add_action( 'wp_enqueue_scripts', 'hv_scripts' );
add_image_size( 'scroller-size', 530, 9999 );
function mytheme_post_thumbnails() {
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'mytheme_post_thumbnails' );


// Add the Page Meta Box
function codeless_add_custom_meta_box() {
    add_meta_box(
            'codeless_meta_box', // $id
            'Codeless Page Options', // $title 
            'codeless_show_custom_meta_box', // $callback
            'page', // $page
            'normal', // $context
            'high'); // $priority
}

add_action('add_meta_boxes', 'codeless_add_custom_meta_box');

// Add the Post Meta Box
function codeless_add_custom_post_meta_box() {
    add_meta_box(
            'codeless_meta_box', // $id
            'Codeless Page Options', // $title 
            'codeless_show_custom_post_meta_box', // $callback
            'post', // $post
            'normal', // $context
            'high'); // $priority
}

add_action('add_meta_boxes', 'codeless_add_custom_post_meta_box');

$prefix = 'codeless_';

// Field Array (Pages Meta)
$codeless_meta_fields = array();

// Field Array (Posts Meta)
$codeless_post_meta_fields = array(
    array(
        'label' => 'Featured Video Embed Code',
        'desc' => 'Paste your video code here to show a video instead of a featured image.',
        'id' => $prefix . 'video_embed',
        'type' => 'textarea'
    )
);

// The Callback for page meta box
function codeless_show_custom_meta_box() {
    global $codeless_meta_fields;
    codeless_show_page_meta_box($codeless_meta_fields);
}

// The Callback for post meta box
function codeless_show_custom_post_meta_box() {
    global $codeless_post_meta_fields;
    codeless_show_page_meta_box($codeless_post_meta_fields);
}

// The Callback
function codeless_show_page_meta_box($meta_fields) {

    global $post;
// Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';

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
function codeless_save_custom_meta($post_id) {
    global $codeless_meta_fields;
    global $codeless_post_meta_fields;

    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
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
    if ('page' == $_POST['post_type']) {

        $fields = $codeless_meta_fields;
    } else if ('post' == $_POST['post_type']) {

        $fields = $codeless_post_meta_fields;
    }

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

add_action('save_post', 'codeless_save_custom_meta');
?>