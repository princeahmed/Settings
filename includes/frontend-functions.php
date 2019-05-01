<?php
/**
 * Settings functions
 */

/**
 * Settings ID
 *
 * @return    string
 *
 * @access    public
 * @since     1.0.0
 */
if ( ! function_exists( 'prince_options_id' ) ) {

	function prince_options_id() {

		return apply_filters( 'prince_options_id', 'option_tree' );

	}

}

/**
 * Theme Settings ID
 *
 * @return    string
 *
 * @access    public
 * @since     1.0.0
 */
if ( ! function_exists( 'prince_settings_id' ) ) {

	function prince_settings_id() {

		return apply_filters( 'prince_settings_id', 'option_tree_settings' );

	}

}

/**
 * Get Option.
 *
 * Helper function to return the option value.
 * If no value has been saved, it returns $default.
 *
 * @param     string    The option ID.
 * @param     string    The default option value.
 *
 * @return    mixed
 *
 * @access    public
 * @since     1.0.0
 */
if ( ! function_exists( 'prince_get_option' ) ) {

	function prince_get_option( $option_id, $default = '' ) {

		/* get the saved options */
		$options = get_option( prince_options_id() );

		/* look for the saved value */
		if ( isset( $options[ $option_id ] ) && '' != $options[ $option_id ] ) {

			return prince_wpml_filter( $options, $option_id );

		}

		return $default;

	}

}

/**
 * Echo Option.
 *
 * Helper function to echo the option value.
 * If no value has been saved, it echos $default.
 *
 * @param     string    The option ID.
 * @param     string    The default option value.
 *
 * @return    mixed
 *
 * @access    public
 * @since     1.0.0
 */
if ( ! function_exists( 'prince_echo_option' ) ) {

	function prince_echo_option( $option_id, $default = '' ) {

		echo prince_get_option( $option_id, $default );

	}

}

/**
 * Enqueue the dynamic CSS.
 *
 * @return    void
 *
 * @access    public
 * @since     1.0.0
 */
if ( ! function_exists( 'prince_load_dynamic_css' ) ) {

	function prince_load_dynamic_css() {

		/* don't load in the admin */
		if ( is_admin() ) {
			return;
		}

		/**
		 * Filter whether or not to enqueue a `dynamic.css` file at the theme level.
		 *
		 * By filtering this to `false` Prince will not attempt to enqueue any CSS files.
		 *
		 * Example: add_filter( 'prince_load_dynamic_css', '__return_false' );
		 *
		 * @since     1.0.0
		 *
		 * @param bool $load_dynamic_css Default is `true`.
		 *
		 * @return bool
		 */
		if ( false === (bool) apply_filters( 'prince_load_dynamic_css', true ) ) {
			return;
		}

		/* grab a copy of the paths */
		$prince_css_file_paths = get_option( 'prince_css_file_paths', array() );
		if ( is_multisite() ) {
			$prince_css_file_paths = get_blog_option( get_current_blog_id(), 'prince_css_file_paths', $prince_css_file_paths );
		}

		if ( ! empty( $prince_css_file_paths ) ) {

			$last_css = '';

			/* loop through paths */
			foreach ( $prince_css_file_paths as $key => $path ) {

				if ( '' != $path && file_exists( $path ) ) {

					$parts = explode( '/wp-content', $path );

					if ( isset( $parts[1] ) ) {

						$sub_parts = explode( '/', $parts[1] );

						if ( isset( $sub_parts[1] ) && isset( $sub_parts[2] ) ) {
							if ( $sub_parts[1] == 'themes' && $sub_parts[2] != get_stylesheet() ) {
								continue;
							}
						}

						$css = set_url_scheme( WP_CONTENT_URL ) . $parts[1];

						if ( $last_css !== $css ) {

							/* enqueue filtered file */
							wp_enqueue_style( 'prince-dynamic-' . $key, $css, false, false );

							$last_css = $css;

						}

					}

				}

			}

		}

	}

}

/**
 * Enqueue the Google Fonts CSS.
 *
 * @return    void
 *
 * @access    public
 * @since     1.0.0
 */
if ( ! function_exists( 'prince_load_google_fonts_css' ) ) {

	function prince_load_google_fonts_css() {

		/* don't load in the admin */
		if ( is_admin() ) {
			return;
		}

		$prince_google_fonts     = get_theme_mod( 'prince_google_fonts', array() );
		$prince_set_google_fonts = get_theme_mod( 'prince_set_google_fonts', array() );
		$families                = array();
		$subsets                 = array();
		$append                  = '';

		if ( ! empty( $prince_set_google_fonts ) ) {

			foreach ( $prince_set_google_fonts as $id => $fonts ) {

				foreach ( $fonts as $font ) {

					// Can't find the font, bail!
					if ( ! isset( $prince_google_fonts[ $font['family'] ]['family'] ) ) {
						continue;
					}

					// Set variants & subsets
					if ( ! empty( $font['variants'] ) && is_array( $font['variants'] ) ) {

						// Variants string
						$variants = ':' . implode( ',', $font['variants'] );

						// Add subsets to array
						if ( ! empty( $font['subsets'] ) && is_array( $font['subsets'] ) ) {
							foreach ( $font['subsets'] as $subset ) {
								$subsets[] = $subset;
							}
						}

					}

					// Add family & variants to array
					if ( isset( $variants ) ) {
						$families[] = str_replace( ' ', '+', $prince_google_fonts[ $font['family'] ]['family'] ) . $variants;
					}

				}

			}

		}

		if ( ! empty( $families ) ) {

			$families = array_unique( $families );

			// Append all subsets to the path, unless the only subset is latin.
			if ( ! empty( $subsets ) ) {
				$subsets = implode( ',', array_unique( $subsets ) );
				if ( $subsets != 'latin' ) {
					$append = '&subset=' . $subsets;
				}
			}

			wp_enqueue_style( 'prince-google-fonts', esc_url( '//fonts.googleapis.com/css?family=' . implode( '%7C', $families ) ) . $append, false, null );
		}

	}

}

/**
 * Registers the Theme Option page link for the admin bar.
 *
 * @return    void
 *
 * @access    public
 * @since     1.0.0
 */
if ( ! function_exists( 'prince_register_settings_admin_bar_menu' ) ) {

	function prince_register_settings_admin_bar_menu( $wp_admin_bar ) {

		if ( ! current_user_can( apply_filters( 'prince_settings_capability', 'edit_theme_options' ) ) || ! is_admin_bar_showing() ) {
			return;
		}

		$wp_admin_bar->add_node( array(
			'parent' => 'appearance',
			'id'     => apply_filters( 'prince_settings_menu_slug', 'prince-settings' ),
			'title'  => apply_filters( 'prince_settings_page_title', __( 'Settings', 'prince-text-domain' ) ),
			'href'   => admin_url( apply_filters( 'prince_settings_parent_slug', 'themes.php' ) . '?page=' . apply_filters( 'prince_settings_menu_slug', 'prince-settings' ) )
		) );

	}

}
