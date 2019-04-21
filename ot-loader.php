<?php
/**
 * Plugin Name: Options
 * Plugin URI:  https://github.com/valendesigns/option-tree/
 * Description: Theme Options UI Builder for WordPress. A simple way to create & save Theme Options and Meta Boxes for free or premium themes.
 * Version:     2.6.0
 * Author:      Derek Herman
 * Author URI:  http://valendesigns.com
 * License:     GPLv3
 * Text Domain: option-tree
 */
include __DIR__ . '/includes/settings-functions.php';
/**
 * This is the OptionTree loader class.
 *
 * @package   OptionTree
 * @author    Derek Herman <derek@valendesigns.com>
 * @copyright Copyright (c) 2013, Derek Herman
 */
if ( ! class_exists( 'Settings_Loader' ) ) {

	class Settings_Loader {

		/**
		 * PHP5 constructor method.
		 *
		 * This method loads other methods of the class.
		 *
		 * @return    void
		 *
		 * @access    public
		 * @since     2.0
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'load_option_tree' ), 1 );
		}

		/**
		 * Load OptionTree on the 'after_setup_theme' action. Then filters will
		 * be availble to the theme, and not only when in Theme Mode.
		 *
		 * @return    void
		 *
		 * @access    public
		 * @since     2.1.2
		 */
		public function load_option_tree() {
			/* setup the constants */
			$this->constants();

			/* include the required admin files */
			$this->admin_includes();

			/* hook into WordPress */
			$this->hooks();
		}

		/**
		 * Constants
		 *
		 * Defines the constants for use within OptionTree. Constants
		 * are prefixed with 'OT_' to avoid any naming collisions.
		 *
		 * @return    void
		 *
		 * @access    private
		 * @since     2.0
		 */
		private function constants() {
			define( 'OT_DIR', plugin_dir_path( __FILE__ ) );
			define( 'OT_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Include admin files
		 *
		 * These functions are included on admin pages only.
		 *
		 * @return    void
		 *
		 * @access    private
		 * @since     2.0
		 */
		private function admin_includes() {

			/* exit early if we're not on an admin page */
			if ( ! is_admin() ) {
				return;
			}

			/* global include files */
			$files = array(
				'settings-api',
				'meta-box-api',
				'settings-types',
				'settings-functions',
			);

			/* require the files */
			foreach ( $files as $file ) {
				include( __DIR__ . "\includes" . DIRECTORY_SEPARATOR . "{$file}.php" );
			}

			/* Registers the Theme Option page */
			add_action( 'init', 'prince_register_theme_options_page' );

		}

		/**
		 * Execute the WordPress Hooks
		 *
		 * @return    void
		 *
		 * @access    public
		 * @since     2.0
		 */
		private function hooks() {

			/* add scripts for metaboxes to post-new.php & post.php */
			add_action( 'admin_print_scripts-post-new.php', 'prince_admin_scripts', 11 );
			add_action( 'admin_print_scripts-post.php', 'prince_admin_scripts', 11 );

			/* add styles for metaboxes to post-new.php & post.php */
			add_action( 'admin_print_styles-post-new.php', 'prince_admin_styles', 11 );
			add_action( 'admin_print_styles-post.php', 'prince_admin_styles', 11 );


			/* Adds the Theme Option page to the admin bar */
			add_action( 'admin_bar_menu', 'prince_register_theme_options_admin_bar_menu', 999 );

			/* prepares the after save do_action */
			add_action( 'admin_init', 'prince_after_theme_options_save', 1 );

			/* default settings */
			add_action( 'admin_init', 'prince_default_settings', 2 );

			/* save settings */
			add_action( 'admin_init', 'prince_save_settings', 6 );

			/* create media post */
			add_action( 'admin_init', 'prince_create_media_post', 8 );

			/* Google Fonts front-end CSS */
			add_action( 'wp_enqueue_scripts', 'ot_load_google_fonts_css', 1 );

			/* dynamic front-end CSS */
			add_action( 'wp_enqueue_scripts', 'prince_load_dynamic_css', 999 );

			/* insert theme CSS dynamically */
			add_action( 'prince_after_theme_options_save', 'prince_save_css' );

			/* AJAX call to create a new contextual help */
			add_action( 'wp_ajax_add_the_contextual_help', array( $this, 'add_the_contextual_help' ) );

			/* AJAX call to create a new choice */
			add_action( 'wp_ajax_add_choice', array( $this, 'add_choice' ) );

			/* AJAX call to create a new list item setting */
			add_action( 'wp_ajax_add_list_item_setting', array( $this, 'add_list_item_setting' ) );


			/* AJAX call to create a new list item */
			add_action( 'wp_ajax_add_list_item', array( $this, 'add_list_item' ) );

			/* AJAX call to create a new social link */
			add_action( 'wp_ajax_add_social_links', array( $this, 'add_social_links' ) );

			/* AJAX call to retrieve Google Font data */
			add_action( 'wp_ajax_ot_google_font', array( $this, 'retrieve_google_font' ) );

			// Adds the temporary hacktastic shortcode
			add_filter( 'media_view_settings', array( $this, 'shortcode' ), 10, 2 );

			// AJAX update
			add_action( 'wp_ajax_gallery_update', array( $this, 'ajax_gallery_update' ) );

			/* Modify the media uploader button */
			add_filter( 'gettext', array( $this, 'change_image_button' ), 10, 3 );

		}

		/**
		 * AJAX utility function for adding a new list item setting.
		 */
		public function add_list_item_setting() {
			echo prince_settings_view( $_REQUEST['name'] . '[settings]', $_REQUEST['count'] );
			die();
		}

		/**
		 * AJAX utility function for adding new contextual help content.
		 */
		public function add_the_contextual_help() {
			echo prince_contextual_help_view( $_REQUEST['name'], $_REQUEST['count'] );
			die();
		}

		/**
		 * AJAX utility function for adding a new choice.
		 */
		public function add_choice() {
			echo prince_choices_view( $_REQUEST['name'], $_REQUEST['count'] );
			die();
		}

		/**
		 * AJAX utility function for adding a new list item.
		 */
		public function add_list_item() {
			check_ajax_referer( 'option_tree', 'nonce' );
			prince_list_item_view( $_REQUEST['name'], $_REQUEST['count'], array(), $_REQUEST['post_id'], $_REQUEST['get_option'], unserialize( prince_decode( $_REQUEST['settings'] ) ), $_REQUEST['type'] );
			die();
		}

		/**
		 * AJAX utility function for adding a new social link.
		 */
		public function add_social_links() {
			check_ajax_referer( 'option_tree', 'nonce' );
			prince_social_links_view( $_REQUEST['name'], $_REQUEST['count'], array(), $_REQUEST['post_id'], $_REQUEST['get_option'], unserialize( prince_decode( $_REQUEST['settings'] ) ), $_REQUEST['type'] );
			die();
		}

		/**
		 * Fake the gallery shortcode
		 *
		 * The JS takes over and creates the actual shortcode with
		 * the real attachment IDs on the fly. Here we just need to
		 * pass in the post ID to get the ball rolling.
		 *
		 * @param     array     The current settings
		 * @param     object    The post object
		 *
		 * @return    array
		 *
		 * @access    public
		 * @since     2.2.0
		 */
		public function shortcode( $settings, $post ) {
			global $pagenow;

			if ( in_array( $pagenow, array( 'upload.php', 'customize.php' ) ) ) {
				return $settings;
			}

			// Set the OptionTree post ID
			if ( ! is_object( $post ) ) {
				$post_id = isset( $_GET['post'] ) ? $_GET['post'] : ( isset( $_GET['post_ID'] ) ? $_GET['post_ID'] : 0 );
				if ( $post_id == 0 && function_exists( 'prince_get_media_post_ID' ) ) {
					$post_id = prince_get_media_post_ID();
				}
				$settings['post']['id'] = $post_id;
			}

			// No ID return settings
			if ( $settings['post']['id'] == 0 ) {
				return $settings;
			}

			// Set the fake shortcode
			$settings['ot_gallery'] = array( 'shortcode' => "[gallery id='{$settings['post']['id']}']" );

			// Return settings
			return $settings;

		}

		/**
		 * Returns the AJAX images
		 *
		 * @return    string
		 *
		 * @access    public
		 * @since     2.2.0
		 */
		public function ajax_gallery_update() {

			if ( ! empty( $_POST['ids'] ) ) {

				$return = '';

				foreach ( $_POST['ids'] as $id ) {

					$thumbnail = wp_get_attachment_image_src( $id, 'thumbnail' );

					$return .= '<li><img  src="' . $thumbnail[0] . '" width="75" height="75" /></li>';

				}

				echo $return;
				exit();

			}

		}

		/**
		 * Returns a JSON encoded Google fonts array.
		 *
		 * @return    array
		 *
		 * @access    public
		 * @since     2.5.0
		 */
		public function retrieve_google_font() {

			if ( isset( $_POST['field_id'], $_POST['family'] ) ) {

				prince_fetch_google_fonts();

				echo json_encode( array(
					'variants' => prince_recognized_google_font_variants( $_POST['field_id'], $_POST['family'] ),
					'subsets'  => prince_recognized_google_font_subsets( $_POST['field_id'], $_POST['family'] )
				) );
				exit();

			}

		}

		/**
		 * Filters the media uploader button.
		 *
		 * @return    string
		 *
		 * @access    public
		 * @since     2.1
		 */
		public function change_image_button( $translation, $text, $domain ) {
			global $pagenow;

			if ( $pagenow == apply_filters( 'prince_theme_options_parent_slug', 'themes.php' ) && 'default' == $domain && 'Insert into post' == $text ) {

				// Once is enough.
				remove_filter( 'gettext', array( $this, 'ot_change_image_button' ) );

				return apply_filters( 'prince_upload_text', __( 'Send to OptionTree', 'prince-text-domain' ) );

			}

			return $translation;

		}

	}

	/**
	 * Instantiate the OptionTree loader class.
	 *
	 * @since     2.0
	 */

	$settings_loader = new Settings_Loader();

	require_once __DIR__ . '/assets.bk/theme-mode/demo-theme-options.php';

}