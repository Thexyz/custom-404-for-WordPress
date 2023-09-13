<?php
/**
 * Plugin Name: Custom 404 Page URL
 * Description: A simple plugin by <a href="https://www.thexyz.com">Thexyz</a> to set a custom 404 page URL. Navigate to the settings to configure.
 * Version: 1.0.9
 * Author: Thexyz
 * Author URI:  https://www.thexyz.com


 */

// Hook the 'template_redirect' action hook
add_action('template_redirect', 'custom_404_page_url');

// Hook the 'admin_menu' action hook
add_action('admin_menu', 'custom_404_page_url_settings_page');

// Hook the 'admin_init' action hook
add_action('admin_init', 'custom_404_page_url_register_settings');

// Register settings
function custom_404_page_url_register_settings(){
    register_setting('custom_404_page_url_settings', 'custom_404_url');
}

// Add settings page
function custom_404_page_url_settings_page(){
    add_options_page(
        'Custom 404 URL',
        'Custom 404 URL',
        'manage_options',
        'custom-404-page-url',
        'custom_404_page_url_html'
    );
}

// Settings page HTML
function custom_404_page_url_html(){
    ?>
    <div class="wrap">
        <h1>Custom 404 Page URL</h1>
        <p>This plugin allows you to set a custom 404 page URL for your WordPress site. Developed by <a href="https://www.thexyz.com">Thexyz</a>.</p>
        <form method="post" action="options.php">
            <?php settings_fields('custom_404_page_url_settings'); ?>
            <?php do_settings_sections('custom_404_page_url_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Custom 404 URL</th>
                    <td>
                        <input type="text" name="custom_404_url" value="<?php echo esc_attr(get_option('custom_404_url')); ?>" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Main function
function custom_404_page_url(){
    global $wp_query;

    if($wp_query->is_404){
        $custom_404_url = get_option('custom_404_url', 'https://yourwebsite.com/404/');
        if(!empty($custom_404_url)){
            wp_redirect($custom_404_url);
            exit();
        }
    }
}
?>
