<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '2.8.1' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		wp_enqueue_style( 'cep-custom-css', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array() );

		wp_enqueue_style( 'cep-slick-min', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array() );

	   wp_enqueue_style( 'cep-slick-theme-min', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css', array() );

	   wp_enqueue_script( 'custom-jquery-min', get_template_directory_uri() . '/assets/js/jquery.min.js', array( 'jquery' ), true );

	   wp_enqueue_script( 'cep-slick-jquery', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array( 'jquery' ), true );

	   wp_enqueue_script( 'cep-custom-jquery', get_template_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), true );

		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

/**
 * If Elementor is installed and active, we can load the Elementor-specific Settings & Features
*/

// Allow active/inactive via the Experiments
require get_template_directory() . '/includes/elementor-functions.php';

/**
 * Include customizer registration functions
*/
function hello_register_customizer_functions() {
	if ( is_customize_preview() ) {
		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_register_customizer_functions' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		$post = get_queried_object();

		if ( is_singular() && ! empty( $post->post_excerpt ) ) {
			echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
		}
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

function cep_scripts(){
	if(is_page( 'custom_posts' )){
	    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
	    wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);	        
	}
}
add_action('wp_enqueue_scripts', 'cep_scripts', 1);

function our_history_shortcode_handler($atts){
?>
<div class="container">
	<div class="our_history">
	    <div class="container">
	     <div class="row justify-content-center">
	       <div class="col-lg-6">
	         <div class="history__inner">
	          	<div class="border_testi"></div>
		           <ul class="slider-nav testi-ul pt-0 text-center">
		           	<li>
		              <div class="last_circle"><span></span></div>
		            </li>
		            <li>
		              <div class="sec_cls"><span></span></div>
		            </li>
		             <li>
		              <div class="mid_circle"><span>1994</span></div>
		            </li>
		            <li>
		              <div class="circle_cls"><span>1996</span></div>
		            </li>
		            <li>
		              <div class="mid_circle"><span>2010</span></div>
		            </li>
		            <li>
		              <div class="sec_cls"><span></span></div>
		            </li>
		            <li>
		              <div class="last_circle"><span></span></div>
		            </li>
		           </ul>

		           <div class=" slider-for">
	                 <div class="history-slide">
	                 	<div class="history_box-text">
	                       <p class="history_text">Senior visionary management founded Ascent' in 1996 to offer electrical services to its continually growing client base. In 2011 after a period of organic growth the company expanded to become Ascent Group a leading expert in electrical contracting and energy related services working across the INDIA</p>
	                       <h6 class="history_title">Large Scale of Operation & Maintenance (O&M) projects and Govt. and PUSs Trunkey Projects.</h6>
	                    </div>
	                 </div>
	                 <div class="history-slide">
	                 	<div class="history_box-text">
	                       <p class="history_text">Senior visionary management founded Ascent' in 1996 to offer electrical services to its continually growing client base. In 2011 after a period of organic growth the company expanded to become Ascent Group a leading expert in electrical contracting and energy related services working across the INDIA</p>
	                       <h6 class="history_title">Large Scale of Operation & Maintenance (O&M) projects and Govt. and PUSs Trunkey Projects.</h6>
	                    </div>
	                 </div>
	                 <div class="history-slide">
	                 	<div class="history_box-text">
	                       <p class="history_text">Senior visionary management founded Ascent' in 1994 to offer electrical services to its continually growing client base. In 2011 after a period of organic growth the company expanded to become Ascent Group a leading expert in electrical contracting and energy related services working across the INDIA</p>
	                       <h6 class="history_title">Large Scale of Operation & Maintenance (O&M) projects and Govt. and PUSs Trunkey Projects.</h6>
	                    </div>
	                 </div>
	                 <div class="history-slide">
	                 	<div class="history_box-text">
	                       <p class="history_text">Senior visionary management founded Ascent' in 1996 to offer electrical services to its continually growing client base. In 2011 after a period of organic growth the company expanded to become Ascent Group a leading expert in electrical contracting and energy related services working across the INDIA</p>
	                       <h6 class="history_title">Large Scale of Operation & Maintenance (O&M) projects and Govt. and PUSs Trunkey Projects.</h6>
	                    </div>
	                 </div>
	                 <div class="history-slide">
	                 	<div class="history_box-text">
	                       <p class="history_text">Senior visionary management founded Ascent' in 1996 to offer electrical services to its continually growing client base. In 2011 after a period of organic growth the company expanded to become Ascent Group a leading expert in electrical contracting and energy related services working across the INDIA</p>
	                       <h6 class="history_title">Large Scale of Operation & Maintenance (O&M) projects and Govt. and PUSs Trunkey Projects.</h6>
	                    </div>
	                 </div>
	                 <div class="history-slide">
	                 	<div class="history_box-text">
	                       <p class="history_text">Senior visionary management founded Ascent' in 2010 to offer electrical services to its continually growing client base. In 2011 after a period of organic growth the company expanded to become Ascent Group a leading expert in electrical contracting and energy related services working across the INDIA</p>
	                       <h6 class="history_title">Large Scale of Operation & Maintenance (O&M) projects and Govt. and PUSs Trunkey Projects.</h6>
	                    </div>
	                 </div>
	                 <div class="history-slide">
	                 	<div class="history_box-text">
	                       <p class="history_text">Senior visionary management founded Ascent' in 1996 to offer electrical services to its continually growing client base. In 2011 after a period of organic growth the company expanded to become Ascent Group a leading expert in electrical contracting and energy related services working across the INDIA</p>
	                       <h6 class="history_title">Large Scale of Operation & Maintenance (O&M) projects and Govt. and PUSs Trunkey Projects.</h6>
	                    </div>
	                 </div>
                   </div>
	         </div>
	       </div>
	     </div>
	    </div>
	</div>
</div>
<?php }
add_shortcode('our_history', 'our_history_shortcode_handler');