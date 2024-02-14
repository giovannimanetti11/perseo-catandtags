# Perseo - Category and Tags Images

The Perseo - Category and Tags Images plugin allows you to add and manage images for categories and tags in WordPress, enhancing your website's taxonomy presentation. With this plugin, you can easily upload an image for each category or tag, providing a visual representation that can be utilized throughout your site.

## Features

- **Upload Images for Categories and Tags**: Easily assign an image to each term within your WordPress taxonomy.
- **Simple Administration Interface**: Use the WordPress native media uploader for easy management of taxonomy images.
- **Flexible Image Retrieval**: Retrieve and display the assigned images in your theme or through custom development.

## Installation

1. **Download the Plugin**: Download the latest version of the Perseo plugin from the GitHub repository.
2. **Upload to WordPress**:
   - Navigate to the WordPress admin area.
   - Go to `Plugins` > `Add New` > `Upload Plugin`.
   - Choose the downloaded plugin file (`perseocatandtags.zip`) and click `Install Now`.
3. **Activate the Plugin**: After installation, activate the plugin through the 'Plugins' menu in WordPress.

## Usage

### Uploading images

1. Go to the `Posts` > `Categories` or `Posts` > `Tags` page in the WordPress admin area.
2. Add a new category or tag, or edit an existing one.
3. You'll see an option to upload an image for the category or tag. Use the WordPress media uploader to select or upload a new image.

### Retrieving and displaying images in your theme

To display the image associated with a category or tag in your theme, you can use the following PHP code snippet. This example demonstrates how to retrieve and display the image for the current category or tag on a taxonomy archive page:

```php
$term_id = get_queried_object_id(); // Gets the current term ID
$image_id = get_term_meta($term_id, 'perseo-category-image-id', true); // Replace 'perseo-category-image-id' with your actual meta key

if ( ! empty($image_id) ) {
    echo wp_get_attachment_image( $image_id, 'full' ); // Outputs the image HTML. Replace 'full' with any registered image size.
}

If you prefer to use the image URL for background images or CSS, you can retrieve the URL like so:

```php
$image_url = wp_get_attachment_url( $image_id );
if ( ! empty($image_url) ) {
    echo 'background-image: url(' . esc_url($image_url) . ');'; // Use this in an inline style attribute, for example
}

## Customization and extensibility

Perseo is designed to be simple to use but also flexible for developers. You can extend its functionality or integrate it with your theme by using WordPress hooks and the provided metadata. This flexibility allows you to customize how images are displayed or even add additional metadata to each term, enhancing your site's taxonomy.

## Contributing

Contributions to the Perseo - Category and Tags Images plugin are welcome! If you have ideas for improvements, bug fixes, or new features, please feel free to submit them.

1. **Fork** the repository on GitHub.
2. **Clone** the project to your own machine.
3. **Commit** changes to your own branch.
4. **Push** your work back up to your fork.
5. Submit a **Pull request** so that I can review your changes

NOTE: Be sure to merge the latest from "upstream" before making a pull request!

## License

The Perseo - Category and Tags Images plugin is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). Feel free to fork, modify, and use it in your own projects.


