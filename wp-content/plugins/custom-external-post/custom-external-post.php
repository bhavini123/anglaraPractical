<?php

/**
 * The plugin file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://localhost/anglara_practical
 * @since             1.0.0
 * @package           Custom_External_Post
 *
 * @wordpress-plugin
 * Plugin Name:       Custom External Post
 * Plugin URI:        http://localhost/anglara_practical/wp-admin/admin.php?page=custom-external-posts
 * Description:       Create custom external posts with some extra fields.
 * Version:           1.0.0
 * Author:            Bhavini Shah
 * Author URI:        https://localhost/anglara_practical
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-external-post
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CUSTOM_EXTERNAL_POST_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-external-post-activator.php
 */
function activate_custom_external_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-external-post-activator.php';
	Custom_External_Post_Activator::activate();

    //When activated this plugin add this table in DB
    global $wpdb;
    $table_name = $wpdb->prefix . 'ang_custom_date';
    $test_db_version = '1.0.0';
    $charset_collate = $wpdb->get_charset_collate();
    if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
        $sql = "CREATE TABLE `$table_name` (
                id INT NOT NULL AUTO_INCREMENT,
            post_title VARCHAR(255) NOT NULL,
            post_url VARCHAR(255),
            post_image_url VARCHAR(255),
            post_status VARCHAR(10),
            PRIMARY KEY (id)
        ) $charset_collate;";
       
       require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
       dbDelta( $sql );
       add_option( 'test_db_version', $test_db_version );
    }
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-external-post-deactivator.php
 */
function deactivate_custom_external_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-external-post-deactivator.php';
	Custom_External_Post_Deactivator::deactivate();

        //When deactivated this plugin delete this table from DB
        global $wpdb;
        $table_name = $wpdb->prefix . 'ang_custom_date';
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);
    
}

register_activation_hook( __FILE__, 'activate_custom_external_post' );
register_deactivation_hook( __FILE__, 'deactivate_custom_external_post' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-external-post.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_external_post() {

	$plugin = new Custom_External_Post();
	$plugin->run();

}
run_custom_external_post();

// Start create custom posts shortcode 
function cep_shortcode_handler($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ang_custom_date';
    $posts = $wpdb->get_results("SELECT * FROM $table_name");
    ob_start();

    if ($posts) { ?>
        <div class="row">
        <?php   
        foreach ($posts as $post) {
            $post_title = esc_html($post->post_title);
            $post_image_url = esc_url($post->post_image_url);
            $post_status = esc_html($post->post_status);
            $post_url = esc_url($post->post_url);
            if($post_status == 'enabled'){
            ?>
           <div class="col-md-4 mb-4">
            <div class="card border-0 rounded-2">
              <img src="<?php echo $post_image_url;?>" class="card-img-top" alt="<?php echo $post_title;?>">
               <div class="card-body">
                <h5 class="card-title"><?php echo $post_title;?></h5>
                <a href="<?php echo $post_url;?>" class="read_more_btn">Read more</a>
               </div>
            </div>
           </div>
        <?php } } ?>
        </div>
    <?php } else {
        echo '<p>No custom posts found.</p>';
    }
    return ob_get_clean();
}
add_shortcode('custom_external_posts', 'cep_shortcode_handler');