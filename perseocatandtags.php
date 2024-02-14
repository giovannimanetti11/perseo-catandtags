<?php
/**
 * Plugin Name: Perseo - Category and Tags Images
 * Plugin URI:  https://github.com/giovannimanetti11/perseo-catandtags
 * Description: Allows you to add images to categories and tags in WordPress.
 * Version:     1.0
 * Author:      Giovanni Manetti
 * Author URI:  https://github.com/giovannimanetti11
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

// Enqueue scripts and styles for admin
function perseo_enqueue_scripts_styles() {
    wp_enqueue_media();
    wp_enqueue_script('perseo-media-uploader', plugin_dir_url(__FILE__) . 'media-uploader.js', array(), '1.0', true);
    wp_enqueue_style('perseo-style', plugin_dir_url(__FILE__) . 'style.css', array(), '1.0', 'all');
}
add_action('admin_enqueue_scripts', 'perseo_enqueue_scripts_styles');


// Register the taxonomy image field
function perseo_add_taxonomy_image_field() {
	?>
	<div class="form-field term-group">
		<label for="perseo-category-image-id"><?php _e('Image', 'perseo'); ?></label>
		<input type="hidden" id="perseo-category-image-id" name="perseo-category-image-id" class="custom_media_url" value="">
		<div id="category-image-wrapper"></div>
		<p>
			<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'perseo'); ?>" />
			<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'perseo'); ?>" />
		</p>
	</div>
	<?php
}
add_action('category_add_form_fields', 'perseo_add_taxonomy_image_field', 10, 2);
add_action('post_tag_add_form_fields', 'perseo_add_taxonomy_image_field', 10, 2);

// Add a column to the term list table to display the image
function perseo_add_image_column_to_term_list($columns) {
	$columns['perseo_image'] = __('Image', 'perseo');
	return $columns;
}
add_filter('manage_edit-category_columns', 'perseo_add_image_column_to_term_list');
add_filter('manage_edit-post_tag_columns', 'perseo_add_image_column_to_term_list');

// Fill the image column with the term's image
function perseo_fill_image_column_in_term_list($content, $column_name, $term_id) {
    if ('perseo_image' === $column_name) {
        $image_id = get_term_meta($term_id, 'perseo-category-image-id', true);
        if ($image_id) {
            $content = wp_get_attachment_image($image_id, 'thumbnail', false, array('style' => 'max-width:100%;height:auto;'));
        }
    }
    return $content;
}
add_filter('manage_category_custom_column', 'perseo_fill_image_column_in_term_list', 10, 3);
add_filter('manage_post_tag_custom_column', 'perseo_fill_image_column_in_term_list', 10, 3);


// Add image field in edit form
function perseo_edit_taxonomy_image_field($term) {
    // Ensure the $term is an object
    if (!is_object($term)) return;
    
    $image_id = get_term_meta($term->term_id, 'perseo-category-image-id', true);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="perseo-category-image-id"><?php _e('Image', 'perseo'); ?></label>
        </th>
        <td>
            <input type="hidden" id="perseo-category-image-id" name="perseo-category-image-id" value="<?php echo esc_attr($image_id); ?>">
            <div id="category-image-wrapper">
                <?php if ($image_id) { echo wp_get_attachment_image($image_id, 'thumbnail'); } ?>
            </div>
            <p>
                <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'perseo'); ?>" />
                <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'perseo'); ?>" />
            </p>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'perseo_edit_taxonomy_image_field', 10, 2);
add_action('post_tag_edit_form_fields', 'perseo_edit_taxonomy_image_field', 10, 2);

// Save the image data on term creation and edit
function perseo_save_taxonomy_image_on_create($term_id) {
    if (isset($_POST['perseo-category-image-id']) && '' !== $_POST['perseo-category-image-id']){
        $image = $_POST['perseo-category-image-id'];
        add_term_meta($term_id, 'perseo-category-image-id', $image, true);
    }
}
add_action('created_category', 'perseo_save_taxonomy_image_on_create');
add_action('created_post_tag', 'perseo_save_taxonomy_image_on_create');


function perseo_save_taxonomy_image_on_edit($term_id) {
    if (isset($_POST['perseo-category-image-id']) && '' !== $_POST['perseo-category-image-id']){
        $image = $_POST['perseo-category-image-id'];
        update_term_meta($term_id, 'perseo-category-image-id', $image);
    } else {
        delete_term_meta($term_id, 'perseo-category-image-id');
    }
}
add_action('edited_category', 'perseo_save_taxonomy_image_on_edit', 10, 2);
add_action('edited_post_tag', 'perseo_save_taxonomy_image_on_edit', 10, 2);







