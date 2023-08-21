<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://localhost/anglara_practical
 * @since      1.0.0
 *
 * @package    Custom_External_Post
 * @subpackage Custom_External_Post/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Custom_External_Post
 * @subpackage Custom_External_Post/admin
 * @author     Bhavini Shah <bhavinishah098@gmail.com>
 */
class Custom_External_Post_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_External_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_External_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-external-post-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_External_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_External_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-external-post-admin.js', array( 'jquery' ), $this->version, false );

	}

}

//Add custom css in admin page
function cep_enqueue_admin_scripts() {
    wp_enqueue_style('cep-admin-style', plugin_dir_url(__FILE__) . './css/admin-style.css');
}
add_action('admin_enqueue_scripts', 'cep_enqueue_admin_scripts');

//Add bootstrapcdn in specific plugin 'custom-external-posts' admin page
if(!function_exists("cep_admin_scripts")) {
    function cep_admin_scripts() {
        global $pagenow;
        $current_page = get_current_screen();
        if(isset($_GET["page"]) && $_GET["page"] === 'custom-external-posts') { 
            wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
            wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
        }
    }
    add_action('admin_enqueue_scripts', 'cep_admin_scripts', 1);
}

//Add new menu when active this plugin
function cep_admin_menu() {
    add_menu_page('Custom External Posts','Custom Posts','manage_options','custom-external-posts','cep_render_admin_page','dashicons-format-aside',3);
}
add_action('admin_menu', 'cep_admin_menu');

// 'Custom External Posts' plugin callback function
function cep_render_admin_page() {
    settings_errors('cep_errors'); 
    settings_errors('cep_success');
?>
    <div class="container">
        <h2>Custom External Posts</h2>
        <form method="post" action="">
            <?php if(isset($success) && !empty($success)) { echo $success; } 
              if(isset($error) && !empty($error)) { echo $error; }
            ?>
            <?php for ($i = 1; $i <= 3; $i++) : ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Post <?php echo $i; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="post_<?php echo $i; ?>_title">Title:</label>
                            <input type="text" class="form-control" id="post_<?php echo $i; ?>_title" name="post_<?php echo $i; ?>_title">
                        </div>
                        <div class="form-group">
                            <label for="post_<?php echo $i; ?>_image_url">URL for Featured Image:</label>
                            <input type="url" class="form-control" id="post_<?php echo $i; ?>_image_url" name="post_<?php echo $i; ?>_image_url">
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="post_<?php echo $i; ?>_status" name="post_<?php echo $i; ?>_status" value="enabled" checked>
                            <label class="form-check-label checkbox_lbl" for="post_<?php echo $i; ?>_status">Enable Post</label>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary" name="cep_submit_btn">Save Posts</button>
        </form>
    </div>
    <?php
}

// 'Custom External Posts' submit form process
function cep_process_form_submission() {
    global $wpdb;
    if (isset($_POST['cep_submit_btn'])) {
        $table_name = $wpdb->prefix . 'ang_custom_date';
        $errors = array(); 

        for ($i = 1; $i <= 3; $i++) {
            $title = sanitize_text_field($_POST["post_{$i}_title"]);
            $image_url = esc_url_raw($_POST["post_{$i}_image_url"]);
            $status = isset($_POST["post_{$i}_status"]) ? 'enabled' : 'disabled';
            $post_slug = sanitize_title($title);
            $post_url = get_site_url() . '/' . $post_slug;
           
            if (empty($title)) {
                $errors[] = "Title cannot be empty for Post {$i}.";
            }
            if (empty($image_url)) {
                $errors[] = "Image URL cannot be empty for Post {$i}.";
            }

            if (!empty($image_url) && !filter_var($image_url, FILTER_VALIDATE_URL)) {
                $errors[] = "Invalid URL for Featured Image in Post {$i}.";
            }

            if (empty($errors)) {
                $data = array( 
                    'post_title' => $title,
                    'post_url' => $post_url,
                    'post_image_url' => $image_url,
                    'post_status' => $status,

                );
                $wpdb->insert( $table_name, $data );
            }
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                add_settings_error('cep_errors', 'error', $error);
            }
        } else {
            add_settings_error('cep_success', 'updated', 'Post Details saved successfully!','success');
        }
    }
}
add_action('admin_init', 'cep_process_form_submission');
